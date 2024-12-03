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

foreach(range('A','E') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

// Set document properties
$objPHPExcel->getProperties()->setCreator("WEB-CRM")->setLastModifiedBy("WEB-CRM")->setTitle("HistoriqueDesMouvements");

$headTable = 1;

cellColor($objPHPExcel,'A'.$headTable.':E'.$headTable,'DDDDDD');
foreach(range('A','E') as $columnID) {
	$objPHPExcel->getActiveSheet()->getStyle($columnID.$headTable)->getFont()->setBold(true);
}

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$headTable, 'Référence')
            ->setCellValue('B'.$headTable, 'Produit')
            ->setCellValue('C'.$headTable, 'Date')
            ->setCellValue('D'.$headTable, 'Quantité')
            ->setCellValue('E'.$headTable, 'Opération');

$objPHPExcel->getActiveSheet()->getStyle('A'.$headTable.':E'.$headTable)->applyFromArray($styleBorder);

$objPHPExcel->getActiveSheet()->setTitle('HistoriqueDesMouvements');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$total = 0;
for ($i = 0; $i < count($taches); $i++){
	$cell = $headTable + $i + 1;
    $reste_a_payer = ( isset( $taches[$i][0]['reste_a_payer'] ) ) ? (float) $taches[$i][0]['reste_a_payer'] : 0;
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$cell, $taches[$i]['Mouvement']['reference'])
	            ->setCellValue('B'.$cell, $taches[$i]['Produit']['libelle'])
	            ->setCellValue('C'.$cell, $taches[$i]['Mouvement']['date'])
                ->setCellValue('D'.$cell, $taches[$i]['Mouvement']['stock_source'])
                ->setCellValue('E'.$cell, $this->App->getTypeOperation( $taches[$i]['Mouvement']['operation'] ) );
    $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':E'.$cell)->applyFromArray($styleBorder);
}
//die;
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="HistoriqueDesMouvements.xls"');
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