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
      print "<option ";
      if ($_GET["actor"] == "$row[0]") {echo 'selected="true"';}
      print "value=$row[0]>$row[1], $row[2]</option>\n";
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
      print "<option ";
      if ($_GET["movie"] == "$row[0]") {echo 'selected="true"';}
      print "value=$row[0]>$row[1]</option>\n";
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
    $mid = $_GET["movie"];
    $aid = $_GET["actor"];
    $role = $_GET["role"];

    $db_con = new dbConnect();

    # Obtaining the movie title from the mid
    $movieQuery = "SELECT title FROM Movie WHERE id=$mid";
    $queryMovie = $db_con->execute_command($movieQuery);
    while ($row = $db_con->fetch_row($queryMovie)) {
      $movie = $row[0];
    }

    # Obtaining the actor name from the aid
    $actorQuery = "SELECT last, first FROM Actor WHERE id=$aid";
    $queryActor = $db_con->execute_command($actorQuery);
    while ($row = $db_con->fetch_row($queryActor)) {
      $actor_last = $row[0];
      $actor_first = $row[1];
    }

    $addActorQuery = "INSERT INTO MovieActor VALUES($mid, $aid, '$role')";
    $insertDB = $db_con->execute_command($addActorQuery);

    if (!$insertDB) {
      $error = mysql_error();
      die("Invalid query: $error");
    }
    else {
      print "Successfully inserted $actor_first $actor_last into $movie!";
    }

    $db_con->close_db();
  }

  if (isset($_GET["submit"])) {
     execute_command();
  }
?>

</body>
</html>
