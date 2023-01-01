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
if ( $_POST['raport_type'] == 'gospodarze' ) 
{
    $pdf->setSourceFile('raport_host.pdf');
}
if ( $_POST['raport_type'] == 'goscie' ) {
    $pdf->setSourceFile('raport_guest.pdf');
}

$pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);

$pdf->addPage();
$pdf->useImportedPage($pageId, 0, 0 );
$pdf->SetFont('AbhayaLibre','',12);

$team_size = $_POST['generate_data_size'];
$post_array_data = array();
$separator_generate_data = $_POST['separator_generate_data'];
$distance_between_name = 4.0;
$distance_date_name = 4.0;
$line_num = 0;

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
    }
    return $new_complete_generator_data;
}

$base_team_data_array = generateArrayData();
$reserve_team_data_array = generateArrayData( false );

function printAll() {
    global $base_team_data_array;
    global $reserve_team_data_array;
    $iterator = 0;
    for ( $iterator = 0; $iterator < count( $base_team_data_array ); $iterator++ ) {
        printOneLine( $iterator, $base_team_data_array[ $iterator ] );
    }

    for ( $iterator = 0; $iterator < count( $reserve_team_data_array ); $iterator++ ) {
        printOneLine( $iterator, $reserve_team_data_array[ $iterator ], false );
    }
    printCoach();
    printCoachLicenseNumber();
    printSecondCoach();
    printMasseur();
    printDoctor();
    printDirector();
    printDate();
    printTeamName();
}

function getPolishCharacterNumber( $char ) {
    if ( ord( $char ) == 152 || ord( $char ) == 153 ) { 
        return 202;
    } else if ( ord( $char ) == 147 || ord( $char ) == 179 ) {
        return 211;
    } else if ( ord( $char ) == 132 || ord( $char ) == 133 ) {
        return 161;
    } else if ( ord( $char ) == 154 || ord( $char ) == 155 ) {
        return 166;
    } else if ( ord( $char ) == 129 || ord( $char ) == 130 ) {
        return 163;
    } else if ( ord( $char ) == 187 || ord( $char ) == 188 ) {
        return 175;
    } else if ( ord( $char ) == 185 || ord( $char ) == 186 ) {
        return 172;
    } else if ( ord( $char ) == 134 || ord( $char ) == 135 ) {
        return 198;
    } else if ( ord( $char ) == 131 || ord( $char ) == 132 ) {
        return 209;
    } else {
        return 0;
    }
}

function generateArrayCharNumTextForPrint( $print_text, $max_size ) {
    $array_num = array();
    for ( $iterator = 0; count( $array_num ) < $max_size; $iterator++ ) {
        if ( $iterator >= strlen( $print_text ) ) {
            array_push($array_num, 32 );
        } else {
            if ( ord( $print_text[ $iterator ] ) > 125 ) {
                $get_char = getPolishCharacterNumber( $print_text[ $iterator ] );
                if ( $get_char != 0 ) {
                    array_push($array_num, $get_char);
                }
            } else {
                array_push($array_num, ord( strtoupper( $print_text[ $iterator ] ) ) );
            }
        }
    }
    return $array_num;
}

function printTeamName(){
    global $pdf;
    $begin_pos_y = 23;
    $begin_pos_x = 30.5;
    if ( $_POST['raport_type'] == 'gospodarze' ) 
    {
        $begin_pos_x = 39.5;
    }
    $between_char_spacing = 2.5;
    $between_char_spacing_if_is_exception = 0;
    $pdf->SetFont('AbhayaLibre','',10);
    $between_char_spacing_if_is_exception_after = 0.0;
    $name_array = generateArrayCharNumTextForPrint( $_POST['team_name'], 30 );
    for ( $iterator = 0; $iterator < count( $name_array ); $iterator++ ) {
        //var_dump( $name_array [ $iterator ] );
        $single_char = chr( $name_array [ $iterator ] );
        $between_char_spacing_if_is_exception = generateSpacingBeforeCharInClearPlace( $single_char );
        $x_position = $begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception + $between_char_spacing_if_is_exception_after;
        $pdf->Text($x_position, $begin_pos_y, $single_char );
        $between_char_spacing_if_is_exception_after += generateSpacingAfterCharInClearPlace( $single_char );
    }
    $pdf->SetFont('AbhayaLibre','',12);
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
    $between_char_spacing_if_is_exception_after = 0.0;
    $name_array = generateArrayCharNumTextForPrint( $print_text, 22 );
    for ( $iterator = 0; $iterator < count( $name_array ); $iterator++ ) {
        $single_char = chr( $name_array [ $iterator ] );
        $between_char_spacing_if_is_exception = generateSpacingBeforeCharInPlayersPlace( $single_char );
        $x_position = $begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception + $between_char_spacing_if_is_exception_after;
        $pdf->Text($x_position, $begin_pos_y, $single_char );
        $between_char_spacing_if_is_exception_after += generateSpacingAfterCharInPlayersPlace( $single_char );
    }
}


function printCoach() {
    global $pdf;
    $begin_pos_y = 207.5;
    $begin_pos_x = 17.2;
    $between_char_spacing = 5.9;
    $between_char_spacing_if_is_exception_after = 0;
    $name_array = generateArrayCharNumTextForPrint( $_POST['coach'], 20 );
    for ( $iterator = 0; $iterator < count( $name_array ); $iterator++ ) {
        $single_char = chr( $name_array [ $iterator ] );
        $between_char_spacing_if_is_exception = generateSpacingBeforeCharInTrainerPlace( $single_char );
        $x_position = $begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception + $between_char_spacing_if_is_exception_after;
        $pdf->Text($x_position, $begin_pos_y, $single_char );
        $between_char_spacing_if_is_exception_after += generateSpacingAfterCharInTrainerPlace( $single_char );
    }
}

function printCoachLicenseNumber() {
    global $pdf;
    $begin_pos_y = 207.0;
    $begin_pos_x = 140.2;
    $pdf->SetFont('AbhayaLibre','',14);
    $pdf->Text($begin_pos_x, $begin_pos_y, $_POST['coach_license'] );
    $pdf->SetFont('AbhayaLibre','',12);
}

function printSecondCoach() {
    global $pdf;
    $begin_pos_y = 213.1;
    $begin_pos_x = 17.2;
    $between_char_spacing = 5.9;
    $between_char_spacing_if_is_exception_after = 0;
    $name_array = generateArrayCharNumTextForPrint( $_POST['second_coach'], 20 );
    for ( $iterator = 0; $iterator < count( $name_array ); $iterator++ ) {
        $single_char = chr( $name_array [ $iterator ] );
        $between_char_spacing_if_is_exception = generateSpacingBeforeCharInTrainerPlace( $single_char );
        $x_position = $begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception + $between_char_spacing_if_is_exception_after;
        $pdf->Text($x_position, $begin_pos_y, $single_char );
        $between_char_spacing_if_is_exception_after += generateSpacingAfterCharInTrainerPlace( $single_char );
    }
}

function printMasseur() {
    global $pdf;
    $begin_pos_y = 219.2;
    $begin_pos_x = 17.2;
    $between_char_spacing = 5.9;
    $between_char_spacing_if_is_exception_after = 0;
    $name_array = generateArrayCharNumTextForPrint( $_POST['masseur'], 20 );
    for ( $iterator = 0; $iterator < count( $name_array ); $iterator++ ) {
        $single_char = chr( $name_array [ $iterator ] );
        $between_char_spacing_if_is_exception = generateSpacingBeforeCharInTrainerPlace( $single_char );
        $x_position = $begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception + $between_char_spacing_if_is_exception_after;
        $pdf->Text($x_position, $begin_pos_y, $single_char );
        $between_char_spacing_if_is_exception_after += generateSpacingAfterCharInTrainerPlace( $single_char );
    }
}

function printDoctor() {
    global $pdf;
    $begin_pos_y = 225.3;
    $begin_pos_x = 17.2;
    $between_char_spacing = 5.9;
    $between_char_spacing_if_is_exception_after = 0;
    $name_array = generateArrayCharNumTextForPrint( $_POST['doctor'], 20 );
    for ( $iterator = 0; $iterator < count( $name_array ); $iterator++ ) {
        $single_char = chr( $name_array [ $iterator ] );
        $between_char_spacing_if_is_exception = generateSpacingBeforeCharInTrainerPlace( $single_char );
        $x_position = $begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception + $between_char_spacing_if_is_exception_after;
        $pdf->Text($x_position, $begin_pos_y, $single_char );
        $between_char_spacing_if_is_exception_after += generateSpacingAfterCharInTrainerPlace( $single_char );
    }
}

function printDirector() {
    global $pdf;
    $begin_pos_y = 231.3;
    $begin_pos_x = 17.2;
    $between_char_spacing = 5.9;
    $between_char_spacing_if_is_exception_after = 0;
    $name_array = generateArrayCharNumTextForPrint( $_POST['director'], 20 );
    for ( $iterator = 0; $iterator < count( $name_array ); $iterator++ ) {
        $single_char = chr( $name_array [ $iterator ] );
        $between_char_spacing_if_is_exception = generateSpacingBeforeCharInTrainerPlace( $single_char );
        $x_position = $begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception + $between_char_spacing_if_is_exception_after;
        $pdf->Text($x_position, $begin_pos_y, $single_char );
        $between_char_spacing_if_is_exception_after += generateSpacingAfterCharInTrainerPlace( $single_char );
    }
}

function printDate() {
    global $pdf;
    $date = date("d-m-y", strtotime( $_POST['event_date'] ));
    // $date = $_POST['event_date'];
    // $date = date("d-m-y");
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
    printTshirt( $line_num, $one_line[ 0 ], $is_base_player );
    printName( $line_num, $one_line[ 1 ], $is_base_player );
    printDOB( $line_num, $one_line[ 2 ], $is_base_player );

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

// Clear Place = place without any frame, print char by char, example: team_name
function generateSpacingBeforeCharInClearPlace( $single_char ) {
    if ( $single_char == 'I' || $single_char == ' ') {
        return 0.4;
    } else if ( $single_char == 'W' || $single_char == 'M' ) {
        return 0.2;
    } else {
        return 0;
    }
}

// Clear Place = place without any frame, print char by char, example: team_name
function generateSpacingAfterCharInClearPlace( $single_char )  {
    if ( $single_char == 'W' ) {
        return 0.7;
    } else if ( $single_char == 'M' ) {
        return 0.5;
    } else if ( $single_char == 'J' || $single_char == 'I' || $single_char == 'E' ) {
        return 0.5;
    } else {
        return 0;
    }
}

// Players Place = place where we print players names
function generateSpacingBeforeCharInPlayersPlace( $single_char ) {
    if ( $single_char == 'I' || $single_char == ' ') {
        return 0.8;
    } else if ( $single_char == 'W' || $single_char == 'M') {
        return -0.4;
    } else {
        return 0;
    }
}

// Players Place = place where we print players names
function generateSpacingAfterCharInPlayersPlace( $single_char )  {
    return 0;
}

// Trainer Place = place where we print trainers, doctor, etc
function generateSpacingBeforeCharInTrainerPlace( $single_char ) {
    return 0;
}

// Trainer Place = place where we print trainers, doctor, etc
function generateSpacingAfterCharInTrainerPlace( $single_char )  {
    return 0;
}

printAll();

function generate_name_file() {
    global $pdf;
    $name = "";
    if ( $_POST['raport_type'] == 'gospodarze' ) 
    {
        $name = 'protokol_dla_gospodarzy.pdf';
    }
    if ( $_POST['raport_type'] == 'goscie' ) {
        $name = 'protokol_dla_gospodarzy.pdf';
    }
    else
    {
        $name = 'raport.pdf';
    }
    return $name;
}

$pdf->Output('I', generate_name_file() );

?>