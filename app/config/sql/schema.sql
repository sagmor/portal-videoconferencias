CREATE TABLE app_sessions (
  id varchar(255) NOT NULL default '',
  data text,
  expires int(11) default NULL,
  PRIMARY KEY  (id)
);

CREATE TABLE users(
  id int(11) NOT NULL auto_increment,
  password varchar(255),
  salt varchar(255),
  email varchar(100),
  type varchar(50),
  name varchar(255),
  lang varchar(10),
  PRIMARY KEY  (id)
);

CREATE TABLE tags(
  id int(11) NOT NULL auto_increment,
  name varchar(255),
  PRIMARY KEY  (id)
);

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

CREATE TABLE speech_subscriptions(
  id int(11) NOT NULL auto_increment,
  user_id int(11),
  speech_id int(11),
  remember_at timestamp,
  resend_in timestamp,
  PRIMARY KEY  (id)
);

CREATE TABLE tag_subscriptions(
 id int(11) NOT NULL auto_increment,
  user_id int(11),
  tag_id int(11),
  PRIMARY KEY  (id)
);

CREATE TABLE tagged_speeches(
  tag_id int(11),
  speech_id int(11)
);

CREATE TABLE attachments(
  id int(11) NOT NULL auto_increment,
  name varchar(255),
  speech_id int(11),
  type varchar(50),
  location varchar(255),
  filename varchar(255),
  PRIMARY KEY  (id)
);
