<?php
ob_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $index = ((int)file_get_contents("task-index.txt"));
    $indexfile = fopen("task-index.txt", "w") or die("Unable to open file!");

    fwrite($indexfile, ($index + 1));
    fclose($indexfile);

    $myfile = fopen($_GET["level"]."_".$index.".txt", "w") or die("Unable to open file!");
    fwrite($myfile, $_POST["taskvalue"]);
    fclose($myfile);

    header("Location: index.php");
}
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
    <div class="parent">
        <div class="div1 table-header">TO-DO</div>
        <div class="div2 table-header">Developing</div>
        <div class="div3 table-header">Completed</div>

        <div class="div4 task-panel">
        <?php
            $files = array_diff(scandir("./"), array('.', '..'));
            foreach ($files as $file) {
        ?>
                <?php
                    if(explode("_", $file)[0] == "1"){
                ?>
                    <div class="task-item"><?php echo file_get_contents($file); ?></div>
                <?php } ?>
        <?php } ?>
        </div>
        <div class="div5 task-panel">
        <?php
            $files = array_diff(scandir("./"), array('.', '..'));
            foreach ($files as $file) {
        ?>
                <?php
                    if(explode("_", $file)[0] == "2"){
                ?>
                    <div class="task-item"><?php echo file_get_contents($file); ?></div>
                <?php } ?>
        <?php } ?>
        </div>
        <div class="div6 task-panel">
        <?php
            $files = array_diff(scandir("./"), array('.', '..'));
            foreach ($files as $file) {
        ?>
                <?php
                    if(explode("_", $file)[0] == "3"){
                ?>
                    <div class="task-item"><?php echo file_get_contents($file); ?></div>
                <?php } ?>
        <?php } ?>
        </div>
    </div>
</body>
</html>
<script src="main.js"></script>