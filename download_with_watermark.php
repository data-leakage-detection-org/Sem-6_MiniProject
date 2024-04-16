<?php 
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\Fpdf;
require_once('vendor/autoload.php');

session_start();

date_default_timezone_set('Asia/Kolkata');

$username=$_SESSION['username']."-".date('d-m-Y H:i:s');

function addWatermark($x, $y, $watermarkText, $angle, $pdf)
{
    $angle = $angle * M_PI / 180;
    $c = cos($angle);
    $s = sin($angle);
    $cx = $x * 1;
    $cy = (300 - $y) * 1;
    $pdf->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, - $s, $c, $cx, $cy, - $cx, - $cy));
    $pdf->Text($x, $y, $watermarkText);
    $pdf->_out('Q');
}

$pdf = new Fpdi();
$fileInput = "assets/files/".$_GET["name"];
$pages_count = $pdf->setSourceFile($fileInput);
for ($i = 1; $i <= $pages_count; $i ++) {
    $pdf->AddPage();
    $tplIdx = $pdf->importPage($i);
    $pdf->useTemplate($tplIdx, 0, 0);
    $pdf->SetFont('Times', 'B', 30);
    $pdf->SetTextColor(192, 192, 192);
    $watermarkText = $username;
    addWatermark(105, 220, $watermarkText, 45, $pdf);
    $pdf->SetXY(25, 25);
}
$pdf->Output();


?>