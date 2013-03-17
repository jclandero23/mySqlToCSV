mySqlToCSV
==========

Class to convert a mySQL query to a CSV File on PHP

Example:

	<?php
		require 'mySqlToCsv.php';
		
		$host = '127.0.0.1';
		$port = '3306';
		$server = $host . ':' . $port;
		$user = 'root';
		$password = 'root';
		$database = 'DB_NAME';
		
		$link = mysql_connect ($server, $user, $password);
		if (!$link)
		  die('Error: Could not connect: ' . mysql_error());
		
		mysql_select_db($database);
		$query = 'select * from TABLE_NAME';
		$result = mysql_query($query);
		
			//Output As String
			echo sqlToCsv::toStr($result, "<br />");
			/* Output:
			"Column1","Column2","Column3"<br />
			"dataA3","dataA2","dataA3"<br />
			"dataB3","dataB2","dataB3"<br />
			"dataC3","dataC2","dataC3"
			*/
		
			//Output As File
			echo sqlToCsv::toFile($result, "example_CSV_from_PHP");
			
			//Output changing file extension, encoding and newline character
			//echo sqlToCsv::toFile($result, "example_CSV_from_PHP", "txt", "UTF-8", "\n");
		
		mysql_close ($link);
	?>
