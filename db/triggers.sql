DROP FUNCTION IF EXISTS verifyReportAdmin() CASCADE;
DROP FUNCTION IF EXISTS verifyBlockingAdmin() CASCADE;
DROP FUNCTION IF EXISTS userAcceptClanInvite() CASCADE;
DROP FUNCTION IF EXISTS userStillBlocked() CASCADE;
DROP FUNCTION IF EXISTS userCanRequestFriend() CASCADE;
DROP FUNCTION IF EXISTS verifyCommentDate() CASCADE;
DROP FUNCTION IF EXISTS verifyShareDate() CASCADE;
DROP FUNCTION IF EXISTS verifyLikeDate() CASCADE;

DROP TRIGGER IF EXISTS verifyReportAdmin ON report;
DROP TRIGGER IF EXISTS verifyBlockingAdmin ON blocked;
DROP TRIGGER IF EXISTS userAcceptClanInvite ON report;
DROP TRIGGER IF EXISTS userStillBlocked ON blocked;
DROP TRIGGER IF EXISTS userCanRequestFriend ON request;
DROP TRIGGER IF EXISTS verifyCommentDate ON comment;
DROP TRIGGER IF EXISTS verifyShareDate ON share;
DROP TRIGGER IF EXISTS verifyLikeDate ON "like";

--VERIFY IF USER REPORT IS HANDLED BY AN ADMIN
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


--VERIFY IF USER WAS BANNED BY AN ADMIN
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


--VERIFY IF USER CAN ACCEPT CLAN INVITE
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


--USER CAN ONLY HAVE ONE BLOCKED IN EVERY MOMENT
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


--USER CAN'T SEND A FRIEND REQUEST TO AN USER THAT ALREADY SENT HIM FRIEND REQUEST THAT WAS NOT ANSWERED YET OR ALREADY ACCEPTED
CREATE FUNCTION userCanRequestFriend() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM friendRequest
        WHERE sender = New.receiver AND receiver = New.sender AND hasAccepted = null
    )
    THEN RAISE EXCEPTION 'User already has a suspend friend request from that user.';
    END IF;

    IF EXISTS (
        SELECT *
        FROM friendRequest
        WHERE sender = New.receiver AND 
    )
    THEN RAISE EXCEPTION '';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER userCanRequestFriend
    BEFORE INSERT ON friendRequest
    FOR EACH ROW
    EXECUTE PROCEDURE userCanRequestFriend();



--VERIFY COMMENT DATE
CREATE FUNCTION verifyCommentDate() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM post
        WHERE post.id = New.postID AND post."date" > New."date"
    ) 
    THEN RAISE EXCEPTION 'A post cannot be commented before it is created.';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verifyCommentDate
    BEFORE INSERT OR UPDATE ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE verifyCommentDate();


--VERIFY SHARE DATE
CREATE FUNCTION verifyShareDate() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM post
        WHERE post.id = New.postID AND post."date" > New."date"
    ) 
    THEN RAISE EXCEPTION 'A post cannot be shared before it is created.';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verifyShareDate
    BEFORE INSERT OR UPDATE ON share
    FOR EACH ROW
    EXECUTE PROCEDURE verifyShareDate();


--VERIFY LIKE DATE
CREATE FUNCTION verifyLikeDate() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (
        SELECT *
        FROM post
        WHERE post.id = New.postID AND post."date" > New."date"
    ) 
    THEN RAISE EXCEPTION 'A post cannot be liked before it is created.';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verifyCommentDate
    BEFORE INSERT OR UPDATE ON "like"
    FOR EACH ROW
    EXECUTE PROCEDURE verifyLikeDate();
