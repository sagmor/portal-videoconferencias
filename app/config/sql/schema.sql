DROP TABLE app_sessions;
CREATE TABLE app_sessions (
  id varchar(255) NOT NULL default '',
  data text,
  expires int(11) default NULL,
  PRIMARY KEY  (id)
);

DROP TABLE users;
CREATE TABLE users(
  id int(11) NOT NULL auto_increment,
  hashed_password varchar(255),
  salt varchar(255),
  email varchar(100),
  type varchar(50),
  name varchar(255),
  lang varchar(10),
  PRIMARY KEY  (id)
);

DROP TABLE tags;
CREATE TABLE tags(
  id int(11) NOT NULL auto_increment,
  name varchar(255),
  PRIMARY KEY  (id)
);

DROP TABLE speeches;
CREATE TABLE speeches(
  id int(11) NOT NULL auto_increment,
  title varchar(255),
  date timestamp,
  description text,
  location varchar(255),
  speakers text,
  status varchar(50),
  informed int(1),
  PRIMARY KEY  (id)
);

DROP TABLE speeches_users;
CREATE TABLE speeches_users(
  id int(11) NOT NULL auto_increment,
  user_id int(11),
  speech_id int(11),
  remember_at timestamp,
  resend_in timestamp,
  PRIMARY KEY  (id)
);

DROP TABLE users_tags;
CREATE TABLE users_tags(
 id int(11) NOT NULL auto_increment,
  user_id int(11),
  tag_id int(11),
  PRIMARY KEY  (id)
);

DROP TABLE speeches_tags;
CREATE TABLE speeches_tags(
  id int(11) NOT NULL auto_increment,
  tag_id int(11),
  speech_id int(11),
  PRIMARY KEY  (id)
);

DROP TABLE attachments;
CREATE TABLE attachments(
  id int(11) NOT NULL auto_increment,
  name varchar(255),
  speech_id int(11),
  type varchar(50),
  location varchar(255),
  filename varchar(255),
  PRIMARY KEY  (id)
);

INSERT INTO users (id, hashed_password, salt, email, type, name, lang) VALUES
(1, 'd4500e2b4e8021a92653999e24d706d3', '0d23af15757c9dcf9a953479e497b684', 'admin@example.com', 'admin', 'Admin', 'es'),
(2, 'd4500e2b4e8021a92653999e24d706d3', '0d23af15757c9dcf9a953479e497b684', 'user@example.com', 'normal', 'User', 'es');
