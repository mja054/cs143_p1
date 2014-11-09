<DOCTYPE html>
<html>
<title> Actor Information </title>
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
  function print_movie_list($db_con, $Mres)
  {
    $i = 0;
    echo "<table>";
    echo "<tbody>";
    while ($mrow = mysql_fetch_row($Mres)) {
      echo "<tr><td><a href=\"./B2.php?id=".$mrow[0]."\">".$mrow[1]." (".$mrow[2].")</a></td></tr>";
      $i = $i+1;
    }
    echo "</tbody></table>";
    return $i;
  }

  function search_movie_info($db_con, $mid)
  {
    $mq1 = "select id,title,year from Movie where id=".$mid;

    $Mresult = $db_con->execute_command($mq1) or die ("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
    $result_q = print_movie_list($db_conn, $Mresult);
    return $result_q ? true : false;
  }
  function execute_command()
  {
    $aid = $_GET["id"];
    $db_con = new dbConnect();
    $query = "SELECT mid FROM MovieActor WHERE aid=".$aid;
    $res = $db_con->execute_command($query) or die("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
    while($row=$db_con->fetch_row($res)) {
      search_movie_info($db_con, $row[0]);
    }
    $db_con->close_db();
  }

  if (isset($_GET["id"])) {
     execute_command();
  }
?>

</body>
</html>
