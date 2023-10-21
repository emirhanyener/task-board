<script>
    for (let index = 0; index < document.getElementsByClassName("task-panel").length; index++) {
        document.getElementsByClassName("task-panel")[index].innerHTML += '<form action="/?level=' + (index + 1) +'" method="post"><input type="text" class="add-task-text" name="taskvalue" placeholder="<?php echo $lang[$langcode]["task_value"] ?>"></form>';
    }
</script>