DROP DATABASE IF EXISTS movies;
CREATE DATABASE movies;
USE movies;

CREATE TABLE rols
(
	id_role INT PRIMARY KEY AUTO_INCREMENT,
	rol_name VARCHAR(45) NOT NULL,
	estatus VARCHAR(5) DEFAULT 'A'
)Engine=InnoDB;

CREATE TABLE users
(
	id_user INT PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(45) NOT NULL,
	secret_password VARCHAR(100) UNIQUE NOT NULL,
	complete_name VARCHAR(200),
	id_role INT NOT NULL DEFAULT 2,
	token VARCHAR(100) UNIQUE DEFAULT NULL,
	fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	estatus VARCHAR(5) DEFAULT 'A'
)Engine=InnoDB;

CREATE TABLE login_register
(
	id_user INT NOT NULL,
	check_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)Engine=InnoDB;

CREATE TABLE movie
(
	id_movie INT PRIMARY KEY AUTO_INCREMENT,
	-- title VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(100)
)Engine=InnoDB;

CREATE TABLE register_user_movie 
(
	id_regmov INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    id_movie INT,
    reg_views INT DEFAULT 0
)Engine=InnoDB;

alter table users add constraint fk_users_rols foreign key (id_role) references rols(id_role);
alter table login_register add constraint fk_register_users foreign key (id_user) references users(id_user);
alter table register_user_movie add constraint fk_regmov_user foreign key (id_user) references users(id_user);
alter table register_user_movie add constraint fk_regmov_movie foreign key (id_movie) references movie(id_movie);

DROP TRIGGER IF EXISTS register_token_new;
DELIMITER $$
CREATE TRIGGER register_token_new
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
	SET NEW.token = md5(uuid());
END$$
DELIMITER ;

INSERT INTO rols(rol_name) VALUES('admin'),('user');
INSERT INTO movie(name, image)VALUES('Avengers_Infinity_War', '1'),('Jurassic_World', '2'),
('DeadPool_2', '3'),('Solo', '4'),('Los_Increibles_2', '5'),('Oceans_8', '6'),
('Black_Panter', '7'),('Tom_Raider', '8'),('Ready_Player_One', '9'),('Mission_Imposible', '10'),
('Pacific_Rim', '11'),('Venom', '12'),('Dog_Island', '13'),('Ralp', '14'),('Mamma_Mia', '15');