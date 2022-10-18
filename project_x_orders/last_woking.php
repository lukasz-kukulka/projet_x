<?php


if ( is_user_logged_in() ){ 

    $base_players_numbers = 0;
    $reserve_players_numbers = 0;

    $error_message = "";

    function wpse16119876_init_session() {
        if ( ! session_id() ) {
            session_start();
        }
    }
    add_action( 'init', 'wpse16119876_init_session' );

    function checkInjection( $text ) {
        global $wpdb;
        $text = htmlentities( $text, ENT_QUOTES, "UFT-8" );
        return $wpdb->_real_escape( $text );
    }

    function resetErrorMessage() {
        global $error_message;
        $error_message = "";
    }

    function validationTeamName( $name ) {
        global $error_message;
        if ( !ctype_alpha( $name ) )
        {
            $error_message = $error_message."</br>Nieprawidłowa nazwa, akceptowalne tylko litery alfabetu";
        }
    }

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

    function printPlayers( $team_id ) {
        global $wpdb;
        $query = $wpdb->prepare("SELECT * FROM `project_x_trener_team` WHERE `team_id` = %s", $team_id );
        $player_results = $wpdb->get_results($query);
        if( count( $player_results ) == 0)
        {
            echo'<p style="text-align:center"><strong><span style="font-size:24px">Aktulanie nie posiadasz żadnych zawodników</span></strong></p>';
        }
        else
        {
            echo'<p style="text-align:center"><strong><span style="font-size:36px">Zawodnicy</span></strong></p>';
        }
        echo '</br>';
        printBasePlayers( $player_results );
        printReservePlayers( $player_results );
        printOthersPlayers( $player_results );
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
            <input type="hidden" name="team_name" value="'.$page->club.'"/>
            <input type="hidden" name="coach" value="'.$page->coach.'"/>
            <input type="hidden" name="director" value="'.$page->director.'"/>
            <input type="hidden" name="coach_license" value="'.$page->coach_license.'"/>
            <input type="hidden" name="second_coach" value="'.$page->second_coach.'"/>
            <input type="hidden" name="masseur" value="'.$page->masseur.'"/>
            <input type="hidden" name="doctor" value="'.$page->doctor.'"/>
            <input type="submit" name="edit_team" class="button" value = "Edytuj"/><br/>
            <input type="submit" name="delete" class="button" value = "Usuń"/><br/>
            <input type="submit" name="add_player" class="button" value = "Dodaj zawodnika"/><br/>
            <input type="submit" name="generate_raport" class="button" value = "Generuj protokół"/><br/>
            </form>
            </td></tr>
            <tr><td>Nazwa drużyny</td> <td>'.$page->team. '</td></tr>
            <tr><td>Nazwa klubu :</td> <td>'.$page->club.'</td></tr>
            <tr><td>Imię i nazwisko trenera :</td> <td>'.$page->coach.'</td></tr>
            <tr><td>Numer licencji trenera :</td> <td>'.$page->coach_license.'</td></tr>
            <tr><td>Imię i nazwisko drugiego trenera :</td> <td>'.$page->second_coach.'</td></tr>
            <tr><td>Imię i nazwisko masażysty :</td> <td>'.$page->masseur.'</td></tr>
            <tr><td>Imię i nazwisko lekarza :</td> <td>'.$page->doctor.'</td></tr>
            <tr><td>Imię i nazwisko menagera :</td> <td>'.$page->manager.'</td></tr>
            <tr><td>Imię i nazwisko kierownika :</td> <td>'.$page->director.'</td></tr>
            </table><br/><br/>';
            if ( $team_results > 0 )
            {
                printPlayers( $page->id );
            }
        }
    }

    function addTeam() {
        $user = wp_get_current_user()->display_name;
        echo '<form method="post">';
        echo '<br /><br />Nazwa drużyny<input type="text" name="team" value=""/> <br />';
        echo '<br /><br />Nazwa klubu<input type="text" name="club" value="" /> <br />';
        echo '<br /><br />Podaj nazwisko i imie trenera<input type="text" name="coach" value="'.$user.'"/> <br />';
        echo '<br /><br />Podaj numer licencji trenera<input type="text" name="coach_license" value=""/> <br />';
        echo '<br /><br />Podaj nazwisko i imie drugiego trenera<input type="text" name="second_coach" value=""/> <br />';
        echo '<br /><br />Podaj nazwisko i imie masażysty<input type="text" name="masseur" value=""/> <br />';
        echo '<br /><br />Podaj nazwisko i imie lekarza<input type="text" name="doctor" value=""/> <br />';
        echo '<br /><br />Podaj nazwisko i imie menagera<input type="text" name="manager" value="'.$user.'"/> <br />';
        echo '<br /><br />Podaj nazwisko i imie kierownika<input type="text" name="director" value="'.$user.'"/> <br />';
        echo '<input type="submit" name="confirm" class="button" value = "Dodaj"/>';
        echo '</form>';
    }
    
    function confirmAddTeam() {
        global $wpdb;
        $table_name =  'project_x_team'; 
        $user = wp_get_current_user()->display_name;
        validationTeamName( $_POST['team'] );
        $date = date('Y-m-d H:i:s');
        $coach = $user;
        if ( isset($_POST['coach']) ) {
            $coach = $_POST['coach'];
        }

        $wpdb->insert($table_name, array(
            'id' => NULL, 
            'team' => checkInjection( $_POST['team'] ), 
            'club' => checkInjection( $_POST['club'] ),
            'create_date' => $date, 
            'edit_date' => $date,
            'creator' => $user,
            'coach' => $coach,
            'coach_license' => checkInjection( $_POST['coach_license'] ),
            'second_coach' => checkInjection( $_POST['second_coach'] ),
            'masseur' => checkInjection( $_POST['masseur'] ),
            'doctor' => checkInjection( $_POST['doctor'] ),
            'manager' => checkInjection( $_POST['manager'] ),
            'director' => checkInjection( $_POST['director']) ) ); 
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
            echo '<br /><br />Podaj numer licencji trenera<input type="text" name="coach_license" value="'.$page->coach_license.'"/> <br />';
            echo '<br /><br />Podaj nazwisko i imie drugiego trenera<input type="text" name="second_coach" value="'.$page->second_coach.'"/> <br />';
            echo '<br /><br />Podaj nazwisko i imie masażysty<input type="text" name="masseur" value="'.$page->masseur.'"/> <br />';
            echo '<br /><br />Podaj nazwisko i imie lekarza<input type="text" name="doctor" value="'.$page->doctor.'"/> <br />';
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
        $edit_date = date('Y-m-d H:i:s');
        $wpdb->update( $table_name, 
                      array( 'team' => checkInjection( $_POST['team'] ), 
                             'club' => checkInjection( $_POST['club'] ),
                             'edit_date' => $edit_date,
                             'coach' => checkInjection( $_POST['coach'] ),
                             'coach_license' => checkInjection( $_POST['coach_license'] ),
                             'second_coach' => checkInjection( $_POST['second_coach'] ),
                             'masseur' => checkInjection( $_POST['masseur'] ),
                             'doctor' => checkInjection( $_POST['doctor'] ),
                             'manager' => checkInjection( $_POST['manager'] ),
                             'director' => checkInjection( $_POST['director'] ),
                      ), 
                      array( 'id' => $_POST['id'] ) );
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
        echo '<br /><br />Numer koszulki<input type="text" name="tshirt_number" value="0" size="2"/> <br />';
        echo '<br /><br />Data urodzenia: <input type="date" name="dob_player" min="1950-01-02"/> <br />';
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
            'name' => checkInjection( $_POST['player_name'] ), 
            'surname' => checkInjection( $_POST['player_surname'] ),
            'dob' => date("d/m/y", strtotime( checkInjection( $_POST['dob_player'] ))),
            'tshirt_number' => checkInjection( $_POST['tshirt_number'] ),
            'is_player_exist' => NULL,
            'id_existing_account' => 0, 
            'is_player' => NULL, 
            'is_coach' => NULL, 
            'is_director' => NULL, 
            'is_manager' => NULL,
            'team_id' => checkInjection( $_POST['id_team'] ),
            'category' => 'none'
            ) ); 
        refresh();        
    }

    function editPlayer() {
        $players = getPlayerResult( $_POST['player_id'] );

        foreach ( $players as $player )
        {
            echo '<form method="post">';
            echo '<input type="hidden" name="id_player" value="'.$_POST['player_id'].'"/>';
            echo '<br /><br />Imię<input type="text" name="player_name" value="'.$player->name.'"/> <br />';
            echo '<br /><br />Nazwisko<input type="text" name="player_surname" value="'.$player->surname.'" /> <br />';
            echo '<br /><br />Numer koszulki<input type="text" name="tshirt_number" value="'.$player->tshirt_number.'"/> <br />';
            echo '<br /><br />Data urodzenia<input type="text" name="dob_player" value="'.$player->dob.'"/> <br />';
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
                      array( 'edit_date' => $date,
                             'name' => checkInjection( $_POST['player_name'] ), 
                             'surname' => checkInjection( $_POST['player_surname'] ),
                             'dob' => checkInjection( $_POST['dob_player'] ),
                             'tshirt_number' => checkInjection( $_POST['tshirt_number'] )
                      ), 
                      array( 'id' => $_POST['id_player'] ) );
        refresh();
    }

    function deletePlayer() {
        echo '<form method="post">';
        echo '<input type="hidden" name="id_player" value="'.$_POST['player_id'].'"/>';
        echo '<table><tr>
                <td>Jesteś pewien że chcesz usunąć?</td> 
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
    
    function generateVariableForRaport( $separator_generate_data ) {
        global $wpdb;
        $query = $wpdb->prepare("SELECT * FROM `project_x_trener_team` WHERE `team_id` = %s", $_POST['id']);
        $players_results = $wpdb->get_results($query);
        $distance_between_name_char = 4.0;
        $players_array = array();

        foreach ( $players_results as $player ) {
            $player_name = $player->category.$separator_generate_data.$player->tshirt_number.$separator_generate_data.$player->surname.' '.$player->name.$separator_generate_data.$player->dob.$separator_generate_data;
            array_push($players_array, $player_name);
        }

        return $players_array;
    }

    function printBasePlayers( $players_results ) {
        global $base_players_numbers;
        $base_players_num = 1;
        echo'<p style="text-align:center"><strong><span style="font-size:24px">Skład podstawowy</span></strong></p>';
        echo '<table>
                <tr><td>   </td><td>Numer </br>koszulki</td><td>Imie</td><td>Nazwisko</td><td>Data </br>urodzenia</td><td>   </td><td>   </td><td>   </td></tr>';
            foreach ( $players_results as $player )
            {
                if ( $player->category == 'base' )
                {
                    echo '
                    <tr><form method="post">
                        <td>'.$base_players_num++.'</td>
                        <td>'.$player->tshirt_number.'</td>
                        <td>'.$player->name.'</td>
                        <td>'.$player->surname.'</td>
                        <td>'.$player->dob.'</td>
                        <input type="hidden" name="player_id" value="'.$player->id.'"/>
                        <input type="hidden" name="id" value="'.$_POST['id'].'"/>
                        <td><input type="submit" name="edit_player" class="button" value = "Edytuj"/></td>
                        <td><input type="submit" name="delete_player" class="button" value = "Usuń"/></td>
                        <td><input type="submit" name="del_from_base_team" class="button" value = "Usuń z podstawowego składu"/></td>
                        
                        </form></tr>';
                }
            }
        echo '</table>';
        echo'</br>';
        $base_players_numbers = $base_players_num;
    }

    function printReservePlayers( $players_results ) {
        global $reserve_players_numbers;
        $reserve_players_num = 1;
        echo'<p style="text-align:center"><strong><span style="font-size:24px">Skład rezerwowy</span></strong></p>';
        echo '<table>
                <tr><td>   </td><td>Numer </br>koszulki</td><td>Imie</td><td>Nazwisko</td><td>Data </br>urodzenia</td><td>   </td><td>   </td><td>   </td></tr>';
            foreach ( $players_results as $player )
            {
                if ( $player->category == 'reserve' )
                {
                    echo '<tr><form method="post">
                            <td>'.$reserve_players_num++.'</td>
                            <td>'.$player->tshirt_number.'</td>
                            <td>'.$player->name.'</td>
                            <td>'.$player->surname.'</td>
                            <td>'.$player->dob.'</td>
                            <input type="hidden" name="player_id" value="'.$player->id.'"/>
                            <input type="hidden" name="id" value="'.$_POST['id'].'"/>
                            <td><input type="submit" name="edit_player" class="button" value = "Edytuj"/></td>
                            <td><input type="submit" name="delete_player" class="button" value = "Usuń"/></td>
                            <td><input type="submit" name="del_from_reserve_team" class="button" value = "Usuń ze składu rezerwowego"/></td>
                        
                        </form></tr>';
                }
            }
        echo '</table>';
        echo'</br>';
        $reserve_players_numbers = $reserve_players_num;
    }

    function printOthersPlayers($players_results) {
        global $base_players_numbers;
        global $reserve_players_numbers;
        $others_players = 1;
        echo'<p style="text-align:center"><strong><span style="font-size:24px">Pozostali</span></strong></p>';
        echo '<table><tr><td>   </td><td>Numer </br>koszulki</td><td>Imie</td><td>Nazwisko</td><td>Data </br>urodzenia</td><td>   </td><td>   </td>';
        if ( $base_players_numbers <= 11 )
        {
            echo '<td></td>';
        }
        if ( $reserve_players_numbers <= 7 )
        {
            echo '<td></td>';
        }
        echo '</tr>';
        foreach ( $players_results as $player )
        {
            if ( $player->category != 'reserve' && $player->category != 'base')
            {
                echo '<tr><form method="post"><td>'.$others_players++.'</td><td>'.$player->tshirt_number.'</td><td>'.$player->name.'</td><td>'.$player->surname.'</td><td>'.$player->dob.'</td>';
                echo '<input type="hidden" name="player_id" value="'.$player->id.'"/>';
                echo '<input type="hidden" name="id" value="'.$_POST['id'].'"/>';
                echo '<td><input type="submit" name="edit_player" class="button" value = "Edytuj"/></td>';
                echo '<td><input type="submit" name="delete_player" class="button" value = "Usuń"/></td>';
                if ( $base_players_numbers <= 11 )
                {
                    echo '<td><input type="submit" name="add_to_base_team" class="button" value = "Dodaj do podstawowego"/></td>';
                }
                if ( $reserve_players_numbers <= 7 )
                {
                    echo '<td><input type="submit" name="add_to_reserve_team" class="button" value = "Dodaj do rezerwowego"/></td></tr>';
                }
                echo '</form>';
            }
            
        }
        echo '</table>';
        echo'</br>';
    }

    function generateRaportSummary() {
        global $wpdb;
        $separator_generate_data = "|";
        $query = $wpdb->prepare("SELECT * FROM `project_x_trener_team` WHERE `team_id` = %s", $_POST['id'] );
        $players_results = $wpdb->get_results($query);
        $generate_data = generateVariableForRaport( $separator_generate_data );

        echo '<tr><form action="../generate_raport.php" method="post">';
        $base_players_num = 1;

        echo '<p style="text-align:center"><label><input type="radio" id="raport" name="raport_type" value="goscie" checked="checked" ><strong><span style="font-size:24px"> Protokół dla gości </span></strong></label>';
        echo '<label><input type="radio" id="raport" name="raport_type" value="gospodarze"><strong><span style="font-size:24px"> Protokół dla gospodarzy</span></strong></label></p>';        

        echo '<br />Data meczu w formacie DD-MM-RR<input type="text" name="event_date" value="01-01-23"/><br />';
        echo '<br />Nazwisko i imie trenera<input type="text" name="coach" value="'.$_POST['coach'].'"/> <br />';
        echo '<br />Numer licencji trenera<input type="text" name="coach_license" value="'.$_POST['coach_license'].'"/> <br />';
        echo '<br />Nazwisko i imie drugiego trenera<input type="text" name="second_coach" value="'.$_POST['second_coach'].'"/> <br />';
        echo '<br />Nazwisko i imie masażysty<input type="text" name="masseur" value="'.$_POST['masseur'].'"/> <br />';
        echo '<br />Nazwisko i imie lekarza<input type="text" name="doctor" value="'.$_POST['doctor'].'"/> <br />';
        echo '<br />Nazwisko i imie kierownika<input type="text" name="director" value="'.$_POST['director'].'"/> <br />';

        echo'<table><tr><td colspan="5"><p style="text-align:center"><strong><span style="font-size:24px">Skład podstawowy</span></strong></p></td></tr>';
        echo '<tr><td>   </td><td>Numer koszulki</td><td>Imie</td><td>Nazwisko</td><td>Data urodzenia</td></tr>';
            foreach ( $players_results as $player )
            {
                if ( $player->category == 'base' )
                {
                    echo '
                        <td>'.$base_players_num++.'</td>
                        <td>'.$player->tshirt_number.'</td>
                        <td>'.$player->name.'</td>
                        <td>'.$player->surname.'</td>
                        <td>'.$player->dob.'</td>
                        </tr>';
                }
            }
        echo'</br>';

        $reserve_players_num = 1;
        echo'<tr><td colspan="5"><p style="text-align:center"><strong><span style="font-size:24px">Skład rezerwowy</span></strong></p></td></tr>';
            foreach ( $players_results as $player )
            {
                if ( $player->category == 'reserve' )
                {
                    echo '
                            <td>'.$reserve_players_num++.'</td>
                            <td>'.$player->tshirt_number.'</td>
                            <td>'.$player->name.'</td>
                            <td>'.$player->surname.'</td>
                            <td>'.$player->dob.'</td>
                            </tr>';
                }
            }
        echo '</table>';

        
        $data_array_size = count($generate_data);
        for ($iterator = 0; $iterator < $data_array_size; $iterator++) {
            echo '<input type="hidden" name="player_id'.$iterator.'" value="'.$generate_data[$iterator].'"/>';
        }
        //var_dump( $_POST[ 'team_name' ] );
        echo '<input type="hidden" name="team_name" value="'.$_POST[ 'team_name' ].'"/>';
        echo '<input type="hidden" name="generate_data_size" value="'.$data_array_size.'"/>';
        echo '<input type="hidden" name="separator_generate_data" value="'.$separator_generate_data.'"/>';
        echo '<input type="submit" name="generate_raport_to_pdf" class="button" value = "Generuj"/>
        </form></tr>';
        echo '<tr><form method="post"><input type="submit" name="cancel_generate_raport_to_pdf" class="button" value = "Powrót"/></form></tr>';
    }

    function teamConditionsCreate( $team_results ) {
        if ( count($team_results) < 1 ) {
            if ( isset($_POST['add_team']) ) {
                addTeam();
            } else {
                echo'<form method="post">
                    <input type="submit" name="add_team" class="button" value="Dodaj drużynę">
                </form>';
            }
        }
    }

    function deletePlayerFromBaseTeam( ) {
        global $base_players_numbers;
        $base_players_numbers--;
        global $wpdb;
        $table_name = 'project_x_trener_team'; 
        $date = date('Y-m-d H:i:s');
        $wpdb->update( $table_name, 
                      array( 'edit_date' => $date,
                             'category' => 'none'
                             
                      ), 
                      array( 'id' => $_POST['player_id'] ) );
        refresh();
        printPlayers( $_POST['id'] );
    }

    function deletePlayerFromReserveTeam( ) {
        global $reserve_players_numbers;
        $reserve_players_numbers--;
        global $wpdb;
        $table_name = 'project_x_trener_team'; 
        $date = date('Y-m-d H:i:s');
        $wpdb->update( $table_name, 
                      array( 'edit_date' => $date,
                             'category' => 'none'
                             
                      ), 
                      array( 'id' => $_POST['player_id'] ) );
        refresh();
        printPlayers( $_POST['id'] );
    }

    function addPlayerToBaseTeam( ) {
        global $base_players_numbers;
        $base_players_numbers++;
        global $wpdb;
        $table_name = 'project_x_trener_team'; 
        $date = date('Y-m-d H:i:s');
        $wpdb->update( $table_name, 
                      array( 'edit_date' => $date,
                             'category' => 'base'
                             
                      ), 
                      array( 'id' => $_POST['player_id'] ) );
        refresh();
        printPlayers( $_POST['id'] );
    }

    function addPlayerToReserveTeam( ) {
        global $reserve_players_numbers;
        $reserve_players_numbers++;
        global $wpdb;
        $table_name = 'project_x_trener_team'; 
        $date = date('Y-m-d H:i:s');
        $wpdb->update( $table_name, 
                      array( 'edit_date' => $date,
                             'category' => 'reserve'
                             
                      ), 
                      array( 'id' => $_POST['player_id'] ) );
        refresh();
        printPlayers( $_POST['id'] );
    }

    function validationAddPlayer() {
        // id' => NULL, 
        //     'create_date' => $date, 
        //     'edit_date' => $date, 
        //     'name' => checkInjection( $_POST['player_name'] ), 
        //     'surname' => checkInjection( $_POST['player_surname'] ),
        //     'dob' => checkInjection( $_POST['dob_player'] ),
        //     'tshirt_number' => checkInjection( $_POST['tshirt_number'] ),
        //     'is_player_exist' => NULL,
        //     'id_existing_account' => 0, 
        //     'is_player' => NULL, 
        //     'is_coach' => NULL, 
        //     'is_director' => NULL, 
        //     'is_manager' => NULL,
        //     'team_id' => checkInjection( $_POST['id_team'] ),
        //     'category' => 'none'
    }

    function buttonsConditions( $team_results ) {
        if(isset($_POST['add_player'])) {
            addPlayer();
        } else if(isset($_POST['edit_team'])) {
            editTeam( $team_results );
        } else if(isset($_POST['edit_player'])) {
            editPlayer();
        } else if(isset($_POST['delete_player'])) {
            deletePlayer();
        } else if( !isset($_POST['generate_raport']) && 
            !isset($_POST['generate_raport_to_pdf'])) {
            printTeam( $team_results );
            teamConditionsCreate( $team_results );
        }
        if(isset($_POST['confirm'])) {
            confirmAddTeam();
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
            validationAddPlayer();
            confirmAddPlayer ( $team_results );
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
        if(isset($_POST['cancel_generate_raport_to_pdf'])) {
            refresh();
        }
        if(isset($_POST['generate_raport']) ) {
            generateRaportSummary();
        }
        if(isset($_POST['del_from_base_team'])) {
            deletePlayerFromBaseTeam();
        }
        if(isset($_POST['del_from_reserve_team'])) {
            deletePlayerFromReserveTeam();
        }
        if(isset($_POST['add_to_base_team'])) {
            addPlayerToBaseTeam();
        }
        if(isset($_POST['add_to_reserve_team'])) {
            addPlayerToReserveTeam();
        }
    }
    buttonsConditions( $team_results );
}


?>