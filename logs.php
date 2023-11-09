<?php
ob_start();
session_start();
include "db.php";
include "config.php";

if($_SESSION["admin"] == 0){
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
    <style>
        table{
            border: 1px solid black;
            width: 100%;
        }
        td{
            border: 1px solid black;
            margin: 0px;
            padding: 7px;
        }
        tr:nth-child(2n - 1){
            background-color: #cbfff2;
        }
        tr:nth-child(2n){
            background-color: #ffffff;
        }
        tr:nth-child(1) > td{
            font-weight: bold;
            border-bottom: 3px solid black;
        }
        tr{
            border-spacing: 0px;
        }
        o{
            text-decoration: line-through;
        }
    </style>
</head>
<body>
    <table>
        <td>Id</td>
        <td><?php echo $lang["time"] ?></td>
        <td><?php echo $lang["user"] ?></td>
        <td><?php echo $lang["status"] ?></td>
        <td><?php echo $lang["message"] ?></td>
    <?php
        $logs = $db->query("select * from logs order by id desc")->fetchAll();
        foreach ($logs as $log) {
    ?>
        <tr>
            <td><?php echo $log["id"] ?></td>
            <td><?php echo $log["timestamp"] ?></td>
            <td><?php echo explode(",", $log["message"])[0] ?></td>
            <td><?php echo explode(",", $log["message"])[1] ?></td>
            <td><?php echo explode(",", $log["message"])[2] ?></td>
        </tr>
    <?php
        }
    ?>
    </table>
</body>
</html>