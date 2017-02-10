<?php
require_once dirname(__FILE__) . '/../models/DataController.php';

$flag = 0;

if(is_ajax()){

    // Get parameters
   if(isset($_POST["drug"]) && isset($_POST["adr"])){
       $drug_ID_list = explode(",",htmlentities($_POST["drug"]));   // array
       $adr_ID_list = explode(",",htmlentities($_POST['adr']));
       $drug_group = htmlentities($_POST["drug_group"]);
       $adr_group = htmlentities($_POST["adr_group"]);
       $source = htmlentities($_POST["source"]);
       $analysis = htmlentities($_POST["analysis"]);

       $num = 60;   // number of drug or ADR

       $hm = new DataController();

       // User only selected drug, select the ID of top $num ADR
       if($drug_ID_list[0]!=""  && $adr_ID_list[0]==""){
           $flag = 1;
           $adr_ID_list = [];
           $n = round($num/count($drug_ID_list));
           foreach($drug_ID_list as $drug_ID){
               $result = $hm->getTopNAdr($drug_ID, $drug_group,$adr_group, $n, $analysis,$source);
               foreach($result as $r){
                   array_push($adr_ID_list,$r);
               }
           }
       }
       // User only selected ADR
       elseif($adr_ID_list[0]!="" && $drug_ID_list[0]==""){
           $flag = 2;
           $drug_ID_list=[];
           $m = round($num/count($adr_ID_list));
           foreach($adr_ID_list as $adr_ID){
               $result = $hm->getTopNDrug($adr_ID, $drug_group,$adr_group, $m, $analysis,$source);
               foreach($result as $r2){
                   array_push($drug_ID_list,$r2);
               }
           }
       }

       $result = getResultByID($hm, $drug_ID_list, $adr_ID_list,$drug_group,$adr_group,$source,$analysis, $flag);
       echo json_encode($result);
   }
}

//Function to check if the request is an AJAX request
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}


/*
 * $hm: database connection
 * $drugIDList : array(string), a list of drug IDs
 * $adrIDList : array(string), a list of adr IDs
 * $drugGroup: string, ingredient or name
 * $adr_group : string, MedDRA or HOI
 * $source :  string, data source
 * $analysis: string, analysis method
 * */
function getResultByID($hm, $drugIDList, $adrIDList,$drug_group,$adr_group,$source,$analysis, $flag){

    $data = array();
    $drug = array();
    $adr = array();

    foreach($drugIDList as $drugID) {
        foreach($adrIDList as $adrID){
            $temp = array();

            $drugName = $hm ->getDrugNameByID($drugID,$drug_group);
            $adrName = $hm ->getOutcomeNameByID($adrID,$adr_group);
            $case_count = $hm -> getDrugOutcomeValue($drugID, $adrID,$drug_group,$adr_group,$analysis,$source);

            $temp['drugName'] = $drugName;
            $temp['adrName'] = $adrName;
            $temp['value'] = $case_count;
            $temp['drugId'] =$drugID;
            $temp['adrId'] = $adrID;

            array_push($drug, $drugName);
            array_push($adr, $adrName);
            array_push($data,$temp);
        }
    }

    $result = array();
    $result['data'] = $data;

    if($flag == 0){
        $result ['drug'] = array_unique($drug);
        $result ['adr'] = array_unique($adr);
    }elseif($flag == 1){
        $result ['drug'] = array_unique($drug);
        $result ['adr'] = $adr;
    }else{
        $result ['drug'] = $drug;
        $result ['adr'] = array_unique($adr);
    }

    $result['source'] = $source;
    $result['analysis'] = $analysis;

    return $result;
}
?>
