drop database if EXISTS dotinstall_db;
create database dotinstall_db;
grant all on dotinstall_db. * to dbuser@localhost identified by 'vader60';
use dotinstall_db;
create table users (
  id int not null auto_increment primary key,
  name varchar(255),
  score int
);
