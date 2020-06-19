<style>
    .btn-social:hover, .btn-social:focus, .btn-social:active {
        background: #F3AD00;}
    img{
        transition-duration: 500ms;
    }
    img:hover{
        filter: blur(1px);
        transition-duration: 500ms;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php

$con = mysqli_connect("localhost", "root", "", "db_fics") or die("Bağlantı kurulamadı");

//Gönderi paylaşma fonksiyonu
function insertPost()
{
    if (isset($_POST['sub'])) {
        $get_post_id = 0;
        global $con;
        global $user_id;
        $content = addslashes(htmlentities($_POST['content']));
        $upload_image = $_FILES['upload_image']['name'];
        echo "<script>alert($content)</script>";
        $image_tmp = $_FILES['upload_image']['tmp_name'];
        $kategori = htmlentities(mysqli_real_escape_string($con, $_POST['kategori']));
        $get_posts = mysqli_query($con, "select post_ID from posts");

        while ($posts_array = mysqli_fetch_array($get_posts)) {
            $get_post_id = $posts_array['post_ID'];
        }
        $get_post_id++;
        if (strlen($content) > 500) {
            echo "<script>alert('500 veya daha az karakter kullanın')</script>";
            echo "<script>window.open('home.php','_self')</script>";
        } else {
            if (strlen($upload_image) >= 1 && strlen($content) >= 1) {
                $insert = "insert into posts (user_ID, kategori_adi, post_content,upload_image,post_date) values ('$user_id','$kategori','$content','$upload_image.$get_post_id',NOW())";
                move_uploaded_file($image_tmp, "../postImages/$upload_image.$get_post_id");
                $run = mysqli_query($con, $insert);
                if ($run) {
                    echo "<script>alert('Gönderiniz başarıyla paylaşıldı')</script>";
                    echo "<script>window.open('home.php','_self')</script>";
                    $update = "update users set posts='yes' where user_id='$user_id'";
                    mysqli_query($con, $update);
                }
                exit();
            } else {
                if ($upload_image == '' && $content == '') {
                    echo "<script>alert('Bir sorunla karşılaştık!')</script>";
                    echo "<script>window.open('home.php','_self')</script>";
                } else {
                    if ($content == '') {
                        move_uploaded_file($image_tmp, "../postImages/$upload_image.$get_post_id");
                        $insert = "insert into posts (user_ID,kategori_adi, post_content,upload_image,post_date) values ('$user_id','$kategori','No','$upload_image.$get_post_id',NOW())";
                        $run = mysqli_query($con, $insert);
                        if ($run) {
                            echo "<script>alert('Gönderiniz başarıyla paylaşıldı.')</script>";
                            echo "<script>window.open('home.php','_self')</script>";
                            $update = "update users set posts='yes' where user_id='$user_id'";
                            mysqli_query($con, $update);
                        }
                        exit();
                    } else {
                        $control_content = preg_replace('/\s+/', '', $content);
                        if ($control_content == '') {
                            echo "<script>alert('Bir sorunla karşılaştık!')</script>";
                            echo "<script>window.open('home.php','_self')</script>";
                        } else {
                            $insert = "insert into posts (user_ID,kategori_adi, post_content,post_date) values ('$user_id','$kategori','$content',NOW())";
                            $run = mysqli_query($con, $insert);
                            if ($run) {
                                echo "<script>alert('Gönderiniz başarıyla paylaşıldı.')</script>";
                                echo "<script>window.open('home.php','_self')</script>";

                                $update = "update users set posts='yes' where user_id='$user_id'";
                                mysqli_query($con, $update);
                            }
                        }

                    }
                }
            }
        }
    }
}

//Gönderi görüntüleme fonksyionu
$per_page = 5;
function get_posts()
{
    global $con;
    global $per_page;
    if (isset($_GET['sayfa'])) {
        $page = $_GET['sayfa'];
    } else {
        $page = 1;
    }
    $start_from = ($page - 1) * $per_page;
    $get_posts = "select * from posts ORDER by 1 DESC LIMIT $start_from, $per_page";
    $run_posts = mysqli_query($con, $get_posts);
    // Görüntüleyen kişi
    $user = $_SESSION['user_email'];
    $get_user = "select * from users where user_email='$user'";
    $run_user = mysqli_query($con, $get_user);
    $row = mysqli_fetch_array($run_user);
    $userown_id = $row['user_ID'];

    while ($row_posts = mysqli_fetch_array($run_posts)) {
        $post_id = $row_posts['post_ID'];
        $user_id = $row_posts['user_ID'];
        $content = $row_posts['post_content'];
        $upload_image = $row_posts['upload_image'];
        $post_date = $row_posts['post_date'];
        $kategori = $row_posts['kategori_adi'];
        //Gönderi paylaşan kullanıcıları çekme
        $user = "select * from users where user_id='$user_id' AND posts='yes'";
        $run_user = mysqli_query($con, $user);
        $row_user = mysqli_fetch_array($run_user);
        $first_name = $row_user['first_name'];
        $last_name = $row_user['last_name'];
        $user_image = $row_user['user_image'];
        $get_begeni = mysqli_query($con, "select count(*) as toplam from postlike where post_ID = '$post_id'");
        $kullanici_begeni_sayisi = mysqli_fetch_assoc($get_begeni);
        $begeniler = $kullanici_begeni_sayisi['toplam'];

        $kontrol_begenme = mysqli_query($con, "select * from postlike where post_ID = '$post_id' AND user_ID = '$userown_id'");
        $begenme = mysqli_num_rows($kontrol_begenme);
        //Hepsini bir arada gösteriyoruz
        if ($content == "No" && strlen($upload_image) >= 1) {
            echo "
			<div class='row'>
				<div class='col-sm-3'>
				</div>
				<div id='posts' class='col-sm-6' style='border-radius: 25px; border-color: #bbbbbb'>
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
						<img id='posts-img' src='../postImages/$upload_image' style='height:350px; border-radius: 25px'>
					</div>
				</div><br>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-social'>Yorum</button></a>";
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
				</div>
				<div class='col-sm-3'>
				</div>
			</div><br><br>
			";
        } else if (strlen($content) >= 1 && strlen($upload_image) >= 1) {
            echo "
			<div class='row'>
				<div class='col-sm-3'>
				</div>
				<div id='posts' class='col-sm-6' style='border-radius: 25px; border-color: #bbbbbb'>
				<div class='row'>
					<div class='col-sm-2'>
						<p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #F3AD00;' href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
						<h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaştı.</strong></small></h4>
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
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-social'>Yorum</button></a>";
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
				</div>
				<div class='col-sm-3'>
				</div>
			</div><br><br>
			";
        } else {
            echo "
		<div class='row'>
			<div class='col-sm-3'>
			</div>
			<div id='posts' class='col-sm-6' style='border-radius: 25px; border-color: #bbbbbb'>
			<div class='row'>
					<div class='col-sm-2'>
						<p><img src='../users/$user_image' class='img-circle' width='90px' height='90px' style='margin-top: 10%; margin-left: 10%'></p>
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
						<h3><p>&#160;&#160;&#160;&#160;&#160;&#160;$content</p></h3>
					</div>
					<div class='col-sm-4'>

					</div>
				</div>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-social'>Yorum</button></a>";
            if($begenme == 0){
                echo"
                <form method='post'>
				    <i style='float:right; text-decoration: none'><button name = 'begeni' class='btn btn-block'  style='background-color:#29B6F6; color: black'>$begeniler <i class='fa fa-thumbs-up'></i> Beğen</button></i><br>
			         <input type='text' name = 'pid' value='$post_id' hidden>
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
				</div>
			<div class='col-sm-3'>
			</div>
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
            header("location:begeniHome.php?sayfa=$page");
        }else{
            $postid = intval(htmlentities($_POST['pid']));
            mysqli_query($con, "delete from postlike where user_ID = '$userown_id' AND post_ID = '$postid'");
            header("location:begeniHome.php?sayfa=$page");
        }
    }
    include("pagination.php");
}

function single_post()
{
    if (isset($_GET['post_id'])) {
        global $con;
        $get_id = $_GET['post_id'];
        $get_posts = "select * from posts where post_ID='$get_id'";
        $run_posts = mysqli_query($con, $get_posts);
        $row_posts = mysqli_fetch_array($run_posts);
        $post_id = $row_posts['post_ID'];
        $user_id = $row_posts['user_ID'];
        $content = $row_posts['post_content'];
        $upload_image = $row_posts['upload_image'];
        $post_date = $row_posts['post_date'];
        //Gönderi atanı çekmek
        $user = "select * from users where user_ID='$user_id' AND posts='yes'";
        $run_user = mysqli_query($con, $user);
        $row_user = mysqli_fetch_array($run_user);
        $first_name = $row_user['first_name'];
        $last_name = $row_user['last_name'];
        $user_image = $row_user['user_image'];
        // Yorum yapan kullanıcı
        $user_com = $_SESSION['user_email'];
        $get_com = "select * from users where user_email='$user_com'";
        $run_com = mysqli_query($con, $get_com);
        $row_com = mysqli_fetch_array($run_com);
        $user_com_id = $row_com['user_ID'];
        $user_com_firstname = $row_com['first_name'];
        $user_com_lastname = $row_com['last_name'];
        if (isset($_GET['post_id'])) {
            $post_id = $_GET['post_id'];
        }
        $get_posts = "select post_id from users where post_ID='$post_id'";
        $run_user = mysqli_query($con, $get_posts);
        $post_id = $_GET['post_id'];
        $post = $_GET['post_id'];
        $get_user = "select * from posts where post_ID='$post'";
        $run_user = mysqli_query($con, $get_user);
        $row = mysqli_fetch_array($run_user);
        $p_id = $row['post_ID'];
        if ($p_id != $post_id) {
            echo "<script>alert('Hata')</script>";
            echo "<script>window.open('home.php','_self')</script>";
        } else {
            if ($content == "No" && strlen($upload_image) >= 1) {
                echo "
			<div class='row'>
				<div class='col-sm-3'>
				</div>
				<div id='posts' class='col-sm-6'>
				<div class='row'>
					<div class='col-sm-2'>
						<p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
						<h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaştı.</strong></small></h4>
					</div>
					<div class='col-sm-4'>
					</div>
				</div>
				<div class='row'>
				    <div  class='col-sm-1'></div>
					<div class='col-sm-10'>
						<img id='posts-img' src='../postImages/$upload_image' style='height:350px;'>
					</div>
					<div  class='col-sm-1'></div>
				</div><br>
				</div>
				<div class='col-sm-3'>
				</div>
			</div><br><br>
			";
            } else if (strlen($content) >= 1 && strlen($upload_image) >= 1) {
                echo "
			<div class='row'>
				<div class='col-sm-3'>
				</div>
				<div id='posts' class='col-sm-6'>
				<div class='row'>
					<div class='col-sm-2'>
						<p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
						<h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaştı.</small></h4>
					</div>
					<div class='col-sm-4'>
					</div>
				</div>
				<div class='row'>
				<div  class='col-sm-1'></div>
					<div class='col-sm-10'>
						<p>$content</p>
						<img id='posts-img' src='../postImages/$upload_image' style='height:350px;'>
					</div>
					<div  class='col-sm-1'></div>
				</div><br>
				</div>
				<div class='col-sm-3'>
				</div>
			</div><br><br>
			";
            } else {
                echo "
		<div class='row'>
			<div class='col-sm-3'>
			</div>
			<div id='posts' class='col-sm-6'>
			<div class='row'>
					<div class='col-sm-2'>
						<p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
						<h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaştı.</small></h4>
					</div>
					<div class='col-sm-4'>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-2'>
					</div>
					<div class='col-sm-6'>
						<h3><p>$content</p></h3>
					</div>
					<div class='col-sm-4'>
					</div>
				</div>
			</div>
			<div class='col-sm-3'>
			</div>
		</div><br><br>
		";
            }
            include("comments.php");
            echo "
		<div class='row'>
        <div class='col-md-6 col-md-offset-3'>
            <div class='panel panel-info'>
                <div class='panel-body'>
                	<form action='' method='post' class='form-inline'>
                    <textarea placeholder='Yorum yaz!' class='pb-cmnt-textarea' name='comment'></textarea>
                    <button class='btn btn-info pull-right' name='reply'>Yorum Yap</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
		";
            if (isset($_POST['reply'])) {
                $comment = htmlentities($_POST['comment']);
                $control_content = preg_replace('/\s+/', '', $comment);
                if ($control_content == "") {
                    echo "<script>alert('Lütfen yorum giriniz!')</script>";
                    echo "<script>window.open('../pages/single.php?post_id=$post_id','_self')</script>";
                } else {
                    $insert = "insert into comments (post_id,user_id,comment,comment_author,date) values ('$post_id','$user_id','$comment','$user_com_firstname $user_com_lastname',NOW())";
                    mysqli_query($con, $insert);
                    echo "<script>window.open('../pages/single.php?post_id=$post_id','_self')</script>";
                }
            }
        }
    }
}

//function for displaying user posts
function user_posts()
{
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
        //getting the user who has posted the thread
        $user = "select * from users where user_ID='$user_id' AND posts='yes'";
        $run_user = mysqli_query($con, $user);
        $row_user = mysqli_fetch_array($run_user);
        $user_name = $row_user['user_name'];
        $first_name = $row_user['first_name'];
        $last_name = $row_user['last_name'];
        $user_image = $row_user['user_image'];
        if (isset($_GET['u_id'])) {
            $u_id = $_GET['u_id'];
        }
        $get_posts = "select user_email from users where user_ID='$u_id'";
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
            echo "<script>window.open('my_post.php?u_id=$user_id','_self')</script>";
        } else {
            if ($content == "No" && strlen($upload_image) >= 1) {
                echo "
			<div class='row'>
				<div class='col-sm-3'>
				</div>
				<div id='posts' class='col-sm-6'>
				<div class='row'>
					<div class='col-sm-2'>
						<p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
						<h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaştı</small></h4>
					</div>
					<div class='col-sm-4'>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-12'>
						<img id='posts-img' src='../postImages/$upload_image' style='height:350px;'>
					</div>
				</div><br>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-success'>Görüntüle</button></a>
                    <a href='../functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Sil</button></a>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Yorum</button></a><br>
				</div>
				<div class='col-sm-3'>
				</div>
			</div><br><br>
			";
            } else if (strlen($content) >= 1 && strlen($upload_image) >= 1) {
                echo "
			<div class='row'>
				<div class='col-sm-3'>
				</div>
				<div id='posts' class='col-sm-6'>
				<div class='row'>
					<div class='col-sm-2'>
						<p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
						<h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaştı</small></h4>
					</div>
					<div class='col-sm-4'>
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
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-success'>Görüntüle</button></a>
                    <a href='../functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Sil</button></a>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Yorum</button></a><br>
				</div>
				<div class='col-sm-3'>
				</div>
			</div><br><br>
			";
            } else {
                echo "
		<div class='row'>
			<div class='col-sm-3'>
			</div>
			<div id='posts' class='col-sm-6'>
			<div class='row'>
					<div class='col-sm-2'>
						<p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
						<h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaştı</small></h4>
					</div>
					<div class='col-sm-4'>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-2'>
					</div>
					<div class='col-sm-6'>
						<h3><p>$content</p></h3>
					</div>
					<div class='col-sm-4'>
					</div>
				</div>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-success'>Görüntüle</button></a>
                    <a href='../functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Sil</button></a>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Yorum</button></a><br>
			</div>
			<div class='col-sm-3'>
			</div>
		</div><br><br>
		";
            }
        }
    }
}

//function for displaying search results
function results()
{
    global $con;
    if (isset($_GET['search'])) {
        $search_query = htmlentities($_GET['user_query']);
    }
    $get_posts = "select * from posts where post_content like '%$search_query%' OR upload_image like '%$search_query%'";
    $run_posts = mysqli_query($con, $get_posts);
    while ($row_posts = mysqli_fetch_array($run_posts)) {
        $post_id = $row_posts['post_ID'];
        $user_id = $row_posts['user_ID'];
        $content = substr($row_posts['post_content'], 0, 40);
        $upload_image = $row_posts['upload_image'];
        $post_date = $row_posts['post_date'];
        $kategori = $row_posts['kategori_adi'];
        $user = "select * from users where user_id='$user_id' AND posts='yes'";
        $run_user = mysqli_query($con, $user);
        $row_user = mysqli_fetch_array($run_user);
        $first_name = $row_user['first_name'];
        $last_name = $row_user['last_name'];
        $user_image = $row_user['user_image'];
        if ($content == "No" && strlen($upload_image) >= 1) {
            echo "
			<div class='row'>
				<div class='col-sm-3'>
				</div>
				<div id='posts' class='col-sm-6'>
				<div class='row'>
					<div class='col-sm-2'>
						<p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
						<h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaştı.</small></h4>
					</div>
					<div class='col-sm-4'>
					<div style=' font-size: 20px; color: black; border-style:dotted; padding: 5px; border-radius: 51px; border-color: white; float: right; background-color: #f3ad00'>$kategori </div>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-12'>
						<img id='posts-img' src='../postImages/$upload_image' style='height:350px;'>
					</div>
				</div><br>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Yorum</button></a><br>
				</div>
				<div class='col-sm-3'>
				</div>
			</div><br><br>
			";
        } else if (strlen($content) >= 1 && strlen($upload_image) >= 1) {
            echo "
			<div class='row'>
				<div class='col-sm-3'>
				</div>
				<div id='posts' class='col-sm-6'>
				<div class='row'>
					<div class='col-sm-2'>
						<p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
						<h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaştı.</small></h4>
					</div>
					<div class='col-sm-4'>
					<div style=' font-size: 20px; color: black; border-style:dotted; padding: 5px; border-radius: 51px; border-color: white; float: right; background-color: #f3ad00'>$kategori </div>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-12'>
						<p>$content</p>
						<img id='posts-img' src='../postImages/$upload_image' style='height:350px;'>
					</div>
				</div><br>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Yorum</button></a><br>
				</div>
				<div class='col-sm-3'>
				</div>
			</div><br><br>
			";
        } else {
            echo "
		<div class='row'>
			<div class='col-sm-3'>
			</div>
			<div id='posts' class='col-sm-6'>
			<div class='row'>
					<div class='col-sm-2'>
						<p><img src='../users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$first_name $last_name</a></h3>
						<h4><small style='color:black;'><strong>$post_date</strong> tarihinde paylaştı.</small></h4>
					</div>
					<div class='col-sm-4'>
					<div style=' font-size: 20px; color: black; border-style:dotted; padding: 5px; border-radius: 51px; border-color: white; float: right; background-color: #f3ad00'>$kategori </div>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-2'>
					</div>
					<div class='col-sm-6'>
						<h3><p>$content</p></h3>
					</div>
					<div class='col-sm-4'>
					</div>
				</div>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Yorum</button></a><br>
			</div>
			<div class='col-sm-3'>
			</div>
		</div><br><br>

		";
        }
    }
}

//Kullanıcı araması için fonksiyon
function search_user()
{
    global $con;
    if (isset($_GET['search_user_btn'])) {
        $search_query = htmlentities($_GET['search_user']);
        $get_user = "select * from users where first_name like '%$search_query%' OR last_name like '%$search_query%' OR user_name like '%$search_query%' order by rutbe_ID desc";
    } else {
        $get_user = "select * from users order by rutbe_ID desc";
    }
    $run_user = mysqli_query($con, $get_user);
    while ($row_user = mysqli_fetch_array($run_user)) {
        $user_id = $row_user['user_ID'];
        $f_name = $row_user['first_name'];
        $l_name = $row_user['last_name'];
        $username = $row_user['user_name'];
        $user_image = $row_user['user_image'];
        $rutbe_id = $row_user['rutbe_ID'];
        $result = mysqli_query($con, "select * from rutbe where rutbe_ID = '$rutbe_id'");
        $sonuc = mysqli_fetch_array($result);
        $sonucc = $sonuc['rutbe_adi'];
        //Görüntüleme
        echo "
		<div class='row'>
			<div class='col-sm-3'>
			</div>
			<div class='col-sm-6''>
			<div class='row' id='find_people'  style='border-radius: 25px; border-color: #bbbbbb'>
			<div class='col-sm-4'>
			<a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>
			<img class='img-circle' src='../users/$user_image' width='150px' height='140px' title='$username' style='float:left; margin:1px;'/>
			</a>
			</div><br><br>
			<div class='col-sm-6'>
			<a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>
			<strong><h2>$f_name $l_name</h2></strong><br>
			<i style='color: red'>$sonucc</i>
			</a>
			</div>
			<div class='col-sm-3'>
			</div>
			</div>
			</div>
			<div class='col-sm-4'>
			</div>
		</div><br>
		";
    }
}

?>
