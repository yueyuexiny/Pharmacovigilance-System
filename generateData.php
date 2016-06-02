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
    require_once dirname(__FILE__) .'/database/DataController.php';
    $hm = new DataController();

    $current = "";

    $rowNum = 1;
    $colNum = 1;

    $file = "./data/drug.tsv";
    $current .= "day\thour\tdrug\toutcome\tvalue\n";

    foreach($drugIDList as $drugID){
        foreach($outcomeIDList as $outcomeID){
            $drugName = $hm ->getDrugNameByID($drugID,'name');
            $conceptName = $hm ->getOutcomeNameByID($outcomeID,'meddra');
            $case_count = $hm -> getDrugOutcomeCounts($drugID, $outcomeID);

            $current .= $rowNum."\t".$colNum."\t".$drugName."\t".$conceptName."\t".$case_count."\n";
            $colNum++;
        }
        $colNum=1;
        $rowNum++;
    }


    echo $current;

    $result = file_put_contents($file, $current);

}
?>
