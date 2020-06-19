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

<head>
    <title>Mesajlar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../style/home_style2.css" media="all"/>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<style>
    #scroll_messages {
        max-height: 500px;
        overflow: scroll;
    }

    #btn-msg {
        width: 20%;
        height: 28px;
        border-radius: 5px;
        margin: 5px;
        border: none;
        color: #fff;
        float: right;
        background-color: #2ecc71;
    }

    #select_user {
        max-height: 500px;
        overflow: scroll;
    }

    #green {
        background-color: #2ecc71;
        border-color: #27ae60;
        width: 45%;
        padding: 2.5px;
        font-size: 16px;
        border-radius: 3px;
        float: left;
        margin-bottom: 5px;
    }

    #blue {
        background-color: #3498db;
        border-color: #2980b9;
        width: 45%;
        padding: 2.5px;
        font-size: 16px;
        border-radius: 3px;
        float: right;
        margin-bottom: 5px;
    }
</style>
<body>
<div class="row">
    <?php
    //Mesaj gönderen kişi
    if (isset($_GET['u_id']) && $_GET['u_id'] != 'new') {
        global $con;
        $get_id = $_GET['u_id'];
        $get_user = "select * from users where user_ID='$get_id'";
        $run_user = mysqli_query($con, $get_user);
        $row_user = mysqli_fetch_array($run_user);
        $user_to_msg = $row_user['user_ID'];
        $user_to_name = $row_user['user_name'];
        $user_to_fname = $row_user['first_name'];
        $user_to_lname = $row_user['last_name'];
    }
    //Mesaj görüntüleyen kişi
    $user = $_SESSION['user_email'];
    $get_user = "select * from users where user_email='$user'";
    $run_user = mysqli_query($con, $get_user);
    $row = mysqli_fetch_array($run_user);
    $user_from_msg = $row['user_ID'];
    $user_from_name = $row['user_name'];
    $user_from_fname = $row['first_name'];
    $user_from_lname = $row['last_name'];
    ?>
    <div class="col-sm-3" id='select_user'>
        <?php
        $user_control = $_SESSION['user_email'];
        $user = "select * from users where user_email!='$user_control'";
        $run_user = mysqli_query($con, $user);
        while ($row_user = mysqli_fetch_array($run_user)) {
            $user_id = $row_user['user_ID'];
            $user_name = $row_user['user_name'];
            $first_name = $row_user['first_name'];
            $last_name = $row_user['last_name'];
            $user_image = $row_user['user_image'];
            $msg_number_gett = mysqli_query($con, "select * from user_messages where user_from='$user_id' AND message_seen='no' AND user_to = '$user_from_msg'");
            $msg_numberr = mysqli_num_rows($msg_number_gett);
            if ($msg_numberr == 0) {
                echo "
			<div class='container-fluid'>
				<a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='messages.php?u_id=$user_id'>
				<img class='img-circle' src='../users/$user_image' width='90px' height='80px' title='$user_name' /> <strong> &nbsp$first_name $last_name</strong><span class='badge badge-secondary' style='float: right; margin-top: 35px'>$msg_numberr</span><br><br>
				</a><br>
			</div>
			";
            }else{
                echo "
			<div class='container-fluid'>
				<a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='messages.php?u_id=$user_id'>
				<img class='img-circle' src='../users/$user_image' width='90px' height='80px' title='$user_name' /> <strong> &nbsp$first_name $last_name</strong><span class='badge badge-secondary' style='float: right; margin-top: 35px; background-color: red'>$msg_numberr</span><br><br>
				</a><br>
			</div>
			";
            }
        }
        ?>
    </div>
    <div class="col-sm-6">
        <?php if ($_GET['u_id'] != 'new') { ?>
            <div class="load_msg" id="scroll_messages">
                <?php
                $sel_msg = "select * from user_messages where (user_to='$user_to_msg' AND user_from='$user_from_msg') OR (user_from='$user_to_msg' AND user_to='$user_from_msg') ORDER by 1 ASC";
                $run_msg = mysqli_query($con, $sel_msg);
                while ($row_msg = mysqli_fetch_array($run_msg)) {
                    $user_to = $row_msg['user_to'];
                    $user_from = $row_msg['user_from'];
                    $msg_body = $row_msg['message_body'];
                    $msg_date = $row_msg['date'];
                    $message_seen = $row_msg['message_seen'];
                    ?>
                    <div id="loaded_msg">
                        <p><?php if ($user_to == $user_to_msg and $user_from == $user_from_msg) {
                                if ($message_seen == 'yes')
                                    echo "<div class='message' id='blue' style='background-color: #E3F2FD; font-family:Comic Sans MS; font-size: 20px; font-weight: bold; ' data-toggle='tooltip' title='$msg_date'>$msg_body</div><i class='fa fa-check-circle' style='float: right; color: deepskyblue; font-size: 20px; margin-right: 5px;' ></i><br><br>";
                                else
                                    echo "<div class='message' id='blue' style='background-color: #E3F2FD; font-family:Comic Sans MS; font-size: 20px; font-weight: bold; data-toggle='tooltip' title='$msg_date'>$msg_body</div><i class='fa fa-check' style='float:right;font-size: 20px; margin-right: 5px'></i><br><br>";
                            } else if ($user_from == $user_to_msg and $user_to == $user_from_msg) {
                                mysqli_query($con, "update user_messages set message_seen='yes' where user_to='$user_to' AND user_from='$user_from' AND message_body='$msg_body' AND date='$msg_date'");
                                echo "<div class='message' id='green' style='background-color: 	#FFEBEE; font-family:Comic Sans MS; font-size: 20px; font-weight: bold; color: black' data-toggle='tooltip' title='$msg_date'>$msg_body</div> <br><br>";
                            } ?></p>
                    </div>
                    <?php
                }
                ?>
            </div>
        <?php } ?>
        <?php
        if (isset($_GET['u_id'])) {
        $u_id = $_GET['u_id'];
        if ($u_id == "new") {
            echo '
				<form>
					<center><h3>Mesajlaşmak için birini seç</h3></center>
				</form><br><br>
				';
        } else { ?>
        <html>
        <form method="POST">
            <textarea class="form-control" placeholder="Mesajınızı giriniz" name="msg_box" id="msgtxt"
                      style="resize: none"></textarea>
            <input type="submit" name="send_msg" class="btn btn-social" style="float: right" value="Gönder">
        </form>
        <br><br>
        <?php }
        } ?>

        <?php
        if (isset($_POST['send_msg'])) {
            $msg = htmlentities($_POST['msg_box']);
            $control_message = preg_replace('/\s+/', '', $msg);
            if ($control_message == "") {
                echo "<h4 style='color:red;text-align:center;'>Mesaj gönderilemedi</h4>";
            } else if (strlen($msg) > 37) {
                echo "<h4 style='color:red;text-align:center;'>Mesaj çok uzun. Lütfen 37 karakter kullanın</h4>";
            } else {
                $insert = "insert into user_messages (user_to,user_from,message_body,date,message_seen) values ('$user_to_msg','$user_from_msg','$msg',NOW(),'no')";
                $run_insert = mysqli_query($con, $insert);
                header("location: result.php?u_id=" . $u_id);
            }
        }
        ?>
    </div>
    <div class="col-sm-3">
        <?php
        if (isset($_GET['u_id']) && $_GET['u_id'] != "new") {
            global $con;
            $get_id = $_GET['u_id'];
            $get_user = "select * from users where user_ID='$get_id'";
            $run_user = mysqli_query($con, $get_user);
            $row = mysqli_fetch_array($run_user);
            $user_id = $row['user_ID'];
            $user_name = $row['user_name'];
            $f_name = $row['first_name'];
            $l_name = $row['last_name'];
            $describe_user = $row['describe_user'];
            $user_country = $row['user_country'];
            $user_image = $row['user_image'];
            $register_date = $row['user_reg_date'];
            $gender = $row['user_gender'];
            $biografi = $row['user_biografi'];
        } else {
            global $con;
            $user = $_SESSION['user_email'];
            $get_user = "select * from users where user_email='$user'";
            $run_user = mysqli_query($con, $get_user);
            $row = mysqli_fetch_array($run_user);
            $get_id = $row['user_ID'];
            $user_id = $row['user_ID'];
            $user_name = $row['user_name'];
            $f_name = $row['first_name'];
            $l_name = $row['last_name'];
            $describe_user = $row['describe_user'];
            $user_country = $row['user_country'];
            $user_image = $row['user_image'];
            $register_date = $row['user_reg_date'];
            $gender = $row['user_gender'];
            $biografi = $row['user_biografi'];
        }

        if ($get_id == "new") {
        } else {
            $rutbe_id = $row['rutbe_ID'];
            $get_rutbe = mysqli_query($con, "select rutbe_adi from rutbe where rutbe_ID='$rutbe_id'");
            $kullanici_rutbesi = mysqli_fetch_array($get_rutbe);
            $rutbe = $kullanici_rutbesi['rutbe_adi'];
            echo "
				<div class='row'>
					<div class='col-sm-2'>
					</div>
					<center>
					<div  style='background-color: #F3AD00' class='col-sm-9'>
					<h2>Hakkında</h2>
					<img class='img-circle' src='../users/$user_image' width='150' height='150' />
					<br><br>
					<ul class='list-group'>
					  <li class='list-group-item' title='Kullanıcı'><strong>$f_name $l_name</strong></li>
					  <li class='list-group-item' title='Kullanici rütbesi'><i style='color: red; font-weight: bold'>$rutbe</i></li>
					  <li class='list-group-item' title='Kullanıcı durumu'><strong style='color:grey;'>$describe_user</strong></li>
					  <li class='list-group-item' title='Cinsiyet'>$gender</li>
					  <li class='list-group-item' title='Ülke'>$user_country</li>
					  <li class='list-group-item' title='Katıldığı tarih'>$register_date</li>
					  <li class='list-group-item' title='Biografi' style='word-wrap: break-word'>$biografi</li>
					</ul>
					</div>
					<div class='col-sm-1'>
					</div>
				</div>
				";
        }
        ?>
    </div>
</div>
<script>
    var div = document.getElementById("scroll_messages");
    div.scrollTop = div.scrollHeight;
</script>
</body>
</html>
<?php } ?>
