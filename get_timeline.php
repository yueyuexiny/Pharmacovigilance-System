<?php
/**
 * Created by PhpStorm.
 * User: xchen2
 * Date: 6/1/16
 * Time: 2:45 PM
 */

//echo 'yes';
//write_timeline_file();

if(is_ajax()){

    if(isset($_GET["drug"]) && isset($_GET["adr"])){
        write_timeline_file();
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

function get_names($result){
    $names = array();
    foreach($result as $row){
        $name = $row['drug_concept_id'].'_'.$row['outcome_concept_id'];
        if(!in_array($name,$names)){
            array_push($names,$name);
        }
    }
    return $names;
}
function write_timeline_file(){
    require_once "./database/DataController.php";
    $drug = $_GET['drug'];
    $adr=$_GET['adr'];
    $group_adr=$_GET['group_adr'];
    $group_drug=$_GET['group_drug'];
    $table = new DataController();
    $result = $table->getCaseCountTimeline($drug,$adr,$group_drug,$group_adr);
    $data = get_dates($result);
    $names = get_names($result);
    $timeline_data = array();
    foreach($result as $row) {
        $name = $row['drug_concept_id'].'_'.$row['outcome_concept_id'];
        $date=$row['recieved_date'];
        $timeline_data[$date][$name]=$row['case_count'];
    }
    //var_dump($timeline_data);
    $file = "./data/linechart1.csv";
    $current = "date";
    foreach($names as $name){
        $current .= ",".$name;
    }
    $current.="\n";

    foreach(array_keys($timeline_data) as $date ){
        $current .= $date;
        foreach($names as $name){
            if(array_key_exists($name,$timeline_data[$date])){
                $current .=','.$timeline_data[$date][$name];
            }
            else{
                $current .=',0';
            }
        }
        $current.="\n";

    }
    //echo $current;
    file_put_contents($file, $current);
}

//echo $current;



/*$text='[{"date":"11/01/1985","drug1_adr1":"115.48","drug1_adr2":"116.78","drug2_adr1":"115.48","drug2_adr2":"116.28","volume":"900900","oi":"0"},
    {"date":"11/04/1985","drug1_adr1":"116.28","drug1_adr2":"117.07","drug2_adr1":"115.82","drug2_adr2":"116.04","volume":"753400","oi":"0"},
    {"date":"11/05/1985","drug1_adr1":"116.04","drug1_adr2":"116.57","drug2_adr1":"115.88","drug2_adr2":"116.44","volume":"876800","oi":"0"},
    {"date":"11/06/1985","drug1_adr1":"116.44","drug1_adr2":"117.62","drug2_adr1":"116.44","drug2_adr2":"117.38","volume":"935000","oi":"0"},
    {"date":"11/07/1985","drug1_adr1":"117.38","drug1_adr2":"117.96","drug2_adr1":"117.38","drug2_adr2":"117.62","volume":"886400","oi":"0"},
    {"date":"11/08/1985","drug1_adr1":"117.62","drug1_adr2":"119.39","drug2_adr1":"117.58","drug2_adr2":"119.26","volume":"867600","oi":"0"}]';*/

//$text=array(array("date"=>"11/01/1985","drug1_adr1"=>"115.48","drug1_adr2"=>"116.78","drug2_adr1"=>"115.48","drug2_adr2"=>"116.28","volume"=>"900900","oi"=>"0"));
//echo '<script>';
//echo $text;
//echo '</script>';

/*$drug='710062';
$adr = '35104067';
$group_drug="";
$group_adr="";
$table = new DataController();
$result = $table->getCaseCountTimeline($drug,$adr,$group_drug,$group_adr);
print_r($result);*/

