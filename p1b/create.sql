DROP TABLE IF EXISTS Movie;
DROP TABLE IF EXISTS Actor;
DROP TABLE IF EXISTS Director;
DROP TABLE IF EXISTS MovieGenre;
DROP TABLE IF EXISTS MovieDirector;
DROP TABLE IF EXISTS MovieActor;
DROP TABLE IF EXISTS Review;

CREATE TABLE IF NOT EXISTS Movie (id int PRIMARY KEY, title varchar(100), year int, rating varchar(10), company varchar(50));
CREATE TABLE IF NOT EXISTS Actor (id int PRIMARY KEY, last varchar(20), first varchar(20), sex varchar(6), dob date, dod date);
CREATE TABLE IF NOT EXISTS Director (id int PRIMARY KEY, last varchar(20), first varchar(20), dob date, dod date);
CREATE TABLE IF NOT EXISTS MovieGenre (mid int, genre varchar(20));
CREATE TABLE IF NOT EXISTS MovieDirector (mid int, did int);
CREATE TABLE IF NOT EXISTS MovieActor (mid int, aid int, role varchar(50));
CREATE TABLE IF NOT EXISTS Review (name varchar(20), time timestamp, mid int, rating int, comment varchar(500));

CREATE TABLE IF NOT EXISTS MaxPersonID (id int);
CREATE TABLE IF NOT EXISTS MaxMovieID (id int);
