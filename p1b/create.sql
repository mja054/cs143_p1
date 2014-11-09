-- Drops table before recreating them if they exist
DROP TABLE IF EXISTS MovieGenre;
DROP TABLE IF EXISTS MovieDirector;
DROP TABLE IF EXISTS MovieActor;
DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS Movie;
DROP TABLE IF EXISTS Actor;
DROP TABLE IF EXISTS Director;
DROP TABLE IF EXISTS MaxPersonID;
DROP TABLE IF EXISTS MaxMovieID;

-- Creates tables
CREATE TABLE Movie (
	id int PRIMARY KEY, -- Every movie has a unique identification number
	title varchar(100), 
	year int,
	rating varchar(10),
	company varchar(50),
	CHECK(title IS NOT NULL), -- Every movie must have a title
	CHECK(year IS NOT NULL) -- Every movie must have a year
) ENGINE = INNODB;

CREATE TABLE Actor (
	id int PRIMARY KEY, -- Every actor has a unique identification number
	last varchar(20), 
	first varchar(20),
	sex varchar(6),
	dob date,
	dod date,
	CHECK(dob IS NOT NULL), -- Every actor must have a date of birth
	CHECK(dob < dod), -- Date of birth must be earlier than date of death
	CHECK(sex IS NOT NULL) -- Every actor must have a sex
) ENGINE = INNODB;

CREATE TABLE Director (
	id int PRIMARY KEY, -- Every director has a unique identification number
	last varchar(20),
	first varchar(20),
	dob date,
	dod date,
	CHECK(dob IS NOT NULL), -- Every director must have a date of birth
	CHECK(dob < dod) -- Date of birth must be earlier than date of death
) ENGINE = INNODB;

CREATE TABLE MovieGenre (
	mid int,
	genre varchar(20),
	FOREIGN KEY (mid) references Movie(id) -- Setting mid to reference the primary key in Movie
) ENGINE = INNODB;

CREATE TABLE MovieDirector (
	mid int,
	did int,
	FOREIGN KEY (mid) references Movie(id), -- Setting mid to reference the primary key in Movie
	FOREIGN KEY (did) references Director(id) -- Setting mid to reference the primary key in Director
) ENGINE = INNODB;

CREATE TABLE MovieActor (
	mid int,
	aid int,
	role varchar(50),
	FOREIGN KEY (mid) references Movie(id), -- Setting mid to reference the primary key in Movie
	FOREIGN KEY (aid) references Actor(id) -- Setting mid to reference the primary key in Actor
) ENGINE = INNODB;

CREATE TABLE Review (
	name varchar(20), 
	time timestamp DEFAULT CURRENT_TIMESTAMP, 
	mid int, 
	rating int, 
	comment varchar(500),
	FOREIGN KEY (mid) references Movie(id) -- Setting mid to reference the primary key in Movie
) ENGINE = INNODB;

CREATE TABLE MaxPersonID (id int) ENGINE = INNODB;
CREATE TABLE MaxMovieID (id int) ENGINE = INNODB;

