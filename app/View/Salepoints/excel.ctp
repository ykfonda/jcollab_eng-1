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

foreach(range('A','K') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

// Set document properties
$objPHPExcel->getProperties()->setCreator("WebCRM")->setLastModifiedBy("WebCRM")->setTitle("Ventes_Pos");

$headTable = 1;

cellColor($objPHPExcel,'A'.$headTable.':K'.$headTable,'DDDDDD');
foreach(range('A','K') as $columnID) {
	$objPHPExcel->getActiveSheet()->getStyle($columnID.$headTable)->getFont()->setBold(true);
}

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$headTable, 'code_art')
            ->setCellValue('B'.$headTable, 'article')
            ->setCellValue('C'.$headTable, 'qte')
            ->setCellValue('D'.$headTable, 'pv_ttc')
            ->setCellValue('E'.$headTable, 'remise')
            ->setCellValue('F'.$headTable, 'mnt_ttc')
            ->setCellValue('G'.$headTable, 'tva')
            ->setCellValue('H'.$headTable, 'mnt_brut')
            ->setCellValue('I'.$headTable, 'valremise')
            ->setCellValue('J'.$headTable, 'vendeur')
            ->setCellValue('K'.$headTable, 'boucher');
           

$objPHPExcel->getActiveSheet()->getStyle('A'.$headTable.':K'.$headTable)->applyFromArray($styleBorder);

$objPHPExcel->getActiveSheet()->setTitle('Ventes_Pos');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$total = 0;
$i = 0;
while ($i < count($taches)) {
    if($i == 0) $cell = $headTable + $i + 1;
	else $cell = $cell +  1;
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$cell, "")
	            ->setCellValue('B'.$cell, $taches[$i]['Salepoint']['reference'] . " du " . $taches[$i]['Salepoint']['date'])
	            ->setCellValue('D'.$cell, "")
                ->setCellValue('E'.$cell, "")
	            ->setCellValue('F'.$cell, "")
	            ->setCellValue('G'.$cell, "")
                ->setCellValue('H'.$cell, "")
                ->setCellValue('I'.$cell, "")
                ->setCellValue('J'.$cell, "")
                ->setCellValue('K'.$cell, "");
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':K'.$cell)->applyFromArray($styleBorder);

    $k = 1;
    for ($j = 0; $j < count($taches[$i]['Salepointdetail']); $j++) {
        $cell = $cell + 1;
        $valremise = $taches[$i]['Salepointdetail'][$j]['montant_remise'];
        /* $valremise = $taches[$i]['Salepointdetail'][$j]['ttc'] - $remise; */
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$cell, $taches[$i]['Salepointdetail'][$j]['Produit']["code_barre"])
        ->setCellValue('B'.$cell, $taches[$i]['Salepointdetail'][$j]['Produit']['libelle'])
        ->setCellValue('C'.$cell, $taches[$i]['Salepointdetail'][$j]['qte'])
        ->setCellValue('D'.$cell, $taches[$i]['Salepointdetail'][$j]['prix_vente'])
        ->setCellValue('E'.$cell, $taches[$i]['Salepointdetail'][$j]['remise'])
        ->setCellValue('F'.$cell, $taches[$i]['Salepointdetail'][$j]['ttc'])
        ->setCellValue('G'.$cell, $taches[$i]['Salepointdetail'][$j]['Produit']['tva_vente'])
        ->setCellValue('H'.$cell, $taches[$i]['Salepointdetail'][$j]['total'])
        ->setCellValue('I'.$cell, $valremise)
        ->setCellValue('J'.$cell, $taches[$i]['User']['nom'] . " " . $taches[$i]['User']['prenom'])
        ->setCellValue('K'.$cell, $taches[$i]['Salepoint']['boucher']);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':K'.$cell)->applyFromArray($styleBorder);   
        $k++;
    }
    
    $cell = $cell  + 1;
    $total = "Total : ";
    for ($j = 0; $j < count($taches[$i]['Avance']); $j++) {
        $total .= $taches[$i]['Avance'][$j]["mode"] . " : " .$taches[$i]['Avance'][$j]["montant"]; 
    }
    
    $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$cell, "")
	            ->setCellValue('B'.$cell, $total)
	            ->setCellValue('C'.$cell, "")
	            ->setCellValue('D'.$cell, "")
                ->setCellValue('E'.$cell, "")
	            ->setCellValue('F'.$cell, "")
	            ->setCellValue('G'.$cell, "")
                ->setCellValue('H'.$cell, "")
                ->setCellValue('I'.$cell, "")
                ->setCellValue('J'.$cell, "")
                ->setCellValue('K'.$cell, "");

                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':K'.$cell)->applyFromArray($styleBorder);
    $i++;
            }

           
//die;
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Ventes_Pos.xls"');
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