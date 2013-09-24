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
	if($task == "getDetails")
	{
	$result = mysqli_query($con, "CALL pb_GetDetails('0','0','0')");	
	 $resultArray = array();
	while ($row = $result->fetch_assoc()) {
       array_push($resultArray,$row);	   
    }
	echo json_encode($resultArray);
	//var_dump($result);	
	}
	else if ($task=="updateRating")
	{
	$result = mysqli_query($con, "CALL pb_UpdateRating('".$pid."','".$rating."')");
	echo $result;
	//var_dump($result);
	}
	else
	{
	$result = mysqli_query($con, "CALL pb_InsertPhoto('".$id."','".$src."','".$imgid."')");
	echo $result;
	//var_dump($result);
	}
	mysqli_close($con);	
?> 