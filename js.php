<script>
    const config = {
        "backgroundColor": "rgb(210, 255, 255)",
        "randomColor": true
    };

    function randInt(minValue, maxValue) {
        return (minValue + Math.floor(Math.random() * (maxValue - minValue)));
    }
    let minRGB = 220;
    if(config.randomColor){
        config.backgroundColor = "rgb(" + randInt(minRGB, 255) + ", " + randInt(minRGB, 255) + ", " + randInt(minRGB, 255) + ")"; 
    }

    document.querySelector("body").style.backgroundColor = config.backgroundColor;

    document.querySelector(".edit-task-panel-button").addEventListener("click", (event) => {
        document.querySelector(".edit-task-panel-back").style.visibility = "hidden";
    });

    <?php
        if(!isset($_COOKIE['announcement_viewed'])){
            setcookie("announcement_viewed", " ", time() + 900);
    ?>
    document.querySelector("#announcements-panel-bg").style.visibility = "visible";
    <?php
        }
    ?>
    document.querySelector("#announcement-button").addEventListener("click", (event) => {
        if(document.querySelector("#announcements-panel-bg").style.visibility == "hidden")
            document.querySelector("#announcements-panel-bg").style.visibility = "visible";
        else
            document.querySelector("#announcements-panel-bg").style.visibility = "hidden";
    });

    function openEditPanel(filename, value, color){
        document.querySelector(".edit-task-panel-back").style.visibility = "visible";
        
        document.querySelector(".edit-task-textarea").innerHTML = value;
        document.querySelector("#edit-task-color").value = color;
        document.querySelector("#edit-task-form").action = "?edit_task=" + filename;
    }

    function CopyToClipboardFunction(e, text){
        e.preventDefault();
        navigator.clipboard.writeText(text);
    }
</script>