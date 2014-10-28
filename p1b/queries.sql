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

-- ????
-- TODO: WRITE ANOTHER QUERY
