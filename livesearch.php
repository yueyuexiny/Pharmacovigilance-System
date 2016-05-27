
<?php
require_once "./database/DrugName.php";
require_once "./database/ADRName.php";
$q=$_GET["q"];
$type=$_GET['type'];
$source = $_GET['source'];
$analysis=$_GET['analysis'];

//var_dump($_GET);

$default_list = [];
if($type=='drug') {
    $drugname = new DrugName();
    $result = $drugname->getDrugNameList($q);
    foreach ($result as $row) {
        //array_push($default_list, $row['drug_name']);
        array_push($default_list,[$row['drug_name'],$row['drug_concept_id']]);
    }
}
elseif($type=='adr'){
        $adrname = new ADRName();
        $result = $adrname->getADRNameList($q);
        foreach ($result as $row) {
            array_push($default_list, [$row['outcome_name'],$row['outcome_concept_id']]);
        }

}
//var_dump($default_list);
//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
    $hint="";
    foreach ($default_list as $row) {
        if($type=='drug'){
            $hint .= "<span class=\"searchtext\" onclick='select_drug(\"".$row[0]."\",\"".$row[1]."\")'>".$row[0]."</span><br>";
          // var_dump($hint);
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
