<?php
/**
 * Created by PhpStorm.
 * User: xchen2
 * Date: 6/1/16
 * Time: 2:45 PM
 */
require_once "./database/DataController.php";
require_once "get_timeline.php";

#$type=$_GET['type'];
$drug = $_GET['drug'];
$adr=$_GET['adr'];
$group_adr=$_GET['group_adr'];
$group_drug=$_GET['group_drug'];

$table = new DataController();
$result = $table->get_data($drug,$adr,$group_drug,$group_adr);
$text = '<div class="details">

    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Details</h3></div>
        <div class="panel-body">
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
        </div>
    </div>
</div>";

echo $text;

write_timeline_file();
