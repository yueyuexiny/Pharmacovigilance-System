<?php
/**
 * Created by PhpStorm.
 * User: xchen2
 * Date: 6/1/16
 * Time: 2:45 PM
 */
require_once dirname(__FILE__)."../../models/DataController.php";

$drug = $_GET['drug'];
$adr=$_GET['adr'];
$group_adr=$_GET['group_adr'];
$group_drug=$_GET['group_drug'];
$analysis=$_GET['analysis'];
$source=$_GET['source'];
$table = new DataController();


// Get all drugs
if($drug=="" && $adr!=""){
    $drug = implode(',',$table ->getTopNDrug($adr, $group_drug,$group_adr, 60, $analysis,$source));
}
//Get all adrs
elseif($adr=="" && $drug!=""){
    $adr = implode(',',$table ->  getTopNAdr($drug, $group_drug,$group_adr, 60, $analysis,$source));
}

$result = $table->get_data($drug,$adr,$group_drug,$group_adr,$source);
$text = '
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Drug name</th>
                    <th>Adr name</th>
                    <th>Case count</th>
                    <th>ROR</th>
                    <th>PRR</th>
                    <th>RRR</th>
                    <th>Chi-Squared test </th>
                    <th>Yules Q ratio</th>
                    <th>Information Componet</th>
                    <th>Leverage(X->Y)</th>
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
                    <td>".$row['rrr']."</td>
                    <td>".$row['chi']."</td>
                    <td>".$row['Q']."</td>
                    <td>".$row['IC']."</td>
                    <td>".$row['L']."</td>
                </tr>";
   $text.=$row;
    }
$text.="</tbody>
            </table>

";

echo $text;

