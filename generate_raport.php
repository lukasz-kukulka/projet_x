<?php

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
require('fpdf184/fpdf.php');
require_once('fpdi2/src/autoload.php');
//require('fpdf184/makefont/makefont.php');
//MakeFont('fpdi2/src/AbhayaLibre-Regular.ttf','ISO-8859-2');
$pdf = new Fpdi();
$pdf->AddFont('AbhayaLibre','','AbhayaLibre-Regular.php', true);
//$pageCount = $pdf->setSourceFile('test.pdf');
$pdf->setSourceFile('raport_host.pdf');
$pdf->setSourceFile('raport_guest.pdf');
$pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);

$pdf->addPage();
$pdf->useImportedPage($pageId, 0, 0 );
$pdf->SetFont('AbhayaLibre','',12);

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

function generateArrayData($is_base_team = true ) {
    global $post_array_data;
    global $separator_generate_data;
    $generate_category = "base";
    if ( $is_base_team == false )
    {
        $generate_category = "reserve";
    }
    $row_array_generate_data = getPostDataToGenerateArray();
    $new_complete_generator_data = array();
    foreach( $row_array_generate_data as $one_line ) {
        // var_dump($one_line);
        // echo"</br></br>";
        $iterator = 0;
        $category = "";
        $tshirt = "";
        $name = "";
        $dob = "";
        $base_team_lane = array();
        $reserve_team_lane = array();

        while ( $one_line[ $iterator ] != $separator_generate_data ) {
            $category = $category.$one_line[ $iterator ];
            $iterator++;
        }

        $iterator++;

        while ( $one_line[ $iterator ] != $separator_generate_data ) {
            $tshirt = $tshirt.$one_line[ $iterator ];
            $iterator++;
        }

        $iterator++;

        while ( $one_line[ $iterator ] != $separator_generate_data ) {
            $name = $name.$one_line[ $iterator ];
            $iterator++;
        }

        $iterator++;

        while ( $one_line[ $iterator ] != $separator_generate_data ) {
            if ( $one_line[ $iterator ] != '/' )
            {
                $dob = $dob.$one_line[ $iterator ];
            }
            $iterator++;
        }
        if ( $category == $generate_category )
        {
            array_push($base_team_lane, $tshirt, $name, $dob);
            array_push($new_complete_generator_data, $base_team_lane);
        }
        // else if ( $category == "reserve")
        // {
        //     array_push($reserve_team_lane, $tshirt, $name, $dob);
        // }

        //array_push($new_complete_generator_data, $base_team_lane, $reserve_team_lane);
    }
    return $new_complete_generator_data;
}

$base_team_data_array = generateArrayData();
$reserve_team_data_array = generateArrayData( false );

//var_dump( $reserve_team_data_array );
function printAll() {
    global $base_team_data_array;
    global $reserve_team_data_array;
    $iterator = 0;
    for ( $iterator = 0; $iterator < count( $base_team_data_array ); $iterator++ ) {
        // echo "</br>";
        // var_dump( $all_data_array[ $iterator ] );
        printOneLine( $iterator, $base_team_data_array[ $iterator ] );
    }

    for ( $iterator = 0; $iterator < count( $reserve_team_data_array ); $iterator++ ) {
        // echo "</br>";
        // var_dump( $all_data_array[ $iterator ] );
        printOneLine( $iterator, $reserve_team_data_array[ $iterator ], false );
    }
    printCoach();
    printCoachLicenseNumber();
    printSecondCoach();
    printMasseur();
    printDoctor();
    printDirector();
    printDate();

    global $pdf;
}

function printCoach() {
    global $pdf;
    $data = $_POST['coach'];
    $begin_pos_y = 207.5;
    $begin_pos_x = 17.2;
    $between_char_spacing = 5.9;
    for ( $iterator = 0; $iterator < strlen($data); $iterator++ ) {
        $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ), $begin_pos_y, strtoupper( $data[ $iterator ] ) );
    }
}

function printCoachLicenseNumber() {
    global $pdf;
    $begin_pos_y = 207.0;
    $begin_pos_x = 142.2;
    $pdf->SetFont('AbhayaLibre','',14);
    $pdf->Text($begin_pos_x, $begin_pos_y, $_POST['coach_license'] );
    $pdf->SetFont('AbhayaLibre','',12);
}

function printSecondCoach() {
    global $pdf;
    $data = $_POST['second_coach'];
    $begin_pos_y = 213.1;
    $begin_pos_x = 17.2;
    $between_char_spacing = 5.9;
    for ( $iterator = 0; $iterator < strlen($data); $iterator++ ) {
        $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ), $begin_pos_y, strtoupper( $data[ $iterator ] ) );
    }
}

function printMasseur() {
    global $pdf;
    $data = $_POST['masseur'];
    $begin_pos_y = 219.2;
    $begin_pos_x = 17.2;
    $between_char_spacing = 5.9;
    for ( $iterator = 0; $iterator < strlen($data); $iterator++ ) {
        $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ), $begin_pos_y, strtoupper( $data[ $iterator ] ) );
    }
}

function printDoctor() {
    global $pdf;
    $data = $_POST['doctor'];
    $begin_pos_y = 225.3;
    $begin_pos_x = 17.2;
    $between_char_spacing = 5.9;
    for ( $iterator = 0; $iterator < strlen($data); $iterator++ ) {
        $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ), $begin_pos_y, strtoupper( $data[ $iterator ] ) );
    }
}

function printDirector() {
    global $pdf;
    $data = $_POST['director'];
    $begin_pos_y = 231.3;
    $begin_pos_x = 17.2;
    $between_char_spacing = 5.9;
    for ( $iterator = 0; $iterator < strlen($data); $iterator++ ) {
        $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ), $begin_pos_y, strtoupper( $data[ $iterator ] ) );
    }
}

function printDate() {
    global $pdf;
    $date = $_POST['event_date'];
    $begin_pos_y = 30;
    $begin_pos_x = 44.5;
    $between_char_spacing = 5.3;
    $space_after_month = 6.0;
    for ( $iterator = 0; $iterator < strlen($date); $iterator++ ) {
        if ( $date[ $iterator ] != "-" ) {
            $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ), $begin_pos_y, strtoupper( $date[ $iterator ] ) );
        } 
        if( $iterator == 4 ) {
            $begin_pos_x += $space_after_month;
        }
    }
}

function printOneLine( $line_num, $one_line, $is_base_player = true ) {
    //echo "test</br>";
    printTshirt( $line_num, $one_line[ 0 ], $is_base_player );
    //var_dump( $one_line[ 1 ]  );
    printName( $line_num, $one_line[ 1 ], $is_base_player );
    printDOB( $line_num, $one_line[ 2 ], $is_base_player );

}

function printName($line_num, $print_text, $is_base_player = true ) {
    global $pdf;
    $begin_pos_y = 0;
    if ( $is_base_player ) {
        $begin_pos_y = ( $line_num * 6.6 ) + 49;
    } else {
        $begin_pos_y = ( $line_num * 6.6 ) + ( 72.6 ) + 49 + 9.9;
    }
    $begin_pos_x = 25.5;
    $between_char_spacing = 4.88;
    $special_char_spacing = 4.88;
    $between_char_spacing_if_is_exception = 1.5;
    $print_text = strtoupper($print_text);
    //echo strlen($print_text)."</br>";
    //var_dump( $print_text );
    $avoid_indexes = 0;
    
    for ( $iterator = 0; $iterator < strlen($print_text); $iterator++ ) {
        $new_space_between = $avoid_indexes * $special_char_spacing;
        if ( ord( $print_text[ $iterator ] ) > 125 ) {
            //Ę Ó Ą Ś Ł Ż Ź Ć Ń 
            if ( ord( $print_text[ $iterator ] ) == 152 || ord( $print_text[ $iterator ] ) == 153 ) { 
                $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) - $new_space_between, $begin_pos_y, chr(202) );
            } else if ( ord( $print_text[ $iterator ] ) == 147 || ord( $print_text[ $iterator ] ) == 179 ) {
                $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) - $new_space_between, $begin_pos_y, chr(211) );
            } else if ( ord( $print_text[ $iterator ] ) == 132 || ord( $print_text[ $iterator ] ) == 133 ) {
                $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) - $new_space_between, $begin_pos_y, chr(161) );
            } else if ( ord( $print_text[ $iterator ] ) == 154 || ord( $print_text[ $iterator ] ) == 155 ) {
                $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) - $new_space_between, $begin_pos_y, chr(166) );
            } else if ( ord( $print_text[ $iterator ] ) == 129 || ord( $print_text[ $iterator ] ) == 130 ) {
                $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) - $new_space_between, $begin_pos_y, chr(163) );
            } else if ( ord( $print_text[ $iterator ] ) == 187 || ord( $print_text[ $iterator ] ) == 188 ) {
                $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) - $new_space_between, $begin_pos_y, chr(175) );
            } else if ( ord( $print_text[ $iterator ] ) == 185 || ord( $print_text[ $iterator ] ) == 186 ) {
                $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) - $new_space_between, $begin_pos_y, chr(172) );
            } else if ( ord( $print_text[ $iterator ] ) == 134 || ord( $print_text[ $iterator ] ) == 135 ) {
                $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) - $new_space_between, $begin_pos_y, chr(198) );
            } else if ( ord( $print_text[ $iterator ] ) == 131 || ord( $print_text[ $iterator ] ) == 132 ) {
                $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) - $new_space_between, $begin_pos_y, chr(209) );
            } else {
                //$pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception, $begin_pos_y, chr(201) );
                $avoid_indexes++;
                //echo "Avoid indexed = ".$avoid_indexes." i = ".$i." iterator = ".$iterator." cos = ".ord( $print_text[ $iterator ] ) ."</br>";
            }
        }
        else {
            if ( $print_text[ $iterator ] == 'I' || $print_text[ $iterator ] == ' ') {
                $between_char_spacing_if_is_exception = 0.8;
            } else if ( $print_text[ $iterator ] == 'W' || $print_text[ $iterator ] == 'M') {
                $between_char_spacing_if_is_exception = -0.8;
            } else {
                $between_char_spacing_if_is_exception = 0;
            }
            $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception - $new_space_between, $begin_pos_y, $print_text[ $iterator ] );
        }
    }
}

function printTshirt($line_num, $print_text, $is_base_player = true) {
    global $pdf;
    $begin_pos_y = 0;
    if ( $is_base_player ) {
        $begin_pos_y = ( $line_num * 6.6 ) + 49;
    } else {
        $begin_pos_y = ( $line_num * 6.6 ) + ( 72.6 ) + 49 + 9.6;
    }
   
    $begin_pos_x = 18.5;
    $between_char_spacing = 5.3;
    $between_char_spacing_if_is_exception = 1.5;
    $print_text = strtoupper($print_text);

    $pdf->Text( $begin_pos_x, $begin_pos_y, $print_text );

}

function printDOB($line_num, $print_text, $is_base_player = true) {
    global $pdf;
     $begin_pos_y = 0;
    if ( $is_base_player ) {
        $begin_pos_y = ( $line_num * 6.6 ) + 49;
    } else {
        $begin_pos_y = ( $line_num * 6.6 ) + ( 72.6 ) + 49 + 9.7;
    }
   
    $begin_pos_x = 138.5;
    $between_char_spacing = 5.3;
    $between_char_spacing_if_is_exception = 1.5;
    $print_text = strtoupper($print_text);
    
    for ( $iterator = 0; $iterator < strlen($print_text); $iterator++ ) {
        if ( $print_text[ $iterator ] == '1' || $print_text[ $iterator ] == ' ') {
            $between_char_spacing_if_is_exception = 0.0;
        } else {
            $between_char_spacing_if_is_exception = 0;
        }
        $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception, $begin_pos_y, $print_text[ $iterator ] );
    }
}

$line_num = 0;

printAll();

// $pdf->Text(24.5, 49, 'A');
// $pdf->Text(29.5, 49, 'B');
// $pdf->Text(34.5, 49, 'C');
// $pdf->Text(39.5, 49, 'D');
$pdf->Output('I', 'generated.pdf');

?>