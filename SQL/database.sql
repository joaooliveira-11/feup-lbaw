create schema if not exists lbaw23117;
SET search_path TO lbaw23117;

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
DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS notification CASCADE;


DROP TYPE IF EXISTS statusTypes;
DROP TYPE IF EXISTS editedTypes;

CREATE TYPE statusTypes AS ENUM ('open', 'closed', 'archived');
CREATE TYPE edited AS ENUM ('original', 'edited');
CREATE TYPE notificationType as ENUM('assignedtask, archivedtask, invite, forum, comment, acceptedinvite');

CREATE TABLE users (
    userId INTEGER PRIMARY KEY,
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
    interestId INTEGER PRIMARY KEY,
    interest TEXT NOT NULL 
);

CREATE TABLE user_interests(
    userId INTEGER REFERENCES Users,
    interestId INTEGER REFERENCES Interest,
    PRIMARY KEY (userId, interestId)
);

CREATE TABLE skill (
    skillId INTEGER PRIMARY KEY,
    skill TEXT NOT NULL 
);

CREATE TABLE user_skills(
    userId INTEGER REFERENCES Users,
    skillId INTEGER REFERENCES Skill,
    PRIMARY KEY (userId, skillId)
); 

CREATE TABLE project (
    projectId INTEGER PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    isPublic BOOLEAN NOT NULL DEFAULT TRUE,
    archived BOOLEAN NOT NULL DEFAULT FALSE,
    createDate TIMESTAMP NOT NULL CHECK(createDate <= now()),
    createdBy INTEGER NOT NULL REFERENCES Users,
    projectCoordinator INTEGER NOT NULL REFERENCES Users
);

CREATE TABLE project_users (
    projectId INTEGER REFERENCES Project,
    userId INTEGER REFERENCES Users,
    PRIMARY KEY (projectId, userId)
);

CREATE TABLE favorite_projects (
    projectId INTEGER REFERENCES Project,
    userId INTEGER REFERENCES Users,
    PRIMARY KEY (projectId, userId)
);

CREATE TABLE invite (
    inviteId INTEGER PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    createDate TIMESTAMP NOT NULL CHECK (createDate <= now()),
    invitedBy INTEGER NOT NULL REFERENCES Users,
    invitedTo INTEGER NOT NULL REFERENCES Users,
    projectInvite INTEGER NOT NULL REFERENCES Project
);

CREATE TABLE task (
    taskId INTEGER PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    priority TEXT NOT NULL,
    createDate TIMESTAMP NOT NULL CHECK(createDate <= now()),
    finishDate TIMESTAMP,
    state statusTypes NOT NULL DEFAULT 'open',
    createBy INTEGER NOT NULL REFERENCES Users,
    assignedTo INTEGER REFERENCES Users,
    projectTask INTEGER REFERENCES Project 
);
    
CREATE TABLE comment (
    commentId INTEGER PRIMARY KEY,
    content TEXT NOT NULL,
    createDate TIMESTAMP NOT NULL CHECK (createDate <= now()),
    edited BOOLEAN NOT NULL DEFAULT FALSE,
    commentBy INTEGER NOT NULL REFERENCES Users,
    taskComment INTEGER NOT NULL REFERENCES Task   
);

CREATE TABLE message (
    messageId INTEGER PRIMARY KEY,
    content TEXT NOT NULL,
    createDate TIMESTAMP NOT NULL CHECK (createDate <= now()),
    edited BOOLEAN NOT NULL DEFAULT FALSE,
    messageBy INTEGER REFERENCES Users,
    projectMessage INTEGER REFERENCES Project
);

CREATE TABLE notification (
    notificationId INTEGER PRIMARY KEY,
    createDate TIMESTAMP NOT NULL CHECK (createDate <= now()),
    viewed BOOLEAN NOT NULL DEFAULT FALSE,
    emitedBy INTEGER NOT NULL REFERENCES Users, 
    emitedTo INTEGER NOT NULL REFERENCES Users,
    type notificationType NOT NULL,
    referenceID INTEGER NOT NULL
);

