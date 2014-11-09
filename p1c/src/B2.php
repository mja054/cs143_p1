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

  function print_actor_list($db_con, $Ares)
  {
    $i = 0;
    echo "<table>";
    echo "<tbody>";
    while ($row = $db_con->fetch_row($Ares)) {
      echo "<tr><td><a href=\"./B1.php?id=".$row[0]."\">".$row[1]." ".$row[2]." (".$row[3].")</a></td></tr>";
      $i = $i+1;
    }
    echo "</tbody></table>";
    return $i;
  }

  function search_actor_info($db_con, $aid)
  {
    $q1 = "Select id,first,last,dob,dod from Actor where id=".$aid;

    $Aresult = $db_con->execute_command($q1) or die ("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
    $result_q3 = print_actor_list($db_con, $Aresult);

    return (result_q3) ? true : false;
  }
  function execute_command()
  {
    $mid = $_GET["id"];
    $db_con = new dbConnect();
    $query = "SELECT aid FROM MovieActor WHERE mid=".$mid;
    $res = $db_con->execute_command($query) or die("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
    while($row=$db_con->fetch_row($res)) {
      search_actor_info($db_con, $row[0]);
    }
    $db_con->close_db();
  }

  if (isset($_GET["id"])) {
     execute_command();
  }
?>

</body>
</html>
