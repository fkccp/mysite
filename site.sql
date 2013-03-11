/* user */

create table user(
	id int unsigned primary key auto_increment,
	name varchar(20) default '',
	nickname varchar(20) default '',
	anoy_name varchar(20) default '',
	created int unsigned default 0,
	status tinyint default 1
);

create table userinfo(
	uid int unsigned default 0,
	prov char(2) default '',
	city char(2) default '',
	town char(2) default '',
	birth int unsigned default 0
);

/* bbs */
drop table if exists bbs_post;
create table bbs_post(
	id int unsigned primary key auto_increment,
	nid int default 0 comment '结点id',
	title varchar(255),
	uid int default 0,
	content text,
	ctime int default 0,
	n_mark int default 0,
	n_click int default 0,
	n_cmt int default 0,
	n_like int default 0,
	is_show tinyint default 1,
	status tinyint default 1 comment '1-未审核，0-已审核',
	last_cmt_ctime int unsigned default 0,
	last_cmt_userid int unsigned default 0,
	last_cmt_username varchar(20) default ''
);

drop table if exists bbs_append;
create table bbs_append(
	id int unsigned primary key auto_increment,
	pid int unsigned default 0,
	content text,
	ctime int unsigned default 0,
	is_show tinyint default 1,
	status tinyint default 1 comment '1-未审核，0-已审核'
);

drop table if exists bbs_node;
create table bbs_node(
	id int unsigned primary key auto_increment,
	name varchar(50) default '',
	n_post int unsigned default 0,
	unique name(name)
);

drop table if exists bbs_mark;
create table bbs_mark
(
	uid int unsigned default 0,
	pid int unsigned default 0,
	ctime int unsigned default 0,
	unique uni(uid, pid)
);

drop table if exists bbs_like;
create table bbs_like
(
	uid int unsigned default 0,
	pid int unsigned default 0,
	ctime int unsigned default 0,
	unique uni(uid, pid)
);

drop table if exists bbs_cmt;
create table bbs_cmt(
	id int unsigned primary key auto_increment,
	pid int unsigned default 0,
	uid int unsigned default 0,
	content text,
	n_like int unsigned default 0,
	ctime int unsigned default 0,
	is_show tinyint default 1,
	status tinyint default 1
);

drop table if exists bbs_cmt_like;
create table bbs_cmt_like
(
	uid int unsigned default 0,
	cid int unsigned default 0,
	ctime int unsigned default 0,
	unique uni(uid, pid)
);

/* site */
drop table site_setting;
create table site_setting(
	k varchar(20) default '',
	v varchar(255) default '',
	unique k(k) 
);