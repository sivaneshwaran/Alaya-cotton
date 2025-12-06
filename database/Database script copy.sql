CREATE DATABASE alaya_cotton;
USE alaya_cotton;

CREATE TABLE client_info(
	client_id INT auto_increment primary key,
	created_at timestamp default current_timestamp,
	client_name varchar(255) not null,
    mail_id varchar(100) unique not null,
    phone_number char(10) unique not null,
    gender varchar(6) not null,
    hash_password char(255) not null,
    date_of_birth date,
    address varchar(255),
    city varchar(100),
    state varchar(100),
    zip_code char(6)
);

drop table client_info;
show tables;
select * from client_info;

insert into client_info(mail_id, phone_number, client_name, hash_password, gender, date_of_birth) 
values ("siva@gmail.com","6385483215", "siva", "12345jkjdk", "male", "2002-04-21");

insert into client_info(mail_id, phone_number, client_name, hash_password,gender, date_of_birth) 
values ("sivan@gmail.com", "6385483005", "siva", "12345jkjdk", "male", '2002-04-21');
 
delete from client_info where mail_id = "siva@gmail.com";

CREATE TABLE product_info(
	product_id int auto_increment primary key,
    product_name tinytext not null,
    product_category varchar(100) not null,	
    available_quantity int not null,
    price smallint unsigned not null,
    product_description tinytext,
    img_1 blob not null,
    img_2 blob not null,
    img_3 blob,
    img_4 blob,
    img_5 blob    
);

drop table product_info;
select * from product_info;

create table card_table(
	id int auto_increment primary key,
    client_id int not null,
    product_id int unique not null,
    quantity int not null,
    saved_type varchar(10)
);

drop table card_table;
select * from card_table;