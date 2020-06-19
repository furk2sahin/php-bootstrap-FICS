<!DOCTYPE html>
<?php
session_start();
include("../includes/header.php");
?>

<?php

if (!isset($_SESSION['user_email'])){
    header("location: index.php");
}
else{ ?>
<html>
<head>
    <title>FICS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../style/home_style2.css" media="all"/>
</head>
<style>
    #own_posts {
        border: 5px solid #e6e6e6;
        padding: 40px 50px;
        width: 90%;
    }

    #posts_img {
        height: 300px;
        width: 100%;
    }
</style>
<body>
<div class="row">
    <?php
    global $con;
    if (isset($_GET['u_id'])) {
        $u_id = $_GET['u_id'];
    }
    if ($u_id < 0 or $u_id == ""){
        echo "<script>window.open('home.php','_self')</script>";
    }else{
    ?>
    <div class="col-sm-12">
        <?php
        if (isset($_GET['u_id'])) {
            global $con;
            $user_id = $_GET['u_id'];
            $select = "select * from users where user_id='$user_id'";
            $run = mysqli_query($con, $select);
            $row = mysqli_fetch_array($run);
            $name = $row['user_name'];
        }
        ?>
        <?php
        if (isset($_GET['u_id'])) {
            // Görüntülenen profil
            global $con;
            $user_id = $_GET['u_id'];
            $select = "select * from users where user_id='$user_id'";
            $run = mysqli_query($con, $select);
            $row = mysqli_fetch_array($run);
            $id = $row['user_ID'];
            $image = $row['user_image'];
            $name = $row['user_name'];
            $ff_name = $row['first_name'];
            $ll_name = $row['last_name'];
            $describe_user = $row['describe_user'];
            $country = $row['user_country'];
            $gender = $row['user_gender'];
            $register_date = $row['user_reg_date'];
            $biografi = $row['user_biografi'];
            $rutbe_id = $row['rutbe_ID'];

            // Görüntüleyen kişi
            $user = $_SESSION['user_email'];
            $get_user = "select * from users where user_email='$user'";
            $run_user = mysqli_query($con, $get_user);
            $row = mysqli_fetch_array($run_user);
            $userown_id = $row['user_ID'];
            $user_name = $row['user_name'];
            $f_name = $row['first_name'];
            $l_name = $row['last_name'];
            $user_image = $row['user_image'];

            //rutbe ayarla
            $get_rutbe = mysqli_query($con, "select rutbe_adi from rutbe where rutbe_ID='$rutbe_id'");
            $kullanici_rutbesi = mysqli_fetch_array($get_rutbe);
            $rutbe = $kullanici_rutbesi['rutbe_adi'];
            $get_yildiz = mysqli_query($con, "select count(*) as toplam from yildizlar where yildiz_alan_ID = '$user_id'");
            $kullanici_yildiz_sayisi = mysqli_fetch_assoc($get_yildiz);
            $sayi = $kullanici_yildiz_sayisi['toplam'];
            echo "
				<div class='row'>
					<div class='col-sm-1'>
					</div>
					<center>
					<div style='background-color: #e6e6e6; margin-top: 3.7%' class='col-sm-3'>
					<h2>Hakkında</h2>
					<img class='img-circle' src='../users/$image' width='150' height='150' />
					<br><br>
					<ul class='list-group'>
					  <li class='list-group-item' title='Kullanıcı adı' style='word-wrap: break-word'><strong>$ff_name $ll_name</strong></li>
					  <li class='list-group-item' title='Kullanici rütbesi' style='word-wrap: break-word'><i style='color: red; font-weight: bold'>$rutbe</i></li>
					  <li class='list-group-item' title='Durum' style='word-wrap: break-word'><strong style='color:grey;'>$describe_user</strong></li>
					  <li class='list-group-item' title='Cinsiyet' style='word-wrap: break-word'>$gender</li>
					  <li class='list-group-item' title='Ülke' style='word-wrap: break-word'>$user_country</li>
					  <li class='list-group-item' title='Katildığı tarih' style='word-wrap: break-word'>$register_date</li>
					  <li class='list-group-item' title='Kullanıcı Biografisi' style='word-wrap: break-word'>$biografi</li>
					</ul>
					
            ";
            if ($user_id == $userown_id) {
                echo "$sayi<i style='font-size:24px; color:black;' class='fa fa-star-o'></i><br><br>";
                echo "<a href='edit_profile.php?u_id=$userown_id' class='btn btn-success'/>Profili düzenle</a><br><br>";
            }
            $kontrol_yildiz = mysqli_query($con, "select * from yildizlar where yildiz_atan_ID = '$userown_id' AND yildiz_alan_ID = '$id'");
            $yildiz = mysqli_num_rows($kontrol_yildiz);
            $get_yildiz = mysqli_query($con, "select count(*) as toplam from yildizlar where yildiz_alan_ID = '$user_id'");
            $kullanici_yildiz_sayisi = mysqli_fetch_assoc($get_yildiz);
            $sayi = $kullanici_yildiz_sayisi['toplam'];
            if ($user_id != $userown_id) {
                if ($yildiz == 0)
                    echo "<form method='post'>
                        $sayi<button name='send_yildiz' style='font-size:24px; text-decoration: none; border: none; background-color:#e6e6e6;' class='fa fa-star-o'></button><br><br><br>
                        </form>";
                else
                    echo "<form method='post'>
                        $sayi<button name='send_yildiz' style='font-size:24px; color:gold; text-decoration: none; border: none; background-color:#e6e6e6;' class='fa fa-star'></button><br><br><br>
                        </form>";
            }
            if(isset($_POST['send_yildiz'])){
                if($yildiz==0){
                    mysqli_query($con, "insert into yildizlar (yildiz_atan_ID, yildiz_alan_ID) values ('$userown_id', '$id')");
                    $get_yildiz = mysqli_query($con, "select count(*) as toplam from yildizlar where yildiz_alan_ID = '$user_id'");
                    $kullanici_yildiz_sayisi = mysqli_fetch_assoc($get_yildiz);
                    $sayi = $kullanici_yildiz_sayisi['toplam'];
                    echo "$rutbe_id";
                    if($rutbe_id != 11 && $rutbe_id != 10){
                        if($sayi < 5)
                            mysqli_query($con, "update users set rutbe_ID = 1 where user_ID = '$user_id'");
                        else if($sayi >= 5 && $sayi <10)
                            mysqli_query($con, "update users set rutbe_ID = 2 where user_ID = '$user_id'");
                        else if($sayi >= 10 && $sayi <15)
                            mysqli_query($con, "update users set rutbe_ID = 3 where user_ID = '$user_id'");
                        else if($sayi >= 15 && $sayi <20)
                            mysqli_query($con, "update users set rutbe_ID = 4 where user_ID = '$user_id'");
                        else if($sayi >= 20 && $sayi <25)
                            mysqli_query($con, "update users set rutbe_ID = 5 where user_ID = '$user_id'");
                        else if($sayi >= 25 && $sayi <30)
                            mysqli_query($con, "update users set rutbe_ID = 6 where user_ID = '$user_id'");
                        else if($sayi >= 35 && $sayi <40)
                            mysqli_query($con, "update users set rutbe_ID = 7 where user_ID = '$user_id'");
                        else if($sayi >= 40 && $sayi <45)
                            mysqli_query($con, "update users set rutbe_ID = 8 where user_ID = '$user_id'");
                        else if($sayi >= 45)
                            mysqli_query($con, "update users set rutbe_ID = 9 where user_ID = '$user_id'");
                    }
                    header('location:yildizVer.php?u_id='.$id);
                }else{
                    mysqli_query($con, "delete from yildizlar where yildiz_atan_ID = '$userown_id' AND yildiz_alan_ID = '$id'");
                    $get_yildiz = mysqli_query($con, "select count(*) as toplam from yildizlar where yildiz_alan_ID = '$user_id'");
                    $kullanici_yildiz_sayisi = mysqli_fetch_assoc($get_yildiz);
                    $sayi = $kullanici_yildiz_sayisi['toplam'];
                    echo "$rutbe_id";
                    if($rutbe_id != 11 && $rutbe_id != 10){
                        if($sayi < 5)
                            mysqli_query($con, "update users set rutbe_ID = 1 where user_ID = '$user_id'");
                        else if($sayi >= 5 && $sayi <10)
                            mysqli_query($con, "update users set rutbe_ID = 2 where user_ID = '$user_id'");
                        else if($sayi >= 10 && $sayi <15)
                            mysqli_query($con, "update users set rutbe_ID = 3 where user_ID = '$user_id'");
                        else if($sayi >= 15 && $sayi <20)
                            mysqli_query($con, "update users set rutbe_ID = 4 where user_ID = '$user_id'");
                        else if($sayi >= 20 && $sayi <25)
                            mysqli_query($con, "update users set rutbe_ID = 5 where user_ID = '$user_id'");
                        else if($sayi >= 25 && $sayi <30)
                            mysqli_query($con, "update users set rutbe_ID = 6 where user_ID = '$user_id'");
                        else if($sayi >= 35 && $sayi <40)
                            mysqli_query($con, "update users set rutbe_ID = 7 where user_ID = '$user_id'");
                        else if($sayi >= 40 && $sayi <45)
                            mysqli_query($con, "update users set rutbe_ID = 8 where user_ID = '$user_id'");
                        else if($sayi >= 45)
                            mysqli_query($con, "update users set rutbe_ID = 9 where user_ID = '$user_id'");
                    }
                    header('location:yildizVer.php?u_id='.$id);
                }
            }
        }
            echo "
					</div>
					</center>
					";
        }
        ?>
        <div class='col-sm-8'>
            <center><h1><strong><?php echo "$ff_name $ll_name"; ?></strong> Gönderileri</h1></center>
            <?php
            global $con;
            if (isset($_GET['u_id'])) {
                $u_id = $_GET['u_id'];
            }
            $get_posts = "select * from posts where user_ID='$u_id' ORDER by 1 DESC LIMIT 5";
            $run_posts = mysqli_query($con, $get_posts);
            while ($row_posts = mysqli_fetch_array($run_posts)) {
                $post_id = $row_posts['post_ID'];
                $user_id = $row_posts['user_ID'];
                $content = $row_posts['post_content'];
                $upload_image = $row_posts['upload_image'];
                $post_date = $row_posts['post_date'];
                $kategori = $row_posts['kategori_adi'];
                //getting the user who has posted the thread
                $user = "select * from users where user_id='$user_id' AND posts='yes'";
                $run_user = mysqli_query($con, $user);
                $row_user = mysqli_fetch_array($run_user);
                $user_name = $row_user['user_name'];
                $f_name = $row['first_name'];
                $l_name = $row['last_name'];
                $user_image = $row_user['user_image'];

                $get_begeni = mysqli_query($con, "select count(*) as toplam from postlike where post_ID = '$post_id'");
                $kullanici_begeni_sayisi = mysqli_fetch_assoc($get_begeni);
                $begeniler = $kullanici_begeni_sayisi['toplam'];

                $kontrol_begenme = mysqli_query($con, "select * from postlike where post_ID = '$post_id' AND user_ID = '$userown_id'");
                $begenme = mysqli_num_rows($kontrol_begenme);

                //now displaying all at once
                if ($content == "No" && strlen($upload_image) >= 1) {
                    echo "
				<div id='own_posts'>
					<div class='row'>
						<div class='col-sm-2'>
							<p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
						</div>
						<div class='col-sm-6'>
							<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$ff_name $ll_name</a></h3>
							<h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaşıldı.</small></h4>
						</div>
						<div class='col-sm-4'>
						<div style=' font-size: 20px; color: black; border-style:dotted; padding: 5px; border-radius: 51px; border-color: white; float: right; background-color: #f3ad00'>$kategori </div>

						</div>
					</div>
					<div class='row'>
					    <div class='col-sm-1'></div>
						<div class='col-sm-10'>
							<img id='posts-img' src='../postImages/$upload_image' style='height:350px; border-radius: 25px'>
						</div>
						<div class='col-sm-1'></div>
					</div><br>
					<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-success'>Yorum</button></a>";
            if($begenme == 0){
                echo"
                <form method='post'>
				    <i style='float:right; text-decoration: none'><button name = 'begeni' class='btn btn-block'  style='background-color:#29B6F6; color: black'>$begeniler <i class='fa fa-thumbs-up'></i> Beğen</button></i><br>
			        <input name = 'pid' type='text' value='$post_id' hidden>
			        <input type='text' name = 'bid' value='$begenme' hidden>
			    </form>";
            }else{
                echo"
                <form method='post'>
				    <i style='float:right; text-decoration: none'><button name = 'begeni' class='btn btn-block'  style='background-color:#EF9A9A; color: black'>$begeniler <i class='fa fa-thumbs-down'></i> Beğenmekten vazgeç</button></i><br>
			    <input type='text' name = 'pid' value='$post_id' hidden>
			         <input type='text' name = 'bid' value='$begenme' hidden>
			    </form>";
            }
            echo"
					
				</div><br/><br/>
				";
                } else if (strlen($content) >= 1 && strlen($upload_image) >= 1) {
                    echo "
				<div id='own_posts'>
					<div class='row'>
						<div class='col-sm-2'>
							<p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
						</div>
						<div class='col-sm-6'>
							<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$ff_name $ll_name</a></h3>
							<h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaşıldı.</small></h4>
						</div>
						<div class='col-sm-4'>
						<div style=' font-size: 20px; color: black; border-style:dotted; padding: 5px; border-radius: 51px; border-color: white; float: right; background-color: #f3ad00'>$kategori </div>
						</div>
					</div>
					<div class='row'>
					<div class='col-sm-1'></div>
						<div class='col-sm-10'>
							<p>$content</p>
							<img id='posts-img' src='../postImages/$upload_image' style='height:350px; border-radius: 25px'>
						</div>
						<div class='col-sm-1'></div>
					</div><br>
					<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Yorum</button></a>";
            if($begenme == 0){
                echo"
                <form method='post'>
				    <i style='float:right; text-decoration: none'><button name = 'begeni' class='btn btn-block'  style='background-color:#29B6F6; color: black'>$begeniler <i class='fa fa-thumbs-up'></i> Beğen</button></i><br>
			        <input name = 'pid' type='text' value='$post_id' hidden>
			        <input type='text' name = 'bid' value='$begenme' hidden>
			    </form>";
            }else{
                echo"
                <form method='post'>
				    <i style='float:right; text-decoration: none'><button name = 'begeni' class='btn btn-block'  style='background-color:	#EF9A9A; color: black'>$begeniler <i class='fa fa-thumbs-down'></i> Beğenmekten vazgeç</button></i><br>
			    <input type='text' name = 'pid' value='$post_id' hidden>
			         <input type='text' name = 'bid' value='$begenme' hidden>
			    </form>";
            }
            echo"
				</div><br/><br/>
				";
                } else {
                    echo "
				<div id='own_posts'>
					<div class='row'>
						<div class='col-sm-2'>
							<p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
						</div>
						<div class='col-sm-6'>
							<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$ff_name $ll_name</a></h3>
							<h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaşıldı.</small></h4>
						</div>
						<div class='col-sm-4'>
						<div style=' font-size: 20px; color: black; border-style:dotted; padding: 5px; border-radius: 51px; border-color: white; float: right; background-color: #f3ad00'>$kategori </div>
						</div>
					</div>
					<div class='row'>
					<div class='col-sm-1'></div>
						<div class='col-sm-10'>
							<h3><p>$content...</p></h3><br>
						</div>
						<div class='col-sm-1'></div>
					</div><br>
					<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Yorum</button></a>";
            if($begenme == 0){
                echo"
                <form method='post'>
				    <i style='float:right; text-decoration: none'><button name = 'begeni' class='btn btn-block'  style='background-color:#29B6F6; color: black'>$begeniler <i class='fa fa-thumbs-up'></i> Beğen</button></i><br>
			        <input name = 'pid' type='text' value='$post_id' hidden>
			        <input type='text' name = 'bid' value='$begenme' hidden>
			    </form>";
            }else{
                echo"
                <form method='post'>
				    <i style='float:right; text-decoration: none'><button name = 'begeni' class='btn btn-block'  style='background-color:#EF9A9A; color: black'>$begeniler <i class='fa fa-thumbs-down'></i> Beğenmekten vazgeç</button></i><br>
			    <input type='text' name = 'pid' value='$post_id' hidden>
			         <input type='text' name = 'bid' value='$begenme' hidden>
			    </form>";
            }
            echo"
				</div><br><br>
				";
                }
            }
            if(isset($_POST['begeni'])){
                $bid = intval(htmlentities($_POST['bid']));
                echo "$bid";
                if($bid == 0){
                    $postid = intval(htmlentities($_POST['pid']));
                    mysqli_query($con, "insert into postlike (post_ID, user_ID) values ('$postid', '$userown_id')");
                    header("location:begeniUserProfile.php?u_id=".$u_id);
                }else{
                    $postid = intval(htmlentities($_POST['pid']));
                    mysqli_query($con, "delete from postlike where user_ID = '$userown_id' AND post_ID = '$postid'");
                    header("location:begeniUserProfile.php?u_id=".$u_id);
                }
            }
            ?>
        </div>
    </div>
</div>
<?php }
?>
</body>
</html>

