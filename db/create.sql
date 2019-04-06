DROP TABLE IF EXISTS "user" CASCADE;
DROP TABLE IF EXISTS regular CASCADE;
DROP TABLE IF EXISTS api_user CASCADE;
DROP TABLE IF EXISTS clan CASCADE;
DROP TABLE IF EXISTS post CASCADE;
DROP TABLE IF EXISTS "like" CASCADE;
DROP TABLE IF EXISTS share CASCADE;
DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS message CASCADE;
DROP TABLE IF EXISTS request CASCADE;
DROP TABLE IF EXISTS friendRequest CASCADE;
DROP TABLE IF EXISTS clanRequest CASCADE;
DROP TABLE IF EXISTS blocked CASCADE;
DROP TABLE IF EXISTS report CASCADE;
DROP TABLE IF EXISTS commentReport CASCADE;
DROP TABLE IF EXISTS postReport CASCADE;
DROP TABLE IF EXISTS notification CASCADE;
DROP TABLE IF EXISTS clanInviteNotification CASCADE;
DROP TABLE IF EXISTS messageNotification CASCADE;
DROP TABLE IF EXISTS friendRequestNotification CASCADE;
DROP TABLE IF EXISTS likeNotification CASCADE;
DROP TABLE IF EXISTS commentNotification CASCADE;
DROP TABLE IF EXISTS shareNotification CASCADE;
DROP TABLE IF EXISTS userClan CASCADE;

DROP TYPE IF EXISTS classEnum;
DROP TYPE IF EXISTS raceEnum;
DROP TYPE IF EXISTS motiveEnum;
DROP TYPE IF EXISTS notificationEnum;
DROP TYPE IF EXISTS requestEnum;


-- Types
CREATE TYPE classEnum AS ENUM ('Fighter', 'Wizard', 'Rogue', 'Healer');
CREATE TYPE raceEnum AS ENUM ('Human', 'Elf', 'Dwarf');
CREATE TYPE motiveEnum AS ENUM ('Inappropriate behaviour', 'Abusive content', 'Racism');
CREATE TYPE notificationEnum AS ENUM ('clanInvite', 'message', 'friendRequest', 'like', 'comment', 'share');
CREATE TYPE requestEnum AS ENUM ('friendRequest', 'clanRequest');

-- Tables
CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    email VARCHAR(30) NOT NULL UNIQUE, 
    username VARCHAR(20) UNIQUE,
    password VARCHAR(20),
    name VARCHAR(30),
    birthdate DATE,
    race raceEnum,
    class classEnum,
    xp INTEGER NOT NULL DEFAULT 0 CHECK (xp >= 0),
    isAdmin BOOLEAN NOT NULL DEFAULT FALSE
);
 
CREATE TABLE clan (
    id SERIAL PRIMARY KEY,
    name VARCHAR(20) NOT NULL UNIQUE,
    description VARCHAR(250),
    ownerID INTEGER NOT NULL REFERENCES "user" (id)
);

CREATE TABLE userClan (
    userID INTEGER NOT NULL REFERENCES "user" PRIMARY KEY,
    clanID INTEGER NOT NULL REFERENCES clan
);
 
CREATE TABLE post (
    id SERIAL PRIMARY KEY,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    content VARCHAR(500) NOT NULL,
    hasImg BOOLEAN NOT NULL,
    userID INTEGER NOT NULL REFERENCES "user" (id)
);  
 
CREATE TABLE "like" (
    postID INTEGER NOT NULL REFERENCES post (id),
    userID INTEGER NOT NULL REFERENCES "user" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    PRIMARY KEY (postID, userID)
);
 
CREATE TABLE share (
    postID INTEGER NOT NULL REFERENCES post (id),
    userID INTEGER NOT NULL REFERENCES "user" (id),
    content VARCHAR(500),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    PRIMARY KEY (postID, userID)
);
 
CREATE TABLE comment (
    id SERIAL PRIMARY KEY,
    postID INTEGER NOT NULL REFERENCES post (id),
    userID INTEGER NOT NULL REFERENCES "user" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    commentText VARCHAR(250)
);
 
CREATE TABLE message (
    id SERIAL PRIMARY KEY,
    sender INTEGER NOT NULL REFERENCES "user" (id),
    receiver INTEGER NOT NULL REFERENCES "user" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    messageText VARCHAR(250),
    hasBeenSeen BOOLEAN NOT NULL DEFAULT FALSE
);
 
CREATE TABLE request (
    id SERIAL PRIMARY KEY,
    sender INTEGER NOT NULL REFERENCES "user" (id),
    receiver INTEGER NOT NULL REFERENCES "user" (id),
    clanID INTEGER REFERENCES clan (id),
    "type" requestEnum,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    hasAccepted BOOLEAN
);  
 
CREATE TABLE blocked (
    id SERIAL PRIMARY KEY,
    userID INTEGER NOT NULL REFERENCES "user" (id),
    admin INTEGER  NOT NULL REFERENCES "user" (id),
    "date" TIMESTAMP WITH TIME zone NOT NULL,
    motive motiveEnum NOT NULL
);
 
CREATE TABLE report (
    id SERIAL PRIMARY KEY,
    sender INTEGER NOT NULL REFERENCES "user" (id),
    admin INTEGER  NOT NULL REFERENCES "user" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    reportText VARCHAR(250),
    motive motiveEnum NOT NULL
);

CREATE TABLE commentReport (
    reportID INTEGER PRIMARY KEY,
    commentID INTEGER NOT NULL REFERENCES comment (id),
    FOREIGN KEY (reportID) REFERENCES report (id)
);

CREATE TABLE postReport (
    reportID INTEGER PRIMARY KEY,
    postID INTEGER NOT NULL REFERENCES post (id),
    FOREIGN KEY (reportID) REFERENCES report (id)
);

CREATE TABLE notification (
   id SERIAL PRIMARY KEY,
   "type" notificationEnum NOT NULL,
   "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
   hasBeenSeen BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE clanInviteNotification (
    notificationID INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    requestID INTEGER NOT NULL REFERENCES request (id)
);

CREATE TABLE messageNotification (
    notificationID INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    messageID INTEGER NOT NULL REFERENCES message (id)
);

CREATE TABLE friendRequestNotification (
    notificationID INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    requestID INTEGER NOT NULL REFERENCES request (id)
);

CREATE TABLE likeNotification (
    notificationID INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    likePostID INTEGER NOT NULL,
    likeUserID INTEGER NOT NULL,
    FOREIGN KEY (likePostID, likeUserID) REFERENCES "like" (postID, userID)
);

CREATE TABLE commentNotification (
    notificationID INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    commentID INTEGER NOT NULL REFERENCES comment (id)   
);

CREATE TABLE shareNotification (
    notificationID INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    sharePostID INTEGER NOT NULL,
    shareUserID INTEGER NOT NULL,
    FOREIGN KEY (sharePostID, shareUserID) REFERENCES share(postID, userID)
);
