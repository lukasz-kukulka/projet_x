<?php


function getTeam() {
      global $wpdb;
      $user = wp_get_current_user()->display_name;
      $query = $wpdb->prepare("SELECT * FROM `project_x_team` WHERE `kreator` = %s", $user );
      $results = $wpdb->get_results($query);
      foreach ( $results as $page )
      {
          echo '<table>
          <tr><td>Data utworzenia drużyny :</td> <td>'.$page->data_utworzenia.'</td><td rowspan="0"> 
          <form method="post">
          <input type="submit" name="edit_team" class="button" value = "Edytuj"/><br/>
          <input type="submit" name="usun" class="button" value = "Usuń"/><br/>
          <input type="submit" name="dodaj" class="button" value = "Dodaj zawodnika"/><br/>
          <input type="submit" name="raport" class="button" value = "Generuj raport"/><br/>
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
	getTeam();
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

    function editTeam() {
        echo "Edytuj drużynę";
        global $wpdb;
        $user = wp_get_current_user()->display_name;
        $query = $wpdb->prepare("SELECT * FROM `project_x_team` WHERE `kreator` = %s", $user );
        $results = $wpdb->get_results($query);
        foreach ( $results as $page )
        {
            echo '<form method="post">';
            echo '<br /><br />Nazwa drużyny<input type="text" name="team" value="'.$page->druzyna.'"/> <br />';
            echo '<br /><br />Nazwa klubu<input type="text" name="club" value="'.$page->klub.'" /> <br />';
            echo '<br /><br />Podaj imie i nazwisko trenera<input type="text" name="trener" value="'.$page->trener.'"/> <br />';
            echo '<br /><br />Podaj imie i nazwisko menagera<input type="text" name="manager" value="'.$page->menager.'"/> <br />';
            echo '<br /><br />kierownika<input type="text" name="director" value="'.$page->kierownik.'"/> <br />';
            echo '<input type="submit" name="confirm" class="button" value = "Confirm_edit_team"/>';
            echo '</form>';
        }
    }

    function confirmEditTeam() {
        echo "Potwierdz edycje";
        global $wpdb;
        $table_name =  'project_x_team'; 
        $tema_name = $_POST['team'];
        $club = $_POST['club'];
        $edit_date = date('Y-m-d H:i:s');
        $trener = $_POST['club'];
        $menager = $_POST['manager'];
        $kierownik = $_POST['kierownik'];
    }

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

        if(isset($_POST['Confirm_edit_team'])) {
            confirmEditTeam();
        }

        if ( count($results) != 100 && !isset($_POST['add_team']) && !isset($_POST['edit_team']))
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
    buttonsConditions( $results );




?>