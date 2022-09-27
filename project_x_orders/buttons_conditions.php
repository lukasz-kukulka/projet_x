<?php
    function buttonsConditions( $results ) {
        
        if(isset($_POST['add_team'])) {
            addTeam();
        }
        if(isset($_POST['edit_team'])) {
            editTeam();
        }
        if(isset($_POST['confirm'])) {
            confirmAddTeam();
        }

        if ( count($results) != 100 && !isset($_POST['add_team']))
        {
            echo'<form method="post">
                <input type="submit" name="add_team" class="button" value="Dodaj drużynę">
            </form>';
            if ( isset($_POST['add_team']) )
            {
                header("Refresh:0");
            }
        }
    }
    buttonsConditions( $results );
?>