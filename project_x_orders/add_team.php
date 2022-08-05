
<?php
    $user = wp_get_current_user()->display_name;
    function addTeam() {
        echo '<form method="post">';
        echo '<br /><br />Nazwa drużyny<input type="text" name="team" /> <br />';
        echo '<br /><br />Nazwa klubu<input type="text" name="club" /> <br />';
        echo '<br /><br />Podaj imie i nazwisko trenera(jeżeli to ty, zostaw puste)<input type="text" name="trener" value=""/> <br />';
        echo '<br /><br />Podaj imie i nazwisko menagera(jeżeli to ty, zostaw puste)<input type="text" name="manager" /> <br />';
        echo '<br /><br />kierownika<input type="text" name="director" /> <br />';
		echo '<input type="submit" name="confirm" class="button" value = "Dodaj"/>';
	    echo '</form>';
    }
    function editTeam() {
        echo "Edytuj drużynę";
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
    }

    if(isset($_POST['add_team'])) {
        addTeam();
    }
    if(isset($_POST['edit_team'])) {
        editTeam();
    }
    if(isset($_POST['confirm'])) {
        confirmAddTeam();
    }

    
?>
  
<form method="post">
    <input type="submit" name="add_team" class="button" value = "Dodaj drużynę"/>
    <input type="submit" name="edit_team" class="button" value = "Edytuj drużynę"/>
</form>