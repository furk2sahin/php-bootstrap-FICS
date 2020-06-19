<?php
include("../includes/connection.php");

if(isset($_POST['sign_up'])){
    mb_internal_encoding('UTF-8');
    $first_name = htmlentities(mysqli_real_escape_string($con,$_POST['first_name']));
    $last_name = htmlentities(mysqli_real_escape_string($con,$_POST['last_name']));
    $pass = htmlentities(mysqli_real_escape_string($con,$_POST['u_pass']));
    $email = htmlentities(mysqli_real_escape_string($con,$_POST['u_email']));
    $country = htmlentities(mysqli_real_escape_string($con,$_POST['u_country']));
    $gender = htmlentities(mysqli_real_escape_string($con,$_POST['u_gender']));
    $birthday = htmlentities(mysqli_real_escape_string($con,$_POST['u_birthday']));
    $user_bio = htmlentities(mysqli_real_escape_string($con,$_POST['bio']));
    $status = "verified";
    $posts = "no";
    $bool = false;
    // ayni kullanıcı adı oluşmasının önüne geçmek
    do{
        $newgid = sprintf('%05d', rand(0, 999999));
        $firstt_name = preg_replace('/\s+/', '', $first_name);
        $lastt_name = preg_replace('/\s+/', '', $last_name);
        $username = mb_strtolower($firstt_name . "_" . $lastt_name . "_" . $newgid);
        $run_username = mysqli_query($con,"select user_name from users where user_name ='$username'");
        $username_count = mysqli_num_rows($run_username);
        if($username_count>0)
            $bool = true;
        else
            $bool = false;
    }while($bool);

    $run_email = mysqli_query($con, "select * from users where user_email = '$email'");
    $email_count = mysqli_num_rows($run_email);
    if($email_count > 0){
        echo "<script>alert('Email zaten alınmış, lütfen başka email girmeyi deneyin.')</script>";
        echo "<script>window.open('signup.php', '_self')</script>";
        exit();
    }


    //parola
    if(strlen($pass) < 8 ){
        echo"<script>alert('Şifre en az 8 karakter olmalı!')</script>";
        exit();
    }
    $rand = rand(1, 3); //Random number between 1 and 3
    //baslangiç avatari
    if($rand == 1)
        $profile_pic = "head_red.png";
    else if($rand == 2)
        $profile_pic = "head_sun_flower.png";
    else if($rand == 3)
        $profile_pic = "head_turqoise.png";

    $insert = "insert into users (first_name,last_name,user_name,describe_user,relationship,user_password,user_email,user_country,user_gender,user_birthday,user_image,user_cover,user_reg_date,status,posts,recovery_account,user_biografi, rutbe_ID)
		values('$first_name','$last_name','$username','Merhaba FICS. Bu benim varsayılan durumum!','...','$pass','$email','$country', '$gender','$birthday','$profile_pic','default_cover.jpg',NOW(),'$status','$posts','Kayıt','$user_bio', 1)";

    $query = mysqli_query($con, $insert);

    if($query){
        echo "<script>alert('Tebrikler $first_name, artık aramızdasın!')</script>";
        echo "<script>window.open('signin.php', '_self')</script>";
    }
    else{
        echo "<script>alert('Kayit başarısız, lütfen tekrar deneyiniz!')</script>";
        echo "<script>window.open('signup.php', '_self')</script>";
    }
}
?>


