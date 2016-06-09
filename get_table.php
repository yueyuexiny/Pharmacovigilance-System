<?php
/**
 * Created by PhpStorm.
 * User: xchen2
 * Date: 6/1/16
 * Time: 2:45 PM
 */
require_once "./database/DataController.php";

$drug = $_GET['drug'];
$adr=$_GET['adr'];
$group_adr=$_GET['group_adr'];
$group_drug=$_GET['group_drug'];
$table = new DataController();
// Get all drugs and adrs
if($drug== "" && $adr==""){
    $drug = implode(',',$table ->getAllDrugIDs($group_drug));
    $adr = implode(',',$table -> getAllAdrIDs($group_adr));
}
// Get all drugs
elseif($drug=="" && $adr!=""){
    $drug = implode(',',$table ->getAllDrugIDs($group_drug));
}
//Get all adrs
elseif($adr=="" && $drug!=""){
    $adr = implode(',',$table -> getAllAdrIDs($group_adr));
}

$result = $table->get_data($drug,$adr,$group_drug,$group_adr);
$text = '
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Drug name</th>
                    <th>Adr name</th>
                    <th>Case count</th>
                    <th>ROR</th>
                    <th>PRR</th>
                </tr>
                </thead>
                <tbody>';

foreach($result as $row) {
    $row = " <tr>
                    <th>".$table->getDrugNameByID($row['drug_concept_id'],$group_drug)."</th>
                    <td>".$table->getOutcomeNameByID($row['outcome_concept_id'],$group_adr)."</td>
                    <td>".$row['case_count']."</td>
                    <td>".$row['prr']."</td>
                    <td>".$row['ror']."</td>
                </tr>";
   $text.=$row;
    }
$text.="</tbody>
            </table>

";

echo $text;

