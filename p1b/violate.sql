-- Violates the movie ID foreign key constraint
INSERT INTO Review VALUES(
	NULL,
	NULL,
	123,
	NULL,
	NULL
);
-- ERROR 1452 (23000) at line 2: Cannot add or update a child row:
-- a foreign key constraint fails (`CS143/Review`, CONSTRAINT 
-- `Review_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

-- Violates the actor ID foreign key constraint
INSERT INTO MovieActor VALUES(
	222,
	345566,
	NULL
);
-- ERROR 1452 (23000) at line 2: Cannot add or update a child row:
-- a foreign key constraint fails (`CS143/MovieActor`, CONSTRAINT
-- `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))

-- Violates the movie ID foreign key constraint
INSERT INTO MovieActor VALUES(
	123,
	345,
	NULL
);
-- ERROR 1452 (23000) at line 2: Cannot add or update a child row:
-- a foreign key constraint fails (`CS143/MovieActor`, CONSTRAINT
-- `MovieActor_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

-- Violates the movie ID foreign key constraint
INSERT INTO MovieDirector VALUES(
	123,
	345
);
-- ERROR 1452 (23000) at line 2: Cannot add or update a child row:
-- a foreign key constraint fails (`CS143/MovieDirector`, CONSTRAINT
-- `MovieDirector_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

-- Violates the director ID foreign key constraint
INSERT INTO MovieDirector VALUES(
	222,
	345
);
-- ERROR 1452 (23000) at line 2: Cannot add or update a child row:
-- a foreign key constraint fails (`CS143/MovieDirector`, CONSTRAINT
-- `MovieDirector_ibfk_2` FOREIGN KEY (`did`) REFERENCES `Director` (`id`))

-- Violates the movie ID foreign key constraint
INSERT INTO MovieGenre VALUES(
	123,
	NULL
);
-- ERROR 1452 (23000) at line 1: Cannot add or update a child row: 
-- a foreign key constraint fails (`CS143/MovieGenre`, CONSTRAINT 
-- `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

-- Violates the director id primary key constraint
INSERT INTO Director VALUES(
	NULL,
	'Tung',
	'Spencer',
	1990-06-07,
	NULL
);
-- ERROR 1048 (23000) at line 2: Column 'id' cannot be null

-- Violates the movie id primary key constraint
INSERT INTO Movie VALUES(
	NULL,
	'The Adventures of CS143',
	2014,
	'R',
	'UCLA'
);
-- ERROR 1048 (23000) at line 2: Column 'id' cannot be null

-- Violates the actor id primary key constraint
INSERT INTO Actor VALUES(
	NULL,
	'Tung',
	'Spencer',
	'M',
	1990-06-07,
	NULL
);
-- ERROR 1048 (23000) at line 2: Column 'id' cannot be null

-- Violates the two check constraints on non-null movie titles and year
INSERT INTO Movie VALUES(
	100110,
	NULL,
	NULL,
	'R',
	'UCLA'
);

-- Violates the two check constraints on non-null actor sex and date of birth
INSERT INTO Actor VALUES(
	11011,
	NULL,
	NULL,
	NULL,
	NULL,
	NULL
);

-- Violates the check constraint on dob being null
INSERT INTO Director VALUES(
	101011,
	NULL,
	NULL,
	NULL,
	NULL
);
