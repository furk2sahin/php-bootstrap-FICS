<!DOCTYPE html>
<html>
<head>
    <title>Şifremi unuttum</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="jquery.js"></script>

</head>
<style>
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
    body {
        overflow-x: hidden;
    }

    .main-content {
        width: 50%;
        height: 40%;
        margin: 10px auto;
        background-color: #fff;
        border: 2px solid #e6e6e6;
        padding: 40px 50px;
    }

    .header {
        border: 0px solid #000;
        margin-bottom: 5px;
    }

    .well {
        background-color: #F3AD00;
    }

    #signup {
        width: 60%;
        border-radius: 30px;
    }
</style>
<body>
<div class="row">
    <div class="col-sm-12">
        <div class="well">
            <center><h1 style="color: white; line-height: 120px;"><strong>FICS</strong></h1></center>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="main-content">
            <div class="header">
                <h3 style="text-align: center;"><strong>Şifremi unuttum</strong></h3>
                <hr>
            </div>
            <div class="l-part">
                <form action="" method="post">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="email" type="text" class="form-control" name="email" placeholder="Mail adresini gir"
                               required="required">
                    </div>
                    <br>
                    <hr>
                    <pre class="text">Güvenlik kodunu gir</pre>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                        <input id="msg" type="text" class="form-control" placeholder="Birisi" name="recovery_account"
                               required="required">
                    </div>
                    <br>
                    <a style="text-decoration:none;float: right; color:#187FAB;" data-toggle="tooltip" title="Signin"
                       href="signin.php">Giriş ekranına dön</a><br><br>
                    <center>
                        <button id="signup" class="btn btn-social" name="submit"><b>GÖNDER</b></button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php
session_start();

include("../includes/connection.php");
if (isset($_POST['submit'])) {
    $email = htmlentities(mysqli_real_escape_string($con, $_POST['email']));
    $recovery_account = htmlentities(mysqli_real_escape_string($con, $_POST['recovery_account']));
    $select_user = "select * from users where user_email='$email' AND recovery_account='$recovery_account'";
    $query = mysqli_query($con, $select_user);
    $check_user = mysqli_num_rows($query);
    if ($check_user == 1) {
        $_SESSION['user_email'] = $email;
        echo "<script>window.open('change_password.php','_self')</script>";
    } else {
        echo "<script>alert('Email veya güvenlik sorusu yanlış')</script>";
        echo "<script>window.open('forgot_password.php','_self')</script>";
    }
}
?>
