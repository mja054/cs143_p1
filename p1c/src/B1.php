<DOCTYPE html>
<html>
<title> CS143 Project 1b </title>
<body>
<h1>Type an SQL query in the following box</h1>

<form action="B1.php" method="GET">
<textarea name="query" rows="8" cols="60"><?php echo $_GET["query"];?></textarea>
<input type = "submit" name = "submit">
</form>

<?php

  function execute_command()
  {
foreach ($_SERVER as $key=>$val ){
echo $key . " = " . $val . "<br />";
}
  }

  if (isset($_GET["submit"])) {
     execute_command();
  }
?>

</body>
</html>
