<?php
$servername="localhost";
$username="root";
$password="";
$database="u1701227_tastyigniter";
$conn= new mysqli($servername,$username,$password,$database);
if($conn->connect_error)
{

	die("Connection Failed".$conn->connect_error);
}
else
{
	//echo "Sucessfully database connected...";
}
?>