<DOCTYPE html>
<html>
<title> CS143 Project 1b </title>
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
  function execute_command()
  {
    $aid = $_GET["id"];
    $db_con = new dbConnect();
    $query = "SELECT mid FROM MovieActor WHERE aid=".$aid;
    $res = $db_con->execute_command($query) or die("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
    while($row=$db_con->fetch_row($res)) {
      echo $row[0] . "<br />";
    }
    $db_con->close_db();
  }

  if (isset($_GET["id"])) {
     execute_command();
  }
?>

</body>
</html>
