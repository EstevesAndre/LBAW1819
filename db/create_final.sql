-- Types
 DROP TYPE IF EXISTS classEnum;
 DROP TYPE IF EXISTS raceEnum;
 DROP TYPE IF EXISTS motiveEnum;

CREATE TYPE classEnum AS ENUM ('Fighter', 'Wizard', 'Rogue', 'Healer');
CREATE TYPE raceEnum AS ENUM ('Human', 'Elf', 'Dwarf');
CREATE TYPE motiveEnum AS ENUM ('Inappropriate behaviour', 'Abusive content', 'Racism');

 
-- Tables
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
DROP TABLE IF EXISTS "notification";
DROP TABLE IF EXISTS clanInviteNotification;
DROP TABLE IF EXISTS messageNotification;
DROP TABLE IF EXISTS friendRequestNotification;
DROP TABLE IF EXISTS likeNotification;
DROP TABLE IF EXISTS commentNotification;
DROP TABLE IF EXISTS shareNotification;

CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    email text NOT NULL CONSTRAINT user_email_uk UNIQUE,
    name text NOT NULL,
    birthdate DATE NOT NULL,
    race raceEnum NOT NULL,
    class classEnum NOT NULL,
    xp INTEGER NOT NULL DEFAULT 0 CHECK (xp >= 0),
    is_admin BOOLEAN NOT NULL DEFAULT FALSE,
    clan_id INTEGER NOT NULL
);
 
CREATE TABLE regular (
    user_id SERIAL NOT NULL REFERENCES "user" (id) PRIMARY KEY, 
    name text NOT NULL CONSTRAINT name_uk UNIQUE,
    password text NOT NULL
);
 
CREATE TABLE api_user (
   user_id SERIAL NOT NULL REFERENCES "user" (id) PRIMARY KEY
);
 
CREATE TABLE clan (
    id SERIAL PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
    description VARCHAR(250),
    owner_id INTEGER NOT NULL REFERENCES "user" (id)
);
 
CREATE TABLE post (
    id SERIAL PRIMARY KEY,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    text VARCHAR(500) NOT NULL,
    img BOOLEAN NOT NULL,
    user_id INTEGER NOT NULL REFERENCES "user" (id)
);  
 
CREATE TABLE "like" (
    post_id INTEGER NOT NULL REFERENCES post (id),
    user_id INTEGER NOT NULL REFERENCES "user" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    PRIMARY KEY (post_id, user_id)
);
 
CREATE TABLE share (
    post_id INTEGER NOT NULL REFERENCES post (id),
    user_id INTEGER NOT NULL REFERENCES "user" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    PRIMARY KEY (post_id, user_id)
);
 
CREATE TABLE comment (
    id SERIAL PRIMARY KEY,
    post_id INTEGER NOT NULL REFERENCES post (id),
    user_id INTEGER NOT NULL REFERENCES "user" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    comment_text VARCHAR(250)
);
 
CREATE TABLE message (
    sender INTEGER NOT NULL REFERENCES "user" (id),
    receiver INTEGER NOT NULL REFERENCES "user" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    message_text VARCHAR(250),
    PRIMARY KEY (sender, receiver, "date")
);
 
CREATE TABLE friendRequest (
    sender INTEGER NOT NULL REFERENCES "user" (id),
    receiver INTEGER NOT NULL REFERENCES "user" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    decision BOOLEAN,
    PRIMARY KEY (sender, receiver)
);
 
CREATE TABLE clanRequest (
    sender INTEGER NOT NULL REFERENCES "user" (id),
    receiver INTEGER NOT NULL REFERENCES "user" (id),
    clan INTEGER NOT NULL REFERENCES clan (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    decision BOOLEAN,
    PRIMARY KEY (sender, receiver, clan)
);  
 
CREATE TABLE blocked (
    user_id INTEGER NOT NULL REFERENCES "user" (id) PRIMARY KEY,
    admin INTEGER  NOT NULL REFERENCES "user" (id),
    "date" TIMESTAMP WITH TIME zone NOT NULL,
    motive motiveEnum NOT NULL
);
 
CREATE TABLE report (
    id SERIAL,
    sender INTEGER NOT NULL REFERENCES "user" (id),
    admin INTEGER  NOT NULL REFERENCES "user" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    report_text VARCHAR(250),
    motive motiveEnum NOT NULL,
    PRIMARY KEY (id, admin)
);

CREATE TABLE commentReport (
    id_report INTEGER NOT NULL,
    id_admin INTEGER NOT NULL,
    id_comment INTEGER NOT NULL REFERENCES comment (id),
    FOREIGN KEY (id_report, id_admin) REFERENCES report (id, admin) ON UPDATE CASCADE,
    PRIMARY KEY(id_report, id_admin)
);

CREATE TABLE postReport (
    id_report INTEGER NOT NULL,
    id_admin INTEGER NOT NULL,
    id_post INTEGER NOT NULL REFERENCES post (id),
    FOREIGN KEY (id_report, id_admin) REFERENCES report (id, admin) ON UPDATE CASCADE,
    PRIMARY KEY(id_report, id_admin)
);

CREATE TABLE notification (
   id SERIAL PRIMARY KEY,
   "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
   seen BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE clanInviteNotification (
    id_notification INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    request_sender INTEGER NOT NULL,
    request_receiver INTEGER NOT NULL,
    request_clan INTEGER NOT NULL,
    FOREIGN KEY (request_sender, request_receiver, request_clan) REFERENCES clanRequest (sender, receiver, clan)
);

CREATE TABLE messageNotification (
    id_notification INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    message_sender INTEGER NOT NULL,
    message_receiver INTEGER NOT NULL,
    message_date DATE NOT NULL,
    FOREIGN KEY (message_sender, message_receiver, message_date) REFERENCES message (sender, receiver, date)
);

CREATE TABLE friendRequestNotification (
    id_notification INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    request_sender INTEGER NOT NULL,
    request_receiver INTEGER NOT NULL,
    request_clan INTEGER NOT NULL,
    FOREIGN KEY (request_sender, request_receiver, request_clan) REFERENCES clanRequest (sender, receiver, clan)
);

CREATE TABLE likeNotification (
    id_notification INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    like_post_id INTEGER NOT NULL,
    like_user_id INTEGER NOT NULL,
    FOREIGN KEY (like_post_id, like_user_id) REFERENCES "like" (post_id, user_id) ON UPDATE CASCADE
);

CREATE TABLE commentNotification (
    id_notification INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    id_comment INTEGER NOT NULL REFERENCES comment (id) ON UPDATE CASCADE
);

CREATE TABLE shareNotification (
    id_notification INTEGER NOT NULL REFERENCES notification (id) PRIMARY KEY,
    share_post_id INTEGER NOT NULL,
    share_user_id INTEGER NOT NULL,
    FOREIGN KEY (share_post_id, share_user_id) REFERENCES share(post_id, user_id) ON UPDATE CASCADE
);

ALTER TABLE "user" 
ADD FOREIGN KEY (clan_id) REFERENCES clan (id);
