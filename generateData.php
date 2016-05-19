<?php

// Generate heatmap data
require_once dirname(__FILE__) .'/database/heatmap.php';
$hm = new Heatmap();
//$result = $hm->getDrugConceptId();
$result = $hm->getOutcomeID();

$rowNum = 1;
$colNum = 1;
$current = "";

$file = "/data/outcome.tsv";
$current .= "day\thour\tvalue\n";

foreach ($result as $row) {

    $current .=$rowNum."\t".$colNum."\t".$row["sum(case_count)"]."\n";


     * if($colNum<20){
        $colNum ++;
    }else{
        $colNum = 1;
        $rowNum++;
    }
    
}
$result = file_put_contents($file, $current);
?>
