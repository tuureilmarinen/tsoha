CREATE TABLE users (
	id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	username varchar,
	password_digest varchar,
	created_at datetime NOT NULL,
	updated_at datetime NOT NULL
);
CREATE TABLE tasks (
	id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	name varchar,
	description text,
	completed boolean,
	priority integer,
	user_id integer,
	created_at datetime NOT NULL,
	updated_at datetime NOT NULL
);
CREATE TABLE groups (
	id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	name varchar,
	user_id integer,
	created_at datetime NOT NULL,
	updated_at datetime NOT NULL
);
CREATE TABLE task_to_groups (
	id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	task_id integer,
	group_id integer,
	created_at datetime NOT NULL,
	updated_at datetime NOT NULL
);