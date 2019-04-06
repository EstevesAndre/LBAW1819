-- chat list
SELECT * FROM request, "user"
    WHERE hasAccepted = "TRUE"
        AND (sender = "user".id
            OR receiver = "user".id);

-- messages with a  friend
SELECT sender, receiver, "date", messageText
    FROM message
        WHERE givenID = id;

