CREATE TABLE users (id INT PRIMARY KEY AUTO_INCREMENT, username VARCHAR(25), userpassword VARCHAR(100));

CREATE TABLE characters (id INT PRIMARY KEY AUTO_INCREMENT, charName VARCHAR(25), charLevel INT, charClass VARCHAR(25), user_id INT, FOREIGN KEY (user_id) REFERENCES users (id))