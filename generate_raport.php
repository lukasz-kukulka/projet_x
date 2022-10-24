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
        return chr(202);
    } else if ( ord( $char ) == 147 || ord( $char ) == 179 ) {
        return chr(211);
    } else if ( ord( $char ) == 132 || ord( $char ) == 133 ) {
        return chr(161);
    } else if ( ord( $char ) == 154 || ord( $char ) == 155 ) {
        return chr(166);
    } else if ( ord( $char ) == 129 || ord( $char ) == 130 ) {
        return chr(163);
    } else if ( ord( $char ) == 187 || ord( $char ) == 188 ) {
        return chr(175);
    } else if ( ord( $char ) == 185 || ord( $char ) == 186 ) {
        return chr(172);
    } else if ( ord( $char ) == 134 || ord( $char ) == 135 ) {
        return chr(198);
    } else if ( ord( $char ) == 131 || ord( $char ) == 132 ) {
        return chr(209);
    } else {
        return chr(0);
    }
}

function printTeamName(){
    global $pdf;
    $begin_pos_y = 23;
    $begin_pos_x = 39.5;
    $between_char_spacing = 2.5;
    $print_text = $_POST['team_name'];
    $between_char_spacing_if_is_exception = 0;
    // $data = generateTeamPrintName();
    // $pdf->SetFont('AbhayaLibre','',10);
    // for ( $iterator = 0; $iterator < strlen($data); $iterator++ ) {
    //     $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ), $begin_pos_y, strtoupper( $data[ $iterator ] ) );
    // }
    // $pdf->SetFont('AbhayaLibre','',12);
    $pdf->SetFont('AbhayaLibre','',10);
    $avoid_indexes = 0;

    $between_char_spacing_if_is_exception_after = 0.0;
    for ( $iterator = 0; $iterator - $avoid_indexes < 32; $iterator++ ) {
        $new_space_between = $avoid_indexes * $between_char_spacing;
        if ( ord( $print_text[ $iterator ] ) > 125 ) {
            //Ę Ó Ą Ś Ł Ż Ź Ć Ń 
            $x_position = $begin_pos_x + ( $iterator * $between_char_spacing ) - $new_space_between + $between_char_spacing_if_is_exception_after;
            // $get_char = getPolishCharacterNumber( $print_text[ $iterator ] );
            // if ( $get_char == 0 ) {
            //     $avoid_indexes++;
            // } else {
            //     $pdf->Text($x_position, $begin_pos_y, $get_char );
            // }
            if ( ord( $print_text[ $iterator ] ) == 152 || ord( $print_text[ $iterator ] ) == 153 ) { 
                $pdf->Text($x_position, $begin_pos_y, chr(202) );
            } else if ( ord( $print_text[ $iterator ] ) == 147 || ord( $print_text[ $iterator ] ) == 179 ) {
                $pdf->Text($x_position, $begin_pos_y, chr(211) );
            } else if ( ord( $print_text[ $iterator ] ) == 132 || ord( $print_text[ $iterator ] ) == 133 ) {
                $pdf->Text($x_position, $begin_pos_y, chr(161) );
            } else if ( ord( $print_text[ $iterator ] ) == 154 || ord( $print_text[ $iterator ] ) == 155 ) {
                $pdf->Text($x_position, $begin_pos_y, chr(166) );
            } else if ( ord( $print_text[ $iterator ] ) == 129 || ord( $print_text[ $iterator ] ) == 130 ) {
                $pdf->Text($x_position, $begin_pos_y, chr(163) );
            } else if ( ord( $print_text[ $iterator ] ) == 187 || ord( $print_text[ $iterator ] ) == 188 ) {
                $pdf->Text($x_position, $begin_pos_y, chr(175) );
            } else if ( ord( $print_text[ $iterator ] ) == 185 || ord( $print_text[ $iterator ] ) == 186 ) {
                $pdf->Text($x_position, $begin_pos_y, chr(172) );
            } else if ( ord( $print_text[ $iterator ] ) == 134 || ord( $print_text[ $iterator ] ) == 135 ) {
                $pdf->Text($x_position, $begin_pos_y, chr(198) );
            } else if ( ord( $print_text[ $iterator ] ) == 131 || ord( $print_text[ $iterator ] ) == 132 ) {
                $pdf->Text($x_position, $begin_pos_y, chr(209) );
            } else {
                $avoid_indexes++;
            }
        }
        else {
            if ( strtoupper( $print_text[ $iterator ] ) == 'I' || $print_text[ $iterator ] == ' ') {
                $between_char_spacing_if_is_exception = 0.4;
            } else if ( strtoupper( $print_text[ $iterator ] ) == 'W' || strtoupper( $print_text[ $iterator ] ) == 'M' ) {
                $between_char_spacing_if_is_exception = 0.2;
            } else {
                $between_char_spacing_if_is_exception = 0;
            }
            $x_position = $begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception - $new_space_between + $between_char_spacing_if_is_exception_after;
            $pdf->Text($x_position, $begin_pos_y, strtoupper( $print_text[ $iterator ] ) );
            if ( strtoupper( $print_text[ $iterator ] ) == strtoupper('W') ) {
                $between_char_spacing_if_is_exception_after += 0.7;
            } else if ( strtoupper( $print_text[ $iterator ] ) == strtoupper('M') ) {
                $between_char_spacing_if_is_exception_after += 0.5;
            } else if ( strtoupper( $print_text[ $iterator ] ) == strtoupper('J') || strtoupper( $print_text[ $iterator ] ) == strtoupper('I') || strtoupper( $print_text[ $iterator ] ) == strtoupper('E') ) {
                $between_char_spacing_if_is_exception_after -= 0.5;
            }
        }
    }
    $pdf->SetFont('AbhayaLibre','',12);
}

// function generateTeamPrintName() {
//     $data = $_POST['team_name'];
//     $team = "";
//     $avoid_indexes = 0;
//     $avoid_increment_char = array( 152, 153, 147, 179, 132, 133, 154, 155, 129, 130, 187, 188, 185, 186, 134, 135, 131, 132 );
//     //in_array( ord( $text[ $iterator ] ), $polish_alphabet ) )
//     for ( $iterator = 0; $iterator < 25; $iterator++ ) {
//         if ( !in_array( ord( $data[ $iterator ] ), $avoid_increment_char )  ) {
//             $avoid_indexes++;
//         } else {
//             $team = $team.$data[ $iterator ];
//         }
//     }
//     return $team;
// }

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
    printTshirt( $line_num, $one_line[ 0 ], $is_base_player );
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
                $avoid_indexes++;
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