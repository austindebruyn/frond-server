
CREATE TABLE `dirs` (
	id			INT PRIMARY KEY AUTO_INCREMENT,
	name 		VARCHAR(1024),
	hash 		VARCHAR(32),
	dirname 	VARCHAR(1024)
)

CREATE TABLE `files` (
	id 			INT PRIMARY KEY AUTO_INCREMENT,
	location 	VARCHAR(1024),
	hash 		VARCHAR(32)
)