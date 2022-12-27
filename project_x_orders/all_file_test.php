<?php

//include 'project_x_style_test.css';
require('project_x_style_test.php');

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
            location.href = location.href
            location.replace(location.pathname)
            window.location = window.location
            window.self.window.self.window.window.location = window.location
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
        $base_results = array();
        $reserve_results = array();
        $others_results = array();
        foreach ( $player_results as $single_result ) {
            if ( $single_result->category == 'base' ) {
                array_push($base_results, $single_result);
            } else if ( $single_result->category == 'reserve' ) {
                array_push($reserve_results, $single_result);
            } else {
                array_push($others_results, $single_result);
            }
        }

        global $base_players_numbers;
        global $reserve_players_numbers;
        $base_players_numbers = count( $base_results );
        $reserve_players_numbers = count( $reserve_results );
        printBasePlayers( $base_results );
        printReservePlayers( $reserve_results );
        printOthersPlayers( $others_results );
    }

    function printTeam( $team_results ) {
        if ( count( $team_results ) == 0 )
        {
            echo'<p style="text-align:center"><strong><span style="font-size:24px">Aktulanie nie posiadasz żadnej drużyny</span></strong></p>';
        }
        else
        {
            $team_num = 1;
            foreach ( $team_results as $page )
            {
                echo'<p style="text-align:center"><strong><span style="font-size:36px">Drużyna '.$team_num.'</span></strong></p>';
                echo '<table id="tab_team">';
                echo '<tr><td class="team_name_cell">'.strtoupper( $page->team ).'</td></tr>';
                echo '<tr><td class="club_name_cell">'.strtoupper( $page->club ).'</td></tr>';
                echo '<tr><td class="coach_cell">'.strtoupper( $page->coach ).'</td></tr>';
                echo '<tr><td class="coach_license_cell">'.strtoupper( $page->coach_license ).'</td></tr>';
                echo '<tr><td class="second_coach_name_cell">'.strtoupper( $page->second_coach ).'</td></tr>';
                echo '<tr><td class="masseur_name_cell">'.strtoupper( $page->masseur ).'</td></tr>';
                echo '<tr><td class="doctor_name_cell">'.strtoupper( $page->doctor ).'</td></tr>';
                echo '<tr><td class="manager_name_cell">'.strtoupper( $page->manager ).'</td></tr>';
                echo '<tr><td class="director_name_cell">'.strtoupper( $page->director ).'</td></tr>';
                echo '<form method="post">';
                echo '<input type="hidden" name="id" value="'.$page->id.'"/>';
                echo '<input type="hidden" name="team_name" value="'.$page->club.'"/>';
                echo '<input type="hidden" name="coach" value="'.$page->coach.'"/>';
                echo '<input type="hidden" name="director" value="'.$page->director.'"/>';
                echo '<input type="hidden" name="coach_license" value="'.$page->coach_license.'"/>';
                echo '<input type="hidden" name="second_coach" value="'.$page->second_coach.'"/>';
                echo '<input type="hidden" name="masseur" value="'.$page->masseur.'"/>';
                echo '<input type="hidden" name="doctor" value="'.$page->doctor.'"/>';
                echo '<tr><td class="button_team_cell"><input type="submit" name="edit_team" class="team_button" value = "Edytuj"/></td></tr>';
                echo '<tr><td class="button_team_cell"><input type="submit" name="delete" class="team_button" value = "Usuń"/></td></tr>';
                echo '<tr><td class="button_team_cell"><input type="submit" name="add_player" class="team_button" value = "Dodaj zawodnika"/></td></tr>';
                echo '<tr><td class="button_team_cell"><input type="submit" name="generate_raport" class="team_button" value = "Generuj protokół"/></td></tr>';
                echo '</form>';
                echo '</table><br/><br/>';

                
                if ( $team_results > 0 )
                {
                    printPlayers( $page->id );
                }
                $team_num++;
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
        echo '<br /><br />Nazwa drużyny<input type="text" name="team" value="'.$insert_team.'" maxlength="50"/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_team.'</span></strong></p>';
        echo '<br /><br />Nazwa klubu<input type="text" name="club" value="'.$insert_club.'" maxlength="50/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_club.'</span></strong></p>';
        echo '<br /><br />Podaj nazwisko i imie trenera<input type="text" name="coach" value="'.$insert_coach.'" maxlength="22/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_coach.'</span></strong></p>';
        echo '<br /><br />Podaj numer licencji trenera 9 cyfr<input type="text" name="coach_license"  minlength="9" maxlength="9" value="'.$insert_license.'"/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_license.'</span></strong></p>';
        echo '<br /><br />Podaj nazwisko i imie drugiego trenera<input type="text" name="second_coach" value="'.$insert_second_coach.'" maxlength="22/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_second_coach.'</span></strong></p>';
        echo '<br /><br />Podaj nazwisko i imie masażysty<input type="text" name="masseur" value="'.$insert_masseur.'" maxlength="22/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_masseur.'</span></strong></p>';
        echo '<br /><br />Podaj nazwisko i imie lekarza<input type="text" name="doctor" value="'.$insert_doctor.'" maxlength="22/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_doctor.'</span></strong></p>';
        echo '<br /><br />Podaj nazwisko i imie menagera<input type="text" name="manager" value="'.$insert_manager.'" maxlength="22/> <br />';
        echo'<p style="color:red;"><strong><span>'.$error_manager.'</span></strong></p>';
        echo '<br /><br />Podaj nazwisko i imie kierownika<input type="text" name="director" value="'.$insert_director.'" maxlength="22/> <br />';
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
            $insert_second_coach = $page->second_coach;
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
            }
            echo '<form method="post">';
            echo '<input type="hidden" name="id" value="'.$page->id.'"/>';
            echo '<br /><br />Nazwa drużyny<input type="text" name="team" value="'.$insert_team.'" maxlength="50"/> <br />';
            echo '<p style="color:red;"><strong><span>'.$error_team.'</span></strong></p>';
            echo '<br /><br />Nazwa klubu<input type="text" name="club" value="'.$insert_club.'"  maxlength="50"/> <br />';
            echo '<p style="color:red;"><strong><span>'.$error_club.'</span></strong></p>';
            echo '<br /><br />Podaj nazwisko i imie trenera<input type="text" name="coach" value="'.$insert_coach.'" maxlength="22"/> <br />';
            echo '<p style="color:red;"><strong><span>'.$error_coach.'</span></strong></p>';
            echo '<br /><br />Podaj numer licencji trenera 9 cyfr<input type="text" name="coach_license" value="'.$insert_license.'" minlength="9" maxlength="9"/> <br />';
            echo '<p style="color:red;"><strong><span>'.$error_license.'</span></strong></p>';
            echo '<br /><br />Podaj nazwisko i imie drugiego trenera<input type="text" name="second_coach" value="'.$insert_second_coach.'" maxlength="22"/> <br />';
            echo '<p style="color:red;"><strong><span>'.$error_second_coach.'</span></strong></p>';
            echo '<br /><br />Podaj nazwisko i imie masażysty<input type="text" name="masseur" value="'.$insert_masseur.'" maxlength="22"/> <br />';
            echo '<p style="color:red;"><strong><span>'.$error_masseur.'</span></strong></p>';
            echo '<br /><br />Podaj nazwisko i imie lekarza<input type="text" name="doctor" value="'.$insert_doctor.'" maxlength="22"/> <br />';
            echo '<p style="color:red;"><strong><span>'.$error_doctor.'</span></strong></p>';
            echo '<br /><br />Podaj nazwisko i imie menagera<input type="text" name="manager" value="'.$insert_manager.'"/> <br />';
            echo '<p style="color:red;"><strong><span>'.$error_manager.'</span></strong></p>';
            echo '<br /><br />Podaj nazwisko i imie kierownika<input type="text" name="director" value="'.$insert_director.'" maxlength="22"/> <br />';
            echo '<p style="color:red;"><strong><span>'.$error_director.'</span></strong></p>';
            echo '<table id="tab_team">';
            echo '<tr><td><input type="submit" name="confirm_edit_team" class="team_button" value = "Potwierdz wprowadzone zmiany"/></td></tr>';
            echo '<tr><td><input type="submit" name="cancel_refresh" class="team_button" value = "Anuluj"/></td></tr>';
            echo '</table>'; 
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
            if ( $_POST['team'] != $team->id || $_POST['club'] != $team->club || $_POST['coach'] != $team->coach  || $_POST['coach_license'] != $team->coach_license || 
            $_POST['second_coach'] != $team->second_coach || $_POST['masseur'] != $team->masseur || $_POST['doctor'] != $team->doctor || $_POST['manager'] != $team->manager
            || $_POST['director'] != $team->director) {
                echo'<p style="text-align:center"><strong><span style="font-size:18px">Drużyna zedytowana poprawnie</span></strong></p>';
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
        echo '<form method="post">';
        echo '<input type="hidden" name="id" value="'.$_POST['id'].'"/>';
        echo '<table><tr>
                <td>Jesteś pewien że chcesz usunąć drużynę ze wszystkimi zawodnikami?</td> 
                <td class="button_del_cell"><input type="submit" name="confirm_delete_team" class="del_button" value = "Usuń"/></td>
                <td class="button_del_cell"><input type="submit" name="cancel_refresh" class="del_button" value = "Anuluj"/></td>
            </tr></table>';
        echo '</form>';
    }

    function doubleDeleteTeam() {
        echo '<form method="post">';
        echo '<input type="hidden" name="id" value="'.$_POST['id'].'"/>';
        echo '<table><tr>
                <td>Usunięcie drużyny, jest nieodwracalne, usuwając drużynę stracisz wszystkich zawodników</td> 
                <td class="button_del_cell"><input type="submit" name="double_confirm_delete_team" class="del_button" value = "Usuń"/></td>
                <td class="button_del_cell"><input type="submit" name="cancel_refresh" class="del_button" value = "Anuluj"/></td>
            </tr></table>';
        echo '</form>';
    }

    function confirmDeleteTeam( $team_results ) {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM `project_x_trener_team` WHERE `team_id` = %s", $_POST['id'] );
        $player_results = $wpdb->get_results($query);

        foreach ( $player_results as $player) {
            $wpdb->delete( 'project_x_trener_team', array( 'id' => $player->id ) );
        }
        $wpdb->delete( 'project_x_team', array( 'id' => $_POST['id'] ) );
        
        $button_name = "cancel_refresh";
        $query = $wpdb->prepare("SELECT * FROM `project_x_trener_team` WHERE `team_id` = %s", $_POST['id'] );
        $player_results = $wpdb->get_results($query);
        $query_team = $wpdb->prepare("SELECT * FROM `project_x_team` WHERE `id` = %s", $_POST['id']  );
        $teams_results = $wpdb->get_results($query_team);
        if ( count ( $player_results ) == 0 && count ( $teams_results ) == 0 ) {
            echo'<p style="text-align:center"><strong><span style="font-size:18px">Drużyna ze wszystkimi zawodnikami została usunięta</span></strong></p>';
        } else {
            echo'<p style="text-align:center"><strong><span style="font-size:18px">Coś poszło nie tak, spróbuj ponownie lub skontaktuj sie z działem pomocy</span></strong></p>';
        }

        echo '<form method="post">';
        echo '<input type="submit" name="'.$button_name.'" class="button" value = "Ok"/>';
        echo '</form>'; 
    }

    function addPlayer () {
        $insert_name = "";
        $insert_surname = "";
        $insert_tshirt = 0;
        $insert_date = date('d/m/y');
        $id_team = $_POST['id'];
        $name_error = "";
        $surname_error = "";

        if ( isset( $_SESSION ) ) {
            $insert_name = $_POST['player_name'];
            $insert_surname = $_POST['player_surname'];
            $insert_tshirt = $_POST['tshirt_number'];
            $insert_date = $_POST['dob_player'];
            $id_team = $_POST['id_team'];
            if ( $_SESSION['error_name'] != "TRUE") {
                $name_error = $_SESSION['error_name'].'</br>';
            }
            if ( $_SESSION['error_surname'] != "TRUE") {
                $surname_error = $_SESSION['error_surname'].'</br>';
            }
        }
        unset( $_SESSION );
        echo '<form method="post">';
        echo '<input type="hidden" name="id_team" value="'.$id_team.'"/>';
        echo '<br /><br />Imię gracza<input type="text" name="player_name" value="'.$insert_name.'" maxlength="15" size="50"/> <br />';
        echo'<p style="color:red;"><strong><span>'.$name_error.'</span></strong></p>';
        echo '<br /><br />Nazwisko gracza<input type="text" name="player_surname" value="'.$insert_surname.'" maxlength="15" size="60"/> <br />';
        echo'<p style="color:red;"><strong><span>'.$surname_error.'</span></strong></p>';
        echo '<br /><br />Numer koszulki<input style="color:black" type="number" name="tshirt_number" min="00" max="99" value="'.$insert_tshirt.'" size="10"/> 
                            Pozostaw zero jeżeli nie znasz numeru koszulki <br />';
        echo '<br /><br />Data urodzenia: <input style="color:black" type="date" name="dob_player" value="'.date("Y-m-d", strtotime( checkInjection( $insert_date ))).'"/> <br />';
       
        echo '<table id="tab_team">';
        echo '<tr><td><input type="submit" name="confirm_add_player" class="team_button" value = "Dodaj zawodnika"/></td></tr>';
        echo '<tr><td><input type="submit" name="cancel_refresh" class="team_button" value = "Anuluj"/></td></tr>';
        echo '</table>';

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
            $name_error = "";
            $surname_error = "";
            if ( isset( $_SESSION ) ) {
                $insert_name = $_POST['player_name'];
                $insert_surname = $_POST['player_surname'];
                $insert_tshirt = $_POST['tshirt_number'];
                $insert_date = $_POST['dob_player'];
                if ( $_SESSION['error_name'] != "TRUE") {
                    $name_error = $_SESSION['error_name'].'</br>';
                }
                if ( $_SESSION['error_surname'] != "TRUE") {
                    $surname_error = $_SESSION['error_surname'].'</br>';
                }
            }
            echo "end: ".date("YYYY-MM-DD", strtotime( checkInjection( $insert_date )))."</br>";
            echo "str: ".strtotime( checkInjection( $insert_date ))."</br>";
            echo "check: ".checkInjection( $insert_date )."</br>";
            echo "date: ".$insert_date."</br>";
            $date_xx = str_replace('/', '-', $insert_date );
            $date_x = str_replace('/', '-', checkInjection( $insert_date ));
            echo "date_xx: ".$date_xx."</br>";
            echo "date_x: ".$date_x."</br>";
            echo "end: ".strtotime( $date_x )."</br>";
            echo "end_x: ".date('Y-m-d', strtotime( $date_xx ))."</br>";

            echo '<form method="post">';
            echo '<input type="hidden" name="player_id" value="'.$_POST['player_id'].'"/>';
            echo '<br /><br />Imię gracza<input type="text" name="player_name" value="'.$insert_name.'" maxlength="15" size="50"/> <br />';
            echo'<p style="color:red;"><strong><span>'.$name_error.'</span></strong></p>';
            echo '<br /><br />Nazwisko gracza<input type="text" name="player_surname" value="'.$insert_surname.'" maxlength="15" size="60"/> <br />';
            echo'<p style="color:red;"><strong><span>'.$surname_error.'</span></strong></p>';
            echo '<br /><br />Numer koszulki<input style="color:black" type="number" name="tshirt_number" min="00" max="99" value="'.$insert_tshirt.'" size="10"/> 
                                Pozostaw zero jeżeli nie znasz numeru koszulki <br />';
            echo '<br /><br />Data urodzenia: <input style="color:black" type="date" name="dob_player" value="'.date("YYYY-MM-DD", strtotime( checkInjection( $insert_date ))).'"/> <br />';
            
            echo '<table id="tab_team">';
            echo '<tr><td><input type="submit" name="confirm_edit_player" class="team_button" value = "Potwierdz wprowadzone zmiany"/></td></tr>';
            echo '<tr><td><input type="submit" name="cancel_refresh" class="team_button" value = "Anuluj"/></td></tr>';
            echo '</table>';
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
                      array( 'id' => $_POST['player_id'] ) );

        $query = $wpdb->prepare("SELECT * FROM `$table_name` WHERE `id` = %s", $_POST['player_id'] );
        $player_results = $wpdb->get_results($query);
        $button_name = "cancel_refresh";
        foreach ( $player_results as $player ) {
            if ( $player->name != $_POST['player_name'] || $player->surname != $_POST['player_surname'] || $player->dob != $_POST['dob_player'] ) {
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
    }

    function deletePlayer() {
        echo '<form method="post">';
        echo '<input type="hidden" name="id_player" value="'.$_POST['player_id'].'"/>';

        foreach ( getPlayerResult($_POST['player_id']) as $player ) {
            echo '<center><table class="single_tab_base_payer">';
            echo '<tr>
                    <td colspan="1" class="tshirt_cell" ><div class="tshirt_text">'.$player->tshirt_number.'</div></td>
                    <td colspan="6" class="name_surname_cell" ><div class="name_text">'.$player->name.' '.$player->surname.'</div></td>
                    
                    </tr>';
            echo '</table><center>';
        }
        echo '<table>
            <tr>
                <td>Jesteś pewien że chcesz usunąć powyższego zawodnika?</td> 
                <td class="button_del_cell"><input type="submit" name="confirm_delete_player" class="del_button" value = "Usuń"/></td>
                <td class="button_del_cell"><input type="submit" name="cancel_refresh" class="del_button" value = "Anuluj"/></td>
            </tr></table>';
        echo '</form>';
    }

    function confirmDeletePlayer() {
        global $wpdb;
        $table_name = 'project_x_trener_team'; 
        $wpdb->delete( $table_name, array( 'id' => $_POST['id_player'] ) );
        $query = $wpdb->prepare("SELECT * FROM `$table_name` WHERE `id` = %s", $_POST['id_player'] );
        $button_name = "cancel_refresh";

        if ( count ( $wpdb->get_results($query) ) ) {
            echo'<p style="text-align:center"><strong><span style="font-size:18px">Coś poszło nie tak, spróbuj ponownie lub skontaktuj sie z działem pomocy</span></strong></p>';
        } else {
            echo'<p style="text-align:center"><strong><span style="font-size:18px">Zawodnik został usunięty</span></strong></p>';
        }

        echo '<form method="post">';

        echo '<center><table style="width: 120px; height: 30px;"><tr><td class="button_team_cell"><input type="submit" name="'.$button_name.'" class="team_button" value = "Ok"/></td></tr></table><center>';

        //echo '<center><input style="width: 120px; height: 30px;" type="submit" name="'.$button_name.'" class="team_button" value = "Ok"/></center>';
        echo '</form>'; 

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
        global $reserve_players_numbers;
        echo '<table id="tab_player">';
        echo '<tr><td><p>Skład podstawowy</p></td></tr>'; 
        echo '<tr><td>';
        $move_to_reserve_button = '';
        if ( $reserve_players_numbers < 7 ) {
            $move_to_reserve_button = '<input type="submit" name="add_to_reserve_team" class="button_move_to" value = "Przenieś do rezerwy"/>';
        } else {
            $move_to_reserve_button = '<input type="submit" name="add_to_reserve_team_off" class="button_move_to_off" value = "Przenieś do rezerwy"/>';
        }
        foreach ( $players_results as $player ) {
            echo '<table class="single_tab_base_payer">';
            echo '<form method="post">';
            echo '<tr>
                    <td colspan="1" class="tshirt_cell" ><div class="tshirt_text">'.$player->tshirt_number.'</div></td>
                    <td colspan="6" class="name_surname_cell" ><div class="name_text">'.$player->name.' '.$player->surname.'</div></td>
                    
                    </tr>';
            echo '<tr>
                    <td colspan="2" class="dob_cell" >'.$player->dob.'</td>
                    <td colspan="2" class="edit_cell" ><input type="submit" name="edit_player" class="button_edit" value = "Edytuj"/>
                                                        <input type="submit" name="delete_player" class="button_delete" value = "Usuń"/></td>
                    <td colspan="3" class="move_to_cell" ><input type="submit" name="del_from_base_team" class="button_move_to" value = "Przenieś do pozostali"/>
                                                            '.$move_to_reserve_button.'</td>
                    </tr>';
            echo '<input type="hidden" name="player_id" value="'.$player->id.'"/>';
            echo '<input type="hidden" name="id" value="'.$_POST['id'].'"/>';
            echo '</form>';
            echo '</table>';
            
        }
        echo '</td></tr>';
        echo '</table>';
        echo'</br>';
        echo'</br>';
    }

    function printReservePlayers( $players_results ) {
        global $base_players_numbers;
        echo '<table id="tab_player">';
        echo '<tr><td><p>Skład rezerwowy</p></td></tr>';
        echo '<tr><td>';
        $move_to_base_button = '';
        if ( $base_players_numbers < 11 ) {
            $move_to_base_button = '<input type="submit" name="add_to_base_team" class="button_move_to" value = "Przenieś do podstawy"/>';
        } else {
            $move_to_base_button = '<input type="submit" name="add_to_base_team_off" class="button_move_to_off" value = "Przenieś do podstawy"/>';
        }
        foreach ( $players_results as $player ) {
            echo '<table class="single_tab_base_payer">';
            echo '<form method="post">';
            echo '<tr>
                    <td colspan="1" class="tshirt_cell" ><div class="tshirt_text">'.$player->tshirt_number.'</div></td>
                    <td colspan="6" class="name_surname_cell" ><div class="name_text">'.$player->name.' '.$player->surname.'</div></td>
                    
                    </tr>';
            echo '<tr>
                    <td colspan="2" class="dob_cell" >'.$player->dob.'</td>
                    <td colspan="2" class="edit_cell" ><input type="submit" name="edit_player" class="button_edit" value = "Edytuj"/>
                                                        <input type="submit" name="delete_player" class="button_delete" value = "Usuń"/></td>
                    <td colspan="3" class="move_to_cell" >'.$move_to_base_button.'
                                                            <input type="submit" name="del_from_base_team" class="button_move_to" value = "Przenieś do pozostali"/>
                                                            </td>
                    </tr>';
            echo '<input type="hidden" name="player_id" value="'.$player->id.'"/>';
            echo '<input type="hidden" name="id" value="'.$_POST['id'].'"/>';
            echo '</form>';
            echo '</table>';
            
        }
        echo '</td></tr>';
        echo '</table>';
        echo'</br>';
        echo'</br>';
    }

    function printOthersPlayers($players_results) {
        global $base_players_numbers;
        global $reserve_players_numbers;
        echo '<table id="tab_player">';
        echo '<tr><td><p>Pozostali</p></td></tr>';
        echo '<tr><td>';
        $move_to_base_button = '';
        if ( $base_players_numbers < 11 ) {
            $move_to_base_button = '<input type="submit" name="add_to_base_team" class="button_move_to" value = "Przenieś do podstawy"/>';
        } else {
            $move_to_base_button = '<input type="submit" name="add_to_base_team_off" class="button_move_to_off" value = "Przenieś do podstawy"/>';
        }
        $move_to_reserve_button = '';
        if ( $reserve_players_numbers < 7 ) {
            $move_to_reserve_button = '<input type="submit" name="add_to_reserve_team" class="button_move_to" value = "Przenieś do rezerwy"/>';
        } else {
            $move_to_reserve_button = '<input type="submit" name="add_to_reserve_team_off" class="button_move_to_off" value = "Przenieś do rezerwy"/>';
        }
        foreach ( $players_results as $player )
        {
            echo '<table class="single_tab_base_payer">';
            echo '<form method="post">';
            echo '<tr>
                    <td colspan="1" class="tshirt_cell" ><div class="tshirt_text">'.$player->tshirt_number.'</div></td>
                    <td colspan="6" class="name_surname_cell" ><div class="name_text">'.$player->name.' '.$player->surname.'</div></td>
                    
                    </tr>';
            echo '<tr>
                    <td colspan="2" class="dob_cell" >'.$player->dob.'</td>
                    <td colspan="2" class="edit_cell" ><input type="submit" name="edit_player" class="button_edit" value = "Edytuj"/>
                                                        <input type="submit" name="delete_player" class="button_delete" value = "Usuń"/></td>
                    <td colspan="3" class="move_to_cell" >'.$move_to_base_button.$move_to_reserve_button.'</td>
                    </tr>';
            echo '<input type="hidden" name="player_id" value="'.$player->id.'"/>';
            echo '<input type="hidden" name="id" value="'.$_POST['id'].'"/>';
            echo '</form>';
            echo '</table>';
        }
        echo '</td></tr>';
        echo '</table>';
        echo'</br>';
        echo'</br>';
    }

    function generateRaportSummary() {
        global $wpdb;
        $separator_generate_data = "|";
        $query = $wpdb->prepare("SELECT * FROM `project_x_trener_team` WHERE `team_id` = %s", $_POST['id'] );
        $players_results = $wpdb->get_results($query);
        $generate_data = generateVariableForRaport( $separator_generate_data );

        echo '<tr><form action="generate_raport_test.php" method="post">';
        $base_players_num = 1;

        echo '<p style="text-align:center"><label><input type="radio" id="raport" name="raport_type" value="goscie" checked="checked" ><strong><span style="font-size:24px"> Protokół dla gości </span></strong></label>';
        echo '<label><input type="radio" id="raport" name="raport_type" value="gospodarze"><strong><span style="font-size:24px"> Protokół dla gospodarzy</span></strong></label></p>';        

        echo '<br /><br />Data spotkania: <input style="color:black" type="date" name="event_date" value="'.date("Y-m-d", strtotime('+1 days')).'"/> <br />';
        echo '<br />Nazwisko i imie trenera<input type="text" name="coach" value="'.$_POST['coach'].'" maxlength="30"/> <br />';
        echo '<br />Numer licencji trenera<input type="text" name="coach_license" value="'.$_POST['coach_license'].'" minlength="9" maxlength="9"/> <br />';
        echo '<br />Nazwisko i imie drugiego trenera<input type="text" name="second_coach" value="'.$_POST['second_coach'].'" maxlength="30"/> <br />';
        echo '<br />Nazwisko i imie masażysty<input type="text" name="masseur" value="'.$_POST['masseur'].'" maxlength="30"/> <br />';
        echo '<br />Nazwisko i imie lekarza<input type="text" name="doctor" value="'.$_POST['doctor'].'" maxlength="30"/> <br />';
        echo '<br />Nazwisko i imie kierownika<input type="text" name="director" value="'.$_POST['director'].'" maxlength="30"/> <br />';

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
        echo '<input type="hidden" name="team_name" value="'.$_POST[ 'team_name' ].'"/>';
        echo '<input type="hidden" name="generate_data_size" value="'.$data_array_size.'"/>';
        echo '<input type="hidden" name="separator_generate_data" value="'.$separator_generate_data.'"/>';

        echo '<table id="tab_team">';
        echo '<tr><td><input type="submit" name="generate_raport_to_pdf" class="team_button" value = "Generuj"/></td></tr>';
        echo '</table></form></tr>';

        //echo '<input type="submit" name="generate_raport_to_pdf" class="button" value = "Generuj"/>
        //</form></tr>';
        echo '<tr><form method="post">';
        echo '<table id="tab_team">';
        echo '<tr><td><input type="submit" name="generate_raport_to_pdf" class="team_button" value = "Powrót"/></td></tr>';
        echo '</table></form></tr>';
        echo '</form></tr>';
        //echo '<tr><form method="post"><input type="submit" name="cancel_generate_raport_to_pdf" class="button" value = "Powrót"/></form></tr>';

        //echo '<tr><form method="post"><input type="submit" name="cancel_generate_raport_to_pdf" class="button" value = "Powrót"/></form></tr>';

        // echo '<table id="tab_team">';
        // echo '<tr><td><input type="submit" name="confirm_edit_player" class="team_button" value = "Potwierdz wprowadzone zmiany"/></td></tr>';
        // echo '<tr><td><input type="submit" name="cancel_refresh" class="team_button" value = "Anuluj"/></td></tr>';
        // echo '</table>';
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
        $_POST = array();
        refresh();
        
        //printPlayers( $_POST['id'] );
        //header("Refresh:0");
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
        $_POST = array();
        refresh();
        //printPlayers( $_POST['id'] );
        //header("Refresh:0");
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
        $_POST = array();
        refresh();
        //printPlayers( $_POST['id'] );
        //header("Refresh:0");
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
        $_POST = array();
        refresh();
        //printPlayers( $_POST['id'] );
        //header("Refresh:0");
    }

    function isAlphabet( $text, $name, $is_space_char = false, $is_line = false , $is_num = false ) {
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
                if ( $is_num && is_numeric( $char) ) {
                    return "TRUE";
                } else {
                    $special_text = $special_text.', jak również numery';
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
        $validation_team = isAlphabet( $_POST['team'], "drużyna", true, true, true );
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
        } else if(isset($_POST['confirm_edit_player'])) {
            if ( validationAddPlayer() == "ERROR" ) {
                editPlayer();
            } else {
                unset($_SESSION);
                confirmEditPlayer();
            }
        } else if(isset($_POST['confirm_delete_team'])) {
            doubleDeleteTeam();
        } else if(isset($_POST['double_confirm_delete_team'])) {
            confirmDeleteTeam( $team_results );
        } else if(isset($_POST['confirm_delete_player'])) {
            confirmDeletePlayer();
        } else if(isset($_POST['add_player'])) {
            addPlayer();
        } else if(isset($_POST['edit_team'])) {
            editTeam( $team_results );
        } else if(isset($_POST['edit_player'])) {
            editPlayer();
        } else if(isset($_POST['delete_player'])) {
            deletePlayer();
        } else if(isset($_POST['delete'])) {
            deleteTeam();
        } else if( !isset($_POST['generate_raport']) && 
            !isset($_POST['generate_raport_to_pdf']) && 
            !isset($_SESSION) ) {
            printTeam( $team_results );
            teamConditionsCreate( $team_results );
        }
        
        
        
        
        if(isset($_POST['cancel_refresh'])) {
            unset($_SESSION);
            //refresh();
        }
        if(isset($_POST['cancel_generate_raport_to_pdf'])) {
            //refresh();
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
    //header("Refresh:0");
}

?>