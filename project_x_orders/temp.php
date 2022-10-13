<?php

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
require('fpdf184/fpdf.php');
require('fpdf184/makefont/makefont.php');
//require('fpdi2/src/DejaVuSansCondensed.ttf');
require_once('fpdi2/src/autoload.php');

$pdf = new Fpdi();
//$pdf->AddFont('DejaVu','','DejaVuSansCondensed.php');
$pageCount = $pdf->setSourceFile('test.pdf');
$pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);
$pdf->addPage();
$pdf->useImportedPage($pageId, 0, 0 );
//MakeFont('fpdi2/src/DejaVuSansCondensed.ttf','ISO-8859-2');
//$pdf->SetFont('Symbol','B',12);

$pdf->SetFont('Arial','',12);

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
        // var_dump($one_line);
        // echo"</br></br>";
        $iterator = 0;
        $tshirt = "";
        $name = "";
        $dob = "";
        $array_one_lane = array();
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
        array_push($array_one_lane, $tshirt, $name, $dob);


        array_push($new_complete_generator_data, $array_one_lane);
    }
    return $new_complete_generator_data;
}

$all_data_array = generateArrayData();
//var_dump(generateArrayData());
function printAll() {
    global $all_data_array;
    for ( $iterator = 0; $iterator < count( $all_data_array ); $iterator++ ) {
        // echo "</br>";
        // var_dump( $all_data_array[ $iterator ] );
        printOneLine( $iterator, $all_data_array[ $iterator ] );
    }

}

function printOneLine( $line_num, $one_line ) {
    //echo "test</br>";
    printTshirt( $line_num, $one_line[ 0 ] );
    //var_dump( $one_line[ 1 ]  );
    printName( $line_num, $one_line[ 1 ] );
    printDOB( $line_num, $one_line[ 2 ] );

}


function printName($line_num, $print_text) {
    global $pdf;<?php

    use setasign\Fpdi\Fpdi;
    use setasign\Fpdi\PdfReader;
    require('fpdf184/fpdf.php');
    require_once('fpdi2/src/autoload.php');
    //require('fpdf184/makefont/makefont.php');
    //MakeFont('fpdi2/src/AbhayaLibre-Regular.ttf','ISO-8859-2');
    $pdf = new Fpdi();
    $pdf->AddFont('AbhayaLibre','','AbhayaLibre-Regular.php', true);
    $pageCount = $pdf->setSourceFile('test.pdf');
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
    
    function generateArrayData() {
        global $post_array_data;
        global $separator_generate_data;
        $row_array_generate_data = getPostDataToGenerateArray();
        $new_complete_generator_data = array();
        foreach( $row_array_generate_data as $one_line ) {
            // var_dump($one_line);
            // echo"</br></br>";
            $iterator = 0;
            $tshirt = "";
            $name = "";
            $dob = "";
            $array_one_lane = array();
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
            array_push($array_one_lane, $tshirt, $name, $dob);
    
    
            array_push($new_complete_generator_data, $array_one_lane);
        }
        return $new_complete_generator_data;
    }
    
    $all_data_array = generateArrayData();
    //var_dump(generateArrayData());
    function printAll() {
        global $all_data_array;
        for ( $iterator = 0; $iterator < count( $all_data_array ); $iterator++ ) {
            // echo "</br>";
            // var_dump( $all_data_array[ $iterator ] );
            printOneLine( $iterator, $all_data_array[ $iterator ] );
        }
        global $pdf;
        //$pdf->Text(39.5, 49, 'ŁŁŁŁŁŚŚŚŚŻŻŻŻąąąąęęę');
    
    }
    
    function printOneLine( $line_num, $one_line ) {
        //echo "test</br>";
        printTshirt( $line_num, $one_line[ 0 ] );
        //var_dump( $one_line[ 1 ]  );
        printName( $line_num, $one_line[ 1 ] );
        printDOB( $line_num, $one_line[ 2 ] );
    
    }
    
    function printName($line_num, $print_text) {
        global $pdf;
        $bottom_spacing = 0;
        if ( $line_num >= 11 ) {
            $bottom_spacing = 9.9;
        } 
        $begin_pos_x = 25.5;
        $begin_pos_y = ( $line_num * 6.6 ) + 49 + $bottom_spacing;
        $between_char_spacing = 4.88;
        $between_char_spacing_if_is_exception = 1.5;
        $print_text = strtoupper($print_text);
        //echo strlen($print_text)."</br>";
        //var_dump( $print_text );
        $avoid_indexes = 0;
        
        for ( $i = 0; $i < strlen($print_text); $i++ ) {
            $iterator = $i - $avoid_indexes;
            
            if ( ord( $print_text[ $iterator ] ) > 125 ) {
                if ( ord( $print_text[ $iterator ] ) == 152 || ord( $print_text[ $iterator ] ) == 153 ) {
                    $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception, $begin_pos_y, chr(202) );
                } else if ( ord( $print_text[ $iterator ] ) == 147 || ord( $print_text[ $iterator ] ) == 179 ) {
                    $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception, $begin_pos_y, chr(211) );
                } else if ( ord( $print_text[ $iterator ] ) == 132 || ord( $print_text[ $iterator ] ) == 133 ) {
                    $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception, $begin_pos_y, chr(161) );
                } else if ( ord( $print_text[ $iterator ] ) == 154 || ord( $print_text[ $iterator ] ) == 155 ) {
                    $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception, $begin_pos_y, chr(166) );
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
                $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception, $begin_pos_y, $print_text[ $iterator ] );
            }
            // if ( $line_num == 16 ) {
            //     //$pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception, $begin_pos_y, chr(178) );
            //     echo $iterator.'. '.ord( $print_text[ $iterator ] ).'</br>';
            // }
            //echo $iterator." test = ".ord($print_text[ $iterator ])."</br>";
            //echo chr($print_text[ $iterator ])."</br>";
             //$print_char =  iconv('UTF-8', 'ISO-8859-2//TRANSLIT//IGNORE', $print_text[ $iterator ]);
            //$pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception, $begin_pos_y, $print_text[ $iterator ] );
            
        }
    }
    
    function printTshirt($line_num, $print_text) {
        global $pdf;
        $bottom_spacing = 0;
        if ( $line_num >= 11 ) {
            $bottom_spacing = 9.6;
        } 
        $begin_pos_x = 18.5;
        $begin_pos_y = ( $line_num * 6.58 ) + 49 + $bottom_spacing;
        $between_char_spacing = 5.3;
        $between_char_spacing_if_is_exception = 1.5;
        $print_text = strtoupper($print_text);
    
        $pdf->Text( $begin_pos_x, $begin_pos_y, $print_text );
    
    }
    
    function printDOB($line_num, $print_text) {
        global $pdf;
        $bottom_spacing = 0;
        if ( $line_num >= 11 ) {
            $bottom_spacing = 9.7;
        } 
        $begin_pos_x = 138.5;
        $begin_pos_y = ( $line_num * 6.60 ) + 49 + $bottom_spacing;
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
    $bottom_spacing = 0;
    if ( $line_num >= 11 ) {
        $bottom_spacing = 9.9;
    } 
    $begin_pos_x = 25.5;
    $begin_pos_y = ( $line_num * 6.6 ) + 49 + $bottom_spacing;
    $between_char_spacing = 4.88;
    $between_char_spacing_if_is_exception = 1.5;
    $print_text = strtoupper($print_text);
    //echo strlen($print_text)."</br>";
    //var_dump( $print_text );
    
    for ( $iterator = 0; $iterator < strlen($print_text); $iterator++ ) {
        if ( $print_text[ $iterator ] == 'I' || $print_text[ $iterator ] == ' ') {
            $between_char_spacing_if_is_exception = 0.8;
        } else if ( $print_text[ $iterator ] == 'W' || $print_text[ $iterator ] == 'M') {
            $between_char_spacing_if_is_exception = -0.8;
        } else {
            $between_char_spacing_if_is_exception = 0;
        }
        $pdf->Text($begin_pos_x + ( $iterator * $between_char_spacing ) + $between_char_spacing_if_is_exception, $begin_pos_y, $print_text[ $iterator ] );
    }
}

function printTshirt($line_num, $print_text) {
    global $pdf;
    $bottom_spacing = 0;
    if ( $line_num >= 11 ) {
        $bottom_spacing = 9.6;
    } 
    $begin_pos_x = 18.5;
    $begin_pos_y = ( $line_num * 6.58 ) + 49 + $bottom_spacing;
    $between_char_spacing = 5.3;
    $between_char_spacing_if_is_exception = 1.5;
    $print_text = strtoupper($print_text);

    $pdf->Text( $begin_pos_x, $begin_pos_y, $print_text );

}

function printDOB($line_num, $print_text) {
    global $pdf;
    $bottom_spacing = 0;
    if ( $line_num >= 11 ) {
        $bottom_spacing = 9.7;
    } 
    $begin_pos_x = 138.5;
    $begin_pos_y = ( $line_num * 6.60 ) + 49 + $bottom_spacing;
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

//printAll();
$pdf->Text(24.5, 49, 'XXXXXXXXXXXXXXXXXXXXXXx');
////$pdf->SetFont('Arial','',12);
////$pdf->Text(29.5, 49, 'ccccccccccccccccccccccccccccc');
// $pdf->Text(34.5, 49, 'C');
// $pdf->Text(39.5, 49, 'D');
$pdf->Output();

?>