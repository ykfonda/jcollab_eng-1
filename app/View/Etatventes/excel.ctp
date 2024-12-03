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

foreach(range('A','J') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

// Set document properties
$objPHPExcel->getProperties()->setCreator("CRM-SOFT")->setLastModifiedBy("CRM-SOFT")->setTitle("EtatVentesParDetails");

$headTable = 1;

cellColor($objPHPExcel,'A'.$headTable.':J'.$headTable,'DDDDDD');
foreach(range('A','J') as $columnID) {
	$objPHPExcel->getActiveSheet()->getStyle($columnID.$headTable)->getFont()->setBold(true);
}

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$headTable, 'Date')
            ->setCellValue('B'.$headTable, 'Code à barre')
            ->setCellValue('C'.$headTable, 'Référence')
            ->setCellValue('D'.$headTable, 'Libelle')
            ->setCellValue('E'.$headTable, 'Quantité')
            ->setCellValue('F'.$headTable, "Prix d'achat")
            ->setCellValue('G'.$headTable, "Total par prix d'achat")
            ->setCellValue('H'.$headTable, 'Prix de vente')
            ->setCellValue('I'.$headTable, 'Total par prix de vente')
            ->setCellValue('J'.$headTable, 'Marge bénéficiaire');

$objPHPExcel->getActiveSheet()->getStyle('A'.$headTable.':J'.$headTable)->applyFromArray($styleBorder);

$objPHPExcel->getActiveSheet()->setTitle('EtatVentesParDetails');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$total = 0;
for ($i = 0; $i < count($taches); $i++){
	$cell = $headTable + $i + 1;
    $valeur_achat = $taches[$i]['Bonlivraisondetail']['qte']*$taches[$i]['Produit']['prixachat'];
    $marge_binificaire = $taches[$i]['Bonlivraisondetail']['total']-$valeur_achat;

	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$cell, $taches[$i]['Bonlivraison']['date'])
	            ->setCellValue('B'.$cell, $taches[$i]['Produit']['code_barre'])
	            ->setCellValue('C'.$cell, $taches[$i]['Produit']['reference'])
                ->setCellValue('D'.$cell, $taches[$i]['Produit']['libelle'])
                ->setCellValue('E'.$cell, $taches[$i]['Bonlivraisondetail']['qte'])
                ->setCellValue('F'.$cell, $taches[$i]['Produit']['prixachat'])
                ->setCellValue('G'.$cell, $valeur_achat)
                ->setCellValue('H'.$cell, $taches[$i]['Bonlivraisondetail']['prix_vente'])
                ->setCellValue('I'.$cell, $taches[$i]['Bonlivraisondetail']['total'])
                ->setCellValue('J'.$cell, $marge_binificaire);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':J'.$cell)->applyFromArray($styleBorder);
}
//die;
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="EtatVentesParDetails.xls"');
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