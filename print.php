<?php
error_reporting(0);

if (isset($_POST['data'])) {

    $text   = $_POST['data'];

    $printer = printer_open("EPSON TM-U220 Receipt"); 
    printer_write($printer, $text);   
    printer_close($printer);
    
} else {
    
    echo json_encode(array('data' => array(), 'error' => '505'));

}

die();
?>
