<?php
parse_str($_SERVER['QUERY_STRING']);
$con=mysqli_connect("localhost","root","","pbuddy");
// Check connection
	if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
	/*else
	{
	echo "conected";
	}*/
	$result = mysqli_query($con, "CALL pb_InsertPhoto('".$id."','".$src."','".$imgid."')");	
	//var_dump($result);
	mysqli_close($con);
?> 