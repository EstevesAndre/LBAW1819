DROP TYPE IF EXISTS classEnum;
DROP TYPE IF EXISTS raceEnum;
DROP TYPE IF EXISTS motiveEnum;
DROP TYPE IF EXISTS notificationEnum;

DROP TABLE IF EXISTS "user";
DROP TABLE IF EXISTS regular;
DROP TABLE IF EXISTS api_user;
DROP TABLE IF EXISTS clan;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS "like";
DROP TABLE IF EXISTS share;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS message;
DROP TABLE IF EXISTS friendRequest;
DROP TABLE IF EXISTS clanRequest;
DROP TABLE IF EXISTS blocked;
DROP TABLE IF EXISTS report;
DROP TABLE IF EXISTS commentReport;
DROP TABLE IF EXISTS postReport;
DROP TABLE IF EXISTS notification;
DROP TABLE IF EXISTS clanInviteNotification;
DROP TABLE IF EXISTS messageNotification;
DROP TABLE IF EXISTS friendRequestNotification;
DROP TABLE IF EXISTS likeNotification;
DROP TABLE IF EXISTS commentNotification;
DROP TABLE IF EXISTS shareNotification;

-- Types
CREATE TYPE classEnum AS ENUM ('Fighter', 'Wizard', 'Rogue', 'Healer');
CREATE TYPE raceEnum AS ENUM ('Human', 'Elf', 'Dwarf');
CREATE TYPE motiveEnum AS ENUM ('Inappropriate behaviour', 'Abusive content', 'Racism');
CREATE TYPE notificationEnum AS ENUM ('clanInvite', 'message', 'friendRequest', 'like', 'comment', 'share');

-- Tables
CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    email text NOT NULL UNIQUE, 
    username text UNIQUE,
    password text,
    name text NOT NULL,
    birthdate DATE NOT NULL,
    race raceEnum NOT NULL,
    class classEnum NOT NULL,
    xp INTEGER NOT NULL DEFAULT 0 CHECK (xp >= 0),
    isAdmin BOOLEAN NOT NULL DEFAULT FALSE,
    clanID INTEGER
);
 
CREATE TABLE clan (
    id SERIAL PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
    description VARCHAR(250),
    ownerID INTEGER NOT NULL REFERENCES "user" (id)
);
 
CREATE TABLE post (
    id SERIAL PRIMARY KEY,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    text VARCHAR(500) NOT NULL,
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
    content text,
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
 
CREATE TABLE friendRequest (
    sender INTEGER NOT NULL REFERENCES "user" (id),
    receiver INTEGER NOT NULL REFERENCES "user" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    hasAccepted BOOLEAN,
    PRIMARY KEY (sender, receiver)
);
 
CREATE TABLE clanRequest (
    sender INTEGER NOT NULL REFERENCES "user" (id),
    receiver INTEGER NOT NULL REFERENCES "user" (id),
    clan INTEGER NOT NULL REFERENCES clan (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    hasAccepted BOOLEAN,
    PRIMARY KEY (sender, receiver, clan)
);  
 
CREATE TABLE blocked (
    userID INTEGER NOT NULL REFERENCES "user" (id) PRIMARY KEY,
    admin INTEGER  NOT NULL REFERENCES "user" (id),
    "date" TIMESTAMP WITH TIME zone NOT NULL,
    motive motiveEnum NOT NULL
);
 
CREATE TABLE report (
    id SERIAL,
    sender INTEGER NOT NULL REFERENCES "user" (id),
    admin INTEGER  NOT NULL REFERENCES "user" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    reportText VARCHAR(250),
    motive motiveEnum NOT NULL,
    PRIMARY KEY (id, admin)
);

CREATE TABLE commentReport (
    reportID INTEGER NOT NULL,
    adminID INTEGER NOT NULL,
    commentID INTEGER NOT NULL REFERENCES comment (id),
    FOREIGN KEY (reportID, adminID) REFERENCES report (id, admin) ON UPDATE CASCADE,
    PRIMARY KEY(reportID, adminID)
);

CREATE TABLE postReport (
    reportID INTEGER NOT NULL,
    adminID INTEGER NOT NULL,
    postID INTEGER NOT NULL REFERENCES post (id),
    FOREIGN KEY (reportID, adminID) REFERENCES report (id, admin) ON UPDATE CASCADE,
    PRIMARY KEY(reportID, adminID)
);

CREATE TABLE notification (
   id SERIAL PRIMARY KEY,
   "type" notificationEnum NOT NULL,
   "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
   hasBeenSeen BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE clanInviteNotification (
    notificationID INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    requestSender INTEGER NOT NULL,
    requestReceiver INTEGER NOT NULL,
    requestClan INTEGER NOT NULL,
    FOREIGN KEY (requestSender, requestReceiver, requestClan) REFERENCES clanRequest (sender, receiver, clan)
);

CREATE TABLE messageNotification (
    notificationID INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    messageID INTEGER NOT NULL
    FOREIGN KEY (messageID) REFERENCES message (id)
);

CREATE TABLE friendRequestNotification (
    notificationID INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    requestSender INTEGER NOT NULL,
    requestReceiver INTEGER NOT NULL,
    requestClan INTEGER NOT NULL,
    FOREIGN KEY (requestSender, requestReceiver, requestClan) REFERENCES clanRequest (sender, receiver, clan)
);

CREATE TABLE likeNotification (
    notificationID INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    likePostID INTEGER NOT NULL,
    likeUserID INTEGER NOT NULL,
    FOREIGN KEY (likePostID, likeUserID) REFERENCES "like" (postID, userID) ON UPDATE CASCADE
);

CREATE TABLE commentNotification (
    notificationID INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    commentID INTEGER NOT NULL REFERENCES comment (id) ON UPDATE CASCADE
);

CREATE TABLE shareNotification (
    notificationID INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    sharePostID INTEGER NOT NULL,
    shareUserID INTEGER NOT NULL,
    FOREIGN KEY (sharePostID, shareUserID) REFERENCES share(postID, userID) ON UPDATE CASCADE
);

ALTER TABLE "user" 
ADD FOREIGN KEY (clanID) REFERENCES clan (id);
