<?php
$con = mysqli_connect("localhost", "root", "", "db_fics") or die("Bağlantı Kurulamadı.");

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $getuid_delete = mysqli_query($con, "select * from posts where post_ID = '$post_id'");
    $getuid_deletee = mysqli_fetch_array($getuid_delete);
    $userid = $getuid_deletee['user_ID'];
    $delete_post = "delete from posts where post_ID='$post_id'";
    $run_delete = mysqli_query($con, $delete_post);
    if ($run_delete) {
        echo "<script>alert('Bir gönderi silindi!')</script>";
        echo "<script>window.open('../pages/profile.php?u_id=$userid','_self')</script>";
    }
}
?>


