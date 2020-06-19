<?php
session_start();

include("../includes/connection.php");
	if (isset($_POST['login'])) {
		$email = htmlentities(mysqli_real_escape_string($con, $_POST['u_email']));
		$pass = htmlentities(mysqli_real_escape_string($con, $_POST['u_pass']));
		$query = mysqli_query($con, "select * from users where user_email='$email' AND user_password='$pass' AND status='verified'");
		$check_user = mysqli_num_rows($query);
		if($check_user == 1){
			$_SESSION['user_email'] = $email;
			echo "<script>window.open('home.php', '_self')</script>";
		}else{
			echo"<script>alert('Email veya şifre yanlış!')</script>";
		}
	}
?>