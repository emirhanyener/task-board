<?php
//////////////////////////
//Start database connect//
//////////////////////////
    $host = "localhost";
    $dbname = "task_board";
    $username = "root";
    $password = "";

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection error: " . $e->getMessage());
    }
////////////////////////
//End database connect//
////////////////////////

/////////////////
//Start add log//
/////////////////
function addLog($message, $status) {
    global $db;

    date_default_timezone_set("Europe/Istanbul");
    $query = $db->prepare("INSERT INTO logs (timestamp, message) VALUES (:timestamp, :message)");
    $query->bindParam(":timestamp", date("[d.m.Y H:i:s]", time()));
    $new_message = $_SESSION["username"].",".$status.",".$message;
    $query->bindParam(":message", $new_message);
    $query->execute();
}
///////////////
//End add log//
///////////////
?>