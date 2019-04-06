QUERIES

-- friends list
SELECT * 
FROM request, "user"
WHERE sender = "user".id AND 
      hasAccepted = TRUE AND 
      clanID IS NULL AND
      (sender=$userID OR receiver=$userID);


-- messages with a  friend
SELECT *
FROM message
WHERE (sender = $activeID AND receiver =$userID) OR 
       sender = $userID AND receiver =$activeID;


--notifications
SELECT * 
FROM notification
ORDER BY "date" DESC,"type" ASC
LIMIT 20;


--reports
SELECT *
FROM report
ORDER by "date" DESC
LIMIT 20;
    
    
--select all users
SELECT *
FROM "user"
ORDER BY id ASC;
 
 
--select banned users
SELECT "user".email, "user".username
FROM "user", blocked
WHERE "user".id = blocked.userID AND
      blocked."date" > Now();


--select clans
SELECT *
FROM clan;


--select all admins
SELECT *
FROM "user"
WHERE isAdmin = TRUE;


--user posts(likes, comments, shares)
SELECT *
FROM post
WHERE post.userID = $userID;

SELECT *
FROM "like"
WHERE postID = $postID; -- <- este postID vem da query anterior 

SELECT *
FROM share 
WHERE postID = $postID; -- <- este postID vem da query anterior 

SELECT *
FROM comment
WHERE postID = $postID; -- <- este postID vem da query anterior 


--clan posts(likes, comments, shares)
//TODO

--shared user posts(likes, comments, shares)
SELECT *
FROM post, share
WHERE post.postID = share.postID AND share.userID = $user;

SELECT *
FROM "like"
WHERE postID = $postID;

SELECT *
FROM share 
WHERE postID = $postID;

SELECT *
FROM comment
WHERE postID = $postID; 
    
--clan members
SELECT *
FROM "user", userClan
WHERE "user".id = userClan.userID AND
      userClan.clanID = $currUserClanID
LIMIT 20; 
  
  
--global leaderboard - ordered by xP
SELECT *
FROM "user"
ORDER BY xP DESC
LIMIT 20;


--clan leaderboard - ordered by xP
SELECT *
FROM "user", userClan
WHERE "user".id = userClan.userID AND
      userClan.clanID = $currUserClanID
ORDER BY xP DESC
LIMIT 20;


--friends leaderboard - ordered by xP
SELECT * 
FROM request, "user"
WHERE sender = "user".id AND 
      hasAccepted = TRUE AND 
      clanID IS NULL AND
      (sender=$userID OR receiver=$userID)
ORDER BY xP DESC;


--sent friend request(order by date)
SELECT *
FROM request
WHERE sender = $userID;


--received friend request(order by date)
SELECT *
FROM request
WHERE receiver = $userID;


--login (verificar login)	 
SELECT password
FROM user
WHERE user.username = $user;


--posts dos amigos order by date (para cada post é preciso saber likes comments e shares)
SELECT *
FROM post, request
WHERE (post.userID = request.sender AND request.receiver = $user AND request.type = 'friendRequest' AND request.hasAccepted = true) OR
      (post.userID = request.receiver AND request.sender = $user AND request.type = 'friendRequest' AND request.hasAccepted = true)
ORDER BY request."date" DESC
LIMIT 20;

SELECT *
FROM "like"
WHERE postID = $postID;

SELECT *
FROM share 
WHERE postID = $postID;

SELECT *
FROM comment
WHERE postID = $postID;

--post (with comments, likes and shares)
SELECT *
FROM post
WHERE post.id = $postID;

SELECT *
FROM "like"
WHERE postID = $postID;

SELECT *
FROM share 
WHERE postID = $postID;

SELECT *
FROM comment
WHERE postID = $postID;  

  
--search users
SELECT * 
FROM user
WHERE "user".email LIKE %$input% OR
      "user".username LIKE %$input%;


--search admin
SELECT * 
FROM user
WHERE ("user".email LIKE %$input% OR "user".username LIKE %$input%) AND
       isAdmin = TRUE;


--search clans
SELECT *
FROM clan
WHERE clan.name LIKE %$input%;


--search posts
SELECT *
FROM post
WHERE post.name LIKE %$input%;