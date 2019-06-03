-----------------------------------------
-- Drop old schmema
-----------------------------------------

DROP TABLE IF EXISTS "users" CASCADE;
DROP TABLE IF EXISTS regulars CASCADE;
DROP TABLE IF EXISTS api_users CASCADE;
DROP TABLE IF EXISTS clans CASCADE;
DROP TABLE IF EXISTS posts CASCADE;
DROP TABLE IF EXISTS "likes" CASCADE;
DROP TABLE IF EXISTS shares CASCADE;
DROP TABLE IF EXISTS comments CASCADE;
DROP TABLE IF EXISTS messages CASCADE;
DROP TABLE IF EXISTS requests CASCADE;
DROP TABLE IF EXISTS friendRequests CASCADE;
DROP TABLE IF EXISTS clanRequests CASCADE;
DROP TABLE IF EXISTS blockeds CASCADE;
DROP TABLE IF EXISTS reports CASCADE;
DROP TABLE IF EXISTS notifications CASCADE;
DROP TABLE IF EXISTS user_clans CASCADE;

DROP TYPE IF EXISTS classEnum CASCADE;
DROP TYPE IF EXISTS raceEnum CASCADE;
DROP TYPE IF EXISTS genderEnum CASCADE;
DROP TYPE IF EXISTS motiveEnum CASCADE;
DROP TYPE IF EXISTS requestEnum CASCADE;

DROP FUNCTION IF EXISTS verifyReportAdmin() CASCADE;
DROP FUNCTION IF EXISTS verifyBlockingAdmin() CASCADE;
DROP FUNCTION IF EXISTS userAcceptClanInvite() CASCADE;
DROP FUNCTION IF EXISTS userStillBlocked() CASCADE;
DROP FUNCTION IF EXISTS userCanRequestFriend() CASCADE;
DROP FUNCTION IF EXISTS repeatedClanInvite() CASCADE;
DROP FUNCTION IF EXISTS addLikeNotification() CASCADE;
DROP FUNCTION IF EXISTS addCommentNotification() CASCADE;
DROP FUNCTION IF EXISTS addShareNotification() CASCADE;
DROP FUNCTION IF EXISTS addMessageNotification() CASCADE;
DROP FUNCTION IF EXISTS addRequestNotification() CASCADE;
DROP FUNCTION IF EXISTS addPostXP() CASCADE;
DROP FUNCTION IF EXISTS addCommentXP() CASCADE;
DROP FUNCTION IF EXISTS addShareXP() CASCADE;
DROP FUNCTION IF EXISTS addLikeXP() CASCADE;
DROP FUNCTION IF EXISTS deleteLikeNotification() CASCADE;

DROP TRIGGER IF EXISTS verifyReportAdmin ON reports CASCADE;
DROP TRIGGER IF EXISTS verifyBlockingAdmin ON blockeds CASCADE;
DROP TRIGGER IF EXISTS userAcceptClanInvite ON reports CASCADE;
DROP TRIGGER IF EXISTS userStillBlocked ON blockeds CASCADE;
DROP TRIGGER IF EXISTS userCanRequestFriend ON requests CASCADE;
DROP TRIGGER IF EXISTS repeatedClanInvite ON requests CASCADE;
DROP TRIGGER IF EXISTS addLikeNotification ON "likes" CASCADE;
DROP TRIGGER IF EXISTS addCommentNotification ON comments CASCADE;
DROP TRIGGER IF EXISTS addShareNotification ON shares CASCADE;
DROP TRIGGER IF EXISTS addMessageNotification ON messages CASCADE;
DROP TRIGGER IF EXISTS addRequestNotification ON requests CASCADE;
DROP TRIGGER IF EXISTS addPostXP ON posts CASCADE;
DROP TRIGGER IF EXISTS addCommentXP ON comments CASCADE;
DROP TRIGGER IF EXISTS addShareXP ON shares CASCADE;
DROP TRIGGER IF EXISTS addLikeXP ON "likes" CASCADE;
DROP TRIGGER IF EXISTS removeLikeNotification ON "likes" CASCADE;

-----------------------------------------
-- Types
-----------------------------------------

CREATE TYPE classEnum AS ENUM ('Fighter', 'Wizard', 'Rogue', 'Healer');
CREATE TYPE raceEnum AS ENUM ('Human', 'Elf', 'Dwarf');
CREATE TYPE genderEnum AS ENUM ('Male', 'Female');
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
    gender genderEnum,
    xp INTEGER NOT NULL DEFAULT 0 CHECK (xp >= 0),
    is_admin BOOLEAN NOT NULL DEFAULT FALSE
);
 
CREATE TABLE clans (
    id SERIAL PRIMARY KEY,
    name VARCHAR(20) NOT NULL UNIQUE,
    description VARCHAR(250),
    owner_id INTEGER NOT NULL REFERENCES "users" (id)
);

CREATE TABLE user_clans (
    user_id INTEGER NOT NULL REFERENCES "users" PRIMARY KEY,
    clan_id INTEGER NOT NULL REFERENCES clans
);
 
CREATE TABLE posts (
    id SERIAL PRIMARY KEY,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    content VARCHAR(500) NOT NULL,
    has_img BOOLEAN NOT NULL,
    user_id INTEGER NOT NULL REFERENCES "users" (id),
    clan_id INTEGER REFERENCES clans (id)
);  
 
CREATE TABLE "likes" (
    post_id INTEGER NOT NULL REFERENCES posts (id),
    user_id INTEGER NOT NULL REFERENCES "users" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    PRIMARY KEY (post_id, user_id)
);
 
CREATE TABLE shares (
    post_id INTEGER NOT NULL REFERENCES posts (id),
    user_id INTEGER NOT NULL REFERENCES "users" (id),
    content VARCHAR(500),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    PRIMARY KEY (post_id, user_id)
);
 
CREATE TABLE comments (
    id SERIAL PRIMARY KEY,
    post_id INTEGER NOT NULL REFERENCES posts (id),
    user_id INTEGER NOT NULL REFERENCES "users" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    comment_text VARCHAR(250)
);
 
CREATE TABLE messages (
    id SERIAL PRIMARY KEY,
    sender INTEGER NOT NULL REFERENCES "users" (id),
    receiver INTEGER NOT NULL REFERENCES "users" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    message_text VARCHAR(250),
    has_been_seen BOOLEAN NOT NULL DEFAULT FALSE
);
 
CREATE TABLE requests (
    id SERIAL PRIMARY KEY,
    sender INTEGER NOT NULL REFERENCES "users" (id),
    receiver INTEGER NOT NULL REFERENCES "users" (id),
    clan_id INTEGER REFERENCES clans (id),
    "type" requestEnum,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    has_accepted BOOLEAN,
    UNIQUE (sender, receiver, "type")
);  

CREATE TABLE blockeds (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES "users" (id),
    clan INTEGER REFERENCES "clans" (id),
    admin INTEGER REFERENCES "users" (id),
    "date" TIMESTAMP WITH TIME zone NOT NULL,
    motive motiveEnum NOT NULL
);
 
CREATE TABLE reports (
    id SERIAL PRIMARY KEY,
    sender INTEGER NOT NULL REFERENCES "users" (id),
    admin INTEGER  NOT NULL REFERENCES "users" (id),
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    report_text VARCHAR(250),
    comment_id INTEGER REFERENCES comments (id),
    post_id INTEGER REFERENCES posts (id),
    motive motiveEnum NOT NULL
);

CREATE TABLE notifications (
    id SERIAL PRIMARY KEY,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    request_id INTEGER REFERENCES requests (id) ON DELETE CASCADE,
    message_id INTEGER REFERENCES messages (id) ON DELETE CASCADE,
    comment_id INTEGER REFERENCES comments (id) ON DELETE CASCADE,
    like_post_id INTEGER,
    like_user_id INTEGER,
    share_post_id INTEGER,
    share_user_id INTEGER,
    FOREIGN KEY (like_post_id, like_user_id) REFERENCES "likes"(post_id, user_id) ON DELETE CASCADE,
    FOREIGN KEY (share_post_id, share_user_id) REFERENCES shares (post_id, user_id) ON DELETE CASCADE,
    has_been_seen BOOLEAN DEFAULT FALSE
);

-----------------------------------------
-- INDEXES
-----------------------------------------
CREATE INDEX requests_sender_recevier ON requests USING btree(sender, receiver);
CREATE INDEX messages_sender_recevier ON messages USING btree(sender, receiver);
CREATE INDEX posts_user ON posts USING hash(user_id);
CREATE INDEX posts_id ON posts USING hash(id);
CREATE INDEX shares_post ON shares USING hash(post_id);
CREATE INDEX shares_user ON shares USING hash(user_id);
CREATE INDEX users_clan_user ON user_clans USING hash(user_id);
CREATE INDEX users_clan_clan ON user_clans USING hash(clan_id);
CREATE INDEX users_username ON "users" USING hash(username);
CREATE INDEX posts_content_search ON posts USING GIN (to_tsvector('english', content));
CREATE INDEX clans_description_search ON "clans" USING GIN (to_tsvector('english', description));
CREATE INDEX messages_search ON "messages" USING GIN (to_tsvector('english', message_text));

-----------------------------------------
-- TRIGGERS and UDFs
-----------------------------------------

CREATE FUNCTION verifyReportAdmin() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM "users"
        WHERE "users".id = New.admin AND "users".is_admin = FALSE
    ) 
    THEN RAISE EXCEPTION 'Only an Admin (with permissions) can handle an user report.';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verifyReportAdmin
    BEFORE INSERT OR UPDATE ON reports
    FOR EACH ROW
    EXECUTE PROCEDURE verifyReportAdmin();

CREATE FUNCTION verifyBlockingAdmin() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM "users"
        WHERE "users".id = New.admin AND "users".is_admin = FALSE
    ) 
    THEN RAISE EXCEPTION 'Only an Admin (with permissions) can block an user.';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verifyBlockingAdmin
    BEFORE INSERT OR UPDATE ON blockeds
    FOR EACH ROW
    EXECUTE PROCEDURE verifyBlockingAdmin();

CREATE FUNCTION userAcceptClanInvite() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM user_clans
        WHERE user_id = Old.receiver AND Old."type" = 'clanRequest' AND New.has_accepted = TRUE
    )
    THEN RAISE EXCEPTION 'User cannot join a clan while is already a member of another clan.';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER userAcceptClanInvite
    BEFORE UPDATE ON requests
    FOR EACH ROW
    EXECUTE PROCEDURE userAcceptClanInvite();

CREATE FUNCTION userStillBlocked() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM blockeds
        WHERE user_id = New.user_id AND "date" > now()
    ) 
    THEN RAISE EXCEPTION 'User is already blocked.';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER userStillBlocked
    BEFORE INSERT ON blockeds
    FOR EACH ROW
    EXECUTE PROCEDURE userStillBlocked();

CREATE FUNCTION userCanRequestFriend() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM requests
        WHERE "type" = 'friendRequest' AND sender = New.receiver AND receiver = New.sender AND has_accepted IS NULL
    )
    THEN RAISE EXCEPTION 'User already has a not answered friend request from that user.';
    END IF;
    IF EXISTS (
        SELECT *
        FROM requests
        WHERE "type" = 'friendRequest' AND sender = New.receiver AND receiver = New.sender AND has_accepted = TRUE
    )
    THEN RAISE EXCEPTION 'Users are already friends.';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER userCanRequestFriend
    BEFORE INSERT ON requests
    FOR EACH ROW
    EXECUTE PROCEDURE userCanRequestFriend();

CREATE FUNCTION repeatedClanInvite() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM requests
        WHERE "type" = 'clanRequest' AND receiver = New.receiver AND clan_id = New.clan_id
    ) 
    THEN RAISE EXCEPTION 'User already received an invite from that clan (not answered yet or already answered).';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER repeatedClanInvite
    BEFORE INSERT OR UPDATE ON requests
    FOR EACH ROW
    EXECUTE PROCEDURE repeatedClanInvite();

CREATE FUNCTION addPostXP() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT * FROM "users" WHERE id = New.user_id AND race = 'Human'
    )   THEN UPDATE "users" SET xp = xp + 10 WHERE id = New.user_id;
    END IF;
    IF EXISTS (
        SELECT * FROM "users" WHERE id = New.user_id AND race = 'Elf'
    )   THEN UPDATE "users" SET xp = xp + 10 WHERE id = New.user_id;
    END IF;
    IF EXISTS (
        SELECT * FROM "users" WHERE id = New.user_id AND race = 'Dwarf'
    )   THEN UPDATE "users" SET xp = xp + 10 WHERE id = New.user_id;
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;


CREATE FUNCTION addLikeNotification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
        VALUES(now(), NULL, NULL, NULL, New.post_id, New.user_id, NULL, NULL, FALSE);
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER addLikeNotification
    AFTER INSERT ON "likes"
    FOR EACH ROW
    EXECUTE PROCEDURE addLikeNotification();


CREATE FUNCTION addCommentNotification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen)
        VALUES(now(), NULL, NULL, New.id, NULL, NULL, NULL, NULL, FALSE);
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER addCommentNotification
    AFTER INSERT ON comments
    FOR EACH ROW
    EXECUTE PROCEDURE addCommentNotification();


CREATE FUNCTION addShareNotification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen)
        VALUES(now(), NULL, NULL, NULL, NULL, NULL, New.post_id, New.user_id, FALSE);
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER addShareNotification
    AFTER INSERT ON shares
    FOR EACH ROW
    EXECUTE PROCEDURE addShareNotification();


CREATE FUNCTION addMessageNotification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen)
        VALUES(now(), NULL, New.id, NULL, NULL, NULL, NULL, NULL, FALSE);
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER addMessageNotification
    AFTER INSERT ON messages
    FOR EACH ROW
    EXECUTE PROCEDURE addMessageNotification();


CREATE FUNCTION addRequestNotification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen)
        VALUES(now(), New.id, NULL, NULL, NULL, NULL, NULL, NULL, FALSE);
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER addRequestNotification
    AFTER INSERT ON requests
    FOR EACH ROW
    EXECUTE PROCEDURE addRequestNotification();

CREATE FUNCTION deleteLikeNotification() RETURNS TRIGGER AS
$BODY$
BEGIN
    DELETE FROM notifications
        WHERE like_post_id = OLD.post_id AND like_user_id = OLD.user_id;
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER removeLikeNotification
    BEFORE DELETE ON "likes"
    FOR EACH ROW
    EXECUTE PROCEDURE deleteLikeNotification();

/*
    DATA
*/

INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('rui.patricio@gmail.com', 'ruiWolves', '_n@6EEs6', 'John Michael', '1998-05-16', 'Elf', 'Fighter', 'Male', 205, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('beto.gr@gmail.com', 'Bebeto', 'K8c4)-Tx' , 'Andrew Esteves', '1997-03-18', 'Human', 'Wizard', 'Male', 124, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('sa.ze@hotmail.com', 'Zezocas', '!8Y,yZ^', 'Francisco Filipe', '1997-03-18', 'Human', 'Fighter', 'Male', 2030, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('pepe.oficial@gmail.com', 'Pepe123', '`/Fsa2g%', 'Lewis Silva', '1997-03-18', 'Elf', 'Wizard', 'Male', 1540, TRUE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('zecafontes@gmail.com', 'Fontes', 'V~n8`5$*', 'Pedro Silva', '1997-03-18','Human', 'Fighter', 'Male', 6074, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('guerreiro.def@gmail.com', 'Guerreiro_do_BVB', 'Z;-8g^Wc', 'Simon Silva', '1998-01-20', 'Dwarf', 'Rogue', 'Male', 681, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('cancelo.juve@hotmail.com', 'CanceloSLB', '?\H=jB3\', 'Pedro Fernandes', '1997-03-18', 'Elf', 'Rogue', 'Male', 112, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('dias_ruben@gmail.com', 'GOATdaDefesa', 'e7Gh/s-K', 'Bruno Sousa', '1997-03-18', 'Elf', 'Healer', 'Male', 967, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('mario_rui@gmail.com', 'Ruizinho', ':YG^n9^z', 'Antero Santos', '1997-03-18', 'Human', 'Fighter', 'Male', 420, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('nelson_semedo.goat@gmail.com', 'M10better_thanCR7', ')K:9Bu^*', 'John Angelical', '1997-03-18', 'Elf', 'Wizard', 'Male', 2304, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('joao_moutinho@gmail.com', 'MacaPodre', 'Xy>qz9M', 'Mariana Costa', '1997-03-18', 'Dwarf', 'Rogue', 'Female', 437, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('carvalho.william@gmail.com', 'William_Carvalho', '^7kNr~N', 'Catarina Almeida', '1997-03-18', 'Human', 'Wizard', 'Female', 892, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('mario_joao@gmail.com', 'OMeuAmoreoSporting', 'q3NTt6.C', 'Miguel Barraca', '1997-03-18', 'Elf', 'Rogue', 'Male', 1423, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('danilo.fcp@gmail.com', 'ItzDanilo', 'k3M~4&./', 'Tony Costa', '1997-03-18','Dwarf', 'Healer', 'Male', 3048, TRUE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('pizzi@gmail.com', 'PizziOficial', '`7vJ4aHw', 'Marcelo Sousa', '1997-03-18', 'Human', 'Fighter', 'Male', 1024, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('bruno_nandes@gmail.com', 'AMinhaVidaeoSport', '[Yw?J5XP', 'Pedro Coelho', '1997-03-18', 'Human', 'Wizard', 'Male', 1312, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('neves_ruben@gmail.com', 'SoGolaceiras', 'W]d89up]', 'Louis Vieira', '1997-03-18','Dwarf', 'Healer', 'Male', 430, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('feliz.joao@gmail.com', 'NextCR7', '$2y$12$m8f/MWb5VFOGvlpLK8sDluUrqKiBm8m.f3RGxsRycmWNkrFG5Iteu', 'Alexandre Santos', '1997-03-18','Dwarf', 'Wizard', 'Male', 20, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('bernas.silva@gmail.com', 'EuSouOBernas', '$2y$12$m8f/MWb5VFOGvlpLK8sDluUrqKiBm8m.f3RGxsRycmWNkrFG5Iteu', 'Fernando Rocha', '1997-03-18', 'Human', 'Rogue', 'Male', 4512, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('rafa_slb@gmail.com', 'JustRafa', '#9sYEtAg', 'Leonel Silva', '1997-03-18', 'Elf', 'Fighter', 'Male', 960, FALSE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('test@test.com', 'lbaw1843', '$2y$12$m8f/MWb5VFOGvlpLK8sDluUrqKiBm8m.f3RGxsRycmWNkrFG5Iteu', '3TEAM3', '1998-04-22', 'Human', 'Fighter', 'Female', 960, TRUE);
INSERT INTO "users"(email, username, password, name, birthdate, race, class, gender, xp, is_admin) 
VALUES('t@t.com', 'user22', '$2y$12$m8f/MWb5VFOGvlpLK8sDluUrqKiBm8m.f3RGxsRycmWNkrFG5Iteu', 'CestLaVie', '1998-04-22', 'Human', 'Wizard', 'Female', 960, FALSE);


INSERT INTO clans(name, description, owner_id) 
VALUES('Default Clan','Looking forward for the first place in the clans leaderboard',1);
INSERT INTO clans(name, description, owner_id) 
VALUES('Selection of Quinas','As a selection, we decided to creat a clans to show the union of this team',2);
INSERT INTO clans(name, description, owner_id) 
VALUES('Liga das Nations','Support Clan for our warriors in Liga das Nations',4);
INSERT INTO clans(name, description, owner_id) 
VALUES('EURO 2016','Remembering old times with our french friends',5);
INSERT INTO clans(name, description, owner_id) 
VALUES('Falta o Eder','A tiny tribute to our national hero Ederzito. Join our cause',7);
INSERT INTO clans(name, description, owner_id) 
VALUES('Working','Join or join',21);


INSERT INTO user_clans(user_id, clan_id) VALUES(1, 1);
INSERT INTO user_clans(user_id, clan_id) VALUES(2, 2);
INSERT INTO user_clans(user_id, clan_id) VALUES(3, 1);
INSERT INTO user_clans(user_id, clan_id) VALUES(4, 3);
INSERT INTO user_clans(user_id, clan_id) VALUES(5, 4);
INSERT INTO user_clans(user_id, clan_id) VALUES(6, 1);
INSERT INTO user_clans(user_id, clan_id) VALUES(7, 5);
INSERT INTO user_clans(user_id, clan_id) VALUES(8, 2);
INSERT INTO user_clans(user_id, clan_id) VALUES(9, 3);
INSERT INTO user_clans(user_id, clan_id) VALUES(10, 3);
INSERT INTO user_clans(user_id, clan_id) VALUES(11, 6);
INSERT INTO user_clans(user_id, clan_id) VALUES(12, 6);
INSERT INTO user_clans(user_id, clan_id) VALUES(13, 6);
INSERT INTO user_clans(user_id, clan_id) VALUES(14, 6);
INSERT INTO user_clans(user_id, clan_id) VALUES(15, 6);
INSERT INTO user_clans(user_id, clan_id) VALUES(16, 6);
INSERT INTO user_clans(user_id, clan_id) VALUES(21, 6);


INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-02-11 13:41:32', 'Clan news tomorrow', TRUE, 1, NULL);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-03-21 17:30:31', 'My clan is too strong. Proud on being Default!', FALSE, 3, NULL);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-01-13 12:22:20', 'Great practice today boys!', FALSE, 15, NULL);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-03-15 02:31:27', 'I believe in god! What about you', TRUE, 20, 2);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-02-17 04:16:04', 'This looks like a good spaghetti!', TRUE, 14, 2);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-03-14 05:05:17', 'What just happened?!', FALSE, 5, NULL);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-01-21 12:12:19', 'This Liverpool-Porto match was so rigged! *feeling angry*', TRUE, 2, NULL);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-01-26 15:18:06', 'I belive Barcelona will win the UCL!', FALSE, 15, NULL);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-01-27 19:34:41', 'Today is a special day!', FALSE, 13, NULL);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-03-04 12:43:45', 'Hans Zimmer is such a great composer!', TRUE, 12, 3);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-04-05 17:16:04', 'Have you seen the first pictures of a black hole? AMAZING!', TRUE, 10, 1);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-03-02 15:42:17', 'Feeling GREAT!', TRUE, 5, NULL);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-03-15 03:51:37', 'What is it with this weather?!', FALSE, 3, NULL);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-03-18 02:16:49', 'Cant sleep right now! Whats wrong with me!', TRUE, 2, 3);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-04-21 19:05:58', 'Finished gym sesh for today! This one was hard...', FALSE, 19, 3);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-04-28 19:05:58', 'my first post ever', FALSE, 21, NULL);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-04-28 21:05:58', 'my second post', FALSE, 21, NULL);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-04-28 11:05:58', 'test post', FALSE, 21, 6);
INSERT INTO posts ("date", content, has_img, user_id, clan_id) 
VALUES ('2019-04-29 21:05:58', 'Second post', FALSE, 1, 6);


INSERT INTO "likes"(post_id, user_id, "date") VALUES(1, 4, '2019-04-01 19:27:12');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(1, 7, '2019-03-01 09:21:17');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(1, 17, '2019-02-01 16:14:34');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(2, 11, '2019-01-01 22:38:58');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(2, 4, '2019-02-01 17:52:43');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(3, 5, '2019-03-01 09:42:01');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(3, 7, '2019-01-14 21:38:51');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(4, 13,'2019-02-17 17:27:22');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(5, 15, '2019-03-09 09:35:34');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(6, 2, '2019-03-02 09:57:52');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(7, 18, '2019-01-17 13:23:36');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(8, 20, '2019-04-19 06:55:44');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(9, 10, '2019-04-24 16:41:18');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(10, 6, '2019-03-27 19:24:15');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(11, 1, '2019-03-30 23:19:30');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(12, 7, '2019-02-06 11:33:46');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(13, 14, '2019-02-14 12:57:12');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(13, 17, '2019-01-21 14:42:27');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(13, 11, '2019-03-17 22:15:34');
INSERT INTO "likes"(post_id, user_id, "date") VALUES(13, 4, '2019-04-01 09:31:18');


INSERT INTO shares(post_id, user_id, content, "date") VALUES (2, 10, 'bump to this!', '2019-03-31 09:23:14');
INSERT INTO shares(post_id, user_id, content, "date") VALUES (3, 6, 'So funny!', '2019-02-21 09:29:10');
INSERT INTO shares(post_id, user_id, content, "date") VALUES (12, 3, 'I agree with you', '2019-01-19 09:29:41');
INSERT INTO shares(post_id, user_id, content, "date") VALUES (5, 19, 'Case terminated!', '2019-02-22 09:12:23');
INSERT INTO shares(post_id, user_id, content, "date") VALUES (10, 4, 'This information is so wrong!', '2019-04-01 19:22:53');
INSERT INTO shares(post_id, user_id, content, "date") VALUES (15, 5, 'This post is so nice!', '2019-04-02 23:42:10');
INSERT INTO shares(post_id, user_id, content, "date") VALUES (2, 12, 'I agree with you!', '2019-04-03 23:35:14');
INSERT INTO shares(post_id, user_id, content, "date") VALUES (9, 3, 'It is like S d i S', '2019-04-15 13:14:32');
INSERT INTO shares(post_id, user_id, content, "date") VALUES (3, 7, 'Just tomorrow', '2019-05-01 15:34:24');
INSERT INTO shares(post_id, user_id, content, "date") VALUES (7, 2, 'I do not agree', '2019-05-12 18:22:10');


INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(1, 10, '2019-02-14 13:41:32', 'Awesome guys!');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(1, 9, '2019-02-15 17:42:32', 'Having seconds thougts about that!');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(2, 6, '2019-03-22 17:30:31','I believe that wont work');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(4, 4, '2019-03-16 02:31:27', 'Completely agree!');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(3, 3, '2019-01-14 12:22:20', 'I dont know if thats a good plan');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(5, 2, '2019-02-19 04:16:04', 'Well see tomorrow!');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(3, 1, '2019-01-14 13:22:20', 'Yeah...of course');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(6, 19, '2019-03-14 07:05:17', 'I cant believe it :o');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(7, 14, '2019-01-22 12:12:19', 'Youre the best');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(8, 13, '2019-01-28 15:18:06', 'This is fake news guys');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(9, 11, '2019-02-27 19:34:41', 'I sugest a tiny change perhaps');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(10, 8, '2019-03-06 12:47:45', 'I smell esturro');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(11, 5, '2019-04-09 17:16:04', 'To be or not to be');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(11, 7, '2019-04-02 23:52:10', 'This Pedro Silva guy...Amazing!');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(4, 12, '2019-03-16 02:33:27', 'I think ill stay at home tomorrow');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(12, 14, '2019-03-04 18:42:17', 'Shut up!');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(12, 13, '2019-03-05 15:42:17', 'WOW! So agressive');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(12, 16, '2019-03-05 15:47:17', 'Lets stay clam guys!');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(13, 14, '2020-03-15 03:51:37', 'Mornings are made to sleep');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(14, 17, '2019-04-18 05:24:49', 'I hurt my wrist yesterday');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(15, 18, '2019-04-22 01:15:58', 'I dont like sardines');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(15, 20, '2019-04-25 20:27:58', 'Sardines is life');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(2, 1, '2019-03-23 17:30:31', 'That would be cool');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(1, 3, '2019-01-13 12:22:20', 'I prefer the second option');
INSERT INTO comments(post_id, user_id, "date", comment_text) 
VALUES(3, 4, '2019-01-14 12:42:20', 'Dont know if i can...');


INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(4, 14, '2019-02-11 13:41:32', 'Hey, i added you as admin because i cant keep this up alone', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(4, 14, '2019-02-11 13:43:07', 'Ill give more hints later on how to be an admin', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(14, 4, '2019-02-11 13:47:12', 'Ah nice!', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(14, 4, '2019-02-11 13:47:54', 'You can teach me tomorrow', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(4, 14, '2019-02-11 13:48:22', 'Yeah yeah we can talk in the practice', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(14, 4, '2019-02-11 13:48:44', 'Its a deal xD', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(4, 14, '2019-02-11 13:49:12', 'See you tomorrow!', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(14, 4, '2019-02-11 13:49:32', 'Yeah bye!', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(5, 16, '2019-01-27 19:34:41', 'Im just letting you know that im NOT the goalkeeper tomorrow', FALSE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(17, 2, '2019-03-04 12:43:45', 'We had a good session today', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(2, 17, '2019-03-04 12:44:15', 'Yeah a pretty cool one', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(2, 17, '2019-03-04 12:44:52', 'Bu there will be more next week', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(17, 2, '2019-03-04 12:46:10', 'True', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(10, 9, '2019-03-18 02:16:49', 'M10better_thanCR7 enviou um GIF', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(9, 10, '2019-03-18 02:17:31', 'I cant see the gif', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(10, 9, '2019-03-18 02:18:23', 'Hehehe theres no gif. We cant even send gifs', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(9, 10, '2019-03-18 02:18:47', 'Dont talk to me. Never again!', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(5, 17, '2019-02-01 16:14:34', 'The dinners at 20:30. Youve been warned', FALSE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(12, 5, '2019-01-01 22:38:58', 'Saw you at the mall today', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(5, 12, '2019-01-01 22:39:23', 'Yeah, my wife made me go!', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(5, 12, '2019-01-01 22:39:54', 'But it was alright. Not that bad', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(5, 12, '2019-01-01 22:40:28', 'Same here xD', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(8, 13, '2019-02-17 17:27:22', 'Wanna go swim tomorrow morning?', FALSE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(1, 3, '2019-03-09 09:35:34', 'Youre crazy.You cant make those kind of challenges at practices', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(1, 3, '2019-03-09 09:35:34', 'You can injury someone', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(1, 3, '2019-03-09 09:35:34', 'Be more careful please', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(3, 1, '2019-03-09 09:35:34', 'Yeah i know. I apologized right after. My bad', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(13, 8, '2019-04-24 16:41:18', 'Sorry onlysaw it now, but couldnt go anyway', FALSE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(18, 19, '2019-03-27 19:24:15', 'Wanna make a barbecue with the boys?', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(18, 19, '2019-03-27 19:25:05', 'We can see whats the best day to do it (with no matches nearby) and schedule one', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(19, 18, '2019-03-27 19:25:45', 'I say YES!', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(18, 19, '2019-03-27 19:26:24', 'Are we the only ones organizing?', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(19, 18, '2019-03-27 19:28:13', 'Dont know but we can do it anyway.', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(19, 18, '2019-03-27 19:28:55', 'I just threw this idea to see if you were down', TRUE);
INSERT INTO messages(sender, receiver, "date", message_text, has_been_seen) 
VALUES(18, 19, '2019-03-27 19:30:15', 'Im already down! xD', FALSE);


INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (3, 12, NULL, 'friendRequest', '2019-04-16 23:23:59', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (11, 14, 1, 'clanRequest', '2019-03-11 09:37:20', FALSE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (7, 20, 2, 'clanRequest', '2019-04-12 19:45:56', FALSE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (8, 11, NULL, 'friendRequest', '2019-03-16 13:25:26', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (4, 2, NULL, 'friendRequest', '2019-04-02 09:18:01', FALSE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (11, 3, 2, 'clanRequest', '2019-02-06 14:27:16', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (8, 1, NULL, 'friendRequest', '2019-03-16 16:21:17', FALSE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (5, 11, 4, 'clanRequest', '2019-02-19 10:32:39', FALSE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (4, 4, 3, 'clanRequest', '2019-02-23 06:12:20', FALSE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (2, 10, NULL, 'friendRequest', '2019-01-26 15:16:22', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (3, 10, NULL, 'friendRequest', '2019-01-27 05:51:12', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (3, 13, NULL, 'friendRequest', '2019-01-27 13:46:47', FALSE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (4, 13, NULL, 'friendRequest', '2019-01-27 17:34:16', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (3, 15, NULL, 'friendRequest', '2019-01-28 06:23:34', FALSE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (3, 11, NULL, 'friendRequest', '2019-01-28 12:47:27', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (4, 10, NULL, 'friendRequest', '2019-01-28 13:57:24', FALSE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (5, 10, NULL, 'friendRequest', '2019-01-28 18:26:56', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (5, 12, NULL, 'friendRequest', '2019-01-29 02:32:35', FALSE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (6, 13, NULL, 'friendRequest', '2019-01-29 09:35:16', FALSE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (7, 13, NULL, 'friendRequest', '2019-01-30 01:21:39', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (21, 3, NULL, 'friendRequest', '2019-01-29 12:02:21', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (21, 1, NULL, 'friendRequest', '2019-01-31 22:42:33', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (21, 12, NULL, 'friendRequest', '2019-02-15 14:32:21', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (21, 10, NULL, 'friendRequest', '2019-03-19 16:12:53', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (21, 8, NULL, 'friendRequest', '2019-04-02 17:02:11', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (21, 11, 6, 'clanRequest', '2019-04-02 17:02:11', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (21, 12, 6, 'clanRequest', '2019-04-02 17:02:11', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (21, 13, 6, 'clanRequest', '2019-04-02 17:02:11', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (21, 14, 6, 'clanRequest', '2019-04-02 17:02:11', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (21, 15, 6, 'clanRequest', '2019-04-02 17:02:11', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (21, 16, 6, 'clanRequest', '2019-04-02 17:02:11', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (21, 17, 6, 'clanRequest', '2019-04-02 17:02:11', TRUE);
INSERT INTO requests(sender, receiver, clan_id, "type", "date", has_accepted) VALUES (19, 18, null, 'friendRequest', '2019-04-02 17:02:11', TRUE);

INSERT INTO blockeds(user_id, clan, admin, "date", motive) VALUES (13, NULL, 4, '2019-03-21 07:22:16', 'Racism');
INSERT INTO blockeds(user_id, clan, admin, "date", motive) VALUES (15, NULL, 4, '2019-04-01 21:42:32', 'Inappropriate behaviour');
INSERT INTO blockeds(user_id, clan, admin, "date", motive) VALUES (7, NULL, 4, '2019-03-27 19:32:15', 'Abusive content');
INSERT INTO blockeds(user_id, clan, admin, "date", motive) VALUES (9, NULL, 4, '2019-03-23 12:13:20', 'Inappropriate behaviour');
INSERT INTO blockeds(user_id, clan, admin, "date", motive) VALUES (18, NULL, 4, '2019-03-31 05:16:33', 'Inappropriate behaviour');


INSERT INTO reports(sender, admin, "date", report_text, comment_id, post_id, motive) 
VALUES(1, 4, '2019-03-21 07:22:16', 'This user used abusive content', NULL, 2, 'Abusive content');
INSERT INTO reports(sender, admin, "date", report_text, comment_id, post_id, motive) 
VALUES(1, 4, '2019-02-09 23:02:30', 'Abusive user', 21, NULL,'Inappropriate behaviour');
INSERT INTO reports(sender, admin, "date", report_text, comment_id, post_id, motive) 
VALUES(1, 4, '2019-03-04 13:22:03', 'color skin', 21, NULL, 'Racism');
INSERT INTO reports(sender, admin, "date", report_text, comment_id, post_id, motive) 
VALUES(1, 4, '2019-04-02 13:23:18', 'He/She sent me abusive content', NULL, 3, 'Abusive content');
INSERT INTO reports(sender, admin, "date", report_text, comment_id, post_id, motive) 
VALUES(1, 4, '2019-03-19 13:07:04', 'This user must be banned!', 21, NULL,'Inappropriate behaviour');
INSERT INTO reports(sender, admin, "date", report_text, comment_id, post_id, motive) 
VALUES(1, 4, '2019-03-27 12:22:02', 'Abusive user!!', NULL, 1,'Inappropriate behaviour');
INSERT INTO reports(sender, admin, "date", report_text, comment_id, post_id, motive) 
VALUES(1, 4, '2019-02-09 23:02:30', 'He said abusive words', 21, NULL, 'Abusive content');
INSERT INTO reports(sender, admin, "date", report_text, comment_id, post_id, motive) 
VALUES(1, 4, '2019-02-22 23:02:20', 'Soooo inappropriate', NULL, 2,'Inappropriate behaviour');
INSERT INTO reports(sender, admin, "date", report_text, comment_id, post_id, motive) 
VALUES(1, 4, '2019-03-27 12:22:02', 'Inappropriate content', NULL, 3,'Abusive content');
INSERT INTO reports(sender, admin, "date", report_text, comment_id, post_id, motive) 
VALUES(1, 4, '2019-03-13 15:07:02', 'Content not permited', NULL, 1,'Abusive content');


--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-04-04 04:12:10', NULL, NULL, NULL, 1, 4, NULL, NULL, FALSE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-27 12:22:02', NULL, NULL, NULL, 1, 7, NULL, NULL, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-23 13:42:20', NULL, 1, NULL, NULL, NULL, NULL, NULL, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-02-03 12:02:43', NULL, 2, NULL, NULL, NULL, NULL, NULL, FALSE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-04-3 17:22:16', NULL, NULL, NULL, 1, 17, NULL, NULL, FALSE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-22 18:02:04', 6, NULL, NULL, NULL, NULL, NULL, NULL, FALSE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-02 21:12:30', NULL, NULL, NULL, 2, 4, NULL, NULL, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-02-09 23:02:30', 2, NULL, NULL, NULL, NULL, NULL, NULL, FALSE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-02-01 05:23:26', 3, NULL, NULL, NULL, NULL, NULL, NULL, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-02-07 12:52:20', 8, NULL, NULL, NULL, NULL, NULL, NULL, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-04 13:22:03', 9, NULL, NULL, NULL, NULL, NULL, NULL, FALSE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-16 01:32:50', NULL, NULL, 4, NULL, NULL, NULL, NULL, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-01-07 12:02:27', NULL, NULL, 1, NULL, NULL, NULL, NULL, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-05 11:02:26', 1, NULL, NULL, NULL, NULL, NULL, NULL, FALSE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-26 11:23:25', NULL, NULL, 2, NULL, NULL, NULL, NULL, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-01-02 16:52:50', 4, NULL, NULL, NULL, NULL, NULL, NULL, FALSE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-19 13:07:04', NULL, NULL, 3, NULL, NULL, NULL, NULL, FALSE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-13 15:07:02', NULL, NULL, NULL, NULL, NULL, 2, 12, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-27 16:32:20', NULL, NULL, NULL, NULL, NULL, 2, 10, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-12 16:32:30', 5, NULL, NULL, NULL, NULL, NULL, NULL, FALSE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-04-01 17:52:30', NULL, 3, NULL, NULL, NULL, NULL, NULL, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-24 14:22:23', NULL, 4, NULL, NULL, NULL, NULL, NULL, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-04-01 19:02:40', 7, NULL, NULL, NULL, NULL, NULL, NULL, FALSE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-16 23:23:59', NULL, NULL, NULL, 2, 11, NULL, NULL, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-02-22 23:02:20', NULL, 5, NULL, NULL, NULL, NULL, NULL, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-02-02 16:22:40', 10, NULL, NULL, NULL, NULL, NULL, NULL, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-02-12 16:21:50', NULL, NULL, NULL, NULL, NULL, 3, 6, FALSE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-15 12:23:56', NULL, NULL, NULL, NULL, NULL, 12, 3, FALSE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-03-23 16:12:16', NULL, NULL, 5, NULL, NULL, NULL, NULL, TRUE);
--INSERT INTO notifications("date", request_id, message_id, comment_id, like_post_id, like_user_id, share_post_id, share_user_id, has_been_seen) 
--VALUES('2019-04-02 13:23:18', NULL, NULL, NULL, NULL, NULL, 5, 19, FALSE);


SELECT setval('users_id_seq', (SELECT MAX(id) from "users"));
SELECT setval('blockeds_id_seq', (SELECT MAX(id) from blockeds));
SELECT setval('clans_id_seq', (SELECT MAX(id) from clans));
SELECT setval('comments_id_seq', (SELECT MAX(id) from comments));
SELECT setval('messages_id_seq', (SELECT MAX(id) from messages));
SELECT setval('notifications_id_seq', (SELECT MAX(id) from notifications));
SELECT setval('posts_id_seq', (SELECT MAX(id) from posts));
SELECT setval('reports_id_seq', (SELECT MAX(id) from reports));
SELECT setval('requests_id_seq', (SELECT MAX(id) from requests));
