CREATE TABLE ec_user (
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    account VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    postcode VARCHAR(7),
    address VARCHAR(100),
    phone VARCHAR(15),
    mail VARCHAR(100)
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

CREATE TABLE ec_cart (
    id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userid INT(10) NOT NULL,
    itemid INT(10) NOT NULL,
    quantity INT(10) NOT NULL DEFAULT 1,
    FOREIGN KEY (userid) REFERENCES ec_user(id),
    FOREIGN KEY (itemid) REFERENCES ec_item(id)
);


create table ec_purchase (
	id int(10) not null auto_increment primary key, 
	userid int(10) not null, 
	itemid int(10) not null, 
	date date, 
	foreign key(userid) references ec_user(id),
	foreign key(itemid) references ec_item(id)
);