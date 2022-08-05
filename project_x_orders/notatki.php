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