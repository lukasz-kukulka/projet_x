<?php

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
require('fpdf184/fpdf.php');
require_once('fpdi2/src/autoload.php');
echo'test';
class SingeRecordInReport {
    private $tshirt = 0;
    private $name = array();
    private $dob = array();
    private $name_spacing = 4.0;
    private $dob_spacing = 4.0;

    public function generateName( $name ) {
        foreach ( str_split($name) as $char ) {
            array_push($this->name, $char);
        }
    }

    public function generateDoB( $date ) {
        foreach ( str_split($date) as $num) {
            if ( $num != "-") {
                array_push($this->dob, $num);
            }
        }
    }

    public function setTshirt( $num ) {
        $this->tshirt = $num;
    }

    public function getName() {
        return $this->name;
    }

    public function getTshirt() {
        return $this->tshirt;
    }

    public function getDoB() {
        return $this->dob;
    }

    public function getNameSpacing() {
        return $this->name_spacing;
    }

    public function getDoBSpacing() {
        return $this->dob_spacing;
    }
}

function generateVariableForRaport() {
    echo'inside1</br>';
    global $wpdb;
    var_dump($wpdb);
    $query = $wpdb->prepare("SELECT * FROM `project_x_trener_team` WHERE `team_id` = %s", $_POST['team_id']);
    echo'inside2</br>';
    $players_results = $wpdb->get_results($query);
    $distance_between_name_char = 4.0;
    $players_array = array();
    echo'inside2</br>';
    foreach ( $players_results as $player ) {
        $player_name = $player->name.' '.$player->surname;
        $single_record = new SingeRecordInReport();
        $single_record->generateName( $player_name );
        $single_record->generateDoB( $player->dob );
        $single_record->setTshirt( $player->tshirt_number );
        array_push($players_array, $single_record);
    }
    echo'inside3</br>';
    return $players_array;
}
echo'out</br>';
// if(isset($_POST['generate_raport_to_pdf'])) {
//     //testFun();
// }

$generate_data = generateVariableForRaport();
echo'xxxxx</br>';
var_dump($generate_data);
echo'zzzzz</br>';
$pdf = new Fpdi();
$pageCount = $pdf->setSourceFile('test.pdf');
$pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);
$pdf->addPage();
$pdf->useImportedPage($pageId, 0, 0 );
$pdf->SetFont('Arial','B',16);
//$pdf->Cell(404, 10,'Hello World!');
//var_dump();
$pdf->Text(24.5, 49, 'A');
$pdf->Text(29.5, 49, 'B');
$pdf->Text(34.5, 49, 'C');
$pdf->Text(39.5, 49, 'D');
$pdf->Text(44.5, 49, 'E');
//$pdf->Output('I', 'generated.pdf');

?>