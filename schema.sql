CREATE DATABASE IF NOT EXISTS doingsdone;
create table if not exists doingsdone.users(
	id int(10) not null auto_increment,
	date_reg datetime not null,
	email varchar(255) not null,
	name varchar(50) not null,
	password varchar(255) not null,
	PRIMARY KEY (id)
);
create table if not exists doingsdone.projects(
	id int(10) not null auto_increment,
	name varchar(255) not null,
	user_id int(10) not null,
	foreign key (user_id) references users(id),
	PRIMARY KEY (id)
);
create table if not exists doingsdone.tasks(
	id int(10) not null auto_increment,
	user_id int(10) not null,
	proj_id int(10) not null,
	date_create datetime not null,
	status bool default 0,
	name varchar(255) not null,
	file varchar(255),
	deadline date,
	PRIMARY KEY (id),
	foreign key (user_id) references users(id),
	foreign key (proj_id) references projects(id)
);
alter table doingsdone.projects
add foreign key (user_id)
references doingsdone.users (id);

create index i_name on doingsdone.users(name);
create index i_email on doingsdone.users(email);
create index i_file on doingsdone.tasks(file);
create index i_name on doingsdone.projects(name);
create unique index i_id on doingsdone.users(id);
create unique index i_id on doingsdone.tasks(id);
create unique index i_id on doingsdone.projects(id);
create fulltext index task_search on doingsdone.tasks(name);
