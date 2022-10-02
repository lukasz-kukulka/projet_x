<?php

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
require('fpdf184/fpdf.php');
require_once('fpdi2/src/autoload.php');

$team_size = $_POST['generate_data_size'];
$post_array_data = array();
$separator_generate_data = $_POST['separator_generate_data'];
$distance_between_name = 4.0;
$distance_date_name = 4.0;

function getPostDataToGenerateArray() {
    global $team_size;
    $post_data = array();
    for ($iterator = 0; $iterator < $team_size; $iterator++) {
        $post_data_name = "player_id".$iterator;
        $single_record = $_POST[$post_data_name];
        array_push($post_data, $single_record);
    }
    return $post_data;
}

function generateArrayData() {
    global $post_array_data;
    global $separator_generate_data;
    $row_array_generate_data = getPostDataToGenerateArray();
    $new_complete_generator_data = array();
    foreach( $row_array_generate_data as $one_line ) {
        var_dump($one_line);
        echo"</br>";
        $iterator = 0;
        $tshirt = "";
        $name = array();
        $dob = array();

        while ( $one_line[ $iterator ] == $separator_generate_data ) {
            $tshirt = $tshirt.$one_line[ $iterator ];
            $iterator++;
            //echo "iterator = "
        }

        $iterator++;

        while ( $one_line[ $iterator ] == $separator_generate_data ) {
            array_push($name, $one_line[ $iterator ]);
            $iterator++;
        }

        $iterator++;

        while ( $one_line[ $iterator ] == $separator_generate_data ) {
            if ( $one_line[ $iterator ] != '-' )
            {
                array_push($dob, $one_line[ $iterator ]);
            }
            $iterator++;
        }

        array_push($new_complete_generator_data, $tshirt, $name, $dob);
    }
    return $new_complete_generator_data;
}

generateArrayData();
//var_dump(generateArrayData());

$pdf = new Fpdi();
$pageCount = $pdf->setSourceFile('test.pdf');
$pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);
$pdf->addPage();
$pdf->useImportedPage($pageId, 0, 0 );
$pdf->SetFont('Arial','B',16);
//$pdf->Cell(404, 10, $sdsd);
//var_dump();
$pdf->Text(24.5, 49, 'A');
$pdf->Text(29.5, 49, 'B');
$pdf->Text(34.5, 49, 'C');
$pdf->Text(39.5, 49, 'D');
$pdf->Text(44.5, 49, $sdsd);
//$pdf->Output('I', 'generated.pdf');

?>