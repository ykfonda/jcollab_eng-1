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

foreach(range('A','R') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

// Set document properties
$objPHPExcel->getProperties()->setCreator("WebCRM")->setLastModifiedBy("WebCRM")->setTitle("Rapprochement_inv");

$headTable = 1;

cellColor($objPHPExcel,'A'.$headTable.':R'.$headTable,'DDDDDD');
foreach(range('A','R') as $columnID) {
	$objPHPExcel->getActiveSheet()->getStyle($columnID.$headTable)->getFont()->setBold(true);
}

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$headTable, 'code_art')
            ->setCellValue('B'.$headTable, 'article')
            ->setCellValue('C'.$headTable, 'valstkini')
            ->setCellValue('D'.$headTable, 'qtstkini')
            ->setCellValue('E'.$headTable, 'qntentree')
            ->setCellValue('F'.$headTable, 'valentree')
            ->setCellValue('G'.$headTable, 'qntsortie')
            ->setCellValue('H'.$headTable, 'valsortie')
            ->setCellValue('I'.$headTable, 'qntvente')
            ->setCellValue('J'.$headTable, 'valvente')
            ->setCellValue('K'.$headTable, 'valstock')
            ->setCellValue('L'.$headTable, 'valstkfin')
            ->setCellValue('M'.$headTable, 'qtstkfin')
            ->setCellValue('N'.$headTable, 'valecart')
            ->setCellValue('O'.$headTable, 'qteecart')
            ->setCellValue('P'.$headTable, 'Prix')
            ->setCellValue('Q'.$headTable, 'famille')
            ->setCellValue('R'.$headTable, '%ecart/vente');

$objPHPExcel->getActiveSheet()->getStyle('A'.$headTable.':R'.$headTable)->applyFromArray($styleBorder);

$objPHPExcel->getActiveSheet()->setTitle('Rapprochement_inv');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$total = 0;
$j = 0;
$inv_ini = 0;
$entrees = 0;
$sorties = 0;$ventes = 0; $stock = 0; $inv_fin = 0;$val_ecart = 0; $ecart_stock = 0;$ecart_ventes = 0;
for ($i = 0; $i < count($taches); $i++){
	$cell = $headTable + $i + 1;
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$cell, $taches[$i]['code_art'])
	            ->setCellValue('B'.$cell, $taches[$i]['article'])
	            ->setCellValue('C'.$cell, $taches[$i]['valstkini'])
	            ->setCellValue('D'.$cell, $taches[$i]['qtstkini'])
	            ->setCellValue('E'.$cell, $taches[$i]['qntEntree'])
                ->setCellValue('F'.$cell, $taches[$i]['valEntree'])
	            ->setCellValue('G'.$cell, $taches[$i]['qntSortie'])
	            ->setCellValue('H'.$cell, $taches[$i]['valSortie'])
                ->setCellValue('I'.$cell, $taches[$i]['qntVente'])
	            ->setCellValue('J'.$cell, $taches[$i]['valVente'])
                ->setCellValue('K'.$cell, $taches[$i]['valStock'])
	            ->setCellValue('L'.$cell, $taches[$i]['valstkfin'])
	            ->setCellValue('M'.$cell, $taches[$i]['qtstkfin'])
	            ->setCellValue('N'.$cell, $taches[$i]['valecart'])
                ->setCellValue('O'.$cell, $taches[$i]['qteEcart'])
	            ->setCellValue('P'.$cell, $taches[$i]['Prix'])
	            ->setCellValue('Q'.$cell, $taches[$i]['famille'])
                ->setCellValue('R'.$cell, $taches[$i]['%ecart/vente']);
                
    $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':R'.$cell)->applyFromArray($styleBorder);
    $j = $i;
    $inv_ini += $taches[$i]['valstkini'];
    $entrees += $taches[$i]['valEntree'];
    $sorties += $taches[$i]['valSortie'];
    $ventes += $taches[$i]['valVente'];
    $stock += $taches[$i]['valStock'];
    $inv_fin += $taches[$i]['valstkfin'];
    $val_ecart += $taches[$i]['valecart'];
    $ecart_stock += $taches[$i]['qteEcart'];
    $ecart_ventes += $taches[$i]['%ecart/vente'];
}
$cell = $headTable + $j + 1;
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$cell, "Total")
	            ->setCellValue('B'.$cell, "")
	            ->setCellValue('C'.$cell, "INV INI")
	            ->setCellValue('D'.$cell, "")
	            ->setCellValue('E'.$cell, "")
                ->setCellValue('F'.$cell, "Entree")
	            ->setCellValue('G'.$cell, "")
	            ->setCellValue('H'.$cell, "Sortie")
                ->setCellValue('I'.$cell, "")
	            ->setCellValue('J'.$cell, "Ventes")
                ->setCellValue('K'.$cell, "Stock")
	            ->setCellValue('L'.$cell, "INV FIN")
	            ->setCellValue('M'.$cell, "")
	            ->setCellValue('N'.$cell, "VAL Ecart")
                ->setCellValue('O'.$cell, "%Ecart Stock")
	            ->setCellValue('P'.$cell, "")
	            ->setCellValue('Q'.$cell, "")
                ->setCellValue('R'.$cell, '%Ecart vente');
                
                foreach(range('A','R') as $columnID) {
                    $objPHPExcel->getActiveSheet()->getStyle($columnID.$cell)->getFont()->setBold(true);
                }
                cellColor($objPHPExcel,'A'.$cell.':R'.$cell,'DDDDDD');
    $cell = $headTable + $j + 2;
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$cell, "Total")
	            ->setCellValue('B'.$cell, "")
	            ->setCellValue('C'.$cell, $inv_ini)
	            ->setCellValue('D'.$cell, "")
	            ->setCellValue('E'.$cell, "")
                ->setCellValue('F'.$cell, $entrees)
	            ->setCellValue('G'.$cell, "")
	            ->setCellValue('H'.$cell, $sorties)
                ->setCellValue('I'.$cell, "")
	            ->setCellValue('J'.$cell, $ventes)
                ->setCellValue('K'.$cell, $stock)
	            ->setCellValue('L'.$cell, $inv_fin)
	            ->setCellValue('M'.$cell, "")
	            ->setCellValue('N'.$cell, $val_ecart)
                ->setCellValue('O'.$cell, $ecart_stock . " %")
	            ->setCellValue('P'.$cell, "")
	            ->setCellValue('Q'.$cell, "")
                ->setCellValue('R'.$cell, $ecart_ventes . " %");
                
    $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':R'.$cell)->applyFromArray($styleBorder);

//die;
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Rapprochement_inv.xls"');
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