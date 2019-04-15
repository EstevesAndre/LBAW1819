QUERIES

-- friends list

SELECT * 
FROM request, "user"
WHERE sender = "user".id AND 
      hasAccepted = TRUE AND 
      clanID IS NULL AND
      (sender=$userID OR receiver=$userID)
LIMIT 15
OFFSET $offset;


-- messages with a  friend
SELECT *
FROM message
WHERE (sender = $activeID AND receiver =$userID) OR 
       sender = $userID AND receiver =$activeID;


--reports
SELECT *
FROM report
ORDER by "date" DESC
LIMIT 10
OFFSET $offset;

    
    
--select all active users
SELECT *
FROM "user"
WHERE id NOT IN (SELECT "user".id
                FROM "user", blocked
                WHERE "user".id = blocked.userID AND
                blocked."date" > Now())
ORDER BY id ASC
LIMIT 15
OFFSET $offset;
 
 
--select banned users
SELECT "user".email, "user".username
FROM "user", blocked
WHERE "user".id = blocked.userID AND
      blocked."date" > Now()
LIMIT 15
OFFSET $offset;



--select all admins
SELECT *
FROM "user"
WHERE isAdmin = TRUE
LIMIT 15
OFFSET $offset;

    
--clan members
SELECT *
FROM "user", userClan
WHERE "user".id = userClan.userID AND
      userClan.clanID = $currUserClanID
LIMIT 15
OFFSET $offset; 
  
  
--global leaderboard - ordered by xP
SELECT *
FROM "user"
ORDER BY xP DESC
LIMIT 15
OFFSET $offset;


--clan leaderboard - ordered by xP
SELECT *
FROM "user", userClan
WHERE "user".id = userClan.userID AND
      userClan.clanID = $currUserClanID
ORDER BY xP DESC
LIMIT 15
OFFSET $offset;


--friends leaderboard - ordered by xP
SELECT * 
FROM request, "user"
WHERE sender = "user".id AND 
      hasAccepted = TRUE AND 
      clanID IS NULL AND
      (sender=$userID OR receiver=$userID)
ORDER BY xP DESC
LIMIT 15
OFFSET $offset;


--sent friend request(order by date)
SELECT *
FROM request
WHERE sender = $userID
LIMIT 15
OFFSET $offset;

--received friend request(order by date)
SELECT *
FROM request
WHERE receiver = $userID
LIMIT 15
OFFSET $offset;


--login (verificar login)	 
SELECT password
FROM user
WHERE user.username = $user;


--posts dos amigos order by date (likes comments and shares done above)
SELECT *
FROM post, request
WHERE (post.userID = request.sender AND request.receiver = $user AND
       request.type = 'friendRequest' AND request.hasAccepted = true) 
       OR
      (post.userID = request.receiver AND request.sender = $user AND
       request.type = 'friendRequest' AND request.hasAccepted = true)
ORDER BY request."date" DESC
LIMIT 15
OFFSET $offset;


--post (comments, likes and shares done above)
SELECT *
FROM post
WHERE post.id = $postID;
  
--search users
SELECT * 
FROM user
WHERE "user".email LIKE %$input% OR
      "user".username LIKE %$input%
LIMIT 15
OFFSET $offset;


--search admin
SELECT * 
FROM user
WHERE ("user".email LIKE %$input% OR "user".username LIKE %$input%) AND
       isAdmin = TRUE
LIMIT 15
OFFSET $offset;

--search clans
SELECT *
FROM clan
WHERE clan.name LIKE %$input%
LIMIT 15
OFFSET $offset;


--search posts
SELECT *
FROM post
WHERE post.content LIKE %$input%
LIMIT 15
OFFSET $offset;

--requests notification
SELECT *
FROM notification, request
WHERE notification.requestID = request.id
    AND request.receiver = $userID
ORDER BY notification."date" DESC
LIMIT 10
OFFSET $offset;

--messages notification
SELECT *
FROM notification, message
WHERE notification.messageID = message.id
    AND message.receiver = $userID
ORDER BY notification."date" DESC
LIMIT 10
OFFSET $offset;

--comments notification
SELECT *
FROM notification, comment, post
WHERE notification.commentID = comment.id
    AND comment.postID = post.id 
    AND post.userID = $userID
ORDER BY notification."date" DESC
LIMIT 10
OFFSET $offset;

--likes notification
SELECT *
FROM notification, "like", post
WHERE notification.likeUserID = "like".userID
    AND notification.likePostID = "like".postID
    AND "like".postID = post.id
    AND post.userID = $userID
ORDER BY notification."date" DESC
LIMIT 10
OFFSET $offset;


--shares notification
SELECT *
FROM notification, share, post
WHERE notification.shareUserID = share.userID
    AND notification.sharePostID = share.postID
    AND share.postID = post.id
    AND post.userID = $userID
ORDER BY notification."date" DESC
LIMIT 10
OFFSET $offset;