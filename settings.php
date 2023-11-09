<?php 
session_start();
ob_start();
include "db.php";
include "config.php";
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
    <title><?php echo $lang["settings"] ?></title>
    <link rel="stylesheet" href="src/style/settings.css">
</head>
<body>
    <div class="container">
        <div class="panel">
            <h1><?php echo $lang["settings"] ?></h1>
            <form action="" method="post">
                <table>
                    <tr><td><?php echo $lang["username"] ?>: </td><td><?php echo $_SESSION["username"] ?></td></tr>
                    <tr><td><?php echo $lang["password"] ?>: </td><td><input type="text" name="password" id="" class="form-text"></td></tr>
                    <tr><td colspan="2"><input type="submit" value="<?php echo $lang["save"] ?>" class="form-button"></td></tr>
                </table>
            </form>
        </div>
    </div>
    <a href="index.php">
        <div class="task-board-button">
            ← <?php echo $lang["task_board"] ?>
        </div>
    </a>
</body>
</html>