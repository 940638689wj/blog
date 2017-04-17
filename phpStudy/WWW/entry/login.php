<?php
	$con = mysql_connect('localhost:3307','root','root');
	mysql_select_db("blog", $con);

	$result = mysql_query("SELECT * FROM user");

	// echo mysql_fetch_array($result);

	while($row = mysql_fetch_array($result))
	  {
	  	echo json_encode($row);
	  // echo $row['loginName'] . " " . $row['userName'];
	  }

	mysql_close($con);
?>