<DOCTYPE html>
<html>
<title> Search for Actor/Movies! </title>
<body>
<h1>Search for your favorite actor or movie here!</h1>

<form action="search.php" method="GET">
  Enter your search query here: <textarea name="query" rows="1" cols="10"><?php echo $_GET["query"];?></textarea>
  <input type = "submit" name = "submit">
</form>


<?php
  include "db_base.php";
  function execute_command()
  {
    $query = $_GET["query"];

    $db_con = new dbConnect();

    # Crafting the search query as a SQL query


    # ================================================



    $searchQuery = "SELECT id FROM MaxPersonID";
    $querySearch = $db_con->execute_command($searchQuery);
    while ($row = $db_con->fetch_row($querySearch)) {
      $newID = $row[0];
    }

    # Updating the max ID
    $updateMaxIDquery = "UPDATE MaxPersonID SET id=id+1";
    $updateMaxID = $db_con->execute_command($updateMaxIDquery);

    if ($actDir == "Actor") {
      $insert_query = "INSERT INTO Actor VALUES($newID, '$last', '$first', '$sex', $dob, $dod)";
    }
    else if ($actDir == "Director") {
      $insert_query = "INSERT INTO Director VALUES($newID, '$last', '$first', $dob, $dod)";
    }
    
    $insertDB = $db_con->execute_command($insert_query);

    if (!$insertDB) {
      $error = mysql_error();
      $updateMaxIDquery = "UPDATE MaxPersonID SET id=id-1";
      $updateMaxID = $db_con->execute_command($updateMaxIDquery);
      die("Invalid query: $error");
    }
    else {
      print "Successfully inserted $first $last into the $actDir database!";
    }

    $db_con->close_db();
  }

  if (isset($_GET["submit"])) {
     execute_command();
  }
?>

</body>
</html>
