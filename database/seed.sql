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
            NEW.tsvectors :=
                setweight(to_tsvector('english', coalesce(NEW.name, '')), 'A') ||
                setweight(to_tsvector('english', coalesce(NEW.username, '')), 'B');
            RETURN NEW;
        END IF;
    END IF;

    RETURN NULL;
END $$ LANGUAGE plpgsql;

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
            NEW.tsvectors :=
                setweight(to_tsvector('english', coalesce(NEW.title, '')), 'A') ||
                setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B');
            RETURN NEW;
        END IF;
    END IF;

    RETURN NULL;
END $$ LANGUAGE plpgsql;

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
            NEW.tsvectors :=
                setweight(to_tsvector('english', coalesce(NEW.title, '')), 'A') ||
                setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B');
            RETURN NEW;
        END IF;
    END IF;

    RETURN NULL;
END $$ LANGUAGE plpgsql;

create TRIGGER task_search_update BEFORE INSERT OR UPDATE ON task
    FOR EACH ROW EXECUTE PROCEDURE task_search_update();

CREATE INDEX task_search__idx ON task USING GIN(tsvectors);

-----------------------------------------
-- end
-----------------------------------------

-----------------------------------------
-- Populate the database
-----------------------------------------

INSERT INTO users (name, username, email, password, description, photo, is_admin, is_banned, email_verification) VALUES
('Admin', 'admin', 'admin@gmail.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'User account for Admin', 'admin.jpg', TRUE, FALSE, TRUE),
('Bob Smith', 'bobsmith', 'bob@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'User account for Bob', 'bob.jpg', FALSE, FALSE, TRUE),
('Charlie Brown', 'charlieb', 'charlie@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'User account for Charlie', 'charlie.jpg', FALSE, FALSE, TRUE),
('Dav_id Wilson', 'dav_idw', 'dav_id@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'User account for Dav_id', 'dav_id.jpg', FALSE, FALSE, TRUE),
('Eve Anderson', 'evea', 'eve@example.com', 'password1234', 'User account for Eve', 'eve.jpg', FALSE, FALSE, TRUE),
('Frank Miller', 'frankm', 'frank@example.com', 'millerpwd567', 'User account for Frank', 'frank.jpg', FALSE, FALSE, TRUE),
('Grace Martinez', 'gracem', 'grace@example.com', 'grace12345', 'User account for Grace', 'grace.jpg', FALSE, FALSE, TRUE),
('Henry Davis', 'henryd', 'henry@example.com', 'davishash123', 'User account for Henry', 'henry.jpg', FALSE, FALSE, TRUE),
('Ivy Taylor', 'ivyt', 'ivy@example.com', 'ivysecurepwd', 'User account for Ivy', 'ivy.jpg', FALSE, FALSE, TRUE),
('Jack Adams', 'jacka', 'jack@example.com', 'jackpass789', 'User account for Jack', 'jack.jpg', FALSE, FALSE, TRUE),
('Karen White', 'karenw', 'karen@example.com', 'karenpassword', 'User account for Karen', 'karen.jpg', FALSE, FALSE, TRUE),
('Liam Scott', 'liams', 'liam@example.com', 'liam123456', 'User account for Liam', 'liam.jpg', FALSE, FALSE, TRUE),
('Mia Turner', 'miat', 'mia@example.com', 'mia7890pwd', 'User account for Mia', 'mia.jpg', FALSE, FALSE, TRUE),
('Noah Lewis', 'noahl', 'noah@example.com', 'noahpass123', 'User account for Noah', 'noah.jpg', FALSE, FALSE, TRUE),
('Olivia Hall', 'oliviah', 'olivia@example.com', 'secureolivia', 'User account for Olivia', 'olivia.jpg', FALSE, FALSE, TRUE),
('Peter Baker', 'peterb', 'peter@example.com', 'peterpwd2021', 'User account for Peter', 'peter.jpg', FALSE, FALSE, TRUE),
('Quinn King', 'quinnk', 'quinn@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'User account for Quinn', 'quinn.jpg', FALSE, FALSE, TRUE),
('Riley Garcia', 'rileyg', 'riley@example.com', 'rileypassword', 'User account for Riley', 'riley.jpg', FALSE, FALSE, TRUE),
('Sophia Allen', 'sophiaa', 'sophia@example.com', 'allen1234', 'User account for Sophia', 'sophia.jpg', FALSE, FALSE, TRUE),
('Thomas Wright', 'thomasw', 'thomas@example.com', 'pwdfortom', 'User account for Thomas', 'thomas.jpg', FALSE, FALSE, TRUE);


INSERT INTO interest (interest) VALUES
('Coding'),
('Web Development'),
('Machine Learning'),
('Open Source'),
('Data Science'),
('Problem Solving'),
('V_ideo Games'),
('AI and Robotics'),
('Blockchain'),
('Cybersecurity'),
('DevOps'),
('Cloud Computing'),
('Agile Methodology'),
('Hackathons'),
('Tech Conferences'),
('Programming Competitions'),
('Linux');


INSERT INTO user_interests (user_id, interest_id) VALUES 
(1, 1),
(1, 4),
(1, 7),
(2, 12),
(2, 15),
(3, 13),
(3, 16),
(4, 2),
(4, 9),
(5, 10),
(5, 11),
(6, 3),
(6, 5),
(7, 6),
(7, 8),
(8, 12),
(8, 13),
(9, 14),
(9, 1),
(10, 15),
(10, 17),
(11, 12),
(11, 15),
(12, 13), 
(12, 16),
(13, 13), 
(13, 16),
(14, 12), 
(14, 4),
(15, 3),
(15, 12), 
(16, 1), 
(16, 16),
(17, 7),
(17, 8),
(18, 17),
(18, 9),
(19, 9),
(19, 4),
(20, 11),
(20, 10);

INSERT INTO skill (skill) VALUES 
('Programming'),
('Web Development'),
('Database Management'),
('Graphic Design'),
('Data Analysis'),
('Project Management'),
('Marketing'),
('Cybersecurity'),
('DevOps'),
('IT Support'),
('Software Development'),
('Data Science');


INSERT INTO user_skills (user_id, skill_id) VALUES 
(2, 4),
(2, 7),
(3, 3),
(3, 2),
(4, 10),
(4, 8),
(5, 1),
(5, 12),
(6, 5),
(6, 6),
(7, 9),
(7, 7),
(8, 11),
(8, 6),
(9, 8),
(9, 7),
(10, 2),
(10, 4),
(11, 5),
(11, 1),
(12, 3),
(12, 7),
(13, 10),
(13, 1),
(14, 5),
(14, 10),
(15, 12),
(15, 6),
(16, 5),
(16, 11),
(17, 1),
(17, 9),
(18, 10),
(18, 2),
(19, 7),
(19, 4),
(20, 8),
(20, 3);


INSERT INTO project (title, description, is_public, archived, create_date, finish_date, created_by, project_coordinator) VALUES
('Website Redesign', 'Redesign our company website to improve user experience and visual appeal.', FALSE, FALSE, '2022-10-21', '2023-11-30', 2, 2),
('Marketing Campaign for New Product', 'Plan and execute a marketing campaign for our upcoming product launch.', TRUE, FALSE, '2022-10-20', '2022-12-15', 3, 3),
('Customer Support Enhancement', 'Improve our customer support system to prov_ide better assistance to our clients.', TRUE, FALSE, '2022-10-20', NULL, 5, 5),
('Sales Optimization Strategy', 'Develop a strategy to optimize our sales processes and increase revenue.', FALSE, FALSE, '2022-10-12','2022-11-30', 7, 7),
('E-commerce Website Development', 'Create an e-commerce platform for our online store with secure payment processing.', TRUE, FALSE, '2022-9-25', '2022-12-20', 9, 9),
('Content Marketing Plan', 'Plan and execute a content marketing strategy to enhance brand visibility.', TRUE, FALSE, '2022-10-13', '2022-11-30', 11, 11), 
('Data Analysis for Market Insights', 'Analyze market data to prov_ide insights and improve decision-making.', FALSE, FALSE, '2022-10-14', '2022-12-15', 13, 13),
('Social Media Engagement Campaign', 'Increase social media engagement and grow our online presence.', FALSE, TRUE, '2022-10-20', NULL, 15, 15),
('Project Management Tool Implementation', 'Implement a project management tool for efficient task tracking and coordination.', TRUE, FALSE, '2022-09-29', '2022-11-30',17, 17),
('Content Creation and Publishing', 'Create and publish engaging content to boost brand awareness and user engagement.',TRUE, FALSE, '2022-09-30', '2022-12-31', 19, 19),
('Mobile App Development', 'Develop a mobile app to prov_ide our users with a better mobile experience.', TRUE, FALSE, '2022-09-01', NULL, 2, 2),
('Product Inventory Management', 'Implement a system to efficiently manage product inventory and restocking.',TRUE, FALSE, '2022-08-02', '2022-11-30', 4, 4),
('Content Writing for Blog', 'Create high-quality content for our company blog to engage readers.', FALSE, FALSE, '2022-01-03', NULL, 5, 5),
('Customer Feedback Surveys', 'Design and conduct customer feedback surveys to gather insights for improvements.', TRUE, FALSE, '2022-02-04', '2022-12-15', 12, 12),
('Social Media Advertising', 'Launch social media advertising campaigns to increase our online reach.', TRUE, FALSE, '2022-03-05', NULL, 7, 7),
('Database Optimization', 'Optimize our database systems for faster data retrieval and storage.', FALSE, FALSE, '2022-04-06', '2022-11-30', 6, 6),
('Web Security Audit', 'Perform a comprehensive security audit of our website and systems.', FALSE, FALSE, '2022-05-07', NULL, 14, 14),
('Art Gallery Exhibition', 'Organize an art gallery exhibition to showcase local artists and their work.', TRUE, FALSE, '2022-06-08', '2022-12-31', 16, 16),
('Music Festival Planning', 'Plan and execute a music festival with multiple artists and stages.', TRUE, FALSE, '2022-07-09', NULL, 11, 11),
('Data Analytics Workshop', 'Host a workshop on data analytics to educate employees on data-driven decision-making.', TRUE, FALSE, '2022-09-10', '2022-11-30', 15, 15);

INSERT INTO project_users (project_id, user_id) VALUES
(1, 3),
(1, 8),
(2, 7),
(2, 17),
(2, 11),
(3, 8),
(3, 13),
(3, 2),
(4, 4),
(4, 5),
(5, 6),
(5, 15),
(6, 16),
(6, 12),
(7, 4),
(7, 9),
(8, 10),
(8, 13),
(9, 2),
(9, 5),
(10, 8),
(10, 14),
(11, 7),
(11, 12),
(12, 2),
(12, 3),
(13, 18),
(13, 19),
(14, 6),
(14, 16),
(15, 11),
(15, 15),
(16, 8),
(16, 13),
(17, 2),
(17, 9),
(18, 4),
(18, 5),
(19, 6),
(19, 16),
(20, 10),
(20, 12);


INSERT INTO task (title, description, priority, create_date, finish_date, state, create_by, assigned_to, project_task) VALUES
('Redesign Homepage Banner', 'Create a new homepage banner design for the website with a focus on our upcoming product launch.', 'High', '2022-10-17 08:00:00', '2022-10-18 16:00:00', 'assigned', 2, 3, 1),
('Keyword Research for Marketing', 'Conduct keyword research to _identify target keywords for our marketing campaign.', 'Medium', '2022-10-17 09:00:00', NULL, 'open', 3, NULL, 2),
('Product Launch Event Planning', 'Plan and coordinate the upcoming product launch event for our new offering.', 'High', '2022-10-19 10:00:00', '2022-10-24 16:00:00', 'assigned', 3, 17, 2),
('Customer Support Ticket System Upgrade', 'Upgrade our customer support ticket system to improve response times and user experience.', 'Low', '2022-10-17 10:00:00', '2022-10-19 14:00:00', 'assigned', 5, 8, 3),
('Sales Report Analysis', 'Analyze recent sales reports to _identify trends and opportunities for growth.', 'High', '2022-10-17 11:00:00', NULL, 'open', 7, NULL, 4),
('Mobile App UI Design', 'Design the user interface for the mobile app, focusing on a user-friendly experience.', 'Medium', '2022-10-17 12:00:00', '2022-10-20 12:00:00', 'assigned', 9, 6, 5), 
('Content Marketing Calendar Planning', 'Plan the content marketing calendar for the next quarter to align with our brand strategy.', 'Low', '2022-10-17 13:00:00', NULL, 'open', 11, NULL, 6),
('Software Testing and Quality Assurance', 'Conduct testing and quality assurance for a software product before release.', 'High', '2022-10-19 12:00:00', '2022-10-21 16:00:00', 'assigned', 11, 16, 6),
('Market Data Presentation', 'Prepare a presentation with insights from market data analysis for the executive team.', 'High', '2022-10-17 14:00:00', '2022-10-21 10:00:00', 'assigned', 13, 4, 7),
('Social Media Content Creation', 'Create engaging social media content to boost user engagement and brand visibility.', 'Medium', '2022-10-17 15:00:00', NULL, 'open', 15, NULL, 8),
('Project Management Tool Implementation', 'Implement a project management tool for efficient task tracking and coordination.', 'Low', '2022-10-17 16:00:00', '2022-10-22 18:00:00', 'assigned', 17, 2, 9),
('Blog Article Writing', 'Write a blog article on data analytics and its impact on business decision-making for the company blog.', 'High', '2022-10-17 17:00:00', NULL, 'open', 19, NULL, 10),
('Database Performance Monitoring', 'Monitor and optimize database performance to ensure efficient data retrieval.', 'Low', '2022-10-19 14:00:00', '2022-10-21 16:00:00', 'assigned', 19, 14, 10),
('E-commerce Platform Payment Integration', 'Integrate secure payment processing into the e-commerce platform.', 'High', '2022-10-18 08:00:00', '2022-10-20 16:00:00', 'assigned', 2, 7, 11),
('Inventory Management System Testing', 'Conduct testing of the product inventory management system to ensure accuracy.', 'Low', '2022-10-18 10:00:00', '2022-10-19 14:00:00', 'assigned', 4, 6, 12),
('Blog Article Proofreading', 'Proofread and edit blog articles to ensure high-quality content before publication.', 'Medium', '2022-10-18 11:00:00', '2022-10-21 16:00:00', 'assigned', 5, 19, 13),
('Customer Feedback Survey Analysis', 'Analyze data from customer feedback surveys to extract valuable insights.', 'High', '2022-10-18 12:00:00', '2022-10-22 16:00:00', 'assigned', 12, 16, 14),
('Social Media Ad Campaign Management', 'Manage and optimize social media advertising campaigns for better results.', 'Medium', '2022-10-18 13:00:00', '2022-10-25 16:00:00', 'assigned', 7, 11, 15),
('Database Query Optimization', 'Optimize database queries for faster data retrieval and reporting.', 'High', '2022-10-18 14:00:00', '2022-10-21 16:00:00', 'assigned', 6, 13, 16),
('Web Security Vulnerability Patching', 'Patch security vulnerabilities found during the web security audit.', 'Medium', '2022-10-18 15:00:00', '2022-10-20 14:00:00', 'assigned', 14, 9, 17),
('Art Gallery Exhibition Setup', 'Coordinate the setup and arrangement of artworks for the art gallery exhibition.', 'Low', '2022-10-18 16:00:00', NULL, 'open', 16, NULL, 18),
('Music Festival Ticket Sales', 'Manage and oversee ticket sales for the upcoming music festival.', 'Medium', '2022-10-18 17:00:00', '2022-10-23 14:00:00', 'archived', 11, 6, 19),
('Content Marketing Analysis', 'Analyze the performance of content marketing campaigns and prov_ide insights for improvement.', 'Medium', '2022-10-18 09:00:00', '2022-10-24 16:00:00', 'assigned', 15, 10, 20),
('Website Security Audit Report', 'Prepare a detailed security audit report for the website with findings and recommendations.', 'High', '2022-10-19 15:00:00', NULL, 'open', 15, NULL, 20);


INSERT INTO comment (content, create_date, edited, comment_by, task_comment) VALUES
('Great progress on this task!', '2022-10-17 08:30:00', FALSE, 8, 1),
('The new design looks fantastic!', '2022-10-17 14:15:00', FALSE, 7, 3),
('I need some more information to proceed.', '2022-10-17 16:30:00', FALSE, 13, 4),
('I am making good progress on this task.', '2022-10-18 12:45:00', FALSE, 15, 6), 
('Looking forward to seeing the content!', '2022-10-19 09:30:00', TRUE, 17, 8),
('Tool implementation is on track.', '2022-10-19 13:55:00', FALSE, 4, 9), 
('Keep up the good work!', '2022-10-20 14:25:00', FALSE, 5, 11),
('Let me know if you need assistance.', '2022-10-21 15:30:00', FALSE, 8, 13),
('Looking forward to the festival!', '2022-10-23 10:00:00', FALSE, 18, 16),
('The mobile app UI is looking great!', '2022-10-23 14:15:00', FALSE, 6, 17),
('We should analyze the sales trends further.', '2022-10-24 08:30:00', TRUE, 11, 18),
('Please make sure the content aligns with our brand.', '2022-10-24 12:45:00', FALSE, 13, 19);


INSERT INTO invite (title, description, create_date, invited_by, invited_to, project_invite) VALUES
('Web Development Collaboration', 'Join us in an exciting web development project to create innovative solutions.', '2022-10-21', 2, 5, 1),
('Marketing Campaign Team', 'Collaborate on a strategic marketing campaign to boost brand visibility and growth.', '2022-10-22', 9, 11, 5),
('Data Analysis Team Invitation', 'Join our team of data analysts to uncover valuable insights and drive informed decisions.', '2022-10-23', 13, 6, 7),
('Sales Optimization Initiative', 'Participate in an initiative to optimize our sales processes and increase revenue.', '2022-10-24', 2, 8, 11),
('E-commerce Platform Development', 'Get involved in the creation of an e-commerce platform for our online store.', '2022-10-25', 7, 10, 15),
('Content Marketing Collaboration', 'Collaborate on a content marketing strategy to enhance brand visibility and user engagement.', '2022-10-26', 16, 12, 18);


INSERT INTO message (content, create_date, edited, message_by, project_message) VALUES 
('Welcome to our project! We are excited to have you on board.', '2022-10-25', FALSE, 3, 1),
('Lets collaborate and make this project a success!', '2022-10-26', TRUE, 10, 8),
('Important update: We will have a team meeting tomorrow at 2 PM.', '2022-10-27', FALSE, 15, 5),
('Great job on completing your tasks ahead of schedule!', '2022-10-28', FALSE, 6, 14),
('Reminder: The project deadline is approaching. Keep up the good work!', '2022-10-29', FALSE, 9, 17);


-----------------------------------------
-- end
-----------------------------------------