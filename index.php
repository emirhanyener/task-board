<?php
//Config
$langcode = "en";

//Localization
$lang = array(
    "en" => array(
        "todo" => "TO-DO",
        "in_progress" => "In Progress",
        "done" => "Done",
        "task_value" => "Task Value",
        "edit_task" => "Edit Task",
        "edit" => "Edit",
        "cancel" => "Cancel"
    ),
    "tr" => array(
        "todo" => "Yapılacaklar",
        "in_progress" => "Devam Ediyor",
        "done" => "Bitti",
        "task_value" => "Görev içeriği",
        "edit_task" => "Görevi Düzenle",
        "edit" => "Düzenle",
        "cancel" => "İptal Et"
    )
);

ob_start();

function addLog($message){
    //Update log timestamp(Default: 'Europe/Istanbul')
    date_default_timezone_set("Europe/Istanbul");
    
    $logfile = fopen("log.txt", "a") or die("Unable to open file!");
    fwrite($logfile, date("[d.m.Y H:i:s]", time()).$message."\n");
    fclose($logfile);
}

/////////////////////
//Start delete task//
/////////////////////
if(isset($_GET["task_delete"])){
    unlink($_GET["task_delete"]);
    addLog("delete task: ".$_GET["task_delete"]);
    header("Location: index.php");
}
///////////////////
//End delete task//
///////////////////

/////////////////////////
//Start move right task//
/////////////////////////
if(isset($_GET["task_move_right"])){
    rename($_GET["task_move_right"], (((int)explode("_", $_GET["task_move_right"])[0]) + 1)."_".explode("_", $_GET["task_move_right"])[1]);
    addLog("move right task: ".$_GET["task_move_right"]);
    header("Location: index.php");
}
///////////////////////
//End move right task//
///////////////////////

////////////////////////
//Start move left task//
////////////////////////
if(isset($_GET["task_move_left"])){
    rename($_GET["task_move_left"], (((int)explode("_", $_GET["task_move_left"])[0]) - 1)."_".explode("_", $_GET["task_move_left"])[1]);
    addLog("move left task: ".$_GET["task_move_left"]);
    header("Location: index.php");
}
//////////////////////
//End move left task//
//////////////////////

//////////////////
//Start add task//
//////////////////
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_GET["edit_task"])){
        $taskfile = fopen($_GET["edit_task"], "w") or die("Unable to open file!");
        fwrite($taskfile, $_POST["value"]);
        fclose($taskfile);

        header("Location: index.php");
    } else {
        $index = ((int)file_get_contents("task-index.txt"));
        $indexfile = fopen("task-index.txt", "w") or die("Unable to open file!");
    
        fwrite($indexfile, ($index + 1));
        fclose($indexfile);
    
        $myfile = fopen($_GET["level"]."_".$index.".txt", "w") or die("Unable to open file!");
        fwrite($myfile, $_POST["taskvalue"]);
        fclose($myfile);
        addLog("add task: ".($_GET["level"]."_".$index.".txt"));
    
        header("Location: index.php");
    }
}
////////////////
//End add task//
////////////////
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Task Table</title>
</head>
<body>
    <div class="edit-task-panel-back" style="visibility: hidden;">
        <div class="edit-task-panel">
            <form id="edit-task-form" action="" method="post">
                <h1><?php echo $lang[$langcode]["edit_task"] ?></h1>
                <textarea name="value" class="edit-task-textarea"></textarea>
                <div>
                    <input type="button" value="<?php echo $lang[$langcode]["cancel"] ?>" class="edit-task-panel-button"></button>
                    <button type="submit" class="edit-task-panel-button"><?php echo $lang[$langcode]["edit"] ?></button>
                </div>
            </form>
        </div>
    </div>
    <div class="parent">
        <div class="div1 table-header"><?php echo $lang[$langcode]["todo"] ?></div>
        <div class="div2 table-header"><?php echo $lang[$langcode]["in_progress"] ?></div>
        <div class="div3 table-header"><?php echo $lang[$langcode]["done"] ?></div>

        <div class="div4 task-panel">
        <?php
            $files = array_diff(scandir("./"), array('.', '..'));
            foreach ($files as $file) {
        ?>
                <?php
                    if(explode("_", $file)[0] == "1"){
                ?>
                    <div class="task-item">
                        <a href="?task_delete=<?php echo $file; ?>" class="remove_task_link">X</a>
                        <div ondblclick="openEditPanel('<?php echo $file; ?>', '<?php echo file_get_contents($file); ?>')"><?php echo file_get_contents($file); ?></div>
                        <div class="task_move_arrows">
                            <a href="?task_move_right=<?php echo $file; ?>" class="move_right_link">►</a>
                        </div>
                    </div>
                <?php } ?>
        <?php } ?>
        <form action="/?level=1" method="post">
            <input type="text" class="add-task-text" name="taskvalue" placeholder="<?php echo $lang[$langcode]["task_value"] ?>">
        </form>
        </div>
        <div class="div5 task-panel">
        <?php
            $files = array_diff(scandir("./"), array('.', '..'));
            foreach ($files as $file) {
        ?>
                <?php
                    if(explode("_", $file)[0] == "2"){
                ?>
                    <div class="task-item">
                        <a href="?task_delete=<?php echo $file; ?>" class="remove_task_link">X</a>
                        <div ondblclick="openEditPanel('<?php echo $file; ?>', '<?php echo file_get_contents($file); ?>')"><?php echo file_get_contents($file); ?></div>
                        <div class="task_move_arrows">
                            <a href="?task_move_left=<?php echo $file; ?>" class="move_left_link">◄</a> 
                            <a href="?task_move_right=<?php echo $file; ?>" class="move_right_link">►</a>
                        </div>
                    </div>
                <?php } ?>
        <?php } ?>
        <form action="/?level=2" method="post">
            <input type="text" class="add-task-text" name="taskvalue" placeholder="<?php echo $lang[$langcode]["task_value"] ?>">
        </form>
        </div>
        <div class="div6 task-panel">
        <?php
            $files = array_diff(scandir("./"), array('.', '..'));
            foreach ($files as $file) {
        ?>
                <?php
                    if(explode("_", $file)[0] == "3"){
                ?>
                    <div class="task-item">
                        <a href="?task_delete=<?php echo $file; ?>" class="remove_task_link">X</a>
                        <div ondblclick="openEditPanel('<?php echo $file; ?>', '<?php echo file_get_contents($file); ?>')"><?php echo file_get_contents($file); ?></div>
                        <div class="task_move_arrows">
                            <a href="?task_move_left=<?php echo $file; ?>" class="move_left_link">◄</a>
                        </div>
                    </div>
                <?php } ?>
        <?php } ?>
        <form action="/?level=3" method="post">
            <input type="text" class="add-task-text" name="taskvalue" placeholder="<?php echo $lang[$langcode]["task_value"] ?>">
        </form>
        </div>
    </div>
</body>
</html>

<?php include 'js.php';?>