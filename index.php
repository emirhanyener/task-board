<?php
ob_start();
session_start();
include "db.php";
include "config.php";

if(!isset($_SESSION["username"])){
    header("Location: login.php");
}

//Localization
$lang = array(
    "en" => array(
        "todo" => "TO-DO",
        "in_progress" => "In Progress",
        "done" => "Done",
        "task_value" => "Task Value",
        "edit_task" => "Edit Task",
        "edit" => "Edit",
        "cancel" => "Cancel",
        "settings" => "Settings",
        "logout" => "Logout",
        "announcements" => "Announcements",
        "time" => "Time",
        "message" => "Messsage"
    ),
    "tr" => array(
        "todo" => "Yapılacaklar",
        "in_progress" => "Devam Ediyor",
        "done" => "Bitti",
        "task_value" => "Görev içeriği",
        "edit_task" => "Görevi Düzenle",
        "edit" => "Düzenle",
        "cancel" => "İptal Et",
        "settings" => "Ayarlar",
        "logout" => "Çıkış yap",
        "announcements" => "Duyurular",
        "time" => "Zaman",
        "message" => "Mesaj"
    )
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET["edit_task"])) {
        ///////////////////
        //Start edit task//
        ///////////////////
        $color = $_POST["color"];
        $value = $_POST["value"];
        $taskId = $_GET["edit_task"];

        $query = $db->query("SELECT * FROM tasks WHERE id = $taskId; UPDATE tasks SET color = $color, value = ".htmlspecialchars($value)." WHERE id = $taskId")->fetch();
        addLog("[" .$taskId."] <o>". $query["value"]."</o> => ".htmlspecialchars($value), "Edit Task");

        header("Location: index.php");
        /////////////////
        //End edit task//
        /////////////////
    } else {
        //////////////////
        //Start add task//
        //////////////////
        $level = $_GET["level"];
        $taskcolor = $_POST["taskcolor"];
        $taskvalue = $_POST["taskvalue"];

        $query = $db->prepare("INSERT INTO tasks (level, color, value, userid) VALUES (:level, :color, :value, :userid)");
        $query->bindParam(":level", $level);
        $query->bindParam(":color", $taskcolor);
        $query->bindParam(":value", htmlspecialchars($taskvalue));
        $query->bindParam(":userid", $_SESSION["userid"]);
        $query->execute();

        $lastInsertedId = $db->lastInsertId();
        addLog("[" .$lastInsertedId."] ". htmlspecialchars($taskvalue), "Add Task");

        header("Location: index.php");
        ////////////////
        //End add task//
        ////////////////
    }
}

/////////////////////
//Start delete task//
/////////////////////
if (isset($_GET["task_delete"])) {
    $taskId = $_GET["task_delete"];
    
    $query = $db->query("SELECT * FROM tasks where id=$taskId; DELETE FROM tasks WHERE id = $taskId")->fetch();

    addLog("[" . $taskId . "] " . $query["value"], "Delete Task");

    header("Location: index.php");
}
///////////////////
//End delete task//
///////////////////

/////////////////////////
//Start move right task//
/////////////////////////
if (isset($_GET["task_move_right"])) {
    $taskId = $_GET["task_move_right"];
    
    $query = $db->query("SELECT * FROM tasks where id=$taskId; UPDATE tasks SET level = level + 1 WHERE id = $taskId")->fetch();

    addLog("[" . $taskId . "] " . $query["value"], "Move Right Task");

    header("Location: index.php");
}
///////////////////////
//End move right task//
///////////////////////

////////////////////////
//Start move left task//
////////////////////////
if (isset($_GET["task_move_left"])) {
    $taskId = $_GET["task_move_left"];
    
    $query = $db->query("SELECT * FROM tasks where id=$taskId; UPDATE tasks SET level = level - 1 WHERE id = $taskId")->fetch();

    addLog("[" . $taskId . "] " . $query["value"], "Move Left Task");

    header("Location: index.php");
}
//////////////////////
//End move left task//
//////////////////////
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/style/index.css">
    <title>Task Board</title>
</head>
<body>
    <div id="announcements-panel-bg" style="visibility: hidden;">
        <div id="announcements-panel">
            <h1><?php echo $lang[$langcode]["announcements"] ?></h1>
            <table>
                <tr>
                    <td><?php echo $lang[$langcode]["time"] ?></td>
                    <td><?php echo $lang[$langcode]["message"] ?></td>
                </tr>
                <?php
                    $query = $db->query("SELECT * FROM announcements ORDER BY id desc")->fetchAll();

                    foreach ($query as $item) {
                ?>
                <tr>
                    <td><?php echo $item['time']; ?></td>
                    <td><?php echo $item['value']; ?></td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </div>
    <div class="edit-task-panel-back" style="visibility: hidden;">
        <div class="edit-task-panel">
            <form id="edit-task-form" action="" method="post">
                <h1><?php echo $lang[$langcode]["edit_task"] ?></h1>
                <textarea name="value" class="edit-task-textarea"></textarea>
                <div>
                    <input type="button" value="<?php echo $lang[$langcode]["cancel"] ?>" class="edit-task-panel-button"></button>
                    <button type="submit" class="edit-task-panel-button"><?php echo $lang[$langcode]["edit"] ?></button>
                </div>
                <input type="color" name="color" id="edit-task-color">
            </form>
        </div>
    </div>
    <div class="parent">
        <div class="div1 table-header"><?php echo $lang[$langcode]["todo"] ?></div>
        <div class="div2 table-header"><?php echo $lang[$langcode]["in_progress"] ?></div>
        <div class="div3 table-header"><?php echo $lang[$langcode]["done"] ?></div>

        <div class="div4 task-panel">
        <?php
        $query = $db->prepare("SELECT * FROM tasks");
        $query->execute();
        $tasks = $query->fetchAll();

        foreach ($tasks as $task) {
            if($task["level"] == 1) {
        ?>
            <div class="task-item" oncontextmenu="CopyToClipboardFunction(event, '<?php echo $task['value']; ?>')">
                <div style="background-color: <?php echo $task['color']; ?>;" class="task-item-color"></div>
                <a href="?task_delete=<?php echo $task['id']; ?>" class="remove_task_link">X</a>
                <div ondblclick="openEditPanel('<?php echo $task['id']; ?>', '<?php echo $task['value']; ?>', '<?php echo $task['color']; ?>')"><?php echo $task['value']; ?><br><font class="task-user-text"><?php echo $db->query("select * from users where id=".$task["userid"])->fetch()["username"]; ?></font></div>
                <div class="task_move_arrows">
                    <a href="?task_move_right=<?php echo $task['id']; ?>" class="move_right_link">►</a>
                </div>
            </div>
        <?php }} ?>

        <form action="/?level=1" method="post" class="add-task-form">
            <input type="color" value="#00AAFF" name="taskcolor" class="add-task-color" />
            <input type="text" class="add-task-text" name="taskvalue" placeholder="<?php echo $lang[$langcode]["task_value"] ?>">
        </form>
        </div>
        <div class="div5 task-panel">
        <?php
        foreach ($tasks as $task) {
            if($task["level"] == 2) {
        ?>
            <div class="task-item" oncontextmenu="CopyToClipboardFunction(event, '<?php echo $task['value']; ?>')">
                <div style="background-color: <?php echo $task['color']; ?>;" class="task-item-color"></div>
                <a href="?task_delete=<?php echo $task['id']; ?>" class="remove_task_link">X</a>
                <div ondblclick="openEditPanel('<?php echo $task['id']; ?>', '<?php echo $task['value']; ?>', '<?php echo $task['color']; ?>')"><?php echo $task['value']; ?><br><font class="task-user-text"><?php echo $db->query("select * from users where id=".$task["userid"])->fetch()["username"]; ?></font></div>
                <div class="task_move_arrows">
                    <a href="?task_move_left=<?php echo $task['id']; ?>" class="move_left_link">◄</a> 
                    <a href="?task_move_right=<?php echo $task['id']; ?>" class="move_right_link">►</a>
                </div>
            </div>
        <?php }} ?>

        <form action="/?level=2" method="post" class="add-task-form">
            <input type="color" value="#00AAFF" name="taskcolor" class="add-task-color" />
            <input type="text" class="add-task-text" name="taskvalue" placeholder="<?php echo $lang[$langcode]["task_value"] ?>">
        </form>
        </div>
        <div class="div6 task-panel">
        <?php
        foreach ($tasks as $task) {
            if($task["level"] == 3) {
        ?>
            <div class="task-item" oncontextmenu="CopyToClipboardFunction(event, '<?php echo $task['value']; ?>')">
                <div style="background-color: <?php echo $task['color']; ?>;" class="task-item-color"></div>
                <a href="?task_delete=<?php echo $task['id']; ?>" class="remove_task_link">X</a>
                <div ondblclick="openEditPanel('<?php echo $task['id']; ?>', '<?php echo $task['value']; ?>', '<?php echo $task['color']; ?>')"><?php echo $task['value']; ?><br><font class="task-user-text"><?php echo $db->query("select * from users where id=".$task["userid"])->fetch()["username"]; ?></font></div>
                <div class="task_move_arrows">
                    <a href="?task_move_left=<?php echo $task['id']; ?>" class="move_left_link">◄</a> 
                </div>
            </div>
        <?php }} ?>

        <form action="/?level=3" method="post" class="add-task-form">
            <input type="color" value="#00AAFF" name="taskcolor" class="add-task-color" />
            <input type="text" class="add-task-text" name="taskvalue" placeholder="<?php echo $lang[$langcode]["task_value"] ?>">
        </form>
        </div>
    </div>
    <div class="user-data-div">
        <?php echo $_SESSION["username"]; ?> • <a href="settings.php"><?php echo $lang[$langcode]["settings"] ?></a> • <a href="logout.php"><?php echo $lang[$langcode]["logout"] ?></a>
    </div>
    <div id="announcement-button">
        <img src="src/announcement.png" alt="announcements">
    </div>
</body>
</html>

<?php include 'js.php';?>