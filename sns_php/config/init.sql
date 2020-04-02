DROP DATABASE IF EXISTS dotinstall_sns_php;
CREATE DATABASE dotinstall_sns_php;
GRANT ALL ON dotinstall_sns_php.* TO dbuser@localhost IDENTIFIED BY 'vader60';
use dotinstall_sns_php;

CREATE TABLE users(
    id INT NOT NULL auto_increment PRIMARY KEY,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    created DATETIME,
    modified DATETIME
);

desc users;
