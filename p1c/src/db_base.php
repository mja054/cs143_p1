<?php
class dbConnect {
      var $db_connection;
      function dbConnect()
      {
	  $this->db_connection = mysql_connect("localhost","cs143", "");
	  mysql_select_db("CS143", $this->db_connection);
       }

       function execute_command($command)
       {
	     $rs = mysql_query($command, $this->db_connection);
	     return $rs;
       }

       function get_num_fields($rs)
       {
           return mysql_num_fields($rs);
       }

       function get_field_name($rs, $index)
       {
           return mysql_field_name($rs, $index);
       }

       function get_num_rows($rs)
       {
	   return mysql_num_rows($rs);
       }

       function fetch_row($rs)
       {
           return mysql_fetch_row($rs);
       }

       function close_db()
       {
	    mysql_close($this->db_connection);
       }
}
?>
