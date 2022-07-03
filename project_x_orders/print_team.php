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
   addPlayer();
?>

