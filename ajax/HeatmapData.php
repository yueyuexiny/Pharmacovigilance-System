<?php


if(is_ajax()){
   if(isset($_POST["drug"]) && isset($_POST["adr"])){
       $drugIDList = explode(",",$_POST["drug"]);
       $outcomeIDList = explode(",",$_POST['adr']);
       $drugGroup = $_POST["drug_group"];
       $adr_group = $_POST["adr_group"];

       $result = getResultByID($drugIDList, $outcomeIDList,$drugGroup,$adr_group);
       echo json_encode($result);
   }
}

//Function to check if the request is an AJAX request
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}


function getResultByID($drugIDList, $adrIDList,$drugGroup,$adr_group){
    require_once dirname(__FILE__) . '/../database/DataController.php';
    $hm = new DataController();

    $data = array();
    $drug = array();
    $adr = array();


    // Get all drugs and adrs
    if($drugIDList[0]== "" && $adrIDList[0]==""){
        $drugIDList = $hm ->getAllDrugIDs($drugGroup);
        $adrIDList = $hm -> getAllAdrIDs($adr_group);
    }
    // Get all drugs
    elseif($drugIDList[0]=="" && $adrIDList[0]!=""){
        $drugIDList = $hm ->getAllDrugIDs($drugGroup);
    }
    //Get all adrs
    elseif($adrIDList[0]=="" && $drugIDList[0]!=""){
        $adrIDList = $hm -> getAllAdrIDs($adr_group);
    }



    foreach($drugIDList as $drugID) {
        foreach($adrIDList as $adrID){
            $temp = array();

            $drugName = $hm ->getDrugNameByID($drugID,$drugGroup);
            $adrName = $hm ->getOutcomeNameByID($adrID,$adr_group);
            $case_count = $hm -> getDrugOutcomeCounts($drugID, $adrID,$drugGroup,$adr_group);

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
    $result ['drug'] = array_unique($drug);
    $result ['adr'] = array_unique($adr);

    return $result;
}
?>
