<DOCTYPE html>
<html>
<title> New Director to Movie Submission </title>
<body>
<h1>Add a director to a movie here!</h1>

<form action="I5.php" method="GET">
  Director: <select name="director">
  <?php
    include "db_base.php";
    $db_con = new dbConnect();
    $directorQuery = "SELECT id, last, first FROM Director";
    $queryDirectors = $db_con->execute_command($directorQuery);
    while ($row = $db_con->fetch_row($queryDirectors)) {
      print "<option value=$row[0]>$row[1], $row[2]</option>\n";
    }
    $db_con->close_db();
    ?>
  </select><br>
  Movie: <select name="movie">
  <?php
    $db_con = new dbConnect();
    $movieQuery = "SELECT id, title FROM Movie";
    $queryMovies = $db_con->execute_command($movieQuery);
    while ($row = $db_con->fetch_row($queryMovies)) {
      print "<option value=$row[0]>$row[1]</option>\n";
    }
    $db_con->close_db();
  ?>
  </select><br>
  <input type = "submit" name = "submit">
</form>

<?php
  function execute_command()
  {
    $mid = $_GET["movie"];
    $did = $_GET["director"];

    $db_con = new dbConnect();

    # Obtaining the movie title from the mid
    $movieQuery = "SELECT title FROM Movie WHERE id=$mid";
    $queryMovie = $db_con->execute_command($movieQuery);
    while ($row = $db_con->fetch_row($queryMovie)) {
      $movie = $row[0];
    }

    # Obtaining the director name from the did
    $directorQuery = "SELECT last, first FROM Director WHERE id=$did";
    $queryDirector = $db_con->execute_command($directorQuery);
    while ($row = $db_con->fetch_row($queryDirector)) {
      $director_last = $row[0];
      $director_first = $row[1];
    }

    $addDirectorQuery = "INSERT INTO MovieDirector VALUES($mid, $did)";
    $insertDB = $db_con->execute_command($addDirectorQuery);

    if (!$insertDB) {
      $error = mysql_error();
      die("Invalid query: $error");
    }
    else {
      print "Successfully inserted $director_first $director_last into $movie!";
    }

    $db_con->close_db();
  }

  if (isset($_GET["submit"])) {
     execute_command();
  }
?>

</body>
</html>
