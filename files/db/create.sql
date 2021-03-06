-----------------------------------------
-- Drop old schmema
-----------------------------------------

DROP TABLE IF EXISTS "users" CASCADE;
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
DROP TABLE IF EXISTS notification CASCADE;
DROP TABLE IF EXISTS userClan CASCADE;

DROP TYPE IF EXISTS classEnum;
DROP TYPE IF EXISTS raceEnum;
DROP TYPE IF EXISTS motiveEnum;
DROP TYPE IF EXISTS requestEnum;

DROP FUNCTION IF EXISTS verifyReportAdmin() CASCADE;
DROP FUNCTION IF EXISTS verifyBlockingAdmin() CASCADE;
DROP FUNCTION IF EXISTS userAcceptClanInvite() CASCADE;
DROP FUNCTION IF EXISTS userStillBlocked() CASCADE;
DROP FUNCTION IF EXISTS userCanRequestFriend() CASCADE;
DROP FUNCTION IF EXISTS repeatedClanInvite() CASCADE;
DROP FUNCTION IF EXISTS addPostXP() CASCADE;
DROP FUNCTION IF EXISTS addCommentXP() CASCADE;
DROP FUNCTION IF EXISTS addShareXP() CASCADE;
DROP FUNCTION IF EXISTS addLikeXP() CASCADE;

DROP TRIGGER IF EXISTS verifyReportAdmin ON report;
DROP TRIGGER IF EXISTS verifyBlockingAdmin ON blocked;
DROP TRIGGER IF EXISTS userAcceptClanInvite ON report;
DROP TRIGGER IF EXISTS userStillBlocked ON blocked;
DROP TRIGGER IF EXISTS userCanRequestFriend ON request;
DROP TRIGGER IF EXISTS repeatedClanInvite ON request;
DROP TRIGGER IF EXISTS addPostXP ON post;
DROP TRIGGER IF EXISTS addCommentXP ON comment;
DROP TRIGGER IF EXISTS addShareXP ON comment;
DROP TRIGGER IF EXISTS addLikeXP ON comment;

-----------------------------------------
-- Types
-----------------------------------------

CREATE TYPE classEnum AS ENUM ('Fighter', 'Wizard', 'Rogue', 'Healer');
CREATE TYPE raceEnum AS ENUM ('Human', 'Elf', 'Dwarf');
CREATE TYPE motiveEnum AS ENUM ('Inappropriate behaviour', 'Abusive content', 'Racism');
CREATE TYPE requestEnum AS ENUM ('friendRequest', 'clanRequest');

-----------------------------------------
-- Tables
-----------------------------------------

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
    userID INTEGER NOT NULL REFERENCES "user" (id),
    clanID INTEGER REFERENCES clan (id)
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
    hasAccepted BOOLEAN,
    UNIQUE (sender, receiver, "type")
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
    commentID INTEGER REFERENCES comment (id),
    postID INTEGER REFERENCES post (id),
    motive motiveEnum NOT NULL
);

CREATE TABLE notification (
    id SERIAL PRIMARY KEY,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    requestID INTEGER REFERENCES request (id),
    messageID INTEGER REFERENCES message (id),
    commentID INTEGER REFERENCES comment (id),
    likePostID INTEGER,
    likeUserID INTEGER,
    sharePostID INTEGER,
    shareUserID INTEGER,
    FOREIGN KEY (likePostID, likeUserID) REFERENCES "like"(postID, userID),
    FOREIGN KEY (sharePostID, shareUserID) REFERENCES share(postID, userID),
    hasBeenSeen BOOLEAN DEFAULT FALSE
);

-----------------------------------------
-- INDEXES
-----------------------------------------
CREATE INDEX request_sender_recevier ON request USING btree(sender, receiver);
CREATE INDEX message_sender_recevier ON message USING btree(sender, receiver);
CREATE INDEX post_user ON post USING hash(userID);
CREATE INDEX post_id ON post USING hash(id);
CREATE INDEX share_post ON share USING hash(postID);
CREATE INDEX share_user ON share USING hash(userID);
CREATE INDEX userClan_user ON userClan USING hash(userID);
CREATE INDEX userClan_clan ON userClan USING hash(clanID);
CREATE INDEX user_username ON "user" USING hash(username);
CREATE INDEX post_content_search ON post USING GIN (to_tsvector('english', content));
CREATE INDEX clan_description_search ON "clan" USING GIN (to_tsvector('english', description));
CREATE INDEX message_search ON "message" USING GIN (to_tsvector('english', messageText));

-----------------------------------------
-- TRIGGERS and UDFs
-----------------------------------------

CREATE FUNCTION verifyReportAdmin() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM "user"
        WHERE "user".id = New.admin AND "user".isAdmin = FALSE
    ) 
    THEN RAISE EXCEPTION 'Only an Admin (with permissions) can handle an user report.';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verifyReportAdmin
    BEFORE INSERT OR UPDATE ON report
    FOR EACH ROW
    EXECUTE PROCEDURE verifyReportAdmin();

CREATE FUNCTION verifyBlockingAdmin() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM "user"
        WHERE "user".id = New.admin AND "user".isAdmin = FALSE
    ) 
    THEN RAISE EXCEPTION 'Only an Admin (with permissions) can block an user.';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verifyBlockingAdmin
    BEFORE INSERT OR UPDATE ON blocked
    FOR EACH ROW
    EXECUTE PROCEDURE verifyBlockingAdmin();

CREATE FUNCTION userAcceptClanInvite() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM userClan
        WHERE userID = Old.receiver AND Old."type" = 'clanRequest' AND New.hasAccepted = TRUE
    )
    THEN RAISE EXCEPTION 'User cannot join a clan while is already a member of another clan.';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER userAcceptClanInvite
    BEFORE UPDATE ON request
    FOR EACH ROW
    EXECUTE PROCEDURE userAcceptClanInvite();

CREATE FUNCTION userStillBlocked() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM blocked
        WHERE userID = New.userID AND "date" > now()
    ) 
    THEN RAISE EXCEPTION 'User is already blocked.';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER userStillBlocked
    BEFORE INSERT ON blocked
    FOR EACH ROW
    EXECUTE PROCEDURE userStillBlocked();

CREATE FUNCTION userCanRequestFriend() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM request
        WHERE "type" = 'friendRequest' AND sender = New.receiver AND receiver = New.sender AND hasAccepted IS NULL
    )
    THEN RAISE EXCEPTION 'User already has a not answered friend request from that user.';
    END IF;
    IF EXISTS (
        SELECT *
        FROM request
        WHERE "type" = 'friendRequest' AND sender = New.receiver AND receiver = New.sender AND hasAccepted = TRUE
    )
    THEN RAISE EXCEPTION 'Users are already friends.';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER userCanRequestFriend
    BEFORE INSERT ON request
    FOR EACH ROW
    EXECUTE PROCEDURE userCanRequestFriend();

CREATE FUNCTION repeatedClanInvite() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM request
        WHERE "type" = 'clanRequest' AND receiver = New.receiver AND clanID = New.clanID
    ) 
    THEN RAISE EXCEPTION 'User already received an invite from that clan (not answered yet or already answered).';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER repeatedClanInvite
    BEFORE INSERT OR UPDATE ON request
    FOR EACH ROW
    EXECUTE PROCEDURE repeatedClanInvite();

CREATE FUNCTION addPostXP() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT * FROM "user" WHERE id = New.userID AND race = 'Human'
    )   THEN UPDATE "user" SET xp = xp + 10 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "user" WHERE id = New.userID AND race = 'Elf'
    )   THEN UPDATE "user" SET xp = xp + 10 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "user" WHERE id = New.userID AND race = 'Dwarf'
    )   THEN UPDATE "user" SET xp = xp + 10 WHERE id = New.userID;
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER addPostXP
    AFTER INSERT ON post
    FOR EACH ROW
    EXECUTE PROCEDURE addPostXP();

CREATE FUNCTION addCommentXP() RETURNS TRIGGER AS
$BODY$
DECLARE
    posting_user_id INT;
BEGIN
    SELECT "user".id INTO posting_user_id FROM "user", post  WHERE "user".id = post.userID AND post.id = New.postID;

    IF EXISTS (
        SELECT * FROM "user" WHERE id = New.userID AND race = 'Human' AND NOT(id = posting_user_id)
    )   THEN UPDATE "user" SET xp = xp + 5 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "user" WHERE id = posting_user_id  AND race = 'Human' AND NOT(id = New.userID)
    )   THEN UPDATE "user" SET xp = xp + 10 WHERE id = posting_user_id;
    END IF;

    IF EXISTS (
        SELECT * FROM "user" WHERE id = New.userID AND race = 'Elf' AND NOT(id = posting_user_id)
    )   THEN UPDATE "user" SET xp = xp + 10 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "user" WHERE id = posting_user_id  AND race = 'Elf' AND NOT(id = New.userID)
    )   THEN UPDATE "user" SET xp = xp + 20 WHERE id = posting_user_id;
    END IF;

    IF EXISTS (
        SELECT * FROM "user" WHERE id = New.userID AND race = 'Dwarf' AND NOT(id = posting_user_id)
    )   THEN UPDATE "user" SET xp = xp + 15 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "user" WHERE id = posting_user_id  AND race = 'Dwarf' AND NOT(id = New.userID)
    )   THEN UPDATE "user" SET xp = xp + 30 WHERE id = posting_user_id;
    END IF;

    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER addCommentXP
    AFTER INSERT ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE addCommentXP();

CREATE FUNCTION addShareXP() RETURNS TRIGGER AS
$BODY$
DECLARE
    posting_user_id INT;
BEGIN
    SELECT "user".id INTO posting_user_id FROM "user", post  WHERE "user".id = post.userID AND post.id = New.postID;

    IF EXISTS (
        SELECT * FROM "user" WHERE id = New.userID AND race = 'Human' AND NOT(id = posting_user_id)
    )   THEN UPDATE "user" SET xp = xp + 15 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "user" WHERE id = posting_user_id  AND race = 'Human' AND NOT(id = New.userID)
    )   THEN UPDATE "user" SET xp = xp + 30 WHERE id = posting_user_id;
    END IF;

    IF EXISTS (
        SELECT * FROM "user" WHERE id = New.userID AND race = 'Elf' AND NOT(id = posting_user_id)
    )   THEN UPDATE "user" SET xp = xp + 5 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "user" WHERE id = posting_user_id  AND race = 'Elf' AND NOT(id = New.userID)
    )   THEN UPDATE "user" SET xp = xp + 10 WHERE id = posting_user_id;
    END IF;

    IF EXISTS (
        SELECT * FROM "user" WHERE id = New.userID AND race = 'Dwarf' AND NOT(id = posting_user_id)
    )   THEN UPDATE "user" SET xp = xp + 10 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "user" WHERE id = posting_user_id  AND race = 'Dwarf' AND NOT(id = New.userID)
    )   THEN UPDATE "user" SET xp = xp + 20 WHERE id = posting_user_id;
    END IF;

    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER addShareXP
    AFTER INSERT ON share
    FOR EACH ROW
    EXECUTE PROCEDURE addShareXP();

CREATE FUNCTION addLikeXP() RETURNS TRIGGER AS
$BODY$
DECLARE
    posting_user_id INT;
BEGIN
    SELECT "user".id INTO posting_user_id FROM "user", post  WHERE "user".id = post.userID AND post.id = New.postID;

    IF EXISTS (
        SELECT * FROM "user" WHERE id = New.userID AND race = 'Human' AND NOT(id = posting_user_id)
    )   THEN UPDATE "user" SET xp = xp + 15 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "user" WHERE id = posting_user_id  AND race = 'Human' AND NOT(id = New.userID)
    )   THEN UPDATE "user" SET xp = xp + 30 WHERE id = posting_user_id;
    END IF;

    IF EXISTS (
        SELECT * FROM "user" WHERE id = New.userID AND race = 'Elf' AND NOT(id = posting_user_id)
    )   THEN UPDATE "user" SET xp = xp + 5 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "user" WHERE id = posting_user_id  AND race = 'Elf' AND NOT(id = New.userID)
    )   THEN UPDATE "user" SET xp = xp + 10 WHERE id = posting_user_id;
    END IF;

    IF EXISTS (
        SELECT * FROM "user" WHERE id = New.userID AND race = 'Dwarf' AND NOT(id = posting_user_id)
    )   THEN UPDATE "user" SET xp = xp + 10 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "user" WHERE id = posting_user_id  AND race = 'Dwarf' AND NOT(id = New.userID)
    )   THEN UPDATE "user" SET xp = xp + 20 WHERE id = posting_user_id;
    END IF;

    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER addLikeXP
    AFTER INSERT ON "like"
    FOR EACH ROW
    EXECUTE PROCEDURE addLikeXP();