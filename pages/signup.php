<!DOCTYPE html>
<html>
<head>
	<title>Kayıt Ol</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
    .form-box input[type="submit"] {
        width: 100%;
    }
    .form-box textarea {
        width: 100%;
        color: black;
    }
    .form-box {

        width: 30%;
        height: auto;
        padding: 15px;
        color: #ffffff;
        position: relative;
        margin: auto;
        background: rgba(0, 0, 0, 0.75);
    }
    .btn-social, .badge, .btn-social, .bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-primary,
    .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-primary,
    ::-webkit-scrollbar-thumb, ::-webkit-scrollbar-thumb:window-inactive {
        background: #f3ad00;
    }

    .btn-social {
        border: #f3ad00;
    }
    .btn-social { color: #ffffff;}

    .btn-social:hover, .btn-social:focus, .btn-social:active { color: #ffffff;
        background: #e8a500;}

    .btn-social:active:focus { background: #d09400;}
	body{
		overflow-x: hidden;
	}
	.main-content{
		width: 50%;
		height: 40%;
		margin: 10px auto;
		background-color: #fff;
		border: 2px solid #e6e6e6;
		padding: 40px 50px;
	}
	.header{
		border: 0px solid #000;
		margin-bottom: 5px;
	}
	.well{
		background-color: #187FAB;
	}
	#signup{
		width: 60%;
		border-radius: 30px;
	}
    body{
        background-image: url("../images/istanbul2.png");
        width: 100%;
    }
    .login-action, .login-action:link, .login-action:focus, .login-action:visited {
        color: #ffffff;
        font-size: 12px;
    }
</style>
<body>

<div class="row">
	<div class="col-sm-12" style="margin-top: 3%;">
		<div class="form-box">
			<div class="header">
				<img draggable="false" src="../images/logo2.png" style="width: 600px; height: 100px; margin-left: -35px">
				<hr>
			</div>
			<div class="l-part">
				<form action="" method="post">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
						<input type="text" class="form-control" placeholder="Ad" name="first_name" required="required">
					</div><br>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
						<input type="text" class="form-control" placeholder="Soyad" name="last_name" required="required">
					</div><br>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input id="password" type="password" class="form-control" placeholder="Şifre(en az 8 uzunlukta)" name="u_pass" required="required" autocomplete="off">
					</div><br>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input id="email" type="email" class="form-control" placeholder="Email" name="u_email" required="required">
					</div><br>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-chevron-down"></i></span>
						<select class="form-control" name="u_country" required="required">
							<option disabled>Ülkenizi seçiniz</option>
							<option>Turkiye</option>
							<option>ABD</option>
							<option>Hindistan</option>
							<option>Azerbeycan</option>
							<option>İngiltere</option>
							<option>Fransa</option>
                            <option>Almanya</option>
                            <option>Rusya</option>
						</select>
					</div><br>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-chevron-down"></i></span>
						<select class="form-control input-md" name="u_gender" required="required">
							<option disabled>Cinsiyet</option>
							<option>Kadın</option>
							<option>Erkek</option>
							<option>Diğer</option>
						</select>
					</div><br>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						<input type="date" class="form-control input-md" name="u_birthday" required="required">
					</div><br>
                    <center><textarea style="resize: none;" name="bio"  placeholder="Kendinizden bahsedin..." required="required"></textarea></center>
                    <center><br><button id="signup" class="btn btn-social" name="sign_up">Kayıt ol</button></center><br>
                    <center><a class="login-action" data-toggle="tooltip" title="Signin" href="signin.php">Zaten bir hesabın var mı?</a><br><br></center>
					<?php include("insert_user.php"); ?>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>