<!DOCTYPE html>
<?php
session_start();
include("../includes/header.php");

if (!isset($_SESSION['user_email'])) {
    header("location: index.php");
}
?>
<style>
    .btn-social:hover, .btn-social:focus, .btn-social:active {
        background: #F3AD00;}
</style>
<html>
<head>
    <?php
    $user = $_SESSION['user_email'];
    $get_user = "select * from users where user_email='$user'";
    $run_user = mysqli_query($con, $get_user);
    $row = mysqli_fetch_array($run_user);
    $user_name = $row['user_name'];
    ?>
    <title><?php echo "$user_name"; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../style/home_style2.css">
</head>
<body style="background-image: url('../images/bg3.png'); background-attachment: fixed ">
<div class="row">
    <div id="insert_post" class="col-sm-12">
        <center>
            <form action="home.php?id=<?php echo $user_id; ?>" method="post" id="f" enctype="multipart/form-data">
                <textarea class="form-control" id="content" rows="4" name="content"
                          placeholder="Sorun nedir?"></textarea><br>
                <label class="btn btn-warning" id="upload_image_button">Resim seç
                    <span class="glyphicon glyphicon-folder-open" aria-hidden="true">
                        <input type="file" name="upload_image" size="60"/>
                </label>
                        <select name="kategori" required="required" style="  position: absolute;top: 50.5%;right: 20%;min-width: 100px;max-width: 100px;border-radius: 4px;transform: translate(-50%, -50%);">
                            <option disabled>Kategori seçin</option>
                            <option>Sosyal</option>
                            <option>Yemek</option>
                            <option>Sanat</option>
                            <option>Oyun</option>
                            <option>Teknoloji</option>
                            <option>Spor</option>
                        </select>
                <button id="btn-post" class="btn btn-social" name="sub">Paylaş</button>
            </form>
            <?php insertPost(); ?>
        </center>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <center><h2><strong>Yeni Gönderiler</strong></h2><br></center>
        <?php echo get_posts(); ?>
    </div>
</div>
</body>
</html>