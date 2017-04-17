<?php
	$con = mysql_connect('localhost:3307','root','root');
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }

	mysql_select_db("blog", $con);

	$result = mysql_query("SELECT * FROM user");

	while($row = mysql_fetch_array($result))
	  {
	  echo $row['loginName'] . " " . $row['userName'];
	  echo "<br />";
	  }

	mysql_close($con);
?>