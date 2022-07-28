<?php
    function buttonsConditions() {
        
        if(isset($_POST['add_team'])) {
            addTeam();
        }
        if(isset($_POST['edit_team'])) {
            editTeam();
        }
        if(isset($_POST['confirm'])) {
            confirmAddTeam();
        }
    }
?>