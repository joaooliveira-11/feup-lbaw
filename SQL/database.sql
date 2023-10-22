create schema if not exists lbaw23117;
SET search_path TO lbaw23117;

-----------------------------------------
-- Drop old schema
-----------------------------------------

DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS interest CASCADE;
DROP TABLE IF EXISTS user_interests CASCADE;
DROP TABLE IF EXISTS skill CASCADE;
DROP TABLE IF EXISTS user_skills CASCADE;
DROP TABLE IF EXISTS project CASCADE;
DROP TABLE IF EXISTS project_users CASCADE;
DROP TABLE IF EXISTS favorite_projects CASCADE;
DROP TABLE IF EXISTS invite CASCADE;
DROP TABLE IF EXISTS task CASCADE;
DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS message CASCADE;
DROP TABLE IF EXISTS notification CASCADE;

DROP TYPE IF EXISTS taskStatus;
DROP TYPE IF EXISTS notificationTypes;

DROP FUNCTION IF EXISTS inviteNotification;
DROP FUNCTION IF EXISTS coordinatorNotification;
DROP FUNCTION IF EXISTS archivedtaskNotification;
DROP FUNCTION IF EXISTS assignedtaskNotification;
DROP FUNCTION IF EXISTS acceptedInviteNotification;
DROP FUNCTION IF EXISTS commeDntNotification;
DROP FUNCTION IF EXISTS forumNotification;
DROP FUNCTION IF EXISTS inviteUserInProject;
DROP FUNCTION IF EXISTS adminCreateProj;
DROP FUNCTION IF EXISTS coordinatorNotInProjectAsUser;
DROP FUNCTION IF EXISTS updateTasksOnUserLeave;
DROP FUNCTION IF EXISTS commentUnassignedOrArchivedTask;

-----------------------------------------
-- Types
-----------------------------------------

CREATE TYPE taskStatus AS ENUM ('open', 'assigned', 'closed', 'archived');
CREATE TYPE notificationTypes as ENUM('assignedtask', 'coordinator', 'archivedtask', 'invite', 'forum', 'comment', 'acceptedinvite');

-----------------------------------------
-- Tables
-----------------------------------------

CREATE TABLE users (
    userId SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    username TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    description TEXT,
    photo TEXT, 
    isAdmin BOOLEAN NOT NULL DEFAULT FALSE, 
    isBanned BOOLEAN NOT NULL DEFAULT FALSE,
    emailVerification BOOLEAN NOT NULL DEFAULT FALSE 
);

CREATE TABLE interest (
    interestId SERIAL PRIMARY KEY,
    interest TEXT NOT NULL 
);

CREATE TABLE user_interests(
    userId INTEGER REFERENCES users (userId) ON UPDATE CASCADE,
    interestId INTEGER REFERENCES interest (interestId) ON UPDATE CASCADE,
    PRIMARY KEY (userId, interestId)
);

CREATE TABLE skill (
    skillId SERIAL PRIMARY KEY,
    skill TEXT NOT NULL 
);

CREATE TABLE user_skills(
    userId INTEGER REFERENCES users(userId) ON UPDATE CASCADE,
    skillId INTEGER REFERENCES skill(skillId) ON UPDATE CASCADE,
    PRIMARY KEY (userId, skillId)
); 

CREATE TABLE project (
    projectId SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    isPublic BOOLEAN NOT NULL DEFAULT TRUE,
    archived BOOLEAN NOT NULL DEFAULT FALSE,
    createDate TIMESTAMP NOT NULL CHECK(createDate <= now()),
    finishDate TIMESTAMP CHECK(finishDate <= now()),
    createdBy INTEGER NOT NULL REFERENCES users(userId) ON UPDATE CASCADE,
    projectCoordinator INTEGER NOT NULL REFERENCES users(userId) ON UPDATE CASCADE
);

CREATE TABLE project_users (
    projectId INTEGER REFERENCES project(projectId) ON UPDATE CASCADE,
    userId INTEGER REFERENCES users(userId) ON UPDATE CASCADE,
    PRIMARY KEY (projectId, userId)
);

CREATE TABLE favorite_projects (
    projectId INTEGER REFERENCES project(projectId) ON UPDATE CASCADE,
    userId INTEGER REFERENCES users(userId) ON UPDATE CASCADE,
    PRIMARY KEY (projectId, userId)
);

CREATE TABLE invite (
    inviteId SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    createDate TIMESTAMP NOT NULL CHECK (createDate <= now()),
    invitedBy INTEGER NOT NULL REFERENCES users(userId) ON UPDATE CASCADE,
    invitedTo INTEGER NOT NULL REFERENCES users(userId) ON UPDATE CASCADE,
    projectInvite INTEGER NOT NULL REFERENCES project(projectId) ON UPDATE CASCADE
);

CREATE TABLE task (
    taskId SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    priority TEXT NOT NULL,
    createDate TIMESTAMP NOT NULL CHECK(createDate <= now()),
    finishDate TIMESTAMP CHECK(finishDate <= now()),
    state taskStatus NOT NULL DEFAULT 'open',
    createBy INTEGER NOT NULL REFERENCES users(userId) ON UPDATE CASCADE,
    assignedTo INTEGER REFERENCES users(userId) ON UPDATE CASCADE,
    projectTask INTEGER REFERENCES project(projectId) ON UPDATE CASCADE 
);
    
CREATE TABLE comment (
    commentId SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    createDate TIMESTAMP NOT NULL CHECK (createDate <= now()),
    edited BOOLEAN NOT NULL DEFAULT FALSE,
    commentBy INTEGER NOT NULL REFERENCES users(userId) ON UPDATE CASCADE,
    taskComment INTEGER NOT NULL REFERENCES task(taskId) ON UPDATE CASCADE
);

CREATE TABLE message (
    messageId SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    createDate TIMESTAMP NOT NULL CHECK (createDate <= now()),
    edited BOOLEAN NOT NULL DEFAULT FALSE,
    messageBy INTEGER REFERENCES users(userId) ON UPDATE CASCADE,
    projectMessage INTEGER REFERENCES project(projectId) ON UPDATE CASCADE
);

CREATE TABLE notification (
    notificationId SERIAL PRIMARY KEY,
    createDate TIMESTAMP NOT NULL CHECK (createDate <= now()),
    viewed BOOLEAN NOT NULL DEFAULT FALSE,
    emitedBy INTEGER NOT NULL REFERENCES users(userId) ON UPDATE CASCADE, 
    emitedTo INTEGER NOT NULL REFERENCES users(userId) ON UPDATE CASCADE,
    type notificationTypes NOT NULL,
    referenceID INTEGER NOT NULL
);


-----------------------------------------
-- INDEXES
-----------------------------------------

CREATE INDEX users_username ON users USING btree(username);
CLUSTER users USING users_username;

CREATE INDEX emitedBy_notification ON notification USING btree(emitedBy);
CLUSTER notification USING emitedBy_notification;

CREATE INDEX emitedTo_notification ON notification USING btree(emitedTo);
CLUSTER notification USING emitedTo_notification;

CREATE INDEX projectMessage_message ON message USING btree(projectMessage);
CLUSTER message USING projectMessage_message;

CREATE INDEX projectTask_task ON task USING hash(projectTask);

CREATE INDEX task_Comment ON comment USING hash(taskComment);


-----------------------------------------
-- TRIGGERS and UDFs
-----------------------------------------

--TRIGGER01 (Invite Notification)
CREATE FUNCTION inviteNotification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO notification (createDate, viewed, emitedBy, emitedTo, type, referenceID) VALUES (NEW.createDate, 
        FALSE, NEW.invitedBy, NEW.invitedTo , 'invite', NEW.inviteId);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER inviteNotification
    AFTER INSERT ON invite
    FOR EACH ROW
    EXECUTE PROCEDURE inviteNotification();


--TRIGGER02 (Coordinator Notification)
CREATE FUNCTION coordinatorNotification() RETURNS TRIGGER AS
$BODY$
DECLARE
    user_id INTEGER;
BEGIN 
    IF NEW.projectCoordinator <> OLD.projectCoordinator THEN
        FOR user_id IN (SELECT userId FROM project_users WHERE projectId = NEW.projectId) LOOP
            INSERT INTO notification (createDate, viewed, emitedBy, emitedTo, type, referenceID)
            VALUES ('2022-11-25', FALSE, NEW.projectCoordinator, user_id, 'coordinator', NEW.projectId);
        END LOOP;
    END IF;
    
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER coordinatorNotification
    AFTER UPDATE ON project
    FOR EACH ROW
    EXECUTE FUNCTION coordinatorNotification();



--TRIGGER03 (Archieve Task Notification)
CREATE FUNCTION archivedtaskNotification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.state = 'archived' AND NEW.state <> OLD.state THEN
        INSERT INTO notification (createDate, viewed, emitedBy, emitedTo, type, referenceID)
        VALUES ('2022-11-03', FALSE, (SELECT projectCoordinator from project WHERE NEW.projectTask = projectId), NEW.assignedTo, 'archivedtask', NEW.taskId);
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER archivedtaskNotification
    AFTER UPDATE ON task
    FOR EACH ROW
    EXECUTE PROCEDURE archivedtaskNotification();



--TRIGGER04 (Assigned Task Notification)
CREATE FUNCTION assignedtaskNotification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (OLD.assignedTo IS NULL AND NEW.assignedTo IS NOT NULL) OR
    (OLD.assignedTo IS NOT NULL AND NEW.assignedTo IS NOT NULL AND NEW.assignedTo <> OLD.assignedTo) THEN 
        INSERT INTO notification (createDate, viewed, emitedBy, emitedTo, type, referenceID) VALUES ('2022-11-03', 
            FALSE, (SELECT projectCoordinator from project WHERE NEW.projectTask = projectId), NEW.assignedTo, 'assignedtask', NEW.taskId);
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER assignedtaskNotification
        AFTER UPDATE ON task
        FOR EACH ROW
        EXECUTE PROCEDURE assignedtaskNotification();



--TRIGGER05 (Accepted Invite Notification)
CREATE FUNCTION acceptedInviteNotification() RETURNS TRIGGER AS
$BODY$
DECLARE
    user_id INTEGER;
BEGIN
    FOR user_id IN (SELECT userId FROM project_users WHERE projectId = New.projectId AND userId <> NEW.userId) LOOP
        INSERT INTO notification (createDate, viewed, emitedBy, emitedTo, type, referenceID) VALUES ('2022-11-03', 
            FALSE, (SELECT projectCoordinator from project WHERE NEW.projectId = projectId), user_id, 'acceptedinvite', NEW.projectId);
    END LOOP;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER acceptedInviteNotification
        AFTER INSERT ON project_users
        FOR EACH ROW
        EXECUTE PROCEDURE acceptedInviteNotification();



--TRIGGER06 (Comment Notification)
CREATE FUNCTION commentNotification() RETURNS TRIGGER AS
$BODY$
BEGIN 
    INSERT INTO notification (createDate, viewed, emitedBy, emitedTo, type, referenceID) VALUES (NEW.createDate, 
        FALSE, NEW.commentBy , (SELECT assignedTo FROM task WHERE NEW.taskComment = taskId), 'comment', NEW.commentId);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER commentNotification
        AFTER INSERT ON comment
        FOR EACH ROW
        EXECUTE PROCEDURE commentNotification();



--TRIGGER07 (Forum Notification)
CREATE FUNCTION forumNotification() RETURNS TRIGGER AS
$BODY$
DECLARE
    user_id INTEGER;
BEGIN
    FOR user_id IN (
        SELECT userId FROM project_users WHERE projectId = New.projectMessage AND userId <> NEW.messageBy
        UNION
        SELECT projectCoordinator FROM project WHERE projectId = NEW.projectMessage
        ) LOOP
        INSERT INTO notification (createDate, viewed, emitedBy, emitedTo, type, referenceID) VALUES (NEW.createDate, 
            FALSE, NEW.messageBy, user_id, 'forum', NEW.messageId);
    END LOOP;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER forumNotification
        AFTER INSERT ON message
        FOR EACH ROW
        EXECUTE PROCEDURE forumNotification();



--TRIGGER08 (An admin cannot create a project)
CREATE FUNCTION adminCreateProj() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM users WHERE isAdmin = TRUE AND NEW.createdBy = userId) THEN
        RAISE EXCEPTION 'An administrator cannot create a project.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER adminCreateProj
    BEFORE INSERT ON project
    FOR EACH ROW
    EXECUTE PROCEDURE adminCreateProj();


--TRIGGER09 (The coordinator cannot invite a user who is already a part of the team)
CREATE FUNCTION inviteUserInProject() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM project_users WHERE NEW.projectInvite = projectId AND NEW.invitedTo = userId) THEN
        RAISE EXCEPTION 'The user you want to invte is already on the project team.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER inviteUserInProject
    BEFORE INSERT ON invite
    FOR EACH ROW
    EXECUTE PROCEDURE inviteUserInProject();


--TRIGGER10 (The coordinator cannot be part of project as a worker)
CREATE FUNCTION coordinatorNotInProjectAsUser() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM project_users WHERE NEW.userId = (select projectCoordinator from project where NEW.projectId = projectId)) THEN
        RAISE EXCEPTION 'The coordinator cannot be part of project as a worker';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER coordinatorNotInProjectAsUser
    BEFORE INSERT ON project_users
    FOR EACH ROW
    EXECUTE PROCEDURE coordinatorNotInProjectAsUser();


--TRIGGER11 (User cannot comment on a task that is not assigned to someone or is archived)
CREATE FUNCTION commentUnassignedOrArchivedTask() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM task WHERE taskId = NEW.taskComment AND (assignedTo IS NULL OR state = 'archived')) THEN
        RAISE EXCEPTION 'User cannot comment on a task that is not assigned to someone or is archived';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER commentUnassignedOrArchivedTask
    BEFORE INSERT ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE commentUnassignedOrArchivedTask();


--TRIGGER12 (Update tasks when a user leaves a project)
CREATE FUNCTION updateTasksOnUserLeave() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE task
    SET state = 'open', assignedTo = NULL
    WHERE projectTask = OLD.projectId
    AND ((state = 'assigned' OR state = 'closed') AND assignedTo = OLD.userId);
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER updateTasksOnUserLeave
    AFTER DELETE ON project_users
    FOR EACH ROW
    EXECUTE PROCEDURE updateTasksOnUserLeave();


-----------------------------------------
-- end
-----------------------------------------