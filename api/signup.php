<?php 
include 'db_connect.php';
date_default_timezone_set("Asia/Kolkata");
$date=date("Y-m-d H:i:s");
$first_name = $_REQUEST['fname'];
$last_name = $_REQUEST['lname'];
$usr_email= $_REQUEST['email'];
$usr_pwd  = $_REQUEST['password'];
$usr_mobile  = $_REQUEST['mobile'];
$address1  = $_REQUEST['address1'];
$address2  = $_REQUEST['address2'];
$city = $_REQUEST['city'];
$state = $_REQUEST['state'];
$pin = $_REQUEST['pin'];
$country = $_REQUEST['country_id'];
$security_ques = $_REQUEST['security_ques_id'];
$security_ans = $_REQUEST['security_ans'];
$image_string = $_REQUEST['img'];
$uuid_image = $_REQUEST['uuid_image'];
$salt = substr(md5(uniqid(rand(), TRUE)), 0, 9);
$password=sha1($salt . sha1($salt . sha1($usr_pwd)));
$query=mysqli_query($conn,"SELECT * FROM `ti_customers` WHERE `email`='$usr_email'");
if(mysqli_num_rows($query)==0){
$query_first="INSERT INTO `ti_customers`(`first_name`,`last_name`,`email`,`salt`,`password`,`telephone`,`date_added`,`security_question_id`,`security_answer`,`status`) VALUES('$first_name','$last_name','$usr_email','$salt','$password','$usr_mobile','$date','$security_ques','$security_ans','1')";
$row1=mysqli_query($conn,$query_first);
    if($row1==1){
        $response['customer']="Success";
     $last_id1 = mysqli_insert_id($conn);
       
        $query_second="INSERT INTO `ti_addresses`(`customer_id`,`address_1`,`address_2`,`city`,`state`,`postcode`,`country_id`) VALUES('$last_id1','$address1','$address2','$city','$state','$pin','$country')";
        $row2=mysqli_query($conn,$query_second);
        if($image_string!="" && $uuid_image!=""){
        $path = "../images/customers/".$last_id1.".png";
        $sql = "INSERT INTO `ti_customers_image`(`customer_id`,`image_string`,`uuid_image`) VALUES('$last_id1','$path','$uuid_image')";
        if(mysqli_query($conn,$sql)){
			file_put_contents($path,base64_decode($image_string));
		}
	}
        if($row2==1){
        $response['address']="Success";
        $last_id2 = mysqli_insert_id($conn);
        $query_third="UPDATE `ti_customers` SET `address_id`='$last_id2' WHERE `email`='$usr_email'";
        $row3=mysqli_query($conn,$query_third);
            if($row3==1){
                $response['final']="Success";
            } else{
                $response['final']="Failed";
            }
        }else{
    $response['address']="Failed";
}
    }else{
    $response['customer']="Failed";
}
} 
else {
$response['customer']="Failed";
$response['address']="Failed";
$response['final']="Already Registered";
}

echo json_encode($response);
mysqli_close($conn);
?>