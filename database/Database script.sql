CREATE DATABASE alaya_cotton;
USE alaya_cotton;

CREATE TABLE client_info(
	client_id INT auto_increment primary key,
	created_at timestamp default current_timestamp,
	client_name varchar(255) not null,
    mail_id varchar(100) unique not null,
    phone_number char(13) unique not null,
    gender varchar(6) not null,
    hash_password char(255) not null,
    date_of_birth date,
    client_address varchar(255),
    city varchar(100),
    state varchar(100),
    zip_code char(6)
);

drop table client_info;
show tables;
select * from client_info;
truncate client_info;


set sql_safe_updates=0;
delete from client_info;
set sql_safe_updates=1;

insert into client_info(mail_id, phone_number, client_name, hash_password, gender, date_of_birth) 
values ("siva@gmail.com","6385483215", "siva", "12345jkjdk", "male", "2002-04-21");

insert into client_info(mail_id, phone_number, client_name, hash_password,gender, date_of_birth) 
values ("sivan@gmail.com", "6385483005", "siva", "12345jkjdk", "male", '2002-04-21');
 
delete from client_info where phone_number = '9385483215';

CREATE TABLE product_info(
	product_id int auto_increment primary key,
	created_at timestamp default current_timestamp,
    product_name tinytext not null,
    product_category varchar(100) not null,	
    quantity int not null,
    buy_price smallint unsigned not null,
    sell_price smallint unsigned not null,
    product_description tinytext,
    img1_name varchar(200) not null,
    img1_uniqname varchar(100) not null,
    img2_name varchar(200) not null,
    img2_uniqname varchar(100) not null,
    img3_name varchar(200) not null,
    img3_uniqname varchar(100),
    img4_name varchar(200) not null,
    img4_uniqname varchar(100),
    img5_name varchar(200) not null,
    img5_uniqname varchar(100),
    staff_name varchar(255) not null,
    staff_id varchar(255) not null
);

drop table product_info;
select * from product_info;
truncate product_info;

create table card_table(
	id int auto_increment primary key,
    client_id int not null,
    product_id int not null,
    price smallint unsigned not null,
    quantity int not null,
    added_at timestamp default current_timestamp
);

drop table card_table;
select * from card_table;
SELECT * FROM client_info WHERE mail_id = "siva@gmail.com" LIMIT 1;

create table staff_details(
	staff_id INT auto_increment primary key,
	created_at timestamp default current_timestamp,
	staff_name varchar(255) not null,
    mail_id varchar(100) unique not null,
    phone_number char(13) unique not null,
    gender varchar(6) not null,
    hash_password char(255) not null,
    date_of_birth date,
    staff_address varchar(255),
    city varchar(100),
    state varchar(100),
    zip_code char(6),
    job_roll varchar(50) not null    
);

drop table staff_details;
select * from staff_details;

-- Wishlist Table
CREATE TABLE wishlist(
	id int auto_increment primary key,
    client_id int not null,
    client_name varchar(255) not null,
    product_id int not null,
    product_name tinytext not null,
    added_at timestamp default current_timestamp
);

INSERT INTO wishlist(client_id, client_name, product_id, product_name) values(1, "siva", 1, "Kondattam Copper Tissue Shirt & Gold Jari Border Dhoti Set");
INSERT INTO wishlist(client_id, client_name, product_id, product_name) values(1, "siva", 2, "Kondattam Tissue Shirt & Gold Border Dhoti Set");
SELECT * FROM wishlist;
DROP TABLE wishlist;
TRUNCATE wishlist;