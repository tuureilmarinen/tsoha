CREATE TABLE users (
	id SERIAL PRIMARY KEY,
	username varchar UNIQUE NOT NULL,
	password_digest varchar NOT NULL,
	admin boolean,
	created_at timestamp NOT NULL,
	updated_at timestamp NOT NULL
);
CREATE TABLE tasks (
	id SERIAL PRIMARY KEY,
	name varchar UNIQUE NOT NULL,
	description text,
	completed boolean,
	priority integer NOT NULL,
	user_id integer REFERENCES users(id) ON DELETE CASCADE,
	created_at timestamp NOT NULL,
	updated_at timestamp NOT NULL
);
CREATE TABLE groups (
	id SERIAL PRIMARY KEY,
	name varchar UNIQUE NOT NULL,
	user_id integer REFERENCES users(id) ON DELETE CASCADE,
	created_at timestamp NOT NULL,
	updated_at timestamp NOT NULL
);
CREATE TABLE task_to_groups (
	id SERIAL PRIMARY KEY,
	task_id integer REFERENCES tasks(id) ON DELETE CASCADE,
	group_id integer REFERENCES groups(id) ON DELETE CASCADE,
	created_at timestamp NOT NULL,
	updated_at timestamp NOT NULL
);