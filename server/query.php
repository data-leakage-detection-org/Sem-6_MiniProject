<?php 
define('USER_TABLE_QUERY',"CREATE TABLE IF NOT EXISTS users(
id INT(10) AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
user_type ENUM('user','admin') DEFAULT 'user',
gender ENUM('male', 'female') DEFAULT 'male',
mobile VARCHAR(20) DEFAULT NULL,
admin_active VARCHAR(10) DEFAULT '0',
blocked ENUM('0', '1') DEFAULT '0',
profile VARCHAR(255) DEFAULT 'user_profile.jpg'
)");

define('DATA_FILE_TABLE_QUERY',"CREATE TABLE IF NOT EXISTS data_files(
id INT(10) AUTO_INCREMENT PRIMARY KEY,
subject VARCHAR(255) NOT NULL,
file_name VARCHAR(255) NOT NULL,
file_size VARCHAR(255) NOT NULL,
sender_id VARCHAR(255) NOT NULL,
receiver_id VARCHAR(10) NOT NULL,
secret_key VARCHAR(255) NOT NULL
)");


define('KEY_REQUEST_TABLE_QUERY',"CREATE TABLE IF NOT EXISTS key_requests(
id INT(10) AUTO_INCREMENT PRIMARY KEY,
request_by_user VARCHAR(255) NOT NULL,
request_to_user VARCHAR(255) NOT NULL,
file VARCHAR(255) NOT NULL,
secret_key VARCHAR(255) NOT NULL,
status ENUM('pending','rejected','shared') DEFAULT 'pending'
)");

define('LEAKER_TABLE_QUERY',"CREATE TABLE IF NOT EXISTS leakers(
id INT(10) AUTO_INCREMENT PRIMARY KEY,
user_id VARCHAR(255) NOT NULL,
subject VARCHAR(255) NOT NULL,
file_id VARCHAR(255) NOT NULL,
secret_key VARCHAR(255) NOT NULL
)");

define('ADMIN_EXIST_QUERY',"SELECT * FROM users WHERE user_type='admin' LIMIT 1");

define('CREATE_ADMIN_QUERY',"INSERT INTO users(username, email, password, user_type, admin_active)VALUES('admin', 'admin@gmail.com', '12345', 'admin', '1')");

define('LEAKED_MESSAGES_QUERY',"CREATE TABLE IF NOT EXISTS leaked_messages(
	id INT(10) AUTO_INCREMENT PRIMARY KEY,
	user_id VARCHAR(255) NOT NULL,
	file_id VARCHAR(255) NOT NULL,
	created_at DATETIME
)");
define('ATTEMPTS_QUERY',"CREATE TABLE IF NOT EXISTS attempts(
	id INT(10) AUTO_INCREMENT PRIMARY KEY,
	user_id VARCHAR(255) NOT NULL,
	file_id VARCHAR(255) NOT NULL,
	attempt VARCHAR(10) DEFAULT '2'	
)");
?>