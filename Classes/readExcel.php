<?php

require_once('PHPExcel.php');

function readExcelFile(){

    $path = __DIR__.'/../excel.xlsx';
    $reader = PHPExcel_IOFactory::createReaderForFile($path);
    $readerExcel = $reader->load($path);
    $worksheet = $readerExcel->getSheet('0');
    $worksheet2 = $readerExcel->getSheet('1');
    $worksheet3 = $readerExcel->getSheet('2');

    $lastRow = $worksheet->getHighestRow();
    $lastRow2 = $worksheet2->getHighestRow();
    $lastRow3 = $worksheet3->getHighestRow();
// var_dump($lastRow2);
    $colString = $worksheet->getHighestDataColumn();

    $colList = [];
    $colList2 = [];
    $colList3 = [];

    for ($i=0; $i < $lastRow ; $i++) { 
        // echo $i;
        $colList[$worksheet->getCell('A'.$i)->getValue()] =  $worksheet->getCell('B'.$i)->getValue();
    }

    for ($i=0; $i < $lastRow2 ; $i++) { 
        // echo $i;
        $colList2[$worksheet2->getCell('A'.$i)->getValue()] =  $worksheet2->getCell('B'.$i)->getValue();
    }

    for ($i=0; $i < $lastRow3 ; $i++) { 
        // echo $i;
        $colList3[$worksheet3->getCell('A'.$i)->getValue()] =  $worksheet3->getCell('B'.$i)->getValue();
    }


    $msg = [];
    $qtn = [];
    $reply = [];

    foreach($colList as $key => $val){
        if (strpos($key, 'msg')) {
        $msg[$key] = str_replace(['_x000D_', '**'], '', $val) ;
        }
            
    }

    foreach($colList2 as $key => $val){
        // if (strpos($key, 'qtn')) {
            // echo'hi';
        $qtn[$key] = $val ;
        // }
            
    }

    foreach($colList3 as $key => $val){
        // if (strpos($key, 'cm')) {
        $reply[$key] = str_replace(['_x000D_', '**'], '', $val) ;
        // }
            
    }
// var_dump($reply);
    //  echo '<pre>';
    //     print_r($msg);
    //     echo '<pre>';

    return ['msg'=>$msg,'qtn' => $qtn, 'reply'=>$reply];
       
}

