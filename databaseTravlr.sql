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

DELIMITER //
DROP TABLE IF EXISTS sp_insertar_categoria//
CREATE PROCEDURE sp_insertar_categoria(IN desParam TEXT)
BEGIN
	INSERT INTO Travelrdb.Category(
		descCategory
    )
    VALUES
    (
		desParam
    );
END//

DELIMITER //
DROP PROCEDURE IF EXISTS sp_insertar_lugar//
CREATE PROCEDURE sp_insertar_lugar(IN idCatParam INT, IN nameParam VARCHAR(50), IN latParam FLOAT(10, 6), IN lngParam FLOAT(10, 6), IN treshold INT)
BEGIN
	DECLARE eR FLOAT;
    DECLARE latRad2 FLOAT;
    DECLARE cont INT;
    
    SET eR = 6371000;
    SET latRad2 = RADIANS(latParam);
    
    DROP TABLE IF EXISTS formulas;
    CREATE TEMPORARY TABLE formulas AS (
		SELECT
			p.idPlace as idPlace,
			RADIANS(P.LatitudePlace) AS latRad1,
			RADIANS(latParam - P.LatitudePlace) AS dLatRad,
            RADIANS(lngParam - P.LongitudePlace) AS dLngRad
		FROM Place AS p
	);
    
    DROP TABLE IF EXISTS a;
    CREATE TEMPORARY TABLE a AS(
		SELECT 
			f.idPlace as idPlace,
			SIN(f.dLatRad/2) * SIN(f.dLatRad/2) + COS(f.latRad1) * COS(latRad2) * SIN(f.dLngRad/2) * SIN(f.dLngRad/2) AS a
		FROM formulas AS f
    );
    
    DROP TABLE IF EXISTS c;
    CREATE TEMPORARY TABLE c AS(
		SELECT
			a.idPlace as idPlace,
			2 * ATAN2( SQRT(a.a), SQRT(1 - a.a) ) AS c
		from a
    );
    
    DROP TABLE IF EXISTS d;
    CREATE TEMPORARY TABLE d AS(
		SELECT
			c.idPlace as idPlace,
			eR * c.c AS d
		FROM c
    );
    
    SET cont = (
		SELECT COUNT(*)
        FROM d
        WHERE d.d <= treshold
        );

	IF cont > 0 THEN
		SELECT 0 as Valid;
	ELSE
		INSERT INTO Travelrdb.Place(
			idCategory,
            NamePlace,
            LatitudePlace,
            LongitudePlace
        )
        VALUES(
			idCatParam,
            namePAram,
            latParam,
            lngParam
        );
		SELECT 
			1 AS Valid,
            last_insert_id() AS Id;
    END IF;
    
    DROP TABLE IF EXISTS d;
    DROP TABLE IF EXISTS c;
    DROP TABLE IF EXISTS a;
    DROP TABLE IF EXISTS formulas;
END//