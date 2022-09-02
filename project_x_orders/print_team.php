<?php
    function getTeam() {
        global $wpdb;
        $user = wp_get_current_user()->display_name;

        $query = $wpdb->prepare("SELECT * FROM `project_x_team` WHERE `kreator` = %s", $user );
        $results = $wpdb->get_results($query);
        $table_name =  'project_x_team'; 
        $teams = $wpdb->get_results("SELECT * FROM `project_x_team` WHERE `kreator` = 'Nanautzin'" );

        foreach ( $results as $page )
        {
            echo '<table>
            <tr><td>Data utworzenia drużyny :</td> <td>'.$page->data_utworzenia.'</td><td rowspan="0"> 
            <input type="submit" name="edytuj" class="button" value = "Edytuj"/><br/>
            <input type="submit" name="usun" class="button" value = "Usuń"/><br/>
            <input type="submit" name="dodaj" class="button" value = "Wyświetl skład"/><br/>
            <input type="submit" name="dodaj" class="button" value = "Generuj raport"/><br/>
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