-- Names of actors in the movie 'Die Another Day'
SELECT CONCAT(first, ' ', last)
FROM Actor A, MovieActor MA, Movie M
WHERE A.id=MA.aid AND MA.mid=M.id AND M.title='Die Another Day';

-- Count of all actors who acted in multiple movies
SELECT COUNT(*)
FROM (SELECT aid
	  FROM MovieActor MA
	  GROUP BY aid
	  HAVING COUNT(aid) > 1) AS A;

-- Print the id's and titles of movies in which the directors
-- were also the Actors of the movie.
SELECt id, title
FROM Movie M, MovieDirector MD, MovieActor MA
WHERE M.id = MD.mid AND M.id = MA.mid AND MD.did = MA.aid;
