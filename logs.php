<?php
ob_start();
session_start();
include "db.php";
include "config.php";

if(!isset($_SESSION["admin"])){
    header("Location: index.php");
}

//Localization
$lang = array(
    "en" => array(
        "time" => "Time",
        "message" => "Message"
    ),
    "tr" => array(
        "time" => "Zaman",
        "message" => "Mesaj"
    )
);
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
    </style>
</head>
<body>
    <table>
        <td><?php echo $lang[$langcode]["time"] ?></td>
        <td><?php echo $lang[$langcode]["message"] ?></td>
    <?php
        $logs = $db->query("select * from logs order by id desc")->fetchAll();
        foreach ($logs as $log) {
    ?>
        <tr>
            <td><?php echo $log["timestamp"] ?></td>
            <td><?php echo $log["message"] ?></td>
        </tr>
    <?php
        }
    ?>
    </table>
</body>
</html>