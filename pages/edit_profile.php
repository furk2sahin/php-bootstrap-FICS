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
    <title>Profilini Düzenle</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../style/home_style2.css" media="all"/>
</head>
<style>

</style>
<body>
<div class="row">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8">
        <form action="" method="post" enctype="multipart/form-data">
            <table class="table table-bordered table-hover">
                <tr align="center">
                    <td colspan="6" class="active"><h2>Profilini düzenle</h2></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Adını değiştir</td>
                    <td>
                        <input class="form-control" type="text" name="f_name" required="required"
                               value="<?php echo $first_name; ?>"/>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Soyadını değiştir</td>
                    <td>
                        <input class="form-control" type="text" name="l_name" required="required"
                               value="<?php echo $last_name; ?>"/>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Açıklama</td>
                    <td>
                        <input class="form-control" type="text" name="describe_user" required="required"
                               value="<?php echo $describe_user; ?>"/>
                    </td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">İlişki</td>
                    <td>
                        <select class="form-control" name="Relationship">
                            <option><?php echo $relationship_status; ?></option>
                            <option>Evli</option>
                            <option>Bekar</option>
                            <option>İlişkisi var</option>
                            <option>Karmaşık</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">Şifre</td>
                    <td>
                        <input class="form-control" type="password" name="u_pass" id="mypass" required="required"
                               value="<?php echo $user_pass; ?>"/>
                        <input type="checkbox" onclick="show_password()"> <strong>Şifreyi göster</strong>
                    </td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">Email</td>
                    <td>
                        <input class="form-control" type="email" name="u_email" required="required"
                               value="<?php echo $user_email; ?>"></td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">Ülke</td>
                    <td>
                        <select class="form-control" name="u_country">
                            <option><?php echo $user_country; ?></option>
                            <option>ABD</option>
                            <option>Hindistan</option>
                            <option>Azerbeycan</option>
                            <option>İngiltere</option>
                            <option>Fransa</option>
                            <option>Almanya</option>
                            <option>Rusya</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">Cinsiyet</td>
                    <td>
                        <select class="form-control" name="u_gender">
                            <option><?php echo $user_gender; ?></option>
                            <option>Erkek</option>
                            <option>Kadın</option>
                            <option>Diğer</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">Doğum tarihi</td>
                    <td>
                        <input type="date" name="u_birthday" class="form-control input-md"
                               value="<?php echo $user_birthday; ?>" required="required">
                </tr>
                <tr>
                    <td style="font-weight: bold;">Biografi</td>
                    <td>
                        <textarea name="u_biografi" class="form-control input-md"><?php echo $biografi; ?></textarea>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Güvenlik sorusu</td>
                    <td>
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Aktif
                            et
                        </button>

                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Güvenlik sorusu</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="recovery.php?id=<?php echo $user_id; ?>" method="post" id="f">
                                            <strong>En yakın arkadaşının adı?</strong>
                                            <textarea class="form-control" cols="83" rows="4" name="content"
                                                      placeholder="Birisi"></textarea><br/>
                                            <input class="btn btn-default" type="submit" name="sub" value="Gönder"
                                                   style="width:100px;"/><br><br>
                                            <pre>Yukarıdaki soruyu cevapla. Bu cevabını şifreni unuttuğunda kullanabilirsin. <br>
									</pre>
                                            <br><br>
                                        </form>
                                        <?php
                                        if (isset($_POST['sub'])) {
                                            $bfn = htmlentities($_POST['content']);
                                            $control_message = preg_replace('/\s+/', '', $bfn);
                                            if ($control_message == '') {
                                                echo "<script>alert('Lütfen boş geçmeyiniz!')</script>";
                                                echo "<script>window.open('edit_profile.php?u_id=$user_id','_self')</script>";
                                                exit();
                                            } else {
                                                $update = "update users set recovery_account='$bfn' where user_id='$user_id'";
                                                $run = mysqli_query($con, $update);
                                                if ($run) {
                                                    echo "<script>alert('Güncellendi')</script>";
                                                    echo "<script>window.open('edit_profile.php?u_id=$user_id','_self')</script>";
                                                } else {
                                                    echo "<script>alert('Hata ile karşılaşıldı')</script>";
                                                    echo "<script>window.open('edit_profile.php?u_id=$user_id','_self')</script>";
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Kapat
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </tr>
                <tr align="center">
                    <td colspan="6">
                        <input class="btn btn-info" style="width: 250px;" type="submit" name="update" value="Güncelle"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="col-sm-2">
    </div>
</div>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    $f_name = htmlentities($_POST['f_name']);
    $l_name = htmlentities($_POST['l_name']);
    $describe_user = htmlentities($_POST['describe_user']);
    $relationship_status = htmlentities($_POST['Relationship']);
    $u_pass = htmlentities($_POST['u_pass']);
    $u_email = htmlentities($_POST['u_email']);
    $u_country = htmlentities($_POST['u_country']);
    $u_gender = htmlentities($_POST['u_gender']);
    $u_birthday = htmlentities($_POST['u_birthday']);
    $u_biografi = htmlentities($_POST['u_biografi']);
    $update = "update users set first_name='$f_name', last_name='$l_name',describe_user='$describe_user',relationship='$relationship_status', user_password='$u_pass',user_email='$u_email',user_country='$u_country',user_gender='$u_gender',user_birthday='$u_birthday', user_biografi = '$u_biografi' where user_ID='$user_id'";
    $run = mysqli_query($con, $update);
    if ($run) {
        echo "<script>alert('Profil güncellendi!')</script>";
        echo "<script>window.open('home.php','_self')</script>";
    }

}


?>
<?php } ?>
<script>
    function show_password() {
        var x = document.getElementById("mypass");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>