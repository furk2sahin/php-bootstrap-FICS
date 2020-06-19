<!DOCTYPE html>
<?php
session_start();
include("../includes/header.php");

if (!isset($_SESSION['user_email'])) {
    header("location: index.php");
}
if($_GET['u_id'] != $user_id){
    header("location: home.php");
}
?>
<html>
<head>
    <?php
    $user = $_SESSION['user_email'];
    $run_user = mysqli_query($con, "select * from users where user_email='$user'");
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
<style>
    .btn-block,.btn-block, .bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-primary,
    .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-primary,
    ::-webkit-scrollbar-thumb, ::-webkit-scrollbar-thumb:window-inactive {
        background: #f3ad00;
    }

    .btn-block {
        height: 35px;
        border: #f3ad00;
    }
    .btn-block { color: #ffffff;}

    .btn-block:hover, .btn-social:focus, .btn-social:active { color: #ffffff;
        background: #e8a500;}

    .btn-block:active:focus { background: #d09400;}
    body{
        overflow-x: hidden;
    }
    #cover-img {
        height: 400px;
        width: 100%;
    }

    #profile-img {
        position: absolute;
        top: 160px;
        left: 40px;
    }

    #update_profile {
        position: relative;
        top: -33px;
        cursor: pointer;
        left: 93px;
        border-radius: 4px;
        background-color: rgba(0, 0, 0, 0.1);
        transform: translate(-50%, -50%);
    }

    #button_profile {
        position: absolute;
        top: 82%;
        left: 50%;
        cursor: pointer;
        transform: translate(-50%, -50%);
    }

    #cover-img{
        height:400px;
        width:100%;
    }
    #update_profile{
        position: absolute;
        top: 150px;
        cursor: pointer;
        left: 93px;
        border-radius: 4px;
        background-color: rgba(0,0,0,0.1);
        transform: translate(-50%, -50%);
    }
    #button_profile{
        position: absolute;
        top: 115%;
        left: 50%;
        cursor: pointer;
        transform: translate(-50%, -50%);
    }
    #own_posts{
        border: 5px solid #e6e6e6;
        padding: 40px 50px;
    }
    #posts_img {
        height:300px;
        width:100%;
    }

</style>
<body style="background-image: url('../images/bg3.png'); background-attachment: fixed">
<div class="row">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8">
        <?php
        echo "
			<div>
				<div><img id='cover-img' class='img-rounded' src='../cover/$user_cover' alt='cover'></div>
				<form action='profile.php?u_id=$user_id' method='post' enctype='multipart/form-data'>

				<ul class='nav pull-left' style='position:absolute;top:10px;left:40px;'>
					<li class='dropdown'>
						<button class='btn btn-social' data-toggle='dropdown'>Arkaplanı değiştir</button>
						<div class='dropdown-menu'>
							<center>
							<p><strong>Arkaplan seç</strong>'e tıkla ve <br> <strong>Güncelle</strong></p>
							<label class='btn btn-info'> Arkaplan seç
							    <input type='file' name='u_cover' size='60' />
							</label><br><br>
							<button name='coverUpdate' class='btn btn-info'>Güncelle</button>
							</center>
						</div>
					</li>
				</ul>

				</form>
			</div>
			<div id='profile-img'>
				<img id='user-img' src='../users/$user_image' alt='Profile' class='img-circle' width='180px' height='185px'>
				<form action='profile.php?u_id=$user_id' method='post' enctype='multipart/form-data'>
				<label id='update_profile'> Resim seç
				<input type='file' name='u_image' size='60' />
				</label>
				<button id='button_profile' name='profileUpdate' class='btn btn-social'>Profili güncelle</button>
				</form>
			</div><br>
			";
        ?>
        <?php
        if (isset($_POST['coverUpdate'])) {
            $u_cover = $_FILES['u_cover']['name'];
            $image_tmp = $_FILES['u_cover']['tmp_name'];
            $random_number = rand(1, 100);

            if ($u_cover == '') {
                echo "<script>alert('Lütfen önce arkaplan resmi seçiniz...')</script>";
                echo "<script>window.open('profile.php?u_id=$user_id' , '_self')</script>";
                exit();
            } else {
                move_uploaded_file($image_tmp, "../cover/$u_cover.$random_number");
                $update = "update users set user_cover='$u_cover.$random_number' where user_ID='$user_id'";
                $run = mysqli_query($con, $update);

                if ($run) {
                    echo "<script>alert('Arkaplan güncellendi')</script>";
                    echo "<script>window.open('profile.php?u_id=$user_id' , '_self')</script>";
                }
            }
        }
        ?>
    </div>

    <?php
    if (isset($_POST['profileUpdate'])) {

        $u_image = $_FILES['u_image']['name'];
        $image_tmp = $_FILES['u_image']['tmp_name'];

        if ($u_image == '') {
            echo "<script>alert('Lütfen önce profil resmi seçiniz...')</script>";
            echo "<script>window.open('profile.php?u_id=$user_id' , '_self')</script>";
            exit();
        } else {
            move_uploaded_file($image_tmp, "../users/$u_image.$user_id");
            $update = "update users set user_image='$u_image.$user_id' where user_id='$user_id'";

            $run = mysqli_query($con, $update);
            if ($run) {
                echo "<script>alert('Profil fotoğrafı güncellendi')</script>";
                echo "<script>window.open('profile.php?u_id=$user_id' , '_self')</script>";
            }
        }

    }
    ?>
    <div class="col-sm-2">
    </div>
</div>
<div class="row">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-2" style="background-color: #F3AD00; border-radius: 25px; margin-right:0.5%; text-align: center;left: 0.9%; word-wrap: break-word;">
        <?php
        $get_rutbe = mysqli_query($con, "select rutbe_adi from rutbe where rutbe_ID='$rutbe_id'");
        $kullanici_rutbesi = mysqli_fetch_array($get_rutbe);
        $rutbe = $kullanici_rutbesi['rutbe_adi'];
        echo "
			<center><h2><strong>Hakkında</strong></h2></center>
			<center><h4><strong>$first_name $last_name</strong></h4></center>
			<p><strong>Rütbe: </strong><i style='color: red; font-weight: bold'>$rutbe</i></p>
			<p><strong><i style='color:grey;'>$describe_user</i></strong></p><br>
			<p><strong>İlişki durumu: </strong> $relationship_status</p><br>
			<p><strong>Yaşadığı yer: </strong> $user_country</p><br>
			<p><strong>Katıldığı tarih: </strong> $register_date</p><br>
			<p><strong>Cinsiyet: </strong> $user_gender</p><br>
			<p><strong>Doğum tarihi: </strong> $user_birthday</p><br>
			<p><strong>Biografi: </strong> $biografi</p><br>
		";
        ?>
    </div>
    <!--Kullanıcı gönderilerini görüntüleme-->
    <div class="col-sm-6">
        <?php
        global $con;
        if (isset($_GET['u_id'])) {
            $u_id = $_GET['u_id'];
        }
        $get_posts = "select * from posts where user_id='$u_id' ORDER by 1 DESC LIMIT 5";
        $run_posts = mysqli_query($con, $get_posts);
        while ($row_posts = mysqli_fetch_array($run_posts)) {
            //Gönderi verilerini çekme
            $post_id = $row_posts['post_ID'];
            $user_id = $row_posts['user_ID'];
            $content = $row_posts['post_content'];
            $upload_image = $row_posts['upload_image'];
            $post_date = $row_posts['post_date'];
            $kategori = $row_posts['kategori_adi'];
            //Gönderi paylaşan kullanıcıyı getirme
            $user = "select * from users where user_id='$user_id' AND posts='yes'";
            $run_user = mysqli_query($con, $user);
            $row_user = mysqli_fetch_array($run_user);
            $first_name = $row_user['first_name'];
            $last_name = $row_user['last_name'];
            $user_image = $row_user['user_image'];
            //Görüntüleme
            if ($content == "No" && strlen($upload_image) >= 1) {
                echo "
                <div id='own_posts'  style='border-radius: 25px; border-color: #bbbbbb'>
                    <div class='row'>
                        <div class='col-sm-2'>
                            <p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
                        </div>
                        <div class='col-sm-6'>
                            <h3><a style='text-decoration: none;cursor: pointer;color: #F3AD00;' href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
                            <h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaştı.</small></h4>
                        </div>
                        <div class='col-sm-4'>
                        <div style=' font-size: 20px; color: black; border-style:dotted; padding: 5px; border-radius: 51px; border-color: white; float: right; background-color: #f3ad00'>$kategori </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <img id='posts-img' src='../postImages/$upload_image' class='img-rounded' style='height:350px; border-radius: 25px'>
                        </div>
                    </div><br>
                    <a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-block'>Görüntüle</button></a>
                    <a href='edit_post.php?post_id=$post_id' style='float:right;'><button  class='btn btn-social'>Düzenle</button></a>
                    <a href='../functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Sil</button></a>
                </div><br/><br/>
                ";
            } else if (strlen($content) >= 1 && strlen($upload_image) >= 1) {
                echo "
                <div id='own_posts'  style='border-radius: 25px; border-color: #bbbbbb'>
                    <div class='row'>
                        <div class='col-sm-2'>
                            <p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
                        </div>
                        <div class='col-sm-6'>
                            <h3><a style='text-decoration: none;cursor: pointer;color: #F3AD00;' href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
                            <h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaştı.</small></h4>
                        </div>
                        <div class='col-sm-4'>
                            <div style=' font-size: 20px; color: black; border-style:dotted; padding: 5px; border-radius: 51px; border-color: white; float: right; background-color: #f3ad00'>$kategori </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-sm-12' style='word-wrap: break-word;'>
                            <p>&#160;&#160;&#160;&#160;&#160;&#160;$content</p>
                            <img id='posts-img' src='../postImages/$upload_image' style='height:350px; border-radius: 25px'>
                        </div>
                    </div><br>
                    <a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-block'>Görüntüle</button></a>
                    <a href='edit_post.php?post_id=$post_id' style='float:right;'><button  class='btn btn-social'>Düzenle</button></a>
                    <a href='../functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Sil</button></a>
                </div><br/><br/>
                ";
            } else {
                echo "
                <div id='own_posts'  style='border-radius: 25px; border-color: #bbbbbb'>
                    <div class='row'>
                        <div class='col-sm-2'>
                            <p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
                        </div>
                        <div class='col-sm-6'>
                            <h3><a style='text-decoration: none;cursor: pointer;color: #F3AD00;' href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
                            <h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaştı.</small></h4>
                        </div>
                        <div class='col-sm-4'>
                        <div style=' font-size: 20px; color: black; border-style:dotted; padding: 5px; border-radius: 51px; border-color: white; float: right; background-color: #f3ad00'>$kategori </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-sm-2'>
                        </div>
                        <div class='col-sm-6' style='word-wrap: break-word;'>
                            <h3><p>$content</p></h3>
                        </div>
                        <div class='col-sm-4'>
                        </div>
                    </div>
                ";
                global $con;
                if (isset($_GET['u_id'])) {
                    $u_id = $_GET['u_id'];
                }
                $get_posts = "select user_email from users where user_id='$u_id'";
                $run_user = mysqli_query($con, $get_posts);
                $row = mysqli_fetch_array($run_user);
                $user_email = $row['user_email'];
                $user = $_SESSION['user_email'];
                $get_user = "select * from users where user_email='$user'";
                $run_user = mysqli_query($con, $get_user);
                $row = mysqli_fetch_array($run_user);
                $user_id = $row['user_ID'];
                $u_email = $row['user_email'];
                if ($u_email != $user_email) {
                    echo "<script>window.open('profile.php?u_id=$user_id','_self')</script>";
                } else {
                    echo "
                    <a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-block'>Görüntüle</button></a>
                    <a href='edit_post.php?post_id=$post_id' style='float:right;'><button  class='btn btn-social'>Düzenle</button></a>
                    <a href='../functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Sil</button></a>
                </div><br/><br/><br/>
                ";
                }
            }
            include("../functions/delete_post.php");
        }
        ?>
    </div>
</div>
<div class="col-sm--2">
</div>
</div>
</body>
</html>