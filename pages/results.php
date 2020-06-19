<!DOCTYPE html>
<?php
session_start();
include("../includes/header.php");
?>
<?php

if(!isset($_SESSION['user_email'])){
	header("location: index.php");
}
else{ ?>
<html>
<head>
	<title>Sonuçlar</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../style/home_style2.css" media="all"/>
</head>
<body>
<div class="row">
	<div class="col-sm-12">
		<center><h2>Sonuçlar</h2></center><br><br>
		<?php results();?>
	</div>
</div>
</body>
</html>
<?php } ?>
