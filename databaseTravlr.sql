DROP DATABASE IF EXISTS TravelrDB;
CREATE DATABASE TravelrDB;
USE TravelrDB;

DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS ImagePlace;
DROP TABLE IF EXISTS Image;
DROP TABLE IF EXISTS Place;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS User;

CREATE TABLE User (
    IdUser INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(16) NOT NULL,
    PasswordUser VARCHAR(16) NOT NULL,
    EmailUser VARCHAR(50),
    ActivoUser TINYINT UNSIGNED NOT NULL
);

CREATE TABLE Category(
	idCategory INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	descCategory TEXT NOT NULL
);

CREATE TABLE Image(
	idImage INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    path TEXT NOT NULL
);

CREATE TABLE Place(
	IdPlace INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	idCategory INT UNSIGNED,
	NamePlace VARCHAR(50) NOT NULL,
	LatitudePlace FLOAT(10, 6) NOT NULL,
	LongitudePlace FLOAT(10, 6) NOT NULL,

	foreign key(idCategory) REFERENCES Category(idCategory)
);

CREATE TABLE ImagePlace(
	idImage INT UNSIGNED,
    idPlace INT UNSIGNED,
    
    foreign key (idImage) REFERENCES Image(idImage),
    foreign key (idPlace) REFERENCES Place(idPlace)
);

CREATE TABLE Review(
	IdReview INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	IdUser INT UNSIGNED,
	IdPlace INT UNSIGNED,
	ReviewDesc TEXT NOT NULL,
	ReviewStars TINYINT UNSIGNED NOT NULL,
    
	foreign key(IdUser) REFERENCES User(IdUser),
	foreign key(IdPlace) REFERENCES Place(IdPlace)
);

DELIMITER //
DROP PROCEDURE IF EXISTS sp_buscar_usuario_id//
CREATE PROCEDURE sp_buscar_usuario_id(IN idParam INT)
BEGIN
	SELECT 
		COUNT(*) as Valid,
		User.IdUser,
        User.Username,
        User.EmailUser
	FROM TravelrDB.User
	WHERE
		User.IdUser = idParam;
END//

DELIMITER //
DROP PROCEDURE IF EXISTS sp_insertar_usuario//
CREATE PROCEDURE sp_insertar_usuario(IN nameParam VARCHAR(16), IN emailParam VARCHAR(50), IN passParam VARCHAR(16))
BEGIN

	declare cont int;
	set cont = (
		SELECT COUNT(*)
		FROM TravelrDB.User
		WHERE
			User.Username = nameParam
			OR User.EmailUser = emailParam);

	if cont > 0 then
		SELECT 0 as Valid;
	else
		INSERT INTO TravelrDB.User(
			Username,
			PasswordUser,
			EmailUser,
			ActivoUser)
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

DELIMITER //
DROP PROCEDURE IF EXISTS sp_login_user//
CREATE PROCEDURE sp_login_user(IN  nameParam VARCHAR(16), IN passParam VARCHAR(16))
BEGIN
	SELECT
		COUNT(*) as Valid,
		User.Username,
		User.PasswordUser
	FROM TravelrDB.User
	WHERE
		User.Username = nameParam
		AND User.PasswordUser = passParam;
END//

DELIMITER //
DROP PROCEDURE IF EXISTS sp_login_email//
CREATE PROCEDURE sp_login_email(IN  emailParam VARCHAR(50), IN passParam VARCHAR(16))
BEGIN
	SELECT
		COUNT(*) as Valid,
		User.Username,
		User.PasswordUser
	FROM TravelrDB.User
	WHERE
		User.EmailUser = emailParam
		AND User.PasswordUser = passParam;
END//