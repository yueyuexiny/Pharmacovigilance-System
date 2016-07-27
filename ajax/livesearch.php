
<?php
require_once "../models/DataController.php";

$q=$_GET["q"];
$type=$_GET['type'];
$source = $_GET['source'];
//$analysis=$_GET['analysis'];
$group=$_GET['group'];

$default_list = [];
if($type=='drug') {
    $drugname = new DataController();
    $result = $drugname->getDrugNameList($q,$group);
    foreach ($result as $row) {
        //array_push($default_list, $row['drug_name']);
        array_push($default_list,[$row['name'],$row['drug_concept_id']]);
    }
}
elseif($type=='adr'){
        $adrname = new DataController();
        $result = $adrname->getADRNameList($q,$group);
        foreach ($result as $row) {
            array_push($default_list, [$row['name'],$row['outcome_concept_id']]);
        }

}
//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
    $hint="";
    foreach ($default_list as $row) {
        if($type=='drug'){
            $hint .= "<span class=\"searchtext\" onclick='select_drug(\"".$row[0]."\",\"".$row[1]."\")'>".$row[0]."</span><br>";
        }
        elseif($type=='adr'){
            $hint .= "<span class=\"searchtext\" onclick='select_adr(\"".$row[0]."\",\"".$row[1]."\")'>".$row[0]."</span><br>";
        }

    }
}
// Set output to "no suggestion" if no hint was found
// or to the correct values
if ($hint=="") {
    $response="no suggestion";
} else {
    $response=$hint;
}

echo $response;


?>
