<?php
class dbConnect {
      var $db_connection;
      function dbConnect()
      {
	  $this->db_connection = mysql_connect("localhost","cs143", "");
	  mysql_select_db("CS143", $this->db_connection);
	  return $db_connection;
       }

       function execute_command($command)
       {
	     $rs = mysql_query($command, $this->db_connection);
	     if (!$rs) {
		   die('<h4>Invalid query: ' . mysql_error() . '</h4>');
	     }
	     return $rs;
       }

       function close_db()
       {
	    mysql_close($this->db_connection);
       }

}
?>