CREATE TABLE notifications(
id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
sender text NOT NULL,
details text NOT NULL,
owner text NOT NULL,
status int(11) NOT NULL,
day timestamp NOT NULL
ALTER TABLE notifications ADD location text NOT NULL


);