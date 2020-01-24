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
';

    if ($jenis == 'kredit') {

        $text .= '
NOTA KREDIT '. aturString($tanggal, 18, true);

    } else {
        $text .= '
NOTA TUNAI  '. aturString($tanggal, 18, true);
    
    }

    $text .= '
______________________________
NO. '. aturString($struk, 14) .'  '. aturString(trim($kasir), 10, true);

    if ($anggota !== false) {
        
        $text .= '
ID. '. aturString($anggota['id_anggota'], 15) .' '. strtoupper(aturString($anggota['nama'], 10, true));
    
    }

    $text .= '
..............................
BARANG       QTY @    SUBTOTAL
==============================';

    foreach ($items as $key => $value) {
        
    $text .= '
'. aturString( $value['nama'], 30) .'
'. aturString($value['jumlah'], 4) .' @'. aturString(number_format($value['harga']), 10).'   '. aturString(number_format($value['total']), 11, true);
    
    }

    $text .= '
------------------------------
S.TOTAL  : Rp. '. aturString(number_format($data['stotal']), 15, true) .'
POTONGAN : Rp. '. aturString(number_format($data['potongan']), 15, true);

    if ($voucher) {
        $text .= '
VOUCHER  : Rp. '. aturString(number_format($voucher['potongan']), 15, true);
    }

    $text .= '
          ____________________
TOTAL    : Rp. '. aturString(number_format($data['total']), 15, true) .'
BAYAR    : Rp. '. aturString(number_format($bayar), 15, true) .'
          ____________________
KEMBALI  : Rp. '. aturString(number_format($kembali), 15, true) .'
------------------------------';
    
    if ($anggota !== false) {
        
        $text .= '
     TANDA TANGAN ANGGOTA



    ['. aturString($anggota['nama'], 20, false, '.') .']
Sisa Plafon   Rp. '. aturString(number_format($anggota['sisa'] - $data['total']), 12, true) .'
Belanja Total Rp. '. aturString(number_format($anggota['belanja'] + $data['total']), 12, true);
    }
    
    $text .= '
 Harga Sudah Termasuk PPn 10%
TERIMAKSIH ATAS KEHADIRAN ANDA
        DI MEFOMARKET
';

    $printer = printer_open("EPSON TM-U220 Receipt"); 
    printer_write($printer, $text);   
    printer_close($printer);

} else {
    
    echo json_encode(array('data' => array(), 'error' => '505'));
    die();

}
/*
Fungsi bantuan
*/

function aturString($string, $maxlength = 10, $posisi = false, $replace = ' ') {
    // $posisi = false untuk ubah sisanya jadi whitespace ke kanan
    // $posisi = true untuk ubah sisanya jadi whitespace ke kiri
    if (strlen($string) < $maxlength) {
        
        $a = str_repeat($replace, $maxlength - strlen($string));
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