-- Table structure for table user
CREATE TABLE user (
  userid int NOT NULL AUTO_INCREMENT,
  username varchar(16) NOT NULL,
  password varchar(255) NOT NULL,
  momname varchar(32) NOT NULL,
  PRIMARY KEY (userid)
);