CREATE TABLE users (
	id SERIAL PRIMARY KEY,
	username varchar,
	password_digest varchar,
	created_at datetime NOT NULL,
	updated_at datetime NOT NULL
);
CREATE TABLE tasks (
	id SERIAL PRIMARY KEY,
	name varchar,
	description text,
	completed boolean,
	priority integer,
	user_id integer,
	created_at datetime NOT NULL,
	updated_at datetime NOT NULL
);
CREATE TABLE groups (
	id SERIAL PRIMARY KEY,
	name varchar,
	user_id integer,
	created_at datetime NOT NULL,
	updated_at datetime NOT NULL
);
CREATE TABLE task_to_groups (
	id SERIAL PRIMARY KEY,
	task_id integer,
	group_id integer,
	created_at datetime NOT NULL,
	updated_at datetime NOT NULL
);