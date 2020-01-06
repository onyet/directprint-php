<?php
error_reporting(0);

if (isset($_POST['data'])) {

    $data   = $_POST['data'];
    $items  = $data['transaksi'];
    $struk  = $data['nota'];
    $kasir  = strtoupper($data['kasir']);
    $anggota= (isset($data['anggota'])) ? $data['anggota'] : false;
    $voucher= (isset($data['voucher'])) ? $data['voucher'] : false;
    $bayar  = $data['bayar'];
    $kembali= $data['kembalian'];
    $tanggal= $data['tanggal'];
    $jenis  = ($anggota) ? 'kredit' : 'tunai';

    $text = '
         MEFOMARKET          
 JL. PERINTIS KEMERDEKAAN NO.9
   TELP. 0282-544248-CILACAP
______________________________
';

    if ($jenis == 'kredit') {

        $text .= '
NOTA KREDIT '. aturString($tanggal, 20, true);

    } else {
        $text .= '
NOTA TUNAI  '. aturString($tanggal, 20, true);
    
    }

    $text .= '
______________________________
NO. '. aturString($struk, 14) .'  '. aturString($kasir, 10, true);

    if ($anggota !== false) {
        
        $text .= '
ID. '. aturString($anggota['id_anggota'], 15) .' '. strtoupper(aturString($anggota['nama'], 10, true));
    
    }

    $text .= '
..............................
BARANG       QTY @     S.TOTAL';

    foreach ($items as $key => $value) {
        
    $text .= '
'. aturString( $value['nama'], 12) .' '. aturString($value['jumlah'], 3, true) .' '. number_format($value['harga']) .' '. number_format($value['total']);
    
    }

    $text .= '
------------------------------
S.TOTAL  : Rp. '. aturString(number_format($data['stotal']), 15, true) .'
POTONGAN : Rp. '. aturString(number_format($data['potongan']), 15, true) .'
          ____________________
TOTAL    : Rp. '. aturString(number_format($data['total']), 15, true) .'
BAYAR    : Rp. '. aturString(number_format($bayar), 15, true) .'
          ____________________
KEMBALI  : Rp. '. aturString(number_format($kembali), 15, true) .'
------------------------------';
    
    if ($anggota !== false) {
        
        $text .= '
     TANDA TANGAN ANGGOTA



         ['. strtoupper(aturString($anggota['nama']), 10) .']
 Sisa Plafon : Rp. '. aturString(number_format($data['sisa_plafon']), 10, true);
    
    }
    
    $text .= '
 Harga Sudah Termasuk PPn 10%
TERIMAKSIH ATAS KEHADIRAN ANDA
        DI MEFOMARKET
';


    /* tulis dan buka koneksi ke printer */    
    $printer = printer_open("\\OFFICE2-PC\Canon iP2700 series");  
    /* write the text to the print job */  
    printer_write($printer, $text);   
    /* close the connection */ 
    printer_close($printer);

} else {
    
    echo json_encode(array('data' => array(), 'error' => '505'));
    die();

}
/*
Fungsi bantuan
*/

function aturString($string, $maxlength = 10, $posisi = false) {
    // $posisi = false untuk ubah sisanya jadi whitespace ke kanan
    // $posisi = true untuk ubah sisanya jadi whitespace ke kiri
    if (strlen($string) < $maxlength) {
        
        $a = str_repeat(' ', $maxlength - strlen($string));
        $c = $string;

        if ($posisi === false) {
        
            return $c . $a;
        
        } else {
            
            return $a . $c;

        }

    } else {
        
        return substr($string, 0, $maxlength);

    }
}
?>