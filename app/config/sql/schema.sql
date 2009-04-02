CREATE TABLE app_sessions (
  id varchar(255) NOT NULL default '',
  data text,
  expires int(11) default NULL,
  PRIMARY KEY  (id)
);

CREATE TABLE app_sessions (
  id int(11) NOT NULL auto_increment,
  data text,
  expires int(11) default NULL,
  PRIMARY KEY  (id)
);

CREATE TABLE users(
  id int(11) NOT NULL auto_increment,
  password
  email
  type
  name
  PRIMARY KEY  (id)
);

CREATE TABLE tags(
  id int(11) NOT NULL auto_increment,
  name
  PRIMARY KEY  (id)
);

CREATE TABLE speaches(
  id int(11) NOT NULL auto_increment,
  title
  date
  description
  location
  speakers
  status
  informed
  PRIMARY KEY  (id)
);

CREATE TABLE speach_subscriptions(
  id int(11) NOT NULL auto_increment,
  user_id
  speach_id
  remember_at
  PRIMARY KEY  (id)
);

CREATE TABLE tag_subscriptions(
 id int(11) NOT NULL auto_increment,
  user_id
  tag_id
  PRIMARY KEY  (id)
);

CREATE TABLE tagged_speaches(
  id int(11) NOT NULL auto_increment,
  tag_id
  speach_id
  PRIMARY KEY  (id)
);

CREATE TABLE attachments(
  id int(11) NOT NULL auto_increment,
  id
  name
  speach_id
  type
  original
  status
  PRIMARY KEY  (id)
);
