CREATE TABLE roles (id SERIAL NOT NULL, name varchar(40), slug varchar(40), PRIMARY KEY (id));
CREATE TABLE users (id BIGSERIAL NOT NULL, first_name varchar(40) NOT NULL, last_name varchar(40), email varchar(100) NOT NULL, password varchar(100), avatar_url varchar(255), role_id int2 NOT NULL, created_at timestamp DEFAULT now() NOT NULL, updated_at timestamp, deleted_at timestamp, PRIMARY KEY (id));
ALTER TABLE users ADD CONSTRAINT FKusers162913 FOREIGN KEY (role_id) REFERENCES roles (id);
