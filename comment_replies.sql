CREATE TABLE comment_replies(
replyid int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
username text NOT NULL,
replied text NOT NULL,
reply text NOT NULL,
unique_id text NOT NULL

);