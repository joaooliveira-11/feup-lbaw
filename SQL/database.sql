DROP TABLE IF EXISTS User CASCADE;
DROP TABLE IF EXISTS Interest CASCADE;
DROP TABLE IF EXISTS UserInterests CASCADE;
DROP TABLE IF EXISTS Skill CASCADE;
DROP TABLE IF EXISTS UserSkills CASCADE;
DROP TABLE IF EXISTS Project CASCADE;
DROP TABLE IF EXISTS ProjectUsers CASCADE;
DROP TABLE IF EXISTS FavoriteProjects CASCADE;
DROP TABLE IF EXISTS Invite CASCADE;
DROP TABLE IF EXISTS Task CASCADE;
DROP TABLE IF EXISTS Comment CASCADE;

DROP TYPE IF EXISTS statusTypes;
DROP TYPE IF EXISTS editedTypes;

CREATE TYPE statusTypes AS ENUM ('open', 'closed', 'archived');
CREATE TYPE edited AS ENUM ('original', 'edited');

CREATE TABLE User (
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

CREATE TABLE Interest (
    interestId INTEGER PRIMARY KEY,
    interest TEXT NOT NULL 
);

CREATE TABLE UserInterests(
    FOREIGN KEY serId INTEGER REFERENCES user,
    interestId INTEGER REFERENCES interest,
    PRIMARY KEY (userId, Id)
);

CREATE TABLE Skill (
    skillId INTEGER PRIMARY KEY,
    skill TEXT NOT NULL 
);

CREATE TABLE UserSkills(
    userId INTEGER REFERENCES user,
    skillId INTEGER REFERENCES skill,
    PRIMARY KEY (userId, skillId)
); 

CREATE TABLE Project (
    projectId INTEGER PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    isPublic BOOLEAN NOT NULL DEFAULT TRUE,
    archived BOOLEAN NOT NULL DEFAULT FALSE,
    createDate TIMESTAMP NOT NULL CHECK(createDate <= now()),
    isPublic BOOLEAN NOT NULL DEFAULT TRUE,
    archived BOOLEAN NOT NULL DEFAULT FALSE,
    createdBy INTEGER NOT NULL REFERENCES user,
    projectCoordinator NOT NULL REFERENCES user
);

CREATE TABLE ProjectUsers (
    projectId INTEGER REFERENCES project,
    userId INTEGER REFERENCES user,
    PRIMARY KEY (projectId, userId)
);

CREATE TABLE FavoriteProjects (
    projectId INTEGER REFERENCES project,
    userId INTEGER REFERENCES user,
    PRIMARY KEY (projectId, userId)
);

CREATE TABLE Invite (
    inviteId INTEGER PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    createDate TIMESTAMP NOT NULL CHECK (createDate <= now()),
    invitedBy INTEGER NOT NULL REFERENCES User,
    invitedTo INTEGER NOT NULL REFERENCES User,
    projectInvite INTEGER NOT NULL REFERENCES Project
);

CREATE TABLE Task (
    taskId INTEGER PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    priority TEXT NOT NULL,
    createDate TIMESTAMP NOT NULL CHECK(createDate <= now()),
    finishDate TIMESTAMP,
    state statusTypes NOT NULL DEFAULT 'open',
    createBy INTEGER NOT NULL REFERENCES User,
    assignedTo INTEGER REFERENCES User,
    projectTask INTEGER REFERENCES Project 
);
    
CREATE TABLE Comment (
    commentId INTEGER PRIMARY KEY,
    content TEXT NOT NULL,
    createDate TIMESTAMP NOT NULL CHECK (createDate <= now()),
    edited BOOLEAN NOT NULL DEFAULT FALSE,
    commentBy INTEGER NOT NULL REFERENCES User,
    taskComment INTEGER NOT NULL REFERENCES Task   
);

CREATE TABLE Message (
    messageId INTEGER PRIMARY KEY,
    content TEXT NOT NULL,
    createDate TIMESTAMP NOT NULL CHECK (createDate <= now()),
    edited BOOLEAN NOT NULL DEFAULT FALSE,
    messageBy INTEGER REFERENCES User,
    projectMessage INTEGER REFERENCES Project
);

CREATE TABLE Notification (
    notificationId INTEGER PRIMARY KEY,
    createDate TIMESTAMP NOT NULL CHECK (createDate <= now()),
    viewed BOOLEAN NOT NULL DEFAULT FALSE,
    emitedBy INTEGER NOT NULL REFERENCES User, 
    emitedTo INTEGER NOT NULL REFERENCES User
);




