<?php
session_start();
include "db.php";
if (isset($_POST["f_name"])) {

	$f_name = $_POST["f_name"];
	$l_name = $_POST["l_name"];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];
	$mobile = $_POST['mobile'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$name = "/^[a-zA-Z ]+$/";
	$emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
	$number = "/^[0-9]+$/";

if(empty($f_name) || empty($l_name) || empty($email) || empty($password) || empty($repassword) ||
	empty($mobile) || empty($address1) || empty($address2)){
		
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>PLease Fill all fields..!</b>
			</div>
		";
		exit();
	} else {
		if(!preg_match($name,$f_name)){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>this $f_name is not valid..!</b>
			</div>
		";
		exit();
	}
	if(!preg_match($name,$l_name)){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>this $l_name is not valid..!</b>
			</div>
		";
		exit();
	}
	if(!preg_match($emailValidation,$email)){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>this $email is not valid..!</b>
			</div>
		";
		exit();
	}
	if(strlen($password) < 9 ){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Password is weak</b>
			</div>
		";
		exit();
	}
	if(strlen($repassword) < 9 ){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Password is weak</b>
			</div>
		";
		exit();
	}
	if($password != $repassword){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>password is not same</b>
			</div>
		";
	}
	if(!preg_match($number,$mobile)){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Mobile number $mobile is not valid</b>
			</div>
		";
		exit();
	}
	if(!(strlen($mobile) == 10)){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Mobile number must be 10 digit</b>
			</div>
		";
		exit();
	}
	//existing email address in our database
	$sql = "SELECT TOP 1 user_id FROM user_info WHERE email = ?";
	$params = array($email);
	$check_query = sqlsrv_query($con, $sql, $params);

if ($check_query) {
    $count_email = sqlsrv_has_rows($check_query);
} else {
    die(print_r(sqlsrv_errors(), true));
}
	if($count_email > 0){
		echo "
			<div class='alert alert-danger'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Email Address is already available Try Another email address</b>
			</div>
		";
		exit();
	} else {
		
		// Insert user information into the user_info table
$sql = "INSERT INTO user_info 
( first_name, last_name, email, password, mobile, address1, address2) 
VALUES ( ?, ?, ?, ?, ?, ?, ?)";
$params = array($f_name, $l_name, $email, $password, $mobile, $address1, $address2);

<<<<<<< HEAD
$run_query = sqlsrv_query($con, $sql, $params);
=======
$stmt = sqlsrv_query($con, $sql, $params);
>>>>>>> 1ca2733bcc62c70566e3c977e3420fb2a418fda5

if ($run_query === false) {
die(print_r(sqlsrv_errors(), true));
}

<<<<<<< HEAD
// Retrieve the last inserted user ID and store it in a session variable
$_SESSION["uid"] = sqlsrv_get_field($run_query, 0);
echo $_SESSION["uid"];
=======
// Get the inserted user_id
$sql = "SELECT SCOPE_IDENTITY() AS id";
$stmt = sqlsrv_query($con, $sql);
>>>>>>> 1ca2733bcc62c70566e3c977e3420fb2a418fda5

// Store the first name in a session variable
$_SESSION["name"] = $f_name;

// Update the cart table with the user ID
$ip_add = $_SERVER['REMOTE_ADDR'];

$sql = "UPDATE cart SET user_id = ? WHERE ip_add = ? AND user_id = -1";
$params = array($_SESSION["uid"], $ip_add);

<<<<<<< HEAD
$run_update = sqlsrv_query($con, $sql, $params);

if ($run_update === false) {
die(print_r(sqlsrv_errors(), true));
} 


    echo "register_success";
    echo "<script> location.href='store.php'; </script>";
    exit;
=======
$stmt = sqlsrv_query($con, $sql, $params);
>>>>>>> 1ca2733bcc62c70566e3c977e3420fb2a418fda5


		}
	}
	}
	



?>





















































