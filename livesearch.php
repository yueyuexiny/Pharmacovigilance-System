<?php
require_once "./database/DrugName.php";

$q=$_GET["q"];
$drugname = new DrugName();
$result=$drugname->getDrugNameList($q);
$default_drug_list=[];
foreach ($result as $row) {
    array_push($default_drug_list,$row['drug_name']);
}

//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
    $hint="";
    foreach ($default_drug_list as $row) {
        $hint .= "<span style=\"margin-left:10px\" onclick='select(\"".$row."\")'>".$row."</span><br>";
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