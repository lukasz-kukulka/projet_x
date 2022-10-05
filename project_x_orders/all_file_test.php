<?php


if ( is_user_logged_in() ){ 

    $base_players_numbers = 0;
    $reserve_players_numbers = 0;

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
        $insert_team = "";
        $insert_club = "";
        $insert_coach = "";
        $insert_license = "";
        $insert_second_coach = "";
        $insert_masseur = "";
        $insert_doctor = "";
        $insert_manager = "";
        $insert_director = "";

        $error_team = "";
        $error_club = "";
        $error_coach = "";
        $error_license = "";
        $error_second_coach = "";
        $error_masseur = "";
        $error_doctor = "";
        $error_manager = "";
        $error_director = "";

        if ( isset( $_SESSION ) ) {
            $insert_team = $_POST['team'] ;
            $insert_club = $_POST['club'];
            $insert_coach = $_POST['coach'];
            $insert_license = $_POST['coach_license'];
            $insert_second_coach = $_POST['second_coach'];
            $insert_masseur = $_POST['masseur'];
            $insert_doctor = $_POST['doctor'];
            $insert_manager = $_POST['manager'];
            $insert_director = $_POST['director'];
            
            if ( $_SESSION['error_team'] != "TRUE") {
                $error_team = $_SESSION['error_team'].'</br>';
            }
            if ( $_SESSION['error_club'] != "TRUE") {
                $error_club = $_SESSION['error_club'].'</br>';
            }
            if ( $_SESSION['error_coach'] != "TRUE") {
                $error_coach = $_SESSION['error_coach'].'</br>';
            }
            if ( $_SESSION['error_coach_license'] != "TRUE") {
                $error_license = $_SESSION['error_coach_license'].'</br>';
            }
            if ( $_SESSION['error_second_coach'] != "TRUE") {
                $error_second_coach = $_SESSION['error_second_coach'].'</br>';
            }
            if ( $_SESSION['error_masseur'] != "TRUE") {
                $error_masseur = $_SESSION['error_masseur'].'</br>';
            }
            if ( $_SESSION['error_doctor'] != "TRUE") {
                $error_doctor = $_SESSION['error_doctor'].'</br>';
            }
            if ( $_SESSION['error_manager'] != "TRUE") {
                $error_manager = $_SESSION['error_manager'].'</br>';
            }
            if ( $_SESSION['error_director'] != "TRUE") {
                $error_director = $_SESSION['error_director'].'</br>';
            }
        }

        $user = wp_get_current_user()->display_name;
        echo '<form method="post">';
        echo '<br /><br />Nazwa drużyny<input type="text" name="team" value="'.$insert_team.'"/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_team.'</span></strong></p>';
        echo '<br /><br />Nazwa klubu<input type="text" name="club" value="'.$insert_club.'" /> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_club.'</span></strong></p>';
        echo '<br /><br />Podaj nazwisko i imie trenera<input type="text" name="coach" value="'.$insert_coach.'"/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_coach.'</span></strong></p>';
        echo '<br /><br />Podaj numer licencji trenera<input type="text" name="coach_license" value="'.$insert_license.'"/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_license.'</span></strong></p>';
        echo '<br /><br />Podaj nazwisko i imie drugiego trenera<input type="text" name="second_coach" value="'.$insert_second_coach.'"/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_second_coach.'</span></strong></p>';
        echo '<br /><br />Podaj nazwisko i imie masażysty<input type="text" name="masseur" value="'.$insert_masseur.'"/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_masseur.'</span></strong></p>';
        echo '<br /><br />Podaj nazwisko i imie lekarza<input type="text" name="doctor" value="'.$insert_doctor.'"/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_doctor.'</span></strong></p>';
        echo '<br /><br />Podaj nazwisko i imie menagera<input type="text" name="manager" value="'.$insert_manager.'"/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_manager.'</span></strong></p>';
        echo '<br /><br />Podaj nazwisko i imie kierownika<input type="text" name="director" value="'.$insert_director.'"/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_director.'</span></strong></p>';
        echo '<input type="submit" name="confirm_add_team" class="button" value = "Dodaj"/>';
        echo '</form>';
    }
    
    function confirmAddTeam() {
        global $wpdb;
        $table_name =  'project_x_team'; 
        $results_before = count ( getTeamResult() );
        $user = wp_get_current_user()->display_name;
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

        unset( $_SESSION );
        $results_after = count ( getTeamResult() );
        $button_name = "cancel_refresh";
        if ( $results_after > $results_before ) {
            echo'<p style="text-align:center"><strong><span style="font-size:18px">Drużyna dodana poprawnie</span></strong></p>';
        } else {
            $button_name = "add_team";
            echo'<p style="text-align:center"><strong><span style="font-size:18px">Coś poszło nie tak, spróbuj ponownie lub skontaktuj sie z działem pomocy</span></strong></p>';
        }
        echo '<form method="post">';
        echo '<input type="hidden" name="team" value="'.$_POST['team'].'"/>';
        echo '<input type="hidden" name="club" value="'.$_POST['club'].'"/>';
        echo '<input type="hidden" name="coach" value="'.$_POST['coach'].'"/>';
        echo '<input type="hidden" name="coach_license" value="'.$_POST['coach_license'].'"/>';
        echo '<input type="hidden" name="second_coach" value="'.$_POST['second_coach'].'"/>';
        echo '<input type="hidden" name="masseur" value="'.$_POST['masseur'].'"/>';
        echo '<input type="hidden" name="doctor" value="'.$_POST['doctor'].'"/>';
        echo '<input type="hidden" name="manager" value="'.$_POST['manager'].'"/>';
        echo '<input type="hidden" name="director" value="'.$_POST['director'].'"/>';
        echo '<input type="submit" name="'.$button_name.'" class="button" value = "Ok"/>';
        echo '</form>';  
    }
    
    function editTeam( $team_results ) {
        $error_team = "";
        $error_club = "";
        $error_coach = "";
        $error_license = "";
        $error_second_coach = "";
        $error_masseur = "";
        $error_doctor = "";
        $error_manager = "";
        $error_director = "";

        foreach ( $team_results as $page )
        {
            $insert_team = $page->team;
            $insert_club = $page->club;
            $insert_coach = $page->coach;
            $insert_license = $page->coach_license;
            $insert_second_coach = $$page->second_coach;
            $insert_masseur = $page->masseur;
            $insert_doctor = $page->doctor;
            $insert_manager = $page->manager;
            $insert_director = $page->director;

            if ( isset( $_SESSION ) ) {
                $insert_team = $_POST['team'] ;
                $insert_club = $_POST['club'];
                $insert_coach = $_POST['coach'];
                $insert_license = $_POST['coach_license'];
                $insert_second_coach = $_POST['second_coach'];
                $insert_masseur = $_POST['masseur'];
                $insert_doctor = $_POST['doctor'];
                $insert_manager = $_POST['manager'];
                $insert_director = $_POST['director'];
                
                if ( $_SESSION['error_team'] != "TRUE") {
                    $error_team = $_SESSION['error_team'].'</br>';
                }
                if ( $_SESSION['error_club'] != "TRUE") {
                    $error_club = $_SESSION['error_club'].'</br>';
                }
                if ( $_SESSION['error_coach'] != "TRUE") {
                    $error_coach = $_SESSION['error_coach'].'</br>';
                }
                if ( $_SESSION['error_coach_license'] != "TRUE") {
                    $error_license = $_SESSION['error_coach_license'].'</br>';
                }
                if ( $_SESSION['error_second_coach'] != "TRUE") {
                    $error_second_coach = $_SESSION['error_second_coach'].'</br>';
                }
                if ( $_SESSION['error_masseur'] != "TRUE") {
                    $error_masseur = $_SESSION['error_masseur'].'</br>';
                }
                if ( $_SESSION['error_doctor'] != "TRUE") {
                    $error_doctor = $_SESSION['error_doctor'].'</br>';
                }
                if ( $_SESSION['error_manager'] != "TRUE") {
                    $error_manager = $_SESSION['error_manager'].'</br>';
                }
                if ( $_SESSION['error_director'] != "TRUE") {
                    $error_director = $_SESSION['error_director'].'</br>';
                }
            } else {
                
            }
            echo '<form method="post">';
            echo '<input type="hidden" name="id" value="'.$page->id.'"/>';
            echo '<br /><br />Nazwa drużyny<input type="text" name="team" value="'.$insert_team.'"/> <br />';
            echo'<p style="color:red;"><strong><span>'.$error_team.'</span></strong></p>';
            echo '<br /><br />Nazwa klubu<input type="text" name="club" value="'.$insert_club.'" /> <br />';
            echo'<p style="color:red;"><strong><span>'.$error_club.'</span></strong></p>';
            echo '<br /><br />Podaj imie i nazwisko trenera<input type="text" name="coach" value="'.$insert_coach.'"/> <br />';
            echo'<p style="color:red;"><strong><span>'.$error_coach.'</span></strong></p>';
            echo '<br /><br />Podaj numer licencji trenera<input type="text" name="coach_license" value="'.$insert_license.'"/> <br />';
            echo'<p style="color:red;"><strong><span>'.$error_license.'</span></strong></p>';
            echo '<br /><br />Podaj nazwisko i imie drugiego trenera<input type="text" name="second_coach" value="'.$insert_second_coach.'"/> <br />';
            echo'<p style="color:red;"><strong><span>'.$error_second_coach.'</span></strong></p>';
            echo '<br /><br />Podaj nazwisko i imie masażysty<input type="text" name="masseur" value="'.$insert_masseur.'"/> <br />';
            echo'<p style="color:red;"><strong><span>'.$error_masseur.'</span></strong></p>';
            echo '<br /><br />Podaj nazwisko i imie lekarza<input type="text" name="doctor" value="'.$insert_doctor.'"/> <br />';
            echo'<p style="color:red;"><strong><span>'.$error_doctor.'</span></strong></p>';
            echo '<br /><br />Podaj imie i nazwisko menagera<input type="text" name="manager" value="'.$insert_manager.'"/> <br />';
            echo'<p style="color:red;"><strong><span>'.$error_manager.'</span></strong></p>';
            echo '<br /><br />kierownika<input type="text" name="director" value="'.$insert_director.'"/> <br />';
            echo'<p style="color:red;"><strong><span>'.$error_director.'</span></strong></p>';
            echo '<input type="submit" name="confirm_edit_team" class="button" value = "Potwierdz wprowadzone zmiany"/>';
            echo '<input type="submit" name="cancel_refresh" class="button" value = "Anuluj"/>';
            echo '</form>';
        }
    }

    function confirmEditTeam( $team_results ) {
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
        unset( $_SESSION );
        global $wpdb;
        $user = wp_get_current_user()->display_name;
        $query = $wpdb->prepare("SELECT * FROM `project_x_team` WHERE `id` = %s", $_POST['id']  );
        $teams_results = $wpdb->get_results($query);
        $button_name = "cancel_refresh";
        foreach ( $teams_results as $team ) {
            if ( $_POST['team'] == $team->id && $_POST['club'] == $team->club && $_POST['coach'] == $team->coach  && $_POST['coach_license'] == $team->coach_license && 
            $_POST['second_coach'] == $team->second_coach && $_POST['masseur'] == $team->masseur && $_POST['doctor'] == $team->doctor && $_POST['manager'] == $team->manager
            && $_POST['director'] == $team->director) {
                echo'<p style="text-align:center"><strong><span style="font-size:18px">Drużyna dodana poprawnie</span></strong></p>';
            } else {
                $button_name = "edit_team";
                echo'<p style="text-align:center"><strong><span style="font-size:18px">Coś poszło nie tak, spróbuj ponownie lub skontaktuj sie z działem pomocy</span></strong></p>';
            }
        }
        
        echo '<form method="post">';
        echo '<input type="hidden" name="team" value="'.$_POST['team'].'"/>';
        echo '<input type="hidden" name="club" value="'.$_POST['club'].'"/>';
        echo '<input type="hidden" name="coach" value="'.$_POST['coach'].'"/>';
        echo '<input type="hidden" name="coach_license" value="'.$_POST['coach_license'].'"/>';
        echo '<input type="hidden" name="second_coach" value="'.$_POST['second_coach'].'"/>';
        echo '<input type="hidden" name="masseur" value="'.$_POST['masseur'].'"/>';
        echo '<input type="hidden" name="doctor" value="'.$_POST['doctor'].'"/>';
        echo '<input type="hidden" name="manager" value="'.$_POST['manager'].'"/>';
        echo '<input type="hidden" name="director" value="'.$_POST['director'].'"/>';
        echo '<input type="submit" name="'.$button_name.'" class="button" value = "Ok"/>';
        echo '</form>';  
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
        $insert_name = "";
        $insert_surname = "";
        $insert_tshirt = 0;
        $insert_date = date('d/m/y');
        //$id_team = $_POST['id'];
        $name_error = "";
        $surname_error = "";

        if ( isset( $_SESSION ) ) {
            $insert_name = $_POST['player_name'];
            $insert_surname = $_POST['player_surname'];
            $insert_tshirt = $_POST['tshirt_number'];
            $insert_date = $_POST['dob_player'];
            //$id_team = $_POST['id_team'];
            if ( $_SESSION['error_name'] != "TRUE") {
                $name_error = $_SESSION['error_name'].'</br>';
            }
            if ( $_SESSION['error_surname'] != "TRUE") {
                $surname_error = $_SESSION['error_surname'].'</br>';
            }
        }
        unset( $_SESSION );
        echo '<form method="post">';
        echo '<input type="hidden" name="id_team" value="'.$_POST['id'].'"/>';
        echo '<br /><br />Imię gracza<input type="text" name="player_name" value="'.$insert_name.'" maxlength="30" size="50"/> <br />';
        echo'<p style="color:red;"><strong><span>'.$name_error.'</span></strong></p>';
        echo '<br /><br />Nazwisko gracza<input type="text" name="player_surname" value="'.$insert_surname.'" maxlength="40" size="60"/> <br />';
        echo'<p style="color:red;"><strong><span>'.$surname_error.'</span></strong></p>';
        echo '<br /><br />Numer koszulki<input style="color:black" type="number" name="tshirt_number" min="00" max="99" value="'.$insert_tshirt.'" size="10"/> 
                            Pozostaw zero jeżeli nie znasz numeru koszulki <br />';
        echo '<br /><br />Data urodzenia: <input style="color:black" type="date" name="dob_player" value="'.$insert_date.'"/> <br />';
        echo '<input type="submit" name="confirm_add_player" class="button" value = "Dodaj zawodnika"/>';
        echo '<input type="submit" name="cancel_refresh" class="button" value = "Anuluj"/>';
        echo '</form>';
    }

    function confirmAddPlayer ( $team_results ) {
        global $wpdb;
        $table_name = 'project_x_trener_team'; 
        $query = $wpdb->prepare("SELECT * FROM `$table_name` WHERE `team_id` = %s", $_POST['id_team'] );
        $player_results = $wpdb->get_results($query);
        $num_before_add = count( $player_results );
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
        $query = $wpdb->prepare("SELECT * FROM `$table_name` WHERE `team_id` = %s", $_POST['id_team'] );
        $player_results = $wpdb->get_results($query);
        $num_after_add = count( $player_results );
        $button_name = "cancel_refresh";
        if ( $num_after_add > $num_before_add ) {
            echo'<p style="text-align:center"><strong><span style="font-size:18px">Zawodnik dodany poprawnie</span></strong></p>';
        } else {
            $button_name = "add_player";
            echo'<p style="text-align:center"><strong><span style="font-size:18px">Coś poszło nie tak, spróbuj ponownie lub skontaktuj sie z działem pomocy</span></strong></p>';
        }
        echo '<form method="post">';
        echo '<input type="hidden" name="player_name" value="'.$_POST['player_name'].'"/>';
        echo '<input type="hidden" name="player_surname" value="'.$_POST['player_surname'].'"/>';
        echo '<input type="hidden" name="dob_player" value="'.$_POST['dob_player'].'"/>';
        echo '<input type="hidden" name="tshirt_number" value="'.$_POST['tshirt_number'].'"/>';
        echo '<input type="submit" name="'.$button_name.'" class="button" value = "Ok"/>';
        echo '</form>';  
    }

    function editPlayer() {
        $players = getPlayerResult( $_POST['player_id'] );
        foreach ( $players as $player )
        {
            $insert_name = $player->name;
            $insert_surname = $player->surname;
            $insert_tshirt = $player->tshirt_number;
            $insert_date = $player->dob;
            //$id_team = $_POST['id'];
            $name_error = "";
            $surname_error = "";

            if ( isset( $_SESSION ) ) {
                $insert_name = $_POST['player_name'];
                $insert_surname = $_POST['player_surname'];
                $insert_tshirt = $_POST['tshirt_number'];
                $insert_date = $_POST['dob_player'];
                //$id_team = $_POST['id_team'];
                if ( $_SESSION['error_name'] != "TRUE") {
                    $name_error = $_SESSION['error_name'].'</br>';
                }
                if ( $_SESSION['error_surname'] != "TRUE") {
                    $surname_error = $_SESSION['error_surname'].'</br>';
                }
            }

            echo '<form method="post">';
            echo '<input type="hidden" name="id_player" value="'.$_POST['player_id'].'"/>';
            echo '<br /><br />Imię gracza<input type="text" name="player_name" value="'.$insert_name.'" maxlength="30" size="50"/> <br />';
            echo'<p style="color:red;"><strong><span>'.$name_error.'</span></strong></p>';
            echo '<br /><br />Nazwisko gracza<input type="text" name="player_surname" value="'.$insert_surname.'" maxlength="40" size="60"/> <br />';
            echo'<p style="color:red;"><strong><span>'.$surname_error.'</span></strong></p>';
            echo '<br /><br />Numer koszulki<input style="color:black" type="number" name="tshirt_number" min="00" max="99" value="'.$insert_tshirt.'" size="10"/> 
                                Pozostaw zero jeżeli nie znasz numeru koszulki <br />';
            echo '<br /><br />Data urodzenia: <input style="color:black" type="date" name="dob_player" value="'.$insert_date.'"/> <br />';
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
                             'dob' => date("d/m/y", strtotime( checkInjection( $_POST['dob_player'] ))),
                             'tshirt_number' => checkInjection( $_POST['tshirt_number'] )
                      ), 
                      array( 'id' => $_POST['id_player'] ) );

        $query = $wpdb->prepare("SELECT * FROM `$table_name` WHERE `id` = %s", $_POST['id_player'] );
        $player_results = $wpdb->get_results($query);
        $button_name = "cancel_refresh";
        foreach ( $player_results as $player ) {
            if ( $player->name == $_POST['player_name'] && $player->surname == $_POST['player_surname'] && $player->dob == $_POST['dob_player'] ) {
            echo'<p style="text-align:center"><strong><span style="font-size:18px">Zawodnik zedytowany poprawnie</span></strong></p>';
            } else {
                $button_name = "edit_team";
                echo'<p style="text-align:center"><strong><span style="font-size:18px">Coś poszło nie tak, spróbuj ponownie lub skontaktuj sie z działem pomocy</span></strong></p>';
            }
        }
        echo '<form method="post">';
        echo '<input type="hidden" name="player_name" value="'.$_POST['player_name'].'"/>';
        echo '<input type="hidden" name="player_surname" value="'.$_POST['player_surname'].'"/>';
        echo '<input type="hidden" name="dob_player" value="'.$_POST['dob_player'].'"/>';
        echo '<input type="hidden" name="tshirt_number" value="'.$_POST['tshirt_number'].'"/>';
        echo '<input type="submit" name="'.$button_name.'" class="button" value = "Ok"/>';
        echo '</form>';  
        //refresh();
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

    function isAlphabet( $text, $name, $is_space_char = false, $is_line = false ) {
        $space_char = 74;
        $line_char = 75;
        if ( $is_space_char ) {
            $space_char = 32;
        }
        if ( $is_line ) {
            $line_char = 45;
        }
        //$polish_alphabet = array( "Ą", "Ż", "Ź", "Ń", "Ś", "Ł", "Ę", "Ó", "Ć" );
        $polish_alphabet = array( 152, 153, 147, 179, 132, 133, 154, 155, 129, 130, 187, 188, 185, 186, 134, 135, 131, 132, 195, 196, 197, $space_char, $line_char );
        for ( $iterator = 0; $iterator < strlen($text); $iterator++ ) {
            $char = strtoupper( $text[$iterator] );
            if ( !ctype_alpha( $text[$iterator] ) && !in_array( ord( $text[ $iterator ] ), $polish_alphabet ) ) {
                $special_text = "";
                if ( $is_space_char ) {
                    $special_text = $special_text.' i spacja';
                }
                if ( $is_line ) {
                    $special_text = $special_text.', oraz znak "-"';
                }
                return "W polu $name dozwolone są tylko litery".$special_text;
            }
        }
        return "TRUE";
    }

    function isMaxCharacter( $var, $max_char, $is_name_and_surname = false ) {
        if ( strlen( $var ) > $max_char ) {
            if ( $is_name_and_surname ) {
                return "</br>Imię i nazwisko razem maja zbyt dużo znaków, skróć jedno z nich, maksymalna długość znaków to $max_char";
            } else {
                return "</br>Niedozwolona ilość znaków, maksymalna ilość znaków to $max_char";
            }
            
        } else {
            return "TRUE";
        }
    }

    function isOnlyNumber( $num, $text ) {
        if ( !is_numeric( $num ) ) {
            return "W polu '.$text.'dozwolone są tylko liczby";
        } else {
            return "TRUE";
        }
    }

    function validationAddPlayer() {
        $validation_name = isAlphabet( $_POST['player_name'], "imię" );
        $validation_surname = isAlphabet( $_POST['player_surname'], "nazwisko" );
        //$validation_name_plus_surname_size = isMaxCharacter( $_POST['player_name'].' '.$_POST['player_surname'], 21, true);
        if ( $validation_name != "TRUE" ) {
            $_SESSION['error_name'] = $validation_name;
        }
        if ( $validation_surname != "TRUE" ) {
            $_SESSION['error_surname'] = $validation_surname;
        }
        
        // if ( $validation_name_plus_surname_size != "TRUE" ) {
        //     $_SESSION['error_size_name_surname'] = $validation_name_plus_surname_size;
        // }
        if (isset( $_SESSION ) ) {
            return "ERROR";
        } else {
            return "";
        }
    }

    function validationAddTeam() {
        //isAlphabet( $text, $name, $is_space_char = false, $is_line = false ) 
        $validation_team = isAlphabet( $_POST['team'], "drużyna", true, true );
        $validation_club = isAlphabet( $_POST['club'], "klub", true, true );
        $validation_coach = isAlphabet( $_POST['coach'], "nazwisko i imię trenera", true );
        $validation_coach_license = isOnlyNumber( $_POST['coach_license'], "numer licencji trenera");
        $validation_second_coach = isAlphabet( $_POST['second_coach'], "nazwisko i imię drugiego trenera", true );
        $validation_masseur = isAlphabet( $_POST['masseur'], "nazwisko i imię masażysty", true );
        $validation_doctor = isAlphabet( $_POST['doctor'], "nazwisko i imię lekarza", true );
        $validation_manager = isAlphabet( $_POST['manager'], "nazwisko i imię menagera", true );
        $validation_director = isAlphabet( $_POST['director'], "nazwisko i imię kierownika", true );

        if ( $validation_team != "TRUE" ) {
            $_SESSION['error_team'] = $validation_team;
        }
        if ( $validation_club != "TRUE" ) {
            $_SESSION['error_club'] = $validation_club;
        }
        if ( $validation_coach != "TRUE" ) {
            $_SESSION['error_coach'] = $validation_coach;
        }
        if ( $validation_coach_license != "TRUE" ) {
            $_SESSION['error_coach_license'] = $validation_coach_license;
        }
        if ( $validation_second_coach != "TRUE" ) {
            $_SESSION['error_second_coach'] = $validation_second_coach;
        }
        if ( $validation_masseur != "TRUE" ) {
            $_SESSION['error_masseur'] = $validation_masseur;
        }
        if ( $validation_doctor != "TRUE" ) {
            $_SESSION['error_doctor'] = $validation_doctor;
        }
        if ( $validation_manager != "TRUE" ) {
            $_SESSION['error_manager'] = $validation_manager;
        }
        if ( $validation_director != "TRUE" ) {
            $_SESSION['error_director'] = $validation_director;
        }

        if (isset( $_SESSION ) ) {
            return "ERROR";
        } else {
            return "";
        }
    }

    function buttonsConditions( $team_results ) {
        //var_dump($_POST);
        if(isset($_POST['confirm_add_player'])) {
            if ( validationAddPlayer() == "ERROR" ) {
                addPlayer();
            } else {
                unset($_SESSION);
                confirmAddPlayer ( $team_results );
            }
        } else if(isset($_POST['confirm_add_team'])) {
            if ( validationAddTeam() == "ERROR" ) {
                addTeam();
            } else {
                unset($_SESSION);
                confirmAddTeam();
            }
        } else if(isset($_POST['confirm_edit_team'])) {
            if ( validationAddTeam() == "ERROR" ) {
                editTeam( $team_results );
            } else {
                unset($_SESSION);
                confirmEditTeam( $team_results );
            }
        } else if(isset($_POST['add_player'])) {
            addPlayer();
        } else if(isset($_POST['edit_team'])) {
            editTeam( $team_results );
        } else if(isset($_POST['edit_player'])) {
            editPlayer();
        } else if(isset($_POST['delete_player'])) {
            deletePlayer();
        } else if( !isset($_POST['generate_raport']) && 
            !isset($_POST['generate_raport_to_pdf']) && 
            !isset($_SESSION) ) {
            printTeam( $team_results );
            teamConditionsCreate( $team_results );
        }
        
        if(isset($_POST['delete'])) {
            deleteTeam();
        }
        if(isset($_POST['confirm_delete_team'])) {
            confirmDeleteTeam( $team_results );
        }
        if(isset($_POST['confirm_edit_player'])) {
            confirmEditPlayer();
        }
        if(isset($_POST['confirm_delete_player'])) {
            confirmDeletePlayer();
        }
        if(isset($_POST['cancel_refresh'])) {
            unset($_SESSION);
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