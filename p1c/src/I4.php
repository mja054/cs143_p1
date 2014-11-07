<DOCTYPE html>
<html>
<title> New Actor to Movie Submission </title>
<body>
<h1>Add an actor to a movie here!</h1>

<form action="I4.php" method="GET">
  Actor: <select name="actor">
  <?php
    include "db_base.php";
    $db_con = new dbConnect();
    $actorQuery = "SELECT id, last, first FROM Actor";
    $queryActors = $db_con->execute_command($actorQuery);
    while ($row = $db_con->fetch_row($queryActors)) {
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
  Actor Role: <textarea name="role" rows="10" cols="40"><?php echo $_GET["role"];?></textarea> <br><br>
  <input type = "submit" name = "submit">
</form>

<?php
  function execute_command()
  {
    $reviewer = $_GET["name"];
    $currTime = date('Y-m-d');
    $mid = $_GET["movie"];
    $rating = $_GET["rating"];
    $comment = $_GET["comment"];

    $db_con = new dbConnect();

    # Obtaining the movie title from the mid
    $movieQuery = "SELECT title FROM Movie WHERE id=$mid";
    $queryMovie = $db_con->execute_command($movieQuery);
    while ($row = $db_con->fetch_row($queryMovie)) {
      $movie = $row[0];
    }
    print "$reviewer<br>";
    print "$mid<br>";
    print "$movie<br>";
    print "$currTime<br>";
    print "$rating<br>";
    print "$comment<br>";

    $addReviewQuery = "INSERT INTO Review VALUES('$reviewer', $currTime, $mid, $rating, '$comment'";
    $insertDB = $db_con->execute_command($addReviewQuery);

    if (!$insertDB) {
      $error = mysql_error();
      die("Invalid query: $error");
    }
    else {
      print "Successfully inserted review for $movie from $reviewer into the Review database!";
    }

    $db_con->close_db();
  }

  if (isset($_GET["submit"])) {
     execute_command();
  }
?>

</body>
</html>
