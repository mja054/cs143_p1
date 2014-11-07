<DOCTYPE html>
<html>
<title> New Movie Submission </title>
<body>
<h1>Add a new movie here!</h1>

<form action="I2.php" method="GET">
Title<input type="text" name="title" maxlength="20"><br />
Company: <input type="text" name="company" maxlength="50"><br/>
Year : <input type="text" name="year" maxlength="4"><br/>	<!-- Todo: validation-->
MPAA Rating : <select name="mpaarating">
		      <option value="G">G</option>
		      <option value="NC-17">NC-17</option>
		      <option value="PG">PG</option>
		      <option value="PG-13">PG-13</option>
		      <option value="R">R</option>
		      <option value="surrendere">surrendere</option>
		</select><br/>
Genre :<br />
<input type="checkbox" name="moviegenre[]" value="Action">Action</input>
<input type="checkbox" name="moviegenre[]" value="Adult">Adult</input>
<input type="checkbox" name="moviegenre[]" value="Adventure">Adventure</input>
<input type="checkbox" name="moviegenre[]" value="Animation">Animation</input>
<br />
<input type="checkbox" name="moviegenre[]" value="Comedy">Comedy</input>
<input type="checkbox" name="moviegenre[]" value="Crime">Crime</input>
<input type="checkbox" name="moviegenre[]" value="Documentary">Documentary</input>
<input type="checkbox" name="moviegenre[]" value="Drama">Drama</input>
<br />
<input type="checkbox" name="moviegenre[]" value="Family">Family</input>
<input type="checkbox" name="moviegenre[]" value="Fantasy">Fantasy</input>
<input type="checkbox" name="moviegenre[]" value="Horror">Horror</input>
<input type="checkbox" name="moviegenre[]" value="Musical">Musical</input>
<br />
<input type="checkbox" name="moviegenre[]" value="Mystery">Mystery</input>
<input type="checkbox" name="moviegenre[]" value="Romance">Romance</input>
<input type="checkbox" name="moviegenre[]" value="Sci-Fi">Sci-Fi</input>
<input type="checkbox" name="moviegenre[]" value="Short">Short</input>
<br />
<input type="checkbox" name="moviegenre[]" value="Thriller">Thriller</input>
<input type="checkbox" name="moviegenre[]" value="War">War</input>
<input type="checkbox" name="moviegenre[]" value="Western">Western</input>
<br/>
<input type = "submit" name = "submit">
</form>

<?php
  include "db_base.php";

  class add_movie {
    var $title;
    var $company;
    var $year;
    var $mpaa_rating;
    var $movieGenre;

    function add_movie()
    {
	$this->title = '';
	$this->company = '';
	$this->year = '';
	$this->mpaa_rating = '';
	$this->movieGenre = '';
    }

    function parse_input()
    {
	$this->title = $_GET["title"];
	$this->company = $_GET["company"];
	$this->year = (int)$_GET["year"];
	$this->mpaa_rating = $_GET["mpaarating"];
	$this->movieGenre = $_GET["moviegenre"];
    }

    function debug_input()
    {
	echo "title: $this->title <br />";
	echo "company: $this->company <br />";
	echo "year: $this->year <br />";
	echo "mpaarating: $this->mpaa_rating <br />";
	echo "movieGenre: <br />";
	$movieGenre = $this->movieGenre;
	for($i=0; $i < count($this->movieGenre); $i++)
	{
	    echo "$movieGenre[$i] <br /> ";
	}
    }

    function validate()
    {
	if (empty($this->title)) {
	    die("Movie title cannot be empty.");
	} else if (empty($this->company)) {
	    die("Movie company cannot be empty.");
	} else if (empty($this->year) ||
		   !(($this->year > 1700) && ($this->year <= (int)date("Y")))) {
	    die("Movie year cannot be empty or is invalid.");
	} else if (count($this->movieGenre) == 0) {
	    die("Please select atleast one genre for the movie.");
	}
    }

    function parse_and_validate()
    {
	$this->parse_input();
	$this->validate();
    }

    function execute_command()
    {
	$db_con = new dbConnect();

	# Obtaining the current max ID
	$newIDquery = "SELECT id FROM MaxMovieID";
	$queryMaxID = $db_con->execute_command($newIDquery);
	while ($row = $db_con->fetch_row($queryMaxID)) {
	  $newID = $row[0];
	}

	# Updating the max ID
	$updateMaxIDquery = "UPDATE MaxMovieID SET id=id+1";
	$updateMaxID = $db_con->execute_command($updateMaxIDquery);

	$insert_query = "INSERT INTO Movie VALUES($newID, '$this->title',
			  '$this->year', '$this->mpaa_rating',
			  '$this->company')";
	
	$insertDB = $db_con->execute_command($insert_query);
	if (!$insertDB) {
	  $error = mysql_error();
	  $updateMaxIDquery = "UPDATE MaxMovieID SET id=id-1";
	  $updateMaxID = $db_con->execute_command($updateMaxIDquery);
	  die("Invalid query: $error");
	}

	$movieGenre = $this->movieGenre;
	for($i = 0; $i < count($movieGenre); $i++) {
	  $genre = $movieGenre[$i];
	  $insert_query = "INSERT INTO MovieGenre VALUES($newID, '$genre')";
	  $db_con->execute_command($insert_query);
	}
	print "Successfully inserted $newID $this->title $this->company into the movie database!";
        $db_con->close_db();
    }
  }

  if (isset($_GET["submit"])) {
     $movieObj = new add_movie();
     $movieObj->parse_and_validate();
//   $movieObj->debug_input();
     $movieObj->execute_command();
  }
?>

</body>
</html>
