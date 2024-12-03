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

foreach(range('A','I') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

// Set document properties
$objPHPExcel->getProperties()->setCreator("JCOLLAB")->setLastModifiedBy("JCOLLAB")->setTitle("Productions");

$headTable = 1;

cellColor($objPHPExcel,'A'.$headTable.':I'.$headTable,'DDDDDD');
foreach(range('A','I') as $columnID) {
	$objPHPExcel->getActiveSheet()->getStyle($columnID.$headTable)->getFont()->setBold(true);
}

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$headTable, 'Référence')
            ->setCellValue('B'.$headTable, 'Objet')
            ->setCellValue('C'.$headTable, 'Date')
            ->setCellValue('D'.$headTable, 'Responsable')
            ->setCellValue('E'.$headTable, 'Dépot')
            ->setCellValue('F'.$headTable, 'Produit')
            ->setCellValue('G'.$headTable, 'Quantité')
            ->setCellValue('H'.$headTable, 'Statut')
            ->setCellValue('I'.$headTable, 'Date création');

$objPHPExcel->getActiveSheet()->getStyle('A'.$headTable.':I'.$headTable)->applyFromArray($styleBorder);

$objPHPExcel->getActiveSheet()->setTitle('Productions');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$total = 0;
for ($i = 0; $i < count($taches); $i++){
	$cell = $headTable + $i + 1;
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$cell, $taches[$i]['Production']['reference'])
	            ->setCellValue('B'.$cell, $taches[$i]['Production']['libelle'])
	            ->setCellValue('C'.$cell, $taches[$i]['Production']['date'])
	            ->setCellValue('D'.$cell, $taches[$i]['User']['nom'].' '.$taches[$i]['User']['prenom'])
                ->setCellValue('E'.$cell, $taches[$i]['Depot']['libelle'])
	            ->setCellValue('F'.$cell, $taches[$i]['Produit']['libelle'])
	            ->setCellValue('G'.$cell, $taches[$i]['Production']['quantite'])
                ->setCellValue('H'.$cell, $this->App->getValideEntree($taches[$i]['Production']['statut']) )
                ->setCellValue('I'.$cell, $taches[$i]['Production']['date_c']);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':I'.$cell)->applyFromArray($styleBorder);
}
//die;
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Productions.xls"');
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