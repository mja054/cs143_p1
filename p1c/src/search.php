<DOCTYPE html>
<html>
<title> Search for Actor/Movies! </title>
<body>
<h1>Search for your favorite actor or movie here!</h1>

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
    echo "Names:<br />";
    echo "<table>";
    echo "<tbody>";
    while ($row = $db_con->fetch_row($Ares)) {
      echo "<tr><td><a href=\"./B1.php?id=".$row[0]."\">".$row[1]." ".$row[2]." (".$row[3].")</a></td></tr>";
      $i = $i+1;
    }
    echo "</tbody></table>";
    return $i;
  }

  function search_actor_info($keywords, $gender)
  {
    $keyLen = count($keywords);
    if ($keyLen==1){
      $q1 = "Select id,first,last,dob,dod from Actor where first like '%".$keywords[0]."%' and sex like '".$gender."'";
      $q2 = "Select id,first,last,dob,dod from Actor where last like '%".$keywords[0]."%' and sex like '".$gender."'";
      $q3 = $q1. " UNION " . $q2;

    } else {
      $q1 = "Select id,first,last,dob,dod from Actor where first like '%".$keywords[0]."%' and last like '%".$keywords[1]."%' and sex like '".$gender."'";
      $q2 = "Select id,first,last,dob,dod from Actor where last like '%".$keywords[0]."%' and first like '%".$keywords[1]."%' and sex like '".$gender."'";
      $q3 = $q1 . " UNION " . $q2;
    }
    $db_con = new dbConnect();

#   $Aresult = $db_con->execute_command($q1) or die ("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
#   $result_q1 = print_actor_list($db_con, $Aresult);

#   $Aresult = $db_con->execute_command($q2) or die ("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
#   $result_q2 = print_actor_list($db_con, $Aresult);

    $Aresult = $db_con->execute_command($q3) or die ("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
    $result_q3 = print_actor_list($db_con, $Aresult);

    $db_con->close_db();
    return (result_q3) ? true : false;
  }

  function print_movie_list($db_con, $Mres)
  {
    $i = 0;
    echo "<br />Movies:<br />"; 
    echo "<table>";
    echo "<tbody>";
    while ($mrow = mysql_fetch_row($Mres)) {
      echo "<tr><td><a href=\"./B2.php?id=".$mrow[0]."\">".$mrow[1]." (".$mrow[2].")</a></td></tr>";
      $i = $i+1;
    }
    echo "</tbody></table>";
    return $i;
  }

  function connectDB()
  {
    $db_connection = mysql_connect("localhost","cs143", "");
    mysql_select_db("CS143", $db_connection);
    return $db_connection;
  }

  function search_movie_info($keywords)
  {
    $mq1 = "select id,title,year from Movie where title like '%".$keywords."%'";

    $db_con = new dbConnect();
    $Mresult = $db_con->execute_command($mq1) or die ("<h3>" . mysql_errno() . " : " . mysql_error() . "</h3>");
    $result_q = print_movie_list($db_conn, $Mresult);
    $db_con->close_db();
    return $result_q ? true : false;
  }

  function execute_command()
  {
    $query = trim($_GET["query"]);
    if ($query == '') {
      die("");
    }
    $keywords = preg_split("/\s+/", $query);
    if (isset($_GET['type'])) {
      $type = trim($_GET['type']);
    } else {
      $type = '';
    }
    $gender = "%%";
    $search_movie = true;
    $search_actor = true;
#   for ($i = 0; $i < count($keywords); $i++) {
#     echo "$keywords[$i] <br>";
#   }
    if(strcasecmp($type,"actor")==0){
      $gender = "Male";
      $search_movie = false;
    }else if(strcasecmp($type,"actress")==0){
      $gender = "Female";
      $search_movie = false;
    }else if(strcasecmp($type,"movie")==0){
      $search_actor = false;
    }
    # Crafting the search query as a SQL query

    if ($search_actor && count($keywords) < 3) {
      $search_actor = search_actor_info($keywords, $gender);
    } else {
      $search_actor = false;
    }

    if ($search_movie) {
      $search_movie = search_movie_info($query);
    }

    if (!($search_movie || $search_actor)) {
      echo "Your search did not match any records. <br /><br />" ;
      echo "Suggestions: <br />Make sure all words are spelled correctly. <br />";
      echo "Try different keywords.<br />";
    }
  }

  if (isset($_GET["submit"])) {
     execute_command();
  }
?>

</body>
</html>
