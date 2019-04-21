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

DROP TYPE IF EXISTS classEnum CASCADE;
DROP TYPE IF EXISTS raceEnum CASCADE;
DROP TYPE IF EXISTS motiveEnum CASCADE;
DROP TYPE IF EXISTS requestEnum CASCADE;

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

DROP TRIGGER IF EXISTS verifyReportAdmin ON report CASCADE;
DROP TRIGGER IF EXISTS verifyBlockingAdmin ON blocked CASCADE;
DROP TRIGGER IF EXISTS userAcceptClanInvite ON report CASCADE;
DROP TRIGGER IF EXISTS userStillBlocked ON blocked CASCADE;
DROP TRIGGER IF EXISTS userCanRequestFriend ON request CASCADE;
DROP TRIGGER IF EXISTS repeatedClanInvite ON request CASCADE;
DROP TRIGGER IF EXISTS addPostXP ON post CASCADE;
DROP TRIGGER IF EXISTS addCommentXP ON comment CASCADE;
DROP TRIGGER IF EXISTS addShareXP ON comment CASCADE;
DROP TRIGGER IF EXISTS addLikeXP ON comment CASCADE;

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

CREATE TABLE "users" (
    id SERIAL PRIMARY KEY,
    email VARCHAR(30) NOT NULL UNIQUE, 
    username VARCHAR(20) UNIQUE,
    password VARCHAR(255),
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
    ownerID INTEGER NOT NULL REFERENCES "users" (id)
);

CREATE TABLE userClan (
    userID INTEGER NOT NULL REFERENCES "users" PRIMARY KEY,
    clanID INTEGER NOT NULL REFERENCES clan
);
 
CREATE TABLE post (
    id SERIAL PRIMARY KEY,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    content VARCHAR(500) NOT NULL,
    hasImg BOOLEAN NOT NULL,
    userID INTEGER NOT NULL REFERENCES "users" (id),
    clanID INTEGER REFERENCES clan (id)
);  
 
CREATE TABLE "like" (
    postID INTEGER NOT NULL REFERENCES post (id),
    userID INTEGER NOT NULL REFERENCES "users" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    PRIMARY KEY (postID, userID)
);
 
CREATE TABLE share (
    postID INTEGER NOT NULL REFERENCES post (id),
    userID INTEGER NOT NULL REFERENCES "users" (id),
    content VARCHAR(500),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    PRIMARY KEY (postID, userID)
);
 
CREATE TABLE comment (
    id SERIAL PRIMARY KEY,
    postID INTEGER NOT NULL REFERENCES post (id),
    userID INTEGER NOT NULL REFERENCES "users" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    commentText VARCHAR(250)
);
 
CREATE TABLE message (
    id SERIAL PRIMARY KEY,
    sender INTEGER NOT NULL REFERENCES "users" (id),
    receiver INTEGER NOT NULL REFERENCES "users" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    messageText VARCHAR(250),
    hasBeenSeen BOOLEAN NOT NULL DEFAULT FALSE
);
 
CREATE TABLE request (
    id SERIAL PRIMARY KEY,
    sender INTEGER NOT NULL REFERENCES "users" (id),
    receiver INTEGER NOT NULL REFERENCES "users" (id),
    clanID INTEGER REFERENCES clan (id),
    "type" requestEnum,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    hasAccepted BOOLEAN,
    UNIQUE (sender, receiver, "type")
);  

CREATE TABLE blocked (
    id SERIAL PRIMARY KEY,
    userID INTEGER NOT NULL REFERENCES "users" (id),
    admin INTEGER  NOT NULL REFERENCES "users" (id),
    "date" TIMESTAMP WITH TIME zone NOT NULL,
    motive motiveEnum NOT NULL
);
 
CREATE TABLE report (
    id SERIAL PRIMARY KEY,
    sender INTEGER NOT NULL REFERENCES "users" (id),
    admin INTEGER  NOT NULL REFERENCES "users" (id),
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
CREATE INDEX users_username ON "users" USING hash(username);
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
        FROM "users"
        WHERE "users".id = New.admin AND "users".isAdmin = FALSE
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
        FROM "users"
        WHERE "users".id = New.admin AND "users".isAdmin = FALSE
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
        SELECT * FROM "users" WHERE id = New.userID AND race = 'Human'
    )   THEN UPDATE "users" SET xp = xp + 10 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "users" WHERE id = New.userID AND race = 'Elf'
    )   THEN UPDATE "users" SET xp = xp + 10 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "users" WHERE id = New.userID AND race = 'Dwarf'
    )   THEN UPDATE "users" SET xp = xp + 10 WHERE id = New.userID;
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
    SELECT "users".id INTO posting_user_id FROM "users", post  WHERE "users".id = post.userID AND post.id = New.postID;

    IF EXISTS (
        SELECT * FROM "users" WHERE id = New.userID AND race = 'Human' AND NOT(id = posting_user_id)
    )   THEN UPDATE "users" SET xp = xp + 5 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "users" WHERE id = posting_user_id  AND race = 'Human' AND NOT(id = New.userID)
    )   THEN UPDATE "users" SET xp = xp + 10 WHERE id = posting_user_id;
    END IF;

    IF EXISTS (
        SELECT * FROM "users" WHERE id = New.userID AND race = 'Elf' AND NOT(id = posting_user_id)
    )   THEN UPDATE "users" SET xp = xp + 10 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "users" WHERE id = posting_user_id  AND race = 'Elf' AND NOT(id = New.userID)
    )   THEN UPDATE "users" SET xp = xp + 20 WHERE id = posting_user_id;
    END IF;

    IF EXISTS (
        SELECT * FROM "users" WHERE id = New.userID AND race = 'Dwarf' AND NOT(id = posting_user_id)
    )   THEN UPDATE "users" SET xp = xp + 15 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "users" WHERE id = posting_user_id  AND race = 'Dwarf' AND NOT(id = New.userID)
    )   THEN UPDATE "users" SET xp = xp + 30 WHERE id = posting_user_id;
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
    SELECT "users".id INTO posting_user_id FROM "users", post  WHERE "users".id = post.userID AND post.id = New.postID;

    IF EXISTS (
        SELECT * FROM "users" WHERE id = New.userID AND race = 'Human' AND NOT(id = posting_user_id)
    )   THEN UPDATE "users" SET xp = xp + 15 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "users" WHERE id = posting_user_id  AND race = 'Human' AND NOT(id = New.userID)
    )   THEN UPDATE "users" SET xp = xp + 30 WHERE id = posting_user_id;
    END IF;

    IF EXISTS (
        SELECT * FROM "users" WHERE id = New.userID AND race = 'Elf' AND NOT(id = posting_user_id)
    )   THEN UPDATE "users" SET xp = xp + 5 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "users" WHERE id = posting_user_id  AND race = 'Elf' AND NOT(id = New.userID)
    )   THEN UPDATE "users" SET xp = xp + 10 WHERE id = posting_user_id;
    END IF;

    IF EXISTS (
        SELECT * FROM "users" WHERE id = New.userID AND race = 'Dwarf' AND NOT(id = posting_user_id)
    )   THEN UPDATE "users" SET xp = xp + 10 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "users" WHERE id = posting_user_id  AND race = 'Dwarf' AND NOT(id = New.userID)
    )   THEN UPDATE "users" SET xp = xp + 20 WHERE id = posting_user_id;
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
    SELECT "users".id INTO posting_user_id FROM "users", post  WHERE "users".id = post.userID AND post.id = New.postID;

    IF EXISTS (
        SELECT * FROM "users" WHERE id = New.userID AND race = 'Human' AND NOT(id = posting_user_id)
    )   THEN UPDATE "users" SET xp = xp + 15 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "users" WHERE id = posting_user_id  AND race = 'Human' AND NOT(id = New.userID)
    )   THEN UPDATE "users" SET xp = xp + 30 WHERE id = posting_user_id;
    END IF;

    IF EXISTS (
        SELECT * FROM "users" WHERE id = New.userID AND race = 'Elf' AND NOT(id = posting_user_id)
    )   THEN UPDATE "users" SET xp = xp + 5 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "users" WHERE id = posting_user_id  AND race = 'Elf' AND NOT(id = New.userID)
    )   THEN UPDATE "users" SET xp = xp + 10 WHERE id = posting_user_id;
    END IF;

    IF EXISTS (
        SELECT * FROM "users" WHERE id = New.userID AND race = 'Dwarf' AND NOT(id = posting_user_id)
    )   THEN UPDATE "users" SET xp = xp + 10 WHERE id = New.userID;
    END IF;
    IF EXISTS (
        SELECT * FROM "users" WHERE id = posting_user_id  AND race = 'Dwarf' AND NOT(id = New.userID)
    )   THEN UPDATE "users" SET xp = xp + 20 WHERE id = posting_user_id;
    END IF;

    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER addLikeXP
    AFTER INSERT ON "like"
    FOR EACH ROW
    EXECUTE PROCEDURE addLikeXP();

/*
    DATA
*/

INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('rui.patricio@gmail.com', 'ruiWolves', '_n@6EEs6', 'John Michael', '1998-05-16', 'Elf', 'Fighter',  205, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('beto.gr@gmail.com', 'Bebeto', 'K8c4)-Tx' , 'Andrew Esteves', '1997-03-18', 'Human', 'Wizard', 124, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('sa.ze@hotmail.com', 'Zezocas', '!8Y,yZ^', 'Francisco Filipe', '1997-03-18', 'Human', 'Fighter', 2030, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('pepe.oficial@gmail.com', 'Pepe123', '`/Fsa2g%', 'Lewis Silva', '1997-03-18', 'Elf', 'Wizard', 1540, TRUE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('zecafontes@gmail.com', 'Fontes', 'V~n8`5$*', 'Pedro Silva', '1997-03-18','Human', 'Fighter', 6074, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('guerreiro.def@gmail.com', 'Guerreiro_do_BVB', 'Z;-8g^Wc', 'Simon Silva', '1998-01-20', 'Dwarf', 'Rogue', 681, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('cancelo.juve@hotmail.com', 'CanceloSLB', '?\H=jB3\', 'Pedro Fernandes', '1997-03-18', 'Elf', 'Rogue', 112, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('dias_ruben@gmail.com', 'GOATdaDefesa', 'e7Gh/s-K', 'Bruno Sousa', '1997-03-18', 'Elf', 'Healer', 967, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('mario_rui@gmail.com', 'Ruizinho', ':YG^n9^z', 'Antero Santos', '1997-03-18', 'Human', 'Fighter', 420, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('nelson_semedo.goat@gmail.com', 'M10better_thanCR7', ')K:9Bu^*', 'John Angelical', '1997-03-18', 'Elf', 'Wizard', 2304, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('joao_moutinho@gmail.com', 'MacaPodre', 'Xy>qz9M', 'Mariana Costa', '1997-03-18', 'Dwarf', 'Rogue', 437, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('carvalho.william@gmail.com', 'William_Carvalho', '^7kNr~N', 'Catarina Almeida', '1997-03-18', 'Human', 'Wizard', 892, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('mario_joao@gmail.com', 'OMeuAmoreoSporting', 'q3NTt6.C', 'Miguel Barraca', '1997-03-18', 'Elf', 'Rogue', 1423, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('danilo.fcp@gmail.com', 'ItzDanilo', 'k3M~4&./', 'Tony Costa', '1997-03-18','Dwarf', 'Healer', 3048, TRUE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('pizzi@gmail.com', 'PizziOficial', '`7vJ4aHw', 'Marcelo Sousa', '1997-03-18', 'Human', 'Fighter', 1024, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('bruno_nandes@gmail.com', 'AMinhaVidaeoSport', '[Yw?J5XP', 'Pedro Coelho', '1997-03-18', 'Human', 'Wizard',1312, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('neves_ruben@gmail.com', 'SoGolaceiras', 'W]d89up]', 'Louis Vieira', '1997-03-18','Dwarf', 'Healer', 430, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('feliz.joao@gmail.com', 'NextCR7', '6@9Hz\V', 'Alexandre Santos', '1997-03-18','Dwarf', 'Wizard', 20, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('bernas.silva@gmail.com', 'EuSouOBernas', 'BVy%8y8f', 'Fernando Rocha', '1997-03-18', 'Human', 'Rogue', 4512, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, xp, isAdmin) 
VALUES('rafa_slb@gmail.com', 'JustRafa', '#9sYEtAg', 'Leonel Silva', '1997-03-18', 'Elf', 'Fighter', 960, FALSE);


INSERT INTO clan(name, description, ownerID) 
VALUES('Default Clan','Looking forward for the first place in the clans leaderboard',14);
INSERT INTO clan(name, description, ownerID) 
VALUES('Selection of Quinas','As a selection, we decided to creat a clan to show the union of this team',20);
INSERT INTO clan(name, description, ownerID) 
VALUES('Liga das Nations','Support Clan for our warriors in Liga das Nations',4);
INSERT INTO clan(name, description, ownerID) 
VALUES('EURO 2016','Remembering old times with our french friends',11);
INSERT INTO clan(name, description, ownerID) 
VALUES('Falta o Eder','A tiny tribute to our national hero Ederzito. Join our cause',17);


INSERT INTO userClan(userID, clanID) VALUES(1, 1);
INSERT INTO userClan(userID, clanID) VALUES(2, 2);
INSERT INTO userClan(userID, clanID) VALUES(3, 1);
INSERT INTO userClan(userID, clanID) VALUES(4, 3);
INSERT INTO userClan(userID, clanID) VALUES(5, 4);
INSERT INTO userClan(userID, clanID) VALUES(6, 1);
INSERT INTO userClan(userID, clanID) VALUES(7, 5);
INSERT INTO userClan(userID, clanID) VALUES(8, 2);
INSERT INTO userClan(userID, clanID) VALUES(9, 3);
INSERT INTO userClan(userID, clanID) VALUES(10, 3);


INSERT INTO post ("date", content, hasImg, userID, clanID) 
VALUES ('2019-02-11 13:41:32', 'Clan news tomorrow', TRUE, 1, NULL);
INSERT INTO post ("date", content, hasImg, userID, clanID) 
VALUES ('2019-03-21 17:30:31', 'My clan is too strong. Proud on being Default!', FALSE, 3, NULL);
INSERT INTO post ("date", content, hasImg, userID, clanID) 
VALUES ('2019-01-13 12:22:20', 'Great practice today boys!', FALSE, 15, NULL);
INSERT INTO post ("date", content, hasImg, userID, clanID) 
VALUES ('2019-03-15 02:31:27', 'I believe in god! What about you', TRUE, 20, 2);
INSERT INTO post ("date", content, hasImg, userID, clanID) 
VALUES ('2019-02-17 04:16:04', 'This looks like a good spaghetti!', TRUE, 14, 2);
INSERT INTO post ("date", content, hasImg, userID, clanID) 
VALUES ('2019-03-14 05:05:17', 'What just happened?!', FALSE, 5, NULL);
INSERT INTO post ("date", content, hasImg, userID, clanID) 
VALUES ('2019-01-21 12:12:19', 'This Liverpool-Porto match was so rigged! *feeling angry*', TRUE, 2, NULL);
INSERT INTO post ("date", content, hasImg, userID, clanID) 
VALUES ('2019-01-26 15:18:06', 'I belive Barcelona will win the UCL!', FALSE, 15, NULL);
INSERT INTO post ("date", content, hasImg, userID, clanID) 
VALUES ('2019-01-27 19:34:41', 'Today is a special day!', FALSE, 13, NULL);
INSERT INTO post ("date", content, hasImg, userID, clanID) 
VALUES ('2019-03-04 12:43:45', 'Hans Zimmer is such a great composer!', TRUE, 12, 3);
INSERT INTO post ("date", content, hasImg, userID, clanID) 
VALUES ('2019-04-05 17:16:04', 'Have you seen the first pictures of a black hole? AMAZING!', TRUE, 10, 1);
INSERT INTO post ("date", content, hasImg, userID, clanID) 
VALUES ('2019-03-02 15:42:17', 'Feeling GREAT!', TRUE, 5, NULL);
INSERT INTO post ("date", content, hasImg, userID, clanID) 
VALUES ('2019-03-15 03:51:37', 'What is it with this weather?!', FALSE, 3, NULL);
INSERT INTO post ("date", content, hasImg, userID, clanID) 
VALUES ('2019-03-18 02:16:49', 'Cant sleep right now! Whats wrong with me!', TRUE, 2, 3);
INSERT INTO post ("date", content, hasImg, userID, clanID) 
VALUES ('2019-04-21 19:05:58', 'Finished gym sesh for today! This one was hard...', FALSE, 19, 3);


INSERT INTO "like"(postID, userID, "date") VALUES(1, 4, '2019-04-01 19:27:12');
INSERT INTO "like"(postID, userID, "date") VALUES(1, 7, '2019-03-01 09:21:17');
INSERT INTO "like"(postID, userID, "date") VALUES(1, 17, '2019-02-01 16:14:34');
INSERT INTO "like"(postID, userID, "date") VALUES(2, 11, '2019-01-01 22:38:58');
INSERT INTO "like"(postID, userID, "date") VALUES(2, 4, '2019-02-01 17:52:43');
INSERT INTO "like"(postID, userID, "date") VALUES(3, 5, '2019-03-01 09:42:01');
INSERT INTO "like"(postID, userID, "date") VALUES(3, 7, '2019-01-14 21:38:51');
INSERT INTO "like"(postID, userID, "date") VALUES(4, 13,'2019-02-17 17:27:22');
INSERT INTO "like"(postID, userID, "date") VALUES(5, 15, '2019-03-09 09:35:34');
INSERT INTO "like"(postID, userID, "date") VALUES(6, 2, '2019-03-02 09:57:52');
INSERT INTO "like"(postID, userID, "date") VALUES(7, 18, '2019-01-17 13:23:36');
INSERT INTO "like"(postID, userID, "date") VALUES(8, 20, '2019-04-19 06:55:44');
INSERT INTO "like"(postID, userID, "date") VALUES(9, 10, '2019-04-24 16:41:18');
INSERT INTO "like"(postID, userID, "date") VALUES(10, 6, '2019-03-27 19:24:15');
INSERT INTO "like"(postID, userID, "date") VALUES(11, 1, '2019-03-30 23:19:30');
INSERT INTO "like"(postID, userID, "date") VALUES(12, 7, '2019-02-06 11:33:46');
INSERT INTO "like"(postID, userID, "date") VALUES(13, 14, '2019-02-14 12:57:12');
INSERT INTO "like"(postID, userID, "date") VALUES(13, 17, '2019-01-21 14:42:27');
INSERT INTO "like"(postID, userID, "date") VALUES(13, 11, '2019-03-17 22:15:34');
INSERT INTO "like"(postID, userID, "date") VALUES(13, 4, '2019-04-01 09:31:18');


INSERT INTO share(postID, userID, content, "date") VALUES (2, 10, 'bump to this!', '2019-03-31 09:23:14');
INSERT INTO share(postID, userID, content, "date") VALUES (3, 6, 'So funny!', '2019-02-21 09:29:10');
INSERT INTO share(postID, userID, content, "date") VALUES (12, 3, 'I agree with you', '2019-01-19 09:29:41');
INSERT INTO share(postID, userID, content, "date") VALUES (5, 19, 'Case terminated!', '2019-02-22 09:12:23');
INSERT INTO share(postID, userID, content, "date") VALUES (10, 4, 'This information is so wrong!', '2019-04-01 19:22:53');
INSERT INTO share(postID, userID, content, "date") VALUES (15, 5, 'This post is so nice!', '2019-04-02 23:42:10');
INSERT INTO share(postID, userID, content, "date") VALUES (2, 12, 'I agree with you!', '2019-04-03 23:35:14');
INSERT INTO share(postID, userID, content, "date") VALUES (9, 3, 'It is like S d i S', '2019-04-15 13:14:32');
INSERT INTO share(postID, userID, content, "date") VALUES (3, 7, 'Just tomorrow', '2019-05-01 15:34:24');
INSERT INTO share(postID, userID, content, "date") VALUES (7, 2, 'I do not agree', '2019-05-12 18:22:10');


INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(1, 10, '2019-02-14 13:41:32', 'Awesome guys!');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(1, 9, '2019-02-15 17:42:32', 'Having seconds thougts about that!');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(2, 6, '2019-03-22 17:30:31','I believe that wont work');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(4, 4, '2019-03-16 02:31:27', 'Completely agree!');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(3, 3, '2019-01-14 12:22:20', 'I dont know if thats a good plan');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(5, 2, '2019-02-19 04:16:04', 'Well see tomorrow!');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(3, 1, '2019-01-14 13:22:20', 'Yeah...of course');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(6, 19, '2019-03-14 07:05:17', 'I cant believe it :o');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(7, 14, '2019-01-22 12:12:19', 'Youre the best');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(8, 13, '2019-01-28 15:18:06', 'This is fake news guys');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(9, 11, '2019-02-27 19:34:41', 'I sugest a tiny change perhaps');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(10, 8, '2019-03-06 12:47:45', 'I smell esturro');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(11, 5, '2019-04-09 17:16:04', 'To be or not to be');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(11, 7, '2019-04-02 23:52:10', 'This Pedro Silva guy...Amazing!');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(4, 12, '2019-03-16 02:33:27', 'I think ill stay at home tomorrow');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(12, 14, '2019-03-04 18:42:17', 'Shut up!');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(12, 13, '2019-03-05 15:42:17', 'WOW! So agressive');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(12, 16, '2019-03-05 15:47:17', 'Lets stay clam guys!');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(13, 14, '2020-03-15 03:51:37', 'Mornings are made to sleep');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(14, 17, '2019-04-18 05:24:49', 'I hurt my wrist yesterday');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(15, 18, '2019-04-22 01:15:58', 'I dont like sardines');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(15, 20, '2019-04-25 20:27:58', 'Sardines is life');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(2, 1, '2019-03-23 17:30:31', 'That would be cool');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(1, 3, '2019-01-13 12:22:20', 'I prefer the second option');
INSERT INTO comment(postID, userID, "date", commentText) 
VALUES(3, 4, '2019-01-14 12:42:20', 'Dont know if i can...');


INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(4, 14, '2019-02-11 13:41:32', 'Hey, i added you as admin because i cant keep this up alone', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(4, 14, '2019-02-11 13:43:07', 'Ill give more hints later on how to be an admin', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(14, 4, '2019-02-11 13:47:12', 'Ah nice!', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(14, 4, '2019-02-11 13:47:54', 'You can teach me tomorrow', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(4, 14, '2019-02-11 13:48:22', 'Yeah yeah we can talk in the practice', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(14, 4, '2019-02-11 13:48:44', 'Its a deal xD', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(4, 14, '2019-02-11 13:49:12', 'See you tomorrow!', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(14, 4, '2019-02-11 13:49:32', 'Yeah bye!', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(5, 16, '2019-01-27 19:34:41', 'Im just letting you know that im NOT the goalkeeper tomorrow', FALSE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(17, 2, '2019-03-04 12:43:45', 'We had a good session today', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(2, 17, '2019-03-04 12:44:15', 'Yeah a pretty cool one', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(2, 17, '2019-03-04 12:44:52', 'Bu there will be more next week', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(17, 2, '2019-03-04 12:46:10', 'True', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(10, 9, '2019-03-18 02:16:49', 'M10better_thanCR7 enviou um GIF', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(9, 10, '2019-03-18 02:17:31', 'I cant see the gif', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(10, 9, '2019-03-18 02:18:23', 'Hehehe theres no gif. We cant even send gifs', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(9, 10, '2019-03-18 02:18:47', 'Dont talk to me. Never again!', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(5, 17, '2019-02-01 16:14:34', 'The dinners at 20:30. Youve been warned', FALSE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(12, 5, '2019-01-01 22:38:58', 'Saw you at the mall today', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(5, 12, '2019-01-01 22:39:23', 'Yeah, my wife made me go!', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(5, 12, '2019-01-01 22:39:54', 'But it was alright. Not that bad', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(5, 12, '2019-01-01 22:40:28', 'Same here xD', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(8, 13, '2019-02-17 17:27:22', 'Wanna go swim tomorrow morning?', FALSE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(1, 3, '2019-03-09 09:35:34', 'Youre crazy.You cant make those kind of challenges at practices', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(1, 3, '2019-03-09 09:35:34', 'You can injury someone', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(1, 3, '2019-03-09 09:35:34', 'Be more careful please', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(3, 1, '2019-03-09 09:35:34', 'Yeah i know. I apologized right after. My bad', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(13, 8, '2019-04-24 16:41:18', 'Sorry onlysaw it now, but couldnt go anyway', FALSE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(18, 19, '2019-03-27 19:24:15', 'Wanna make a barbecue with the boys?', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(18, 19, '2019-03-27 19:25:05', 'We can see whats the best day to do it (with no matches nearby) and schedule one', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(19, 18, '2019-03-27 19:25:45', 'I say YES!', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(18, 19, '2019-03-27 19:26:24', 'Are we the only ones organizing?', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(19, 18, '2019-03-27 19:28:13', 'Dont know but we can do it anyway.', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(19, 18, '2019-03-27 19:28:55', 'I just threw this idea to see if you were down', TRUE);
INSERT INTO message(sender, receiver, "date", messageText, hasBeenSeen) 
VALUES(18, 19, '2019-03-27 19:30:15', 'Im already down! xD', FALSE);


INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (3, 12, NULL, 'friendRequest', '2019-04-16 23:23:59', TRUE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (11, 14, 1, 'clanRequest', '2019-03-11 09:37:20', FALSE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (7, 20, 2, 'clanRequest', '2019-04-12 19:45:56', FALSE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (8, 11, NULL, 'friendRequest', '2019-03-16 13:25:26', TRUE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (4, 2, NULL, 'friendRequest', '2019-04-02 09:18:01', FALSE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (11, 3, 2, 'clanRequest', '2019-02-06 14:27:16', TRUE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (8, 1, NULL, 'friendRequest', '2019-03-16 16:21:17', FALSE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (5, 11, 4, 'clanRequest', '2019-02-19 10:32:39', FALSE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (4, 4, 3, 'clanRequest', '2019-02-23 06:12:20', FALSE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (2, 10, NULL, 'friendRequest', '2019-01-26 15:16:22', TRUE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (3, 10, NULL, 'friendRequest', '2019-01-27 05:51:12', TRUE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (3, 13, NULL, 'friendRequest', '2019-01-27 13:46:47', FALSE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (4, 13, NULL, 'friendRequest', '2019-01-27 17:34:16', TRUE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (3, 15, NULL, 'friendRequest', '2019-01-28 06:23:34', FALSE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (3, 11, NULL, 'friendRequest', '2019-01-28 12:47:27', TRUE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (4, 10, NULL, 'friendRequest', '2019-01-28 13:57:24', FALSE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (5, 10, NULL, 'friendRequest', '2019-01-28 18:26:56', TRUE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (5, 12, NULL, 'friendRequest', '2019-01-29 02:32:35', FALSE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (6, 13, NULL, 'friendRequest', '2019-01-29 09:35:16', FALSE);
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) VALUES (7, 13, NULL, 'friendRequest', '2019-01-30 01:21:39', TRUE);


INSERT INTO blocked(userID, admin, "date", motive) VALUES (13, 4, '2019-03-21 07:22:16', 'Racism');
INSERT INTO blocked(userID, admin, "date", motive) VALUES (15, 4, '2019-04-01 21:42:32', 'Inappropriate behaviour');
INSERT INTO blocked(userID, admin, "date", motive) VALUES (7, 4, '2019-03-27 19:32:15', 'Abusive content');
INSERT INTO blocked(userID, admin, "date", motive) VALUES (9, 4, '2019-03-23 12:13:20', 'Inappropriate behaviour');
INSERT INTO blocked(userID, admin, "date", motive) VALUES (18, 4, '2019-03-31 05:16:33', 'Inappropriate behaviour');


INSERT INTO report(sender, admin, "date", reportText, commentID, postID, motive) 
VALUES(1, 4, '2019-03-21 07:22:16', 'This user used abusive content', NULL, 2, 'Abusive content');
INSERT INTO report(sender, admin, "date", reportText, commentID, postID, motive) 
VALUES(1, 4, '2019-02-09 23:02:30', 'Abusive user', 21, NULL,'Inappropriate behaviour');
INSERT INTO report(sender, admin, "date", reportText, commentID, postID, motive) 
VALUES(1, 4, '2019-03-04 13:22:03', 'color skin', 21, NULL, 'Racism');
INSERT INTO report(sender, admin, "date", reportText, commentID, postID, motive) 
VALUES(1, 4, '2019-04-02 13:23:18', 'He/She sent me abusive content', NULL, 3, 'Abusive content');
INSERT INTO report(sender, admin, "date", reportText, commentID, postID, motive) 
VALUES(1, 4, '2019-03-19 13:07:04', 'This user must be banned!', 21, NULL,'Inappropriate behaviour');
INSERT INTO report(sender, admin, "date", reportText, commentID, postID, motive) 
VALUES(1, 4, '2019-03-27 12:22:02', 'Abusive user!!', NULL, 1,'Inappropriate behaviour');
INSERT INTO report(sender, admin, "date", reportText, commentID, postID, motive) 
VALUES(1, 4, '2019-02-09 23:02:30', 'He said abusive words', 21, NULL, 'Abusive content');
INSERT INTO report(sender, admin, "date", reportText, commentID, postID, motive) 
VALUES(1, 4, '2019-02-22 23:02:20', 'Soooo inappropriate', NULL, 2,'Inappropriate behaviour');
INSERT INTO report(sender, admin, "date", reportText, commentID, postID, motive) 
VALUES(1, 4, '2019-03-27 12:22:02', 'Inappropriate content', NULL, 3,'Abusive content');
INSERT INTO report(sender, admin, "date", reportText, commentID, postID, motive) 
VALUES(1, 4, '2019-03-13 15:07:02', 'Content not permited', NULL, 1,'Abusive content');


INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-04-04 04:12:10', NULL, NULL, NULL, 1, 4, NULL, NULL, FALSE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-27 12:22:02', NULL, NULL, NULL, 1, 7, NULL, NULL, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-23 13:42:20', NULL, 1, NULL, NULL, NULL, NULL, NULL, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-02-03 12:02:43', NULL, 2, NULL, NULL, NULL, NULL, NULL, FALSE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-04-3 17:22:16', NULL, NULL, NULL, 1, 17, NULL, NULL, FALSE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-22 18:02:04', 6, NULL, NULL, NULL, NULL, NULL, NULL, FALSE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-02 21:12:30', NULL, NULL, NULL, 2, 4, NULL, NULL, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-02-09 23:02:30', 2, NULL, NULL, NULL, NULL, NULL, NULL, FALSE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-02-01 05:23:26', 3, NULL, NULL, NULL, NULL, NULL, NULL, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-02-07 12:52:20', 8, NULL, NULL, NULL, NULL, NULL, NULL, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-04 13:22:03', 9, NULL, NULL, NULL, NULL, NULL, NULL, FALSE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-16 01:32:50', NULL, NULL, 4, NULL, NULL, NULL, NULL, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-01-07 12:02:27', NULL, NULL, 1, NULL, NULL, NULL, NULL, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-05 11:02:26', 1, NULL, NULL, NULL, NULL, NULL, NULL, FALSE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-26 11:23:25', NULL, NULL, 2, NULL, NULL, NULL, NULL, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-01-02 16:52:50', 4, NULL, NULL, NULL, NULL, NULL, NULL, FALSE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-19 13:07:04', NULL, NULL, 3, NULL, NULL, NULL, NULL, FALSE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-13 15:07:02', NULL, NULL, NULL, NULL, NULL, 2, 12, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-27 16:32:20', NULL, NULL, NULL, NULL, NULL, 2, 10, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-12 16:32:30', 5, NULL, NULL, NULL, NULL, NULL, NULL, FALSE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-04-01 17:52:30', NULL, 3, NULL, NULL, NULL, NULL, NULL, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-24 14:22:23', NULL, 4, NULL, NULL, NULL, NULL, NULL, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-04-01 19:02:40', 7, NULL, NULL, NULL, NULL, NULL, NULL, FALSE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-16 23:23:59', NULL, NULL, NULL, 2, 11, NULL, NULL, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-02-22 23:02:20', NULL, 5, NULL, NULL, NULL, NULL, NULL, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-02-02 16:22:40', 10, NULL, NULL, NULL, NULL, NULL, NULL, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-02-12 16:21:50', NULL, NULL, NULL, NULL, NULL, 3, 6, FALSE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-15 12:23:56', NULL, NULL, NULL, NULL, NULL, 12, 3, FALSE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-03-23 16:12:16', NULL, NULL, 5, NULL, NULL, NULL, NULL, TRUE);
INSERT INTO notification("date", requestID, messageID, commentID, likePostID, likeUserID, sharePostID, shareUserID, hasBeenSeen) 
VALUES('2019-04-02 13:23:18', NULL, NULL, NULL, NULL, NULL, 5, 19, FALSE);


SELECT setval('users_id_seq', (SELECT MAX(id) from "users"));
SELECT setval('blocked_id_seq', (SELECT MAX(id) from blocked));
SELECT setval('clan_id_seq', (SELECT MAX(id) from clan));
SELECT setval('comment_id_seq', (SELECT MAX(id) from comment));
SELECT setval('message_id_seq', (SELECT MAX(id) from message));
SELECT setval('notification_id_seq', (SELECT MAX(id) from notification));
SELECT setval('post_id_seq', (SELECT MAX(id) from post));
SELECT setval('report_id_seq', (SELECT MAX(id) from report));
SELECT setval('request_id_seq', (SELECT MAX(id) from request));
