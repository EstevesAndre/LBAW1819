-- INSET USERS (M01)
INSERT INTO "users" (email, username, password, name, birthdate, race, class, xp, isAdmin, clanID) 
  VALUES ($email, $username, $password, NULL, NULL, NULL, NULL, DEFAULT, $isAdmin, NULL); 

-- SELECT FRIEND POSTS (M02)
SELECT post.userID, post.content, post.hasimg, post.date, users.id, users.name
FROM post 
INNER JOIN users ON post.userID = users.id,
request
WHERE (post.userID = request.sender AND request.receiver = $user AND
       request.type = 'friendRequest' AND request.hasAccepted = true) 
       OR
      (post.userID = request.receiver AND request.sender = $user AND
       request.type = 'friendRequest' AND request.hasAccepted = true)
ORDER BY post."date" DESC
LIMIT 15
OFFSET $offset;

-- SELECT FRIENDS (M02)
SELECT u2.id, u2.name
FROM "users" u1 INNER JOIN request ON u1.id = request.sender, "users" u2
WHERE u1.id = $userID 
    AND request.hasAccepted = TRUE
    AND request.receiver = u2.id
LIMIT 15
OFFSET $offset;

-- (M02)
-- INSERT MESSAGES 
INSERT INTO message(id, sender, receiver, "date", messageText, hasBeenSeen) 
  VALUES(nextval('message_id_seq'::regclass), $senderID, $receiverID, now(), $messageText, FALSE);

-- SELECT MESSAGES 
SELECT *
FROM message
WHERE (sender = $activeID AND receiver = $userID) 
    OR 
    (sender = $userID AND receiver = $activeID)
ORDER BY message."date" DESC
LIMIT 15
OFFSET $offset;

-- (M04)
-- INSERT COMMENTS
INSERT INTO comment(id, postID, userID, "date", commentText) 
  VALUES(nextval('comment_id_seq'::regclass), $postID, $userID, now(), $commentText);

-- SELECT COMMENTS
SELECT "users".id, "users".name, comment.commenttext, comment.date
FROM comment 
    INNER JOIN post ON post.id = comment.postID
    INNER JOIN "users" ON "users".id = comment.userID
    WHERE post.id = $postID
    ORDER BY comment."date" DESC
LIMIT 10
OFFSET $offset;

-- SELECT SHARES
SELECT "users".id, "users".name, share.content, share.date
FROM share 
    INNER JOIN post ON post.id = share.postID
    INNER JOIN "users" ON "users".id = share.userID
    WHERE post.id = $postID
    ORDER BY share."date" DESC
LIMIT 10
OFFSET $offset;

-- (M04)
-- INSERT LIKES
INSERT INTO "like"(postID, userID, "date") 
    VALUES($postID, $userID, now());

-- SELECT LIKES
SELECT count(*)
FROM "like"
WHERE postID = $postID;

SELECT "users".id, "users".name, "like".date
FROM "like"
    INNER JOIN post ON post.id = "like".postID
    INNER JOIN "users" ON "users".id = "like".userID
    WHERE post.id = $postID
    ORDER BY "like"."date" DESC
LIMIT 10
OFFSET $offset;

-- (M04)
-- INSERT REQUESTS
INSERT INTO request(sender, receiver, clanID, "type", "date", hasAccepted) 
  VALUES ($senderID, $receiverID, $clanID, $requestType, now(), NULL);

-- SELECT REQUESTS
SELECT type, sender, clanID, date
FROM request
WHERE receiver = $receiverID AND hasAccepted = $hasAccepted;

-- (M03)
-- SELECT CLAN POSTS
SELECT "users".id, "users".name, post.content, post.hasimg, post.date
FROM post INNER JOIN "users" ON post.userID = "users".id
WHERE clanid = $clanID
ORDER BY post."date" DESC
LIMIT 10
OFFSET $offset;


-- (M05)
-- GIVE ADMIN PREV
SELECT username, name, xp
FROM "users"
WHERE isAdmin IS FALSE
ORDER BY xp DESC
LIMIT 10
OFFSET $offset;

-- TRANSACTIONS

experience queries
