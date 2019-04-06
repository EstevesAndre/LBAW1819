DROP FUNCTION IF EXISTS verifyCommentDate() CASCADE;
DROP FUNCTION IF EXISTS verifyShareDate() CASCADE;
DROP FUNCTION IF EXISTS verifyLikeDate() CASCADE;

DROP TRIGGER IF EXISTS verifyCommentDate ON comment;
DROP TRIGGER IF EXISTS verifyShareDate ON share;
DROP TRIGGER IF EXISTS verifyLikeDate ON "like";


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