<!DOCTYPE html>
<html>
<head>
    <title>FICS Giriş ve Kayıt</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
    body {
        overflow-x: hidden;
    }

    #signup {
        width: 60%;
        border-radius: 30px;
    }

    #login {
        width: 60%;
        border-radius: 30px;
    }
    .btn-social, .badge, .btn-social, .bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-primary,
    .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-primary,
    ::-webkit-scrollbar-thumb, ::-webkit-scrollbar-thumb:window-inactive {
        background: #000000;
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
</style>
<body style="background-image: url('../images/FICSbackground2.png')">
<div class="row">
    <a href="main.php">
        <div class="col-sm-12">

        </div>
    </a>
</div>
<div class="row">
    <div class="col-sm-6">
    </div>
    <div class="col-sm-6" style="margin-top: 18%">
        <h3><strong>FICS'e katıl.</strong></h3>
        <form method="post" action="">
            <button id="signup" class="btn btn-social" name="signup">KAYIT OL</button>
            <br><br>
            <?php
            if (isset($_POST['signup'])) {
                echo "<script>window.open('signup.php','_self')</script>";
            }
            ?>
            <button id="login" class="btn btn-success" name="login">GİRİŞ YAP</button>
            <br><br>
            <?php
            if (isset($_POST['login'])) {
                echo "<script>window.open('signin.php','_self')</script>";
            }
            ?>
        </form>
    </div>
</div>
</body>
</html>