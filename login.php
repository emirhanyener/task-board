<?php 
session_start();
ob_start();
include "db.php";
include "config.php";
?>
<?php
if(isset($_SESSION["username"])){
    header("Location: index.php");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(!isset($_SESSION["username"])){
    $query = $db->query("SELECT * FROM users where username = '".str_replace(["\"", "'"], "", $_POST["username"])."' and password = '".str_replace(["\"", "'"], "", $_POST["password"])."'")->fetch(PDO::FETCH_ASSOC);
    if ( $query ){
      $_SESSION["username"] = $query["username"];
      $_SESSION["userid"] = $query["id"];
      $_SESSION["admin"] = $query["is_admin"];
      addLog("", "Login");
      header("Location: index.php");
    } else{
      header("Location: login.php");
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang["login"] ?></title>
    <link rel="stylesheet" href="src/style/login.css">
</head>
<body>
    <div class="container">
        <div class="panel">
            <h1><?php echo $lang["login"] ?></h1>
            <form action="" method="post">
                <table>
                    <tr><td><?php echo $lang["username"] ?>: </td><td><input type="text" name="username" id="" class="form-text"></td></tr>
                    <tr><td><?php echo $lang["password"] ?>: </td><td><input type="text" name="password" id="" class="form-text password-input"></td></tr>
                    <tr><td colspan="2"><input type="submit" value="<?php echo $lang["login"] ?>" class="form-button"></td></tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>