<?php

$user = wp_get_current_user();
echo $user->display_name;
echo "<br>";
global $wpdd;

$wpdb->show_errors();
echo "<br>";
$team = $wpdb->get_results( "SELECT * FROM project_x_team WHERE klub = 'KLUBTEST' " );

var_dump($team);
echo "<br>";
$posts = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'publish'
AND post_type='post' ORDER BY comment_count DESC LIMIT 0,4");

var_dump($posts);
echo "<be>";
echo "<br>";
$ile = mysqli_num_rows($posts);

echo "ILE: ";
echo $ile;
echo $posts[0]->post_title;


?>

INSERT INTO `project_x_team` (`id`, `druzyna`, `klub`, `data_utworzenia`, `kreator`, `trener`, `menager`, `kierownik`) 
VALUES (NULL, 'test_druzyna_2', 'test_klub_2', '2022-08-29', 'ja', 'ja', 'ja', 'ja'); 

-- project_x_relation_team, idteam, iduser
-- project_x_team, druzyna, klub
-- project_x_trener_team imie, nazwisko

<?php

global $wpdd;

$user = wp_get_current_user()->display_name;

$wpdb->show_errors();
echo "<br>";
echo $user;
echo "<br>";
$teams = $wpdb->get_results( "SELECT * FROM project_x_team WHERE trener = '$user' " );

$rows = mysqli_num_rows($teams);
var_dump($teams);

for ($x=1; $x < $rows; $x++) {
    echo teams['druzyna'];
    }

$row = mysqli_fetch_assoc($rezultat);
?>

$user = wp_get_current_user()->display_name;

echo $user;
echo "<br>";
echo "<br>";
$wpdb->show_errors();
echo "<br>";
$teams = $wpdb->get_results( "SELECT * FROM project_x_team WHERE trener = '$user' " );
echo "<br>";
var_dump($teams);
echo "<br>";
$ile = mysqli_num_rows($teams);
echo $ile;
echo "<br>";
$rows = mysqli_num_rows($teams);
for ($x=1; $x < $rows; $x++) {
    echo teams["druzyna"];
    }

INSERT INTO `project_x_team` (`id`, `druzyna`, `klub`, `data_utworzenia`, `kreator`, `trener`, `menager`, `kierownik`) 
VALUES (NULL, 'NANAUTZIN_TEAM', 'NANAUTZIN_KLUB', '2022-08-29', 'Nanautzin', 'Nanautzin', 'Nanautzin', 'Nanautzin'); 

kreator trener menager kierownik 

<input type="submit" name="edit_team" class="button" value="Edytuj drużynę">



<?php
    function addTeam() {
        echo '<form method="post">';
        echo '<br /><br />Nazwa drużyny<input type="text" name="login" /> <br />';
        echo '<br /><br />Nazwa klubu<input type="text" name="login" /> <br />';
        echo '<br /><br />Podaj imie i nazwisko trenera(jeżeli to ty, zostaw puste)<input type="text" name="login" /> <br />';
        echo '<br /><br />Podaj imie i nazwisko menagera(jeżeli to ty, zostaw puste)<input type="text" name="login" /> <br />';
        echo '<br /><br />kierownika<input type="text" name="login" /> <br />';
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
        $wpdb->insert($table_name, array('id' => NULL, 'druzyna' => 'team', 'klub' => '$user','data_utworzenia' => '2022-08-29','kreator' => '$user','trener' => '$user','menager' => '$user','kierownik' => '$user')); 
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


$ile = mysqli_num_rows($results);
        echo "znaleziono: ".$ile;
OR 'trener' = $user 'menager' = $user 'kierownik' = $user
    //druzyna klub data_utworzenia kreator trener menager kierownik
    

    if(isset($_POST['add_team'])) {
        addTeam();
    }
    if(isset($_POST['edit_team'])) {
        editTeam();
    }
    if(isset($_POST['confirm'])) {
        confirmAddTeam();
    }
    echo '<table>
        <tr><td>NData utworzenia drużyny :</td> <td>'.$page->data_utworzenia.'</td></tr>
        <tr><td>Nazwa drużyny</td> <td>'.$page->druzyna. '</td></tr>
        <tr><td>Nazwa klubu :</td> <td>'.$page->klub.'</td></tr>
        <tr><td>Imię i nazwisko trenera :</td> <td>'.$page->trener.'</td></tr>
        <tr><td>Imię i nazwisko menagera :</td> <td>'.$page->menager.'</td></tr>
        <tr><td>Imię i nazwisko kierownika :</td> <td>'.$page->kierownik.'</td></tr>
        </table>';
        echo $page->druzyna.'<br/>';
           echo $page->klub.'<br/>';
           echo $page->data_utworzenia.'<br/>';
           echo $page->kreator.'<br/>';
           echo $page->trener.'<br/>';
           echo $page->menager.'<br/>';
           echo $page->kierownik.'<br/>';
?>

<style> td, th { border: 1px solid black; } </style>
<!-- ustawienie czarnego obramowania tabeli w CSS -->

<table>
   <thead>
      <tr>
         <th>Przedmiot</th> <th>Nazwisko</th> <th>Ocena</th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <th>Historia</th> <td>Nowak</td> <td>4+</td>
      </tr>
      <tr>
         <th>Historia</th> <td>Mazur</td> <td>3-</td>
      </tr>
      <tr>
         <th>Fizyka</th> <td>Nowak</td> <td>2</td>
      </tr>
      <tr>
         <th>Fizyka</th> <td>Mazur</td> <td>4</td>
      </tr>
   </tbody>
</table>