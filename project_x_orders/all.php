<?php

    function getTeamResult() {
        global $wpdb;
        $user = wp_get_current_user()->display_name;
        $query = $wpdb->prepare("SELECT * FROM `project_x_team` WHERE `kreator` = %s", $user );
        $results = $wpdb->get_results($query);
        return $results;
    }

    $team_results = getTeamResult();

    function getTeam( $team_results ) {
        foreach ( $team_results as $page )
        {
            echo '<table>
            <tr><td>Data utworzenia drużyny :</td> <td>'.$page->data_utworzenia.'</td><td rowspan="0"> 
            <form method="post">
            <input type="submit" name="edit_team" class="button" value = "Edytuj"/><br/>
            <input type="submit" name="delete" class="button" value = "Usuń"/><br/>
            <input type="submit" name="add_player" class="button" value = "Dodaj zawodnika"/><br/>
            <input type="submit" name="generate_raport" class="button" value = "Generuj raport"/><br/>
            </form>
            </td></tr>
            <tr><td>Nazwa drużyny</td> <td>'.$page->druzyna. '</td></tr>
            <tr><td>Nazwa klubu :</td> <td>'.$page->klub.'</td></tr>
            <tr><td>Imię i nazwisko trenera :</td> <td>'.$page->trener.'</td></tr>
            <tr><td>Imię i nazwisko menagera :</td> <td>'.$page->menager.'</td></tr>
            <tr><td>Imię i nazwisko kierownika :</td> <td>'.$page->kierownik.'</td></tr>
            </table><br/><br/>';
        }
    }

	getTeam( $team_results );

    function addTeam() {
        $user = wp_get_current_user()->display_name;
        echo '<form method="post">';
        echo '<br /><br />Nazwa drużyny<input type="text" name="team" value=""/> <br />';
        echo '<br /><br />Nazwa klubu<input type="text" name="club" value="" /> <br />';
        echo '<br /><br />Podaj imie i nazwisko trenera<input type="text" name="trener" value="'.$user.'"/> <br />';
        echo '<br /><br />Podaj imie i nazwisko menagera<input type="text" name="manager" value="'.$user.'"/> <br />';
        echo '<br /><br />kierownika<input type="text" name="director" value="'.$user.'"/> <br />';
        echo '<input type="submit" name="confirm" class="button" value = "Dodaj"/>';
        echo '</form>';
    }
    
    function confirmAddTeam() {
        global $wpdb;
        $table_name =  'project_x_team'; 
        $user = wp_get_current_user()->display_name;
        $date = date('Y-m-d H:i:s');
        $trener = $user;
        if ( isset($_POST['trener']) ) {
            $trener = $_POST['trener'];
        }

        $wpdb->insert($table_name, array(
            'id' => NULL, 
            'druzyna' => $_POST['team'], 
            'klub' => $_POST['club'],
            'data_utworzenia' => $date,
            'kreator' => $user,
            'trener' => $trener,
            'menager' => $_POST['manager'],
            'kierownik' => $_POST['director'])); 

        $wpdb->show_errors();
        header("Refresh:0");
    }

    function editTeam( $team_results ) {
        foreach ( $team_results as $page )
        {
            echo '<form method="post">';
            echo '<br /><br />Nazwa drużyny<input type="text" name="team" value="'.$page->druzyna.'"/> <br />';
            echo '<br /><br />Nazwa klubu<input type="text" name="club" value="'.$page->klub.'" /> <br />';
            echo '<br /><br />Podaj imie i nazwisko trenera<input type="text" name="trener" value="'.$page->trener.'"/> <br />';
            echo '<br /><br />Podaj imie i nazwisko menagera<input type="text" name="manager" value="'.$page->menager.'"/> <br />';
            echo '<br /><br />kierownika<input type="text" name="director" value="'.$page->kierownik.'"/> <br />';
            echo '<input type="submit" name="confirm_edit_team" class="button" value = "Potwierdz wprowadzone zmiany"/>';
            echo '</form>';
        }
    }

    function confirmEditTeam( $team_results ) {
        $id_team = 0;
        global $wpdb;

        foreach ( $team_results as $page )
        { 
            $id_team = $page->id;
        }
        
        $table_name =  'project_x_team'; 
        $team_name = $_POST['team'];
        $club = $_POST['club'];
        $edit_date = date('Y-m-d H:i:s');
        $trener = $_POST['trener'];
        $menager = $_POST['manager'];
        $kierownik = $_POST['director'];
        $wpdb->update( $table_name, 
                      array( 'druzyna' => $team_name, 
                             'klub' => $club,
                             'edit_date' => $edit_date,
                             'trener' => $trener,
                             'menager' => $menager,
                             'kierownik' => $kierownik
                      ), 
                      array( 'id' => $id_team ) );
        header("Refresh:0");
    }

    function deleteTeam( $team_results ) {
        echo '<form method="post">';
        echo '<table><tr>
                <td>Jesteś pewien że chcesz usunąć drużynę ze wszystkimi zawodnikami?</td> 
                <td><input type="submit" name="confirm_delete_team" class="button" value = "Usuń"/>
                    <input type="submit" name="cancel_delete_team" class="button" value = "Anuluj"/></td>
            </tr></table>';
        echo '</form>';
    }

    function confirmDeleteTeam( $team_results ) {
        global $wpdb;
        $id_team = 0;

        foreach ( $team_results as $page )
        { 
            $id_team = $page->id;
        }

        $wpdb->delete( 'project_x_team', array( 'id' => $id_team) );
        header("Refresh:0");
    }

    function addPlayer ( $team_results ) {
        
    }

    function buttonsConditions( $team_results ) {
        if(isset($_POST['add_team'])) {
            addTeam();
        }
        if(isset($_POST['edit_team'])) {
            editTeam( $team_results );
        }
        if(isset($_POST['delete'])) {
            deleteTeam( $team_results );
        }
        if(isset($_POST['confirm'])) {
            confirmAddTeam( $team_results );
        }
        if(isset($_POST['confirm_edit_team'])) {
            confirmEditTeam( $team_results );
        }
        if(isset($_POST['confirm_delete_team'])) {
            confirmDeleteTeam( $team_results );
        }
        if(isset($_POST['cancel_delete_team'])) {
            header("Refresh:0");
        }

        if ( count($team_results) != 1 && 
             !isset($_POST['add_team']) && 
             !isset($_POST['edit_team']) &&
             !isset($_POST['confirm']) &&
             !isset($_POST['delete']) &&
             !isset($_POST['confirm_delete_team']) &&
             !isset($_POST['cancel_delete_team']) &&
             !isset($_POST['confirm_edit_team']) )
        {
            echo'<form method="post">
                <input type="submit" name="add_team" class="button" value="Dodaj drużynę">
            </form>';
            if ( isset($_POST['add_team']) )
            {
                header("Refresh:0");
                addTeam();
            }
        }
    }

    buttonsConditions( $team_results );


?>