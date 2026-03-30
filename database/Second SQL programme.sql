use demo;

create table customer(
customer_id int,
customer_name varchar(50),
customer_address varchar(150),
city varchar(50),
state varchar(50),
ZIP_Code varchar(6)
);

select * from customer;

insert into customer values (1, "Elory doe", "392 Sunset Blvd","New York", "NT", "10059");
insert into customer values (2, "Mary Smith", "392 Sunset Blvd","New York", "NT", "94032");
insert into customer values (3, "Richard Newman", "392 Sunset Blvd","New York", "NT", "92010");

select * from customer;

alter table customer change customer_address address varchar(150);

select * from customer;

alter table customer add column mobile_number int;

select * from customer;

set sql_safe_updates=0;
delete from customer where mobile_number is null;
set sql_safe_updates=1;

select * from customer;

insert into customer values (1, "Elory doe", "392 Sunset Blvd","New York", "NT", "10059", 555123453), 
(2, "Mary Smith", "392 Sunset Blvd","New York", "NT", "94032", 343888999), 
(3, "Richard Newman", "392 Sunset Blvd","New York", "NT", "92010", 111222333);

select * from customer;

select customer_name from customer;

select * from user_registration;

use user_registration;

select * from user_registration;

select * from users;

drop table users;

alter table user_info add gender varchar(6);

select * from user_info;

delete from user_info;

set sql_safe_updates=0;
delete from user_info;
set sql_safe_updates=1;

select * from user_info;

drop table user_info;

CREATE TABLE user_info(
	id INT auto_increment PRIMARY KEY,
	user_name varchar(80) NOT NULL,
    email varchar(100) unique NOT NULL,
    hash_password char(60) NOT NULL,
    gender varchar(6) NOT NULL
);

select * from user_info;

drop table user_info;

CREATE TABLE user_info(
	id INT auto_increment PRIMARY KEY,
	user_name varchar(80) NOT NULL,
    email varchar(100) unique NOT NULL,
    hash_password char(60) NOT NULL,
    gender varchar(6) NOT NULL
);

select * from user_info;

drop table user_info;

CREATE TABLE user_info(
	id INT auto_increment PRIMARY KEY,
	user_name varchar(80) NOT NULL,
    email varchar(100) unique NOT NULL,
    hash_password char(60) NOT NULL,
    gender varchar(6) NOT NULL,
    url varchar(2083)
);

select * from user_info;

set sql_safe_updates=0;
delete from user_info;
set sql_safe_updates=1;

select * from user_info;
