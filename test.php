<?php

require_once __DIR__ . '/vendor/autoload.php';

$contents = file_get_contents('output.php');

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($contents);
$mpdf->Output();

?>