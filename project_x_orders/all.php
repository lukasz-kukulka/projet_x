<?php

    function refresh() {
        ?>
        <script type="text/javascript">
            window.location=window.location;
        </script>
        <?php
    }

    function getTeamResult() {
        global $wpdb;
        $user = wp_get_current_user()->display_name;
        $query = $wpdb->prepare("SELECT * FROM `project_x_team` WHERE `creator` = %s", $user );
        $results = $wpdb->get_results($query);
        return $results;
    }

    function getPlayerResult( $id_player ) {
        global $wpdb;
        $query = $wpdb->prepare("SELECT * FROM `project_x_trener_team` WHERE `id` = %s", $id_player );
        $results = $wpdb->get_results($query);
        return $results;
    }

    $team_results = getTeamResult();

    function printPlayers( $team ) {
        global $wpdb;
        $query = $wpdb->prepare("SELECT * FROM `project_x_trener_team` WHERE `team_id` = %s", $team->id );
        $player_results = $wpdb->get_results($query);
        if( count( $player_results ) == 0)
        {
            echo'<p style="text-align:center"><strong><span style="font-size:24px">Aktulanie nie posiadasz żadnych zawodników</span></strong></p>';
        }
        else
        {
            echo'<p style="text-align:center"><strong><span style="font-size:36px">Zawodnicy</span></strong></p>';
        }
        echo '<table>
            <tr><td>Numer koszulki</td><td>Imie</td><td>Nazwisko</td><td>Data urodzenia</td><td>PESEL</td><td></td><td></td></tr>';
        foreach ( $player_results as $player )
        {
            echo '
                <tr>
                    <td>'.$player->tshirt_number.'</td>
                    <td>'.$player->name.'</td>
                    <td>'.$player->surname.'</td>
                    <td>'.$player->dob.'</td>
                    <td>'.$player->pesel.'</td>
                    <form method="post">
                    <td><input type="submit" name="edit_player" class="button" value = "Edytuj"/></td>
                    <td><input type="submit" name="delete_player" class="button" value = "Usuń"/></td>
                    <input type="hidden" name="id_player" value="'.$player->id.'"/>
                    </form>
                </tr>';
            
        }
        echo '</table>';
    }

    function printTeam( $team_results ) {
        if ( count( $team_results ) == 0 )
        {
            echo'<p style="text-align:center"><strong><span style="font-size:24px">Aktulanie nie posiadasz żadnej drużyny</span></strong></p>';
        }
        else
        {
            echo'<p style="text-align:center"><strong><span style="font-size:36px">Drużyna</span></strong></p>';
        }
        
        foreach ( $team_results as $page )
        {
            echo '<table>
            <tr><td>Data utworzenia drużyny :</td> <td>'.$page->create_date.'</td><td rowspan="0"> 
            <form method="post">
            <input type="hidden" name="id" value="'.$page->id.'"/>
            <input type="submit" name="edit_team" class="button" value = "Edytuj"/><br/>
            <input type="submit" name="delete" class="button" value = "Usuń"/><br/>
            <input type="submit" name="add_player" class="button" value = "Dodaj zawodnika"/><br/>
            <input type="submit" name="generate_raport" class="button" value = "Generuj raport"/><br/>
            </form>
            </td></tr>
            <tr><td>Nazwa drużyny</td> <td>'.$page->team. '</td></tr>
            <tr><td>Nazwa klubu :</td> <td>'.$page->club.'</td></tr>
            <tr><td>Imię i nazwisko trenera :</td> <td>'.$page->coach.'</td></tr>
            <tr><td>Imię i nazwisko menagera :</td> <td>'.$page->manager.'</td></tr>
            <tr><td>Imię i nazwisko kierownika :</td> <td>'.$page->director.'</td></tr>
            </table><br/><br/>';
            if ( $team_results > 0 )
            {
                printPlayers( $page );
            }
            
        }
    }

    printTeam( $team_results );

    function addTeam() {
        $user = wp_get_current_user()->display_name;
        echo '<form method="post">';
        echo '<br /><br />Nazwa drużyny<input type="text" name="team" value=""/> <br />';
        echo '<br /><br />Nazwa klubu<input type="text" name="club" value="" /> <br />';
        echo '<br /><br />Podaj imie i nazwisko trenera<input type="text" name="coach" value="'.$user.'"/> <br />';
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
        $coach = $user;
        if ( isset($_POST['coach']) ) {
            $coach = $_POST['coach'];
        }

        $wpdb->insert($table_name, array(
            'id' => NULL, 
            'team' => $_POST['team'], 
            'club' => $_POST['club'],
            'create_date' => $date, 
            'edit_date' => $date,
            'creator' => $user,
            'coach' => $coach,
            'manager' => $_POST['manager'],
            'director' => $_POST['director'])); 
        refresh();
        

    }

    function editTeam( $team_results ) {
        foreach ( $team_results as $page )
        {
            echo '<form method="post">';
            echo '<input type="hidden" name="id" value="'.$page->id.'"/>';
            echo '<br /><br />Nazwa drużyny<input type="text" name="team" value="'.$page->team.'"/> <br />';
            echo '<br /><br />Nazwa klubu<input type="text" name="club" value="'.$page->club.'" /> <br />';
            echo '<br /><br />Podaj imie i nazwisko trenera<input type="text" name="coach" value="'.$page->coach.'"/> <br />';
            echo '<br /><br />Podaj imie i nazwisko menagera<input type="text" name="manager" value="'.$page->manager.'"/> <br />';
            echo '<br /><br />kierownika<input type="text" name="director" value="'.$page->director.'"/> <br />';
            echo '<input type="submit" name="confirm_edit_team" class="button" value = "Potwierdz wprowadzone zmiany"/>';
            echo '<input type="submit" name="cancel_refresh" class="button" value = "Anuluj"/>';
            echo '</form>';
        }
    }

    function confirmEditTeam( $team_results ) {
        $id_team = 0;
        global $wpdb;
        $table_name =  'project_x_team'; 
        $team_name = $_POST['team'];
        $club = $_POST['club'];
        $edit_date = date('Y-m-d H:i:s');
        $coach = $_POST['coach'];
        $manager = $_POST['manager'];
        $director = $_POST['director'];
        $id = $_POST['id'];
        $wpdb->update( $table_name, 
                      array( 'team' => $team_name, 
                             'club' => $club,
                             'edit_date' => $edit_date,
                             'coach' => $coach,
                             'manager' => $manager,
                             'director' => $director
                      ), 
                      array( 'id' => $id ) );
        refresh();
    }

    function deleteTeam() {
        $id_team = $id = $_POST['id'];
        echo '<form method="post">';
        echo '<input type="hidden" name="id" value="'.$id_team.'"/>';
        echo '<table><tr>
                <td>Jesteś pewien że chcesz usunąć drużynę ze wszystkimi zawodnikami?</td> 
                <td><input type="submit" name="confirm_delete_team" class="button" value = "Usuń"/>
                    <input type="submit" name="cancel_refresh" class="button" value = "Anuluj"/></td>
            </tr></table>';
        echo '</form>';
    }

    function confirmDeleteTeam( $team_results ) {
        $id_team = 0;
        global $wpdb;
        $wpdb->delete( 'project_x_team', array( 'id' => $_POST['id'] ) );
        refresh();
    }

    function addPlayer () {
        echo '<form method="post">';
        echo '<input type="hidden" name="id_team" value="'.$_POST['id'].'"/>';
        echo '<br /><br />Imię gracza<input type="text" name="player_name" value="Imie"/> <br />';
        echo '<br /><br />Nazwisko gracza<input type="text" name="player_surname" value="Nazwisko"/> <br />';
        echo '<br /><br />Numer koszulki<input type="text" name="tshirt_number" value="0"/> <br />';
        echo '<br /><br />Data urodzenia w formacie: RRRR-MM-DD <input type="text" name="dob_player" value="2020-01-01"/> <br />';
        echo '<br /><br />Numer PESEL<input type="text" name="pesel" value="45020277898"/> <br />';
        echo '<input type="submit" name="confirm_add_player" class="button" value = "Dodaj zawodnika"/>';
        echo '<input type="submit" name="cancel_refresh" class="button" value = "Anuluj"/>';
        echo '</form>';
    }

    function confirmAddPlayer ( $team_results ) {
        global $wpdb;
        $table_name = 'project_x_trener_team'; 
        $date = date('Y-m-d H:i:s');
        $wpdb->insert($table_name, array(
            'id' => NULL, 
            'create_date' => $date, 
            'edit_date' => $date, 
            'name' => $_POST['player_name'], 
            'surname' => $_POST['player_surname'],
            'dob' => $_POST['dob_player'],
            'pesel' => $_POST['pesel'],
            'tshirt_number' => $_POST['tshirt_number'],
            'is_player_exist' => NULL,
            'id_existing_account' => 0, 
            'is_player' => NULL, 
            'is_coach' => NULL, 
            'is_director' => NULL, 
            'is_manager' => NULL,
            'team_id' => $_POST['id_team']
            ) ); 
        refresh();        
    }

    function editPlayer() {
        $players = getPlayerResult( $_POST['id_player'] );

        foreach ( $players as $player )
        {
            echo '<form method="post">';
            echo '<input type="hidden" name="id_player" value="'.$_POST['id_player'].'"/>';
            echo '<br /><br />Imię<input type="text" name="player_name" value="'.$player->name.'"/> <br />';
            echo '<br /><br />Nazwisko<input type="text" name="player_surname" value="'.$player->surname.'" /> <br />';
            echo '<br /><br />Numer koszulki<input type="text" name="tshirt_number" value="'.$player->tshirt_number.'"/> <br />';
            echo '<br /><br />Data urodzenia<input type="text" name="dob_player" value="'.$player->dob.'"/> <br />';
            echo '<br /><br />Pesel<input type="text" name="pesel" value="'.$player->pesel.'"/> <br />';
            echo '<input type="submit" name="confirm_edit_player" class="button" value = "Potwierdz wprowadzone zmiany"/>';
            echo '<input type="submit" name="cancel_refresh" class="button" value = "Anuluj"/>';
            echo '</form>';
        }
        
    }

    function confirmEditPlayer() {
        global $wpdb;
        $table_name = 'project_x_trener_team'; 
        $date = date('Y-m-d H:i:s');
        $wpdb->update( $table_name, 
                      array( 'name' => $_POST['player_name'], 
                             'surname' => $_POST['player_surname'],
                             'dob' => $_POST['dob_player'],
                             'pesel' => $_POST['pesel'],
                             'tshirt_number' => $_POST['tshirt_number']
                      ), 
                      array( 'id' => $_POST['id_player'] ) );
        refresh();
    }

    function deletePlayer() {
        echo '<form method="post">';
        echo '<input type="hidden" name="id_player" value="'.$_POST['id_player'].'"/>';
        echo '<table><tr>
                <td>Jesteś pewien że chcesz usunąć drużynę ze wszystkimi zawodnikami?</td> 
                <td><input type="submit" name="confirm_delete_player" class="button" value = "Usuń zawodnika"/>
                    <input type="submit" name="cancel_refresh" class="button" value = "Anuluj"/></td>
            </tr></table>';
        echo '</form>';
    }

    function confirmDeletePlayer() {
        global $wpdb;
        $wpdb->delete( 'project_x_trener_team', array( 'id' => $_POST['id_player'] ) );
        refresh();
    }

    function buttonsConditions( $team_results ) {
        if(isset($_POST['confirm'])) {
            confirmAddTeam();
        }
        if(isset($_POST['edit_team'])) {
            editTeam( $team_results );
        }
        if(isset($_POST['confirm_edit_team'])) {
            confirmEditTeam( $team_results );
        }
        if(isset($_POST['delete'])) {
            deleteTeam();
        }
        if(isset($_POST['confirm_delete_team'])) {
            confirmDeleteTeam( $team_results );
        }
        if(isset($_POST['confirm_add_player'])) {
            confirmAddPlayer ( $team_results );
        }
        if(isset($_POST['add_player'])) {
            addPlayer();
        }
        if(isset($_POST['edit_player'])) {
            editPlayer();
        }
        if(isset($_POST['delete_player'])) {
            deletePlayer();
        }
        if(isset($_POST['confirm_edit_player'])) {
            confirmEditPlayer();
        }
        if(isset($_POST['confirm_delete_player'])) {
            confirmDeletePlayer();
        }
        if(isset($_POST['cancel_refresh'])) {
            refresh();
        }

        if ( count($team_results) < 1 )
        {
            if ( isset($_POST['add_team']) )
            {
                echo 'add team -> buttons ';
                header("Refresh:0");
                addTeam();
            }
            else
            {
                echo'<form method="post">
                    <input type="submit" name="add_team" class="button" value="Dodaj drużynę">
                </form>';
            }
            
        }
    }

    buttonsConditions( $team_results );

?>