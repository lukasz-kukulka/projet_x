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