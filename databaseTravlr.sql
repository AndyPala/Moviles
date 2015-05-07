DROP DATABASE IF EXISTS DBName;
CREATE DATABASE DBName;
USE DBName;

DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Place;

CREATE TABLE User(
	IdUser UNSIGNED INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	Username VARCHAR(16) NOT NULL,
	PasswordUser VARCHAR(16) NOT NULL,
	EmailUser VARCHAR(50),
	ActivoUser TINYINT UNSIGNED NOT NULL
);

CREATE TABLE Category(
	idCategory UNSIGNED INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	descCategory TEXT
);

CREATE TABLE Place(
	IdPlace UNSIGNED INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	idCategory INT,
	NamePlace VARCHAR(50) NOT NULL,
	LatitudePlace FLOAT(10, 6) NOT NULL,
	LongitudePlace FLOAT(10, 6) NOT NULL,

	FOREING KEY (idCategory) REFERENCES Category(idCategory)
);

CREATE TABLE Review(
	IdReview UNSIGNED INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	IdUser INT,
	IdPlace INT,
	ReviewDesc TEXT NOT NULL,
	ReviewStars TINYINT UNSIGNED,

	FOREING KEY (IdUser) REFERENCES User(IdUser),
	FOREING KEY (IdPlace) REFERENCES Place(IdPlace)
);

DELIMITER //

DROP PROCEDURE IF EXISTS sp_insertar_usuario
CREATE PROCEDURE sp_insertar_usuario(IN nameParam VARCHAR(16), IN emailParam VARCHAR(50), IN passParam VARCHAR(16))
BEGIN

	declare cont int;
	set cont = (
		SELECT COUNT(*)
		FROM 'DBName'.'User'
		WHERE
			'DBName'.'Username' = nameParam
			OR 'DBName'.'EmailUser' = emailParam);

	if cont > 0 then
		SELECT 0 as Valid
	else
		INSERT INTO 'DBName'.'User'
			('Username',
			'PasswordUser',
			'EmailUser',
			'ActivoUser')
		VALUES
			(nameParam,
			passParam,
			emailParam,
			1);
		SELECT
			1 as Valid,
			last_insert_id() as Id;
	end if;
END//

DROP PROCEDURE IF EXISTS sp_login_user
CREATE PROCEDURE sp_login_user(IN  nameParam VARCHAR(16), IN passParam VARCHAR(16))
BEGIN
	SELECT
		COUNT(*) as Valid,
		'User'.'Username',
		'User'.'PasswordUser'
	FROM 'DBName'.'User'
	WHERE
		'DBName'.'Username' = nameParam
		AND 'DBName'.'PasswordUser' = passParam;
END//


