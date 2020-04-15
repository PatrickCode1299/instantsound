CREATE TABLE artiste_info(
id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
username text NOT NULL,
phone text NOT NULL,
email text NOT NULL,
genre text NOT NULL,
gender text NOT NULL,
password text NOT NULL,
birthday text  NOT NULL,
join_day datetime NOT NULL,
coverbg text NOT NULL,
user_bio text NOT NULL


);
character set utf-8mb64 unicode ci