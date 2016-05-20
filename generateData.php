<?php

// Generate heatmap data
require_once dirname(__FILE__) .'/database/heatmap.php';
$hm = new Heatmap();



/** Group by Drug**/
/*$result = $hm->getDrugConceptId();

$rowNum = 1;
$colNum = 1;
$current = "";

$file = "./data/drug.tsv";
$current .= "day\thour\tvalue\tdrug name\n";

foreach ($result as $row) {

    $drugId = $row['drug_concept_id'];
    $drugName = $hm->getDrugNameByID($drugId);
    var_dump($drugName);
    $current .=$rowNum."\t".$colNum."\t".$row["sum(case_count)"]."\t".$drugName . "\n";

     if($colNum<20){
        $colNum ++;
    }else{
        $colNum = 1;
        $rowNum++;
    }

}
$result = file_put_contents($file, $current);
*/

/** Group by Outcome**/

$result = $hm->getOutcomeID();

$rowNum = 1;
$colNum = 1;
$current = "";

$file = "./data/outcome.tsv";
$current .= "day\thour\tvalue\toutcome\n";

foreach ($result as $row) {

    $outcomeID = $row['outcome_concept_id'];
    $outcomeName = $hm->getOutcomeNameByID($outcomeID);

    $current .=$rowNum."\t".$colNum."\t".$row["sum(case_count)"]."\t".$outcomeName . "\n";

    if($colNum<20){
        $colNum ++;
    }else{
        $colNum = 1;
        $rowNum++;
    }

}
$result = file_put_contents($file, $current);
?>
