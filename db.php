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
?>