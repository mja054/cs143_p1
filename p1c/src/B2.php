<DOCTYPE html>
<html>
<title> Movie Information </title>
<body>

<form action="search.php" method="GET">
  <textarea name="query" rows="1" cols="40"><?php echo $_GET["query"];?></textarea>
  <br />
  <input type = "radio" name="type" value="actor">Actor
  <input type = "radio" name="type" value="actress">Actress
  <input type = "radio" name="type" value="movie">movie
  <br />
  <input type = "submit" name = "submit" value="search">
  <br />
</form>
<?php
  include "db_base.php";

  function print_actor_list($db_con, $Ares, $role)
  {
    $i = 0;
    echo "<table>";
    echo "<tbody>";
    while ($row = $db_con->fetch_row($Ares)) {
      echo "<tr><td><a href=\"./B1.php?id=".$row[0]."\">".$row[1]." ".$row[2]." (".$row[3].")</a> as " . $role . "</td></tr>";
      $i = $i+1;
    }
    echo "</tbody></table>";
    return $i;
  }

  function search_actor_info($db_con, $aid, $role)
  {
    $q1 = "Select id,first,last,dob,dod from Actor where id=".$aid;

    $Aresult = $db_con->execute_command($q1) or die ("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
    $result_q3 = print_actor_list($db_con, $Aresult, $role);

    return (result_q3) ? true : false;
  }

  function print_director($db_con, $did)
  {
    $mq1 = "Select first,last from Director where id=".$did;
    $Mresult = $db_con->execute_command($mq1) or die ("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
    $drow = $db_con->fetch_row($Mresult);
    echo "Director: " . $drow[0] . " " . $drow[1] . "<br />";
  }

  function print_movie_director($db_con, $mid)
  {
    $mq1 = "select did from MovieDirector where mid=".$mid;
    $Mresult = $db_con->execute_command($mq1) or die ("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
    $mdrow = $db_con->fetch_row($Mresult);
    print_director($db_con, $mdrow[0]);
  }

  function print_movie_genre($db_con, $mid)
  {
    $mq1 = "select genre from MovieGenre where mid=".$mid;
    $Mresult = $db_con->execute_command($mq1) or die ("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
    echo "Genre:";
    while($grow = $db_con->fetch_row($Mresult)) {
      echo " " . $grow[0];
    }
    echo "<br />";
  }

  function search_movie_info($db_con, $mid)
  {
    $mq1 = "select id,title,year,company,rating from Movie where id=".$mid;

    $Mresult = $db_con->execute_command($mq1) or die ("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
    $row = $db_con->fetch_row($Mresult);
    echo "<br />";
    echo "Title: " . $row[1] . " (" . $row[2] . ")<br />";
    echo "Producer: ". $row[3] . "<br />";
    echo "MPAA rating: " . $row[4] . "<br />";
    print_movie_director($db_con, $mid);
    print_movie_genre($db_con, $mid);
  }

  function print_movie_rating($db_con, $mid)
  {
    $mq1 = "select AVG(rating), COUNT(*) from Review where mid=".$mid;

    $Mresult = $db_con->execute_command($mq1) or die ("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
    $row = $db_con->fetch_row($Mresult);
    echo "Average rating: " . $gow[0] . " by " . $row[1] . " users";
  }

  function print_movie_review($db_con, $mid)
  {
    echo "<br />User Reviews<br />";
    print_movie_rating($db_con, $mid);

    $mq1 = "select time, name, rating, comment from Review where mid=".$mid;

    $Mresult = $db_con->execute_command($mq1) or die ("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
    while($row = $db_con->fetch_row($Mresult)) {
      echo "In " + $row[0] . ", " . $row[1] . " rates this movie " . $row[2] . "<br />";
      echo "Comment: '" . $row[3] . "'<br />";
    }
  }
  function execute_command()
  {
    $mid = $_GET["id"];
    $db_con = new dbConnect();
    search_movie_info($db_con, $mid);

    echo "<br />Actors in the Movie<br />";
    $query = "SELECT aid,role FROM MovieActor WHERE mid=".$mid;
    $res = $db_con->execute_command($query) or die("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
    while($row=$db_con->fetch_row($res)) {
      search_actor_info($db_con, $row[0], $row[1]);
    }
    print_movie_review($db_con, $mid);
    $db_con->close_db();
    echo "<br /><a href=\"./I3.php?movie=".$mid ."\">Add comment</a><br />";
  }

  if (isset($_GET["id"])) {
     execute_command();
  }
?>

</body>
</html>
