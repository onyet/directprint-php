<?php
error_reporting(0);

if (isset($_POST['data'])) {

    $text   = $_POST['data'];

    /* tulis dan buka koneksi ke printer */    
    $printer = printer_open("\\OFFICE2-PC\Canon iP2700 series");  
    /* write the text to the print job */  
    printer_write($printer, $text);   
    /* close the connection */ 
    printer_close($printer);

} else {
    
    echo json_encode(array('data' => array(), 'error' => '505'));

}

die();
?>