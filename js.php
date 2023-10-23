<script>
    document.querySelector(".edit-task-panel-button").addEventListener("click", (event) => {
        document.querySelector(".edit-task-panel-back").style.visibility = "hidden";
    });

    function openEditPanel(filename, value){
        document.querySelector(".edit-task-panel-back").style.visibility = "visible";
        
        document.querySelector(".edit-task-textarea").innerHTML = value;
        document.querySelector("#edit-task-form").action = "?edit_task=" + filename;
    }
</script>