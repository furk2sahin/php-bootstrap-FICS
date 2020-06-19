<?php
include("connection.php");
include("../functions/functions.php");
?>
<style>
    .btn-social, .badge, .btn-social, .bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-primary,
    .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-primary,
    ::-webkit-scrollbar-thumb, ::-webkit-scrollbar-thumb:window-inactive {
        background: black;
    }

    .btn-social {
        border: #f3ad00;
    }

    .btn-social {
        color: whitesmoke;
    }

    .btn-social:hover, .btn-social:focus, .btn-social:active {
        color: #ffffff;
        background: whitesmoke;
        color: whitesmoke
    }

    .btn-social:active:focus {
        background: #d09400;
    }

    body {
        overflow-x: hidden;
    }
</style>
<nav class="navbar navbar-default" style="background-color: #F3AD00">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img src="../images/logo2.png" width="200px" height="50px" style="margin-left: -50px">
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <?php
                $user = $_SESSION['user_email'];
                $get_user = "select * from users where user_email='$user'";
                $run_user = mysqli_query($con, $get_user);
                $row = mysqli_fetch_array($run_user);

                $user_id = $row['user_ID'];
                $user_name = $row['user_name'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $describe_user = $row['describe_user'];
                $relationship_status = $row['relationship'];
                $user_pass = $row['user_password'];
                $user_email = $row['user_email'];
                $user_country = $row['user_country'];
                $user_gender = $row['user_gender'];
                $user_birthday = $row['user_birthday'];
                $user_image = $row['user_image'];
                $user_cover = $row['user_cover'];
                $recovery_account = $row['recovery_account'];
                $register_date = $row['user_reg_date'];
                $biografi = $row['user_biografi'];
                $rutbe_id = $row['rutbe_ID'];

                $run_posts = mysqli_query($con, "select * from posts where user_ID='$user_id'");
                $posts = mysqli_num_rows($run_posts);

                $msg_number_get = mysqli_query($con, "select distinct user_from from user_messages where user_to='$user_id' AND message_seen='no'");
                $msg_number = mysqli_num_rows($msg_number_get);

                ?>

                <li><a style="color: black"
                       href='profile.php?<?php echo "u_id=$user_id" ?>'><strong><?php echo "$first_name"; ?></strong></a>
                </li>
                <li><a style="color: black" href="home.php"><strong>Anasayfa</strong></a></li>
                <li><a style="color: black" href="members.php"><strong>Yeni insanlar bul</strong></a></li>
                <?php if($msg_number == 0)
                    echo "<li><a style='color: black' href='messages.php?u_id=new'><strong>Mesajlar <span class='badge badge-secondary'>$msg_number</span></strong></a></li>";
                 else
                     echo "<li><a style='color: black' href='messages.php?u_id=new'><strong>Mesajlar <span class='badge badge-secondary' style='background-color: red'>$msg_number</span></strong></a></li>";
                ?>

                <?php

                echo "
					
	        <li class='dropdown'>
	          <a style='color: whitesmoke'  class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><span><i class='glyphicon glyphicon-chevron-down'></i></span></a>
	          <ul class='dropdown-menu'>
	            <li>
	           <a href='my_post.php?u_id=$user_id'><strong>Gönderilerim</strong> <span class='badge badge-secondary'> $posts</span></a>
	            </li>
	            <li>
	            <a href='edit_profile.php?u_id=$user_id'><strong>Profili düzenle</strong></a>
	            </li>
	            <li role='separator' class='divider'></li>
	            <li>
	            <a href='logout.php'><strong>Çıkış</strong></a>
	            </li>
	          </ul>
	        </li>
	      </ul>
	      ";
                ?>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <form class="navbar-form navbar-left" method="get" action="results.php">
                            <div class="form-group">
                                <input type="text" class="form-control" name="user_query" placeholder="Gönderi ara">
                            </div>
                            <button type="submit" class="btn btn-social" name="search">Arama</button>
                        </form>
                    </li>
                </ul>
        </div>
    </div>
</nav>