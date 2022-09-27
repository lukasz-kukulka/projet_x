<?php
    global $wpdb;
    $user = wp_get_current_user()->display_name;

    $query = $wpdb->prepare("SELECT * FROM `project_x_team` WHERE `kreator` = %s", $user );
    $results = $wpdb->get_results($query);
    
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
        echo "Potwierdz drużynę";
        global $wpdb;
        $table_name =  'project_x_team'; 
        $user = wp_get_current_user()->display_name;
        $date = date('Y-m-d H:i:s');
        $trener = $user;
        if ( isset($_POST['trener']) ) {
            $trener = $_POST['trener'];
        }
        echo $trener;

        

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

?>