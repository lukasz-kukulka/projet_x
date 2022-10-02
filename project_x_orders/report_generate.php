<?php


function generateRaportSummary() {
    global $wpdb;
    $query = $wpdb->prepare("SELECT * FROM `project_x_trener_team` WHERE `team_id` = %s", $_POST['id']);
    $player_results = $wpdb->get_results($query);

    echo '<table>
            <tr><td>Numer koszulki</td><td>Imie</td><td>Nazwisko</td><td>Data urodzenia</td><td>PESEL</td></tr>';
        foreach ( $player_results as $player )
        {
            echo '
                <tr>
                    <td>'.$player->tshirt_number.'</td>
                    <td>'.$player->name.'</td>
                    <td>'.$player->surname.'</td>
                    <td>'.$player->dob.'</td>
                    <td>'.$player->pesel.'</td>
                    </form>
                </tr>';
            
        }
        echo '<tr><form method="post">
                    <td><input type="submit" name="edit_player" class="button" value = "Generuj"/></td>
                    <input type="hidden" name="id_player" value="'.$player->id.'"/></tr>';
        echo '</table>';

}

generateRaportSummary();


?>