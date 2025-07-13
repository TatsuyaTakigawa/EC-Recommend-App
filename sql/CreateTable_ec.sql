

create table ec_user (
	id int(10) auto_increment primary key, 
	name varchar(30) not null, 
	account varchar(10) not null unique, 
	password varchar(10) not null,
	postcode varchar(7), 
	address varchar(100), 
	phone varchar(11), 
	mail varchar(30)
);

create table ec_genre (
	id int(10) not null auto_increment primary key, 
	name varchar(100)
);

create table ec_item (
	id int(10) not null auto_increment primary key, 
	name varchar(100) not null, 
	description varchar(500), 
	genre int(10),
	imgpath varchar(100) ,
	price int(10),
	foreign key(genre) references ec_genre(id)
);

create table ec_cart (
	id int(10) not null auto_increment primary key,
	userid int(10) not null, 
	itemid int(10) not null, 
	foreign key(userid) references ec_user(id),
	foreign key(itemid) references ec_item(id)
);


create table ec_purchase (
	id int(10) not null auto_increment primary key, 
	userid int(10) not null, 
	itemid int(10) not null, 
	date date, 
	foreign key(userid) references ec_user(id),
	foreign key(itemid) references ec_item(id)
);

