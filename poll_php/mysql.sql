DROP DATABASE if EXISTS dotinstall_poll_php;
CREATE DATABASE dotinstall_poll_php;

GRANT ALL ON dotinstall_poll_php.* to dbuser@localhost identified by 'vader60';

use dotinstall_poll_php

drop table if EXISTS answers;
create TABLE answers (
    id INT NOT NULL auto_increment PRIMARY KEY,
    answer INT NOT NULL,
    created DATETIME,
    remote_address varchar(15),
    user_agent varchar(255),
    answer_date date,
    unique unique_answer(remote_address, user_agent, answer_date)
);
