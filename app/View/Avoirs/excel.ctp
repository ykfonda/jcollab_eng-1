<?php 
require_once(APP . 'Vendor' . DS . 'PHPExcel' . DS . 'PHPExcel.php'); 
PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
function cellColor(&$objPHPExcel,$cells,$color = 'DDDDDD'){
    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

$styleBorder = array(
	'borders' => array(
		'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,)
	),
);

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('PHPExcel logo');
$objDrawing->setDescription('PHPExcel logo');
$objDrawing->setPath('img/logo.jpg');
$objDrawing->setHeight(60);
//$objDrawing->setWidth(100);
$objDrawing->setCoordinates('A1');
$objDrawing->setOffsetX(-0);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$objPHPExcel->getActiveSheet()->getStyle("D3")->applyFromArray(['alignment' => ['horizontal' => 'left'], 'font' => ['bold' => false, 'size' => '16', 'color' =>  ['rgb' => 'FF0000'] ] ]);
//$objPHPExcel->getActiveSheet()->getStyle("E2")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells("D3:F3");

foreach(range('A','F') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

// Set document properties
$objPHPExcel->getProperties()->setCreator("WebStock")->setLastModifiedBy("WebStock")->setTitle("MouvementStock");

$headTable = 8;

cellColor($objPHPExcel,'A'.$headTable.':F'.$headTable,'DDDDDD');
foreach(range('A','F') as $columnID) {
	$objPHPExcel->getActiveSheet()->getStyle($columnID.$headTable)->getFont()->setBold(true);
}

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$headTable, 'Article')
            ->setCellValue('B'.$headTable, 'Prix d\'achat')
            ->setCellValue('C'.$headTable, 'Date')
            ->setCellValue('D'.$headTable, 'Quantité')
            ->setCellValue('E'.$headTable, 'Opération')
            ->setCellValue('F'.$headTable, 'Description');

$objPHPExcel->getActiveSheet()->getStyle('A'.$headTable.':F'.$headTable)->applyFromArray($styleBorder);

$objPHPExcel->getActiveSheet()->setTitle('MouvementStock');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$total = 0;
for ($i = 0; $i < count($taches); $i++){
	$cell = $headTable + $i + 1;
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$cell, $taches[$i]['Earticle']['libelle'])
	            ->setCellValue('B'.$cell, $taches[$i]['Emvtstock']['prixachat'])
	            ->setCellValue('C'.$cell, $taches[$i]['Emvtstock']['date'])
	            ->setCellValue('D'.$cell, $taches[$i]['Emvtstock']['qte'])
	            ->setCellValue('E'.$cell, $this->Article->getOperation($taches[$i]['Emvtstock']['type']))
	            ->setCellValue('F'.$cell, $taches[$i]['Emvtstock']['description']);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':F'.$cell)->applyFromArray($styleBorder);
}
//die;
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="MouvementStock.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;