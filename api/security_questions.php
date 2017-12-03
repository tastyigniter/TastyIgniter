<?php
include("db_connect.php");
$category_data = array();
$response = array();
$sqlquery=mysqli_query($conn,"SELECT question_id,text FROM  `ti_security_questions`;");
while($row=mysqli_fetch_array($sqlquery))
	{
		$category_data['question_id']=$row['question_id'];
		$category_data['question']=$row['text'];
	    array_push($response, $category_data );
			
	}
	echo json_encode($response);
?>