<?php 
session_start();
ob_start();
include "db.php";
include "config.php";

//Localization
$lang = array(
    "en" => array(
        "username" => "Username",
        "password" => "Password",
        "settings" => "Settings",
        "save" => "Save"
    ),
    "tr" => array(
        "username" => "Kullanıcı Adı",
        "password" => "Şifre",
        "settings" => "Ayarlar",
        "save" => "Katdet"
    )
);
?>
<?php
if(!isset($_SESSION["username"])){
    header("Location: index.php");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db->query("update users set password=\"".$_POST["password"]."\" where id=".$_SESSION["userid"]);
    header("Location: settings.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang[$langcode]["settings"] ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="panel">
            <h1><?php echo $lang[$langcode]["settings"] ?></h1>
            <hr>
            <form action="" method="post">
                <table>
                    <tr><td><?php echo $lang[$langcode]["username"] ?>: </td><td><?php echo $_SESSION["username"] ?></td></tr>
                    <tr><td><?php echo $lang[$langcode]["password"] ?>: </td><td><input type="text" name="password" id="" class="form-text"></td></tr>
                    <tr><td colspan="2"><input type="submit" value="<?php echo $lang[$langcode]["save"] ?>" class="form-button"></td></tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>