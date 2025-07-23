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

CREATE TABLE country (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE menthol_flag (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE ec_item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    tar FLOAT,
    nicotine FLOAT,
    quantity INT,
    price INT,
    country_id INT,
    menthol_flag_id INT,
    image_filename VARCHAR(100),
    FOREIGN KEY (country_id) REFERENCES country(id),
    FOREIGN KEY (menthol_flag_id) REFERENCES menthol_flag(id)
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