<?php
//references
//https://phpoffice.github.io/PhpSpreadsheet/classes/PhpOffice-PhpSpreadsheet-Style-NumberFormat.html
//https://phpspreadsheet.readthedocs.io/en/latest/topics/recipes/

//database
require '../../configuration.php';

//call the autoload
require 'vendor/autoload.php';

//load phpspreadsheet class using namespaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//call iofactory instead of xlsx writer
use PhpOffice\PhpSpreadsheet\IOFactory;

//make a new spreadsheet object
$spreadsheet = new Spreadsheet();
//get current active sheet (first sheet)
$sheet = $spreadsheet->getActiveSheet();

//populate the data
$sql = "SELECT * FROM inv_pickups";
$pickups = mysqli_query($connection,$sql);
$row = 3;
while($pickup = mysqli_fetch_object($pickups)){
  $spreadsheet->getActiveSheet()

	->setCellValue('A'.$row , $pickup->id)
	->setCellValue('B'.$row , $pickup->ean)
	->setCellValue('C'.$row , $pickup->upc)
	->setCellValue('D'.$row , $pickup->category)
	->setCellValue('E'.$row , $pickup->item_name)
	->setCellValue('F'.$row , $pickup->cover)
	->setCellValue('G'.$row , $pickup->description)
	->setCellValue('H'.$row , $pickup->price)
	->setCellValue('I'.$row , $pickup->weight)
	->setCellValue('J'.$row , $pickup->notes)
	->setCellValue('K'.$row , $pickup->img_path);
    //increment the row
    $row++;
}


$d_d_t = date("F d, Y g:i:a");
//set the value of cell a1 to "Hello World!"
$sheet->setCellValue('A1', 'Kinman Barcoded List ('.$d_d_t.')');
$spreadsheet->getActiveSheet()->mergeCells('A1:K1');
$sheet->getStyle('A1:K1')->getAlignment()->setHorizontal('center');
//column names
$sheet->setCellValue('A2', 'ID');
$sheet->setCellValue('B2', 'EAN');
$sheet->setCellValue('C2', 'UPC');
$sheet->setCellValue('D2', 'Category');
$sheet->setCellValue('E2', 'Item Name');
$sheet->setCellValue('F2', 'Cover');
$sheet->setCellValue('G2', 'Description');
$sheet->setCellValue('H2', 'Price');
$sheet->setCellValue('I2', 'Weight');
$sheet->setCellValue('J2', 'Notes');
$sheet->setCellValue('K2', 'Image path');

$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('H')->setAutoSize(true);
$sheet->getColumnDimension('I')->setAutoSize(true);
// $sheet->getColumnDimension('J')->setAutoSize(true);


$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(40, 'cm'); //item name
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(45, 'cm'); //description
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(35, 'cm'); //notes
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(19, 'cm'); //image path

$spreadsheet->getActiveSheet()->getStyle('E3:E'.$row)->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('G3:G'.$row)->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('J3:J'.$row)->getAlignment()->setWrapText(true);


$spreadsheet->getActiveSheet()->getStyle('A3:K'.$row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

$spreadsheet->getActiveSheet()->getStyle('A3:A'.$row)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
$spreadsheet->getActiveSheet()->getStyle('C3:C'.$row)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
$spreadsheet->getActiveSheet()->getStyle('H3:H'.$row)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

//set the header first, so the result will be treated as an xlsx file.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

//make it an attachment so we can define filename
$dateT = date("F d, Y");
header('Content-Disposition: attachment;filename="Kinman Barcoded List '.$dateT.'.xlsx"');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');


?>