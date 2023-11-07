<?php
    include("db.php"); 
    include("config.php"); 
    try {
        $db->query("CREATE TABLE `announcements` (
            `id` int(11) NOT NULL,
            `value` text NOT NULL,
            `time` varchar(50) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $db->query("CREATE TABLE `users` (
            `id` int(11) NOT NULL,
            `username` varchar(50) NOT NULL,
            `password` varchar(50) NOT NULL,
            `is_admin` int(11) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $db->query("CREATE TABLE `logs` (
            `id` int(11) NOT NULL,
            `message` text NOT NULL,
            `timestamp` varchar(50) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $db->query("CREATE TABLE `tasks` (
            `id` int(11) NOT NULL,
            `value` text NOT NULL,
            `color` varchar(10) NOT NULL,
            `level` int(11) NOT NULL,
            `userid` int(11) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $db->query("ALTER TABLE `announcements` ADD PRIMARY KEY (`id`);");
        $db->query("ALTER TABLE `logs` ADD PRIMARY KEY (`id`);");
        $db->query("ALTER TABLE `tasks` ADD PRIMARY KEY (`id`);");
        $db->query("ALTER TABLE `users` ADD PRIMARY KEY (`id`);");

        $db->query("ALTER TABLE `announcements` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
        $db->query("ALTER TABLE `logs` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
        $db->query("ALTER TABLE `tasks` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
        $db->query("ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
        echo $lang[$langcode]["database_created"];
    } catch (PDOException $e) {
        echo $lang[$langcode]["database_already_created"];
    }
?>