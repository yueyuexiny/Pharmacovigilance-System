<?php
/**
 * Created by PhpStorm.
 * User: xchen2
 * Date: 6/1/16
 * Time: 2:45 PM
 */


if(is_ajax()){
    if(isset($_POST["pairs"])){
        $pairs = $_POST["pairs"];
        $drugGroup = $_POST["group_drug"];
        $adr_group = $_POST["group_adr"];
        $drugnames = $_POST["drugnames"];
        $adrnames = $_POST["adrnames"];
        $analysis = $_POST['analysis'];
        $monthoryear=$_POST['monthoryear'];
        //write_timeline_file();
        $result = get_timeline_data_pairs($pairs,$drugGroup,$adr_group,$drugnames,$adrnames,$analysis,$monthoryear);
        echo json_encode($result);
    }
}

//Function to check if the request is an AJAX request
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function get_dates($result){
    $data = array();
    foreach($result as $row){
        $date = $row['recieved_date'];
        if(!array_key_exists($date,$data)){
            $data[$date]=array();
        }
    }
    return $data;
}


function get_names_for_pair($result,$drugnames,$adrnames){
    $names = array();
    foreach($result as $row){
        // $name = $row['drug_concept_id'].'_'.$row['outcome_concept_id'];
        $name = $drugnames[$row[0]['drug_concept_id']].'/'.$adrnames[$row[0]['outcome_concept_id']];
        if(!in_array($name,$names)){
            array_push($names,$name);
        }
    }
    return $names;
}

function get_timeline_data_pairs($pairs,$group_drug,$group_adr,$drugnames,$adrnames,$analysis,$monthoryear){
    require_once dirname(__FILE__)."../../models/DataController.php";
    $table = new DataController();
    $results = [];
    foreach($pairs as $pair){
        $drug = $pair[0];
        $adr = $pair[1];
        if($analysis=='case_count'){
            $result = $table->getCaseCountTimeline($drug,$adr,$group_drug,$group_adr);
        }
        else{
            $result = $table->getAnalysisTimeline($drug,$adr,$group_drug,$group_adr,$analysis,$monthoryear);
        }
        array_push($results,$result);
    }
    $names = get_names_for_pair($results,$drugnames,$adrnames);
    $timeline_data = array();
    foreach($results as $row) {
        foreach($row as $item){
            $name = $drugnames[$item['drug_concept_id']].'/'.$adrnames[$item['outcome_concept_id']];
            $date=$item['recieved_date'];
            $timeline_data[$date][$name]=$item[$analysis];
           }
        }
    $data=array();



    foreach(array_keys($timeline_data) as $date ){
        $item = array();
        $item['date']=strval($date);

        foreach($names as $name){
            if(array_key_exists($name,$timeline_data[$date])){

                $item[$name]=$timeline_data[$date][$name];
            }
            else{
                $item[$name]='0';
            }
        }
        array_push($data,$item);

    }
    return $data;

}
