<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>FICS Giriş</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../style/bootstrap.min.css" type="text/css">
    <script src="../style/jquery-3.2.0.min.js.indir"></script>
    <script src="../style/bootstrap.min.js.indir"></script>
    <link rel="stylesheet" href="../style/font-awesome.min.css">
    <link href="../style/css" rel="stylesheet">
    <link rel="stylesheet" href="../style/style.css" type="text/css">
</head>

<body id="login-page">
<div class="form-box">
    <div class="form-logo">
        <p class="text-center"><img draggable="false" src="../images/logo.png" alt="logo"></p>
    </div>
    <form method="post">
        <input type="Email" name='u_email' class="form-control" placeholder="Email">
        <input type="password" name='u_pass' class="form-control" placeholder="Şifre">
        <input type="submit" class="btn btn-social" value="GİRİŞ" name="login">
    </form>
    <a href="forgot_password.php" class="login-action" title="Şifremi unuttum">
        <p>Şifreni mi unuttun?</p>
    </a>
    <a href="signup.php" class="login-action" title="Kayıt ol">
        <p>Kayıt ol</p>
    </a>
    <?php include("login.php"); ?>
</div>
</body></html>