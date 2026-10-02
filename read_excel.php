<?php
require 'vendor/autoload.php';
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template_alumni.xlsx');
$data = $spreadsheet->getActiveSheet()->toArray();
foreach ($data as $row) {
    if (implode('', $row) !== '') {
        echo implode(' | ', array_filter(array_slice($row, 0, 10))) . "\n";
    }
}
