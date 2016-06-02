<?php


if(is_ajax()){


   if(isset($_POST["drug"]) && isset($_POST["adr"])){
       $drugIDList = explode(",",$_POST["drug"]);
       $outcomeIDList = explode(",",$_POST['adr']);

        getResultByID($drugIDList, $outcomeIDList);
   }


}

//Function to check if the request is an AJAX request
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}


function getResultByID($drugIDList, $outcomeIDList){
    require_once dirname(__FILE__) .'/database/heatmap.php';
    $hm = new Heatmap();

    $current = "";

    $rowNum = 1;
    $colNum = 1;

    $file = "./data/drug.tsv";
    $current .= "day\thour\tdrug\toutcome\tvalue\n";

    foreach($drugIDList as $drugID){
        foreach($outcomeIDList as $outcomeID){
            $drugName = $hm ->getDrugNameByID($drugID);
            $conceptName = $hm ->getOutcomeNameByID($outcomeID);
            $case_count = $hm -> getDrugOutcomeCounts($drugID, $outcomeID);

            $current .= $rowNum."\t".$colNum."\t".$drugName."\t".$conceptName."\t".$case_count."\n";
            $colNum++;
        }
        $colNum=1;
        $rowNum++;
    }

    echo "<pre>";
    echo $current;
    echo "</pre>";
    $result = file_put_contents($file, $current);

}
// Generate heatmap data

/*
require_once dirname(__FILE__) .'/database/heatmap.php';
$hm = new Heatmap();

$drugIDList = ['501343','528323','529072','529072','529116'];
$outcomeIDList = ['36211474','35708208','35708208','36211195','35809243','35809243','37219871','37622465','36918858','36919046'];
$current = "";

$rowNum = 1;
$colNum = 1;

$file = "./data/drug.tsv";
$current .= "day\thour\tdrug\toutcome\tvalue\n";

foreach($drugIDList as $drugID){
    foreach($outcomeIDList as $outcomeID){
        $drugName = $hm ->getDrugNameByID($drugID);
        $conceptName = $hm ->getOutcomeNameByID($outcomeID);
        $case_count = $hm -> getDrugOutcomeCounts($drugID, $outcomeID);

        $current .= $rowNum."\t".$colNum."\t".$drugName."\t".$conceptName."\t".$case_count."\n";
        $colNum++;
    }
    $colNum=1;
    $rowNum++;
}

echo "<pre>";
var_dump($current);
echo "</pre>";
$result = file_get_contents($file, $current);
*/

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

/*
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
*/

?>
