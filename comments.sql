CREATE TABLE comments( 
postid int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
username text NOT NULL, 
post_comment text NOT NULL, 
day timestamp NOT NULL, 
post_id varchar(256) NOT NULL 
);