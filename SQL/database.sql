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

DROP TYPE IF EXISTS task_status;
DROP TYPE IF EXISTS notification_types;

DROP FUNCTION IF EXISTS invite_notification;
DROP FUNCTION IF EXISTS coordinator_notification;
DROP FUNCTION IF EXISTS archivedtask_notification;
DROP FUNCTION IF EXISTS assignedtask_notification;
DROP FUNCTION IF EXISTS acceptedinvite_notification;
DROP FUNCTION IF EXISTS comment_notification;
DROP FUNCTION IF EXISTS forum_notification;
DROP FUNCTION IF EXISTS invite_user_in_project;
DROP FUNCTION IF EXISTS admin_create_proj;
DROP FUNCTION IF EXISTS coordinator_not_in_project;
DROP FUNCTION IF EXISTS update_tasks_on_user_leave;
DROP FUNCTION IF EXISTS comment_unassigned_or_archived_task;
DROP FUNCTION IF EXISTS user_search_update;
DROP FUNCTION IF EXISTS project_search_update;
DROP FUNCTION IF EXISTS task_search_update;
DROP FUNCTION IF EXISTS task_user_in_project;
DROP FUNCTION IF EXISTS check_ProjMember_before_comment;
DROP FUNCTION IF EXISTS check_ProjMember_before_message;
-----------------------------------------
-- Types
-----------------------------------------

CREATE TYPE task_status AS ENUM ('open', 'assigned', 'closed', 'archived');
CREATE TYPE notification_types as ENUM('assignedtask', 'coordinator', 'archivedtask', 'invite', 'forum', 'comment', 'acceptedinvite');

-----------------------------------------
-- Tables
-----------------------------------------

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    username TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    description TEXT,
    photo TEXT, 
    is_admin BOOLEAN NOT NULL DEFAULT FALSE, 
    is_banned BOOLEAN NOT NULL DEFAULT FALSE,
    email_verification BOOLEAN NOT NULL DEFAULT FALSE 
);

CREATE TABLE interest (
    interest_id SERIAL PRIMARY KEY,
    interest TEXT NOT NULL 
);

CREATE TABLE user_interests(
    user_id INTEGER REFERENCES users (id) ON UPDATE CASCADE,
    interest_id INTEGER REFERENCES interest (interest_id) ON UPDATE CASCADE,
    PRIMARY KEY (user_id, interest_id)
);

CREATE TABLE skill (
    skill_id SERIAL PRIMARY KEY,
    skill TEXT NOT NULL 
);

CREATE TABLE user_skills(
    user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE,
    skill_id INTEGER REFERENCES skill(skill_id) ON UPDATE CASCADE,
    PRIMARY KEY (user_id, skill_id)
); 

CREATE TABLE project (
    project_id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    is_public BOOLEAN NOT NULL DEFAULT TRUE,
    archived BOOLEAN NOT NULL DEFAULT FALSE,
    create_date TIMESTAMP NOT NULL CHECK(create_date <= now()),
    finish_date TIMESTAMP,
    created_by INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
    project_coordinator INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE
);

CREATE TABLE project_users (
    project_id INTEGER REFERENCES project(project_id) ON UPDATE CASCADE,
    user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE,
    PRIMARY KEY (project_id, user_id)
);

CREATE TABLE favorite_projects (
    project_id INTEGER REFERENCES project(project_id) ON UPDATE CASCADE,
    user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE,
    PRIMARY KEY (project_id, user_id)
);

CREATE TABLE invite (
    invite_id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    create_date TIMESTAMP NOT NULL CHECK (create_date <= now()),
    invited_by INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
    invited_to INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
    project_invite INTEGER NOT NULL REFERENCES project(project_id) ON UPDATE CASCADE
);

CREATE TABLE task (
    task_id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    priority TEXT NOT NULL,
    create_date TIMESTAMP NOT NULL CHECK(create_date <= now()),
    finish_date TIMESTAMP,
    state task_status NOT NULL DEFAULT 'open',
    create_by INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
    assigned_to INTEGER REFERENCES users(id) ON UPDATE CASCADE,
    project_task INTEGER REFERENCES project(project_id) ON UPDATE CASCADE 
);
    
CREATE TABLE comment (
    comment_id SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    create_date TIMESTAMP NOT NULL CHECK (create_date <= now()),
    edited BOOLEAN NOT NULL DEFAULT FALSE,
    comment_by INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
    task_comment INTEGER NOT NULL REFERENCES task(task_id) ON UPDATE CASCADE
);

CREATE TABLE message (
    message_id SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    create_date TIMESTAMP NOT NULL CHECK (create_date <= now()),
    edited BOOLEAN NOT NULL DEFAULT FALSE,
    message_by INTEGER REFERENCES users(id) ON UPDATE CASCADE,
    project_message INTEGER REFERENCES project(project_id) ON UPDATE CASCADE
);

CREATE TABLE notification (
    notification_id SERIAL PRIMARY KEY,
    create_Date TIMESTAMP NOT NULL CHECK (create_date <= now()),
    viewed BOOLEAN NOT NULL DEFAULT FALSE,
    emited_by INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE, 
    emited_to INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
    type notification_types NOT NULL,
    reference_id INTEGER NOT NULL
);


-----------------------------------------
-- INDEXES
-----------------------------------------

CREATE INDEX users_name ON users USING btree(name);
CLUSTER users USING users_name;

CREATE INDEX emitedBy_notification ON notification USING btree(emited_by);
CLUSTER notification USING emitedBy_notification;

CREATE INDEX emitedTo_notification ON notification USING btree(emited_to);
CLUSTER notification USING emitedTo_notification;

CREATE INDEX projectMessage_message ON message USING btree(project_message);
CLUSTER message USING projectMessage_message;

CREATE INDEX projectTask_task ON task USING hash(project_task);

CREATE INDEX task_comment ON comment USING hash(task_comment);


-----------------------------------------
-- TRIGGERS
-----------------------------------------

--TRIGGER01 (Invite Notification)
CREATE FUNCTION invite_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id) VALUES (NEW.create_date, 
        FALSE, NEW.invited_by, NEW.invited_to , 'invite', NEW.invite_id);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER invite_notification
    AFTER INSERT ON invite
    FOR EACH ROW
    EXECUTE PROCEDURE invite_notification();


--TRIGGER02 (Coordinator Notification)
CREATE FUNCTION coordinator_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    userslist INTEGER;
BEGIN 
    IF NEW.project_coordinator <> OLD.project_Coordinator THEN
        FOR userslist IN (SELECT user_id FROM project_users WHERE project_id = NEW.project_id) LOOP
            INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id)
            VALUES ('2022-11-25', FALSE, NEW.project_coordinator, userslist, 'coordinator', NEW.project_id);
        END LOOP;
    END IF;
    
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER coordinator_notification
    AFTER UPDATE ON project
    FOR EACH ROW
    EXECUTE FUNCTION coordinator_notification();



--TRIGGER03 (Archieve Task Notification)
CREATE FUNCTION archivedtask_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.state = 'archived' AND NEW.state <> OLD.state THEN
        INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id)
        VALUES ('2022-11-03', FALSE, (SELECT project_coordinator from project WHERE NEW.project_task = project_id), NEW.assigned_to, 'archivedtask', NEW.task_id);
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER archivedtask_notification
    AFTER UPDATE ON task
    FOR EACH ROW
    EXECUTE PROCEDURE archivedtask_notification();



--TRIGGER04 (Assigned Task Notification)
CREATE FUNCTION assignedtask_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (OLD.assigned_to IS NULL AND NEW.assigned_to IS NOT NULL) OR
    (OLD.assigned_to IS NOT NULL AND NEW.assigned_to IS NOT NULL AND NEW.assigned_to <> OLD.assigned_to) THEN 
        INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id) VALUES ('2022-11-03', 
            FALSE, (SELECT project_coordinator from project WHERE NEW.project_task = project_id), NEW.assigned_to, 'assignedtask', NEW.task_id);
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER assignedtask_notification
        AFTER UPDATE ON task
        FOR EACH ROW
        EXECUTE PROCEDURE assignedtask_notification();



--TRIGGER05 (Accepted Invite Notification)
CREATE FUNCTION acceptedinvite_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    userslist INTEGER;
BEGIN
    FOR userslist IN (SELECT user_id FROM project_users WHERE project_id = New.project_id AND user_id <> NEW.user_id) LOOP
        INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id) VALUES ('2022-11-03', 
            FALSE, (SELECT project_coordinator from project WHERE NEW.project_id = project_id), userslist, 'acceptedinvite', NEW.project_id);
    END LOOP;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER acceptedinvite_notification
        AFTER INSERT ON project_users
        FOR EACH ROW
        EXECUTE PROCEDURE acceptedinvite_notification();



--TRIGGER06 (Comment Notification)
CREATE FUNCTION comment_notification() RETURNS TRIGGER AS
$BODY$
BEGIN 
    INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id) VALUES (NEW.create_date, 
        FALSE, NEW.comment_by , (SELECT assigned_to FROM task WHERE NEW.task_comment = task_id), 'comment', NEW.comment_id);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER comment_notification
        AFTER INSERT ON comment
        FOR EACH ROW
        EXECUTE PROCEDURE comment_notification();



--TRIGGER07 (Forum Notification)
CREATE FUNCTION forum_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    userslist INTEGER;
BEGIN
    FOR userslist IN (
        SELECT user_id FROM project_users WHERE project_id = New.project_message AND user_id <> NEW.message_by
        UNION
        SELECT project_coordinator FROM project WHERE project_id = NEW.project_message
        ) LOOP
        INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id) VALUES (NEW.create_date, 
            FALSE, NEW.message_by, userslist, 'forum', NEW.message_id);
    END LOOP;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER forum_notification
        AFTER INSERT ON message
        FOR EACH ROW
        EXECUTE PROCEDURE forum_notification();



--TRIGGER08 (An admin cannot create a project)
CREATE FUNCTION admin_create_proj() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM users WHERE is_admin = TRUE AND NEW.created_by = users.id) THEN
        RAISE EXCEPTION 'An administrator cannot create a project.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER admin_create_proj
    BEFORE INSERT ON project
    FOR EACH ROW
    EXECUTE PROCEDURE admin_create_proj();


--TRIGGER09 (The coordinator cannot invite a user who is already a part of the team)
CREATE FUNCTION invite_user_in_project() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM project_users WHERE NEW.project_invite = project_id AND NEW.invited_to = user_id) THEN
        RAISE EXCEPTION 'The user you want to invte is already on the project team.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER invite_user_in_project
    BEFORE INSERT ON invite
    FOR EACH ROW
    EXECUTE PROCEDURE invite_user_in_project();


--TRIGGER10 (The coordinator cannot be part of project as a worker)
CREATE FUNCTION coordinator_not_in_project() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM project_users WHERE NEW.user_id = (select project_coordinator from project where NEW.project_id = project_id)) THEN
        RAISE EXCEPTION 'The coordinator cannot be part of project as a worker';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER coordinator_not_in_project
    BEFORE INSERT ON project_users
    FOR EACH ROW
    EXECUTE PROCEDURE coordinator_not_in_project();

--TRIGGER11 (User cannot comment on a task that is not assigned to someone or is archived)
CREATE FUNCTION comment_unassigned_or_archived_task() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM task WHERE task_id = NEW.task_comment AND (assigned_to IS NULL OR state = 'archived')) THEN
        RAISE EXCEPTION 'User cannot comment on a task that is not assigned to someone or is archived';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER comment_unassigned_or_archived_task
    BEFORE INSERT ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE comment_unassigned_or_archived_task();


--TRIGGER12 (Update tasks when a user leaves a project)
CREATE FUNCTION update_tasks_on_user_leave() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE task
    SET state = 'open', assigned_to = NULL
    WHERE project_task = OLD.project_id
    AND ((state = 'assigned' OR state = 'closed') AND assigned_to = OLD.user_id);
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER update_tasks_on_user_leave
    AFTER DELETE ON project_users
    FOR EACH ROW
    EXECUTE PROCEDURE update_tasks_on_user_leave();


--TRIGGER13 (The task has to be created by a user who is in the project)
CREATE OR REPLACE FUNCTION task_user_in_project() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NOT EXISTS (
        SELECT 1
        FROM project_users
        WHERE project_id = NEW.project_task
          AND user_id = NEW.create_by
    ) THEN
        RAISE EXCEPTION 'The task has to be created by a user who is in the project';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER task_user_in_project
    BEFORE INSERT ON task
    FOR EACH ROW
    EXECUTE PROCEDURE task_user_in_project();


--TRIGGER14 (The user cannot make a comment if they are not in the project.)
CREATE FUNCTION check_ProjMember_before_comment() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM project_users pu
        JOIN task t ON pu.project_id = t.project_task
        WHERE pu.user_id = NEW.comment_by AND t.task_id = NEW.task_comment
    ) THEN
        RAISE EXCEPTION 'User cannot make a comment if they are not in the project.';
    END IF;
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER check_ProjMember_before_comment
    BEFORE INSERT ON comment
    FOR EACH ROW 
    EXECUTE PROCEDURE check_ProjMember_before_comment();


--TRIGGER15 (Sender is not a member of this project.)
CREATE FUNCTION check_ProjMember_before_message() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM project_users WHERE user_id = NEW.message_by AND project_id = NEW.project_message
    ) THEN
        RAISE EXCEPTION 'User cannot send a message if they are not in the project..';
    END IF;
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER check_ProjMember_before_message
    BEFORE INSERT ON message
    FOR EACH ROW 
    EXECUTE PROCEDURE check_ProjMember_before_message();



-----------------------------------------
-- FULL-TEXT SEARCH INDEXES
----------------------------------------
--Full-text search index 1 -> for the users based on matching names and usernames
ALTER TABLE users ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION user_search_update() RETURNS trigger AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors :=
            setweight(to_tsvector('english', coalesce(NEW.name, '')), 'A') ||
            setweight(to_tsvector('english', coalesce(NEW.username, '')), 'B');
        RETURN NEW;
    END IF;

    IF TG_OP = 'UPDATE' THEN
        IF NEW.name <> OLD.name OR NEW.username <> OLD.username THEN
            NEW.tsvectors = (
                setweight(to_tsvector('english', coalesce(NEW.name, '')), 'A') ||
                setweight(to_tsvector('english', coalesce(NEW.username, '')), 'B')
            );
        END IF;
    END IF;
RETURN NEW;
END $$ 
LANGUAGE plpgsql;

CREATE TRIGGER user_search_update BEFORE INSERT OR UPDATE ON users
    FOR EACH ROW EXECUTE PROCEDURE user_search_update();

CREATE INDEX user_search__idx ON users USING GIN(tsvectors);


--Full-text search index 2 -> for the projects based on matching titles and descriptions

ALTER TABLE project ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION project_search_update() RETURNS trigger AS $$

BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors :=
            setweight(to_tsvector('english', coalesce(NEW.title, '')), 'A') ||
            setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B');
        RETURN NEW;
    END IF;

    IF TG_OP = 'UPDATE' THEN
        IF NEW.title <> OLD.title OR NEW.description <> OLD.description THEN
            NEW.tsvectors = (
                setweight(to_tsvector('english', coalesce(NEW.title, '')), 'A') ||
                setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B');
            );
        END IF;
    END IF;
RETURN NEW;
END $$ 
LANGUAGE plpgsql;

CREATE TRIGGER project_search_update BEFORE INSERT OR UPDATE ON project
    FOR EACH ROW EXECUTE PROCEDURE project_search_update();

CREATE INDEX project_search__idx ON project USING GIN(tsvectors);

-- Full-text search index 3 -> for the tasks based on matching titles and descriptions

ALTER TABLE task ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION task_search_update() RETURNS trigger AS $$

BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors :=
            setweight(to_tsvector('english', coalesce(NEW.title, '')), 'A') ||
            setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B');
        RETURN NEW;
    END IF;

    IF TG_OP = 'UPDATE' THEN
        IF NEW.title <> OLD.title OR NEW.description <> OLD.description THEN
             NEW.tsvectors = (
                setweight(to_tsvector('english', coalesce(NEW.title, '')), 'A') ||
                setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B')
             );
        END IF;
    END IF;
RETURN NEW;
END $$ 
LANGUAGE plpgsql;

create TRIGGER task_search_update BEFORE INSERT OR UPDATE ON task
    FOR EACH ROW EXECUTE PROCEDURE task_search_update();

CREATE INDEX task_search__idx ON task USING GIN(tsvectors);
-----------------------------------------
-- end
-----------------------------------------