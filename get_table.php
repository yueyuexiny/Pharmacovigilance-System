<?php
/**
 * Created by PhpStorm.
 * User: xchen2
 * Date: 6/1/16
 * Time: 2:45 PM
 */
require_once "./database/TableStatitics.php";

#$type=$_GET['type'];
$drug = $_GET['drug'];
$adr=$_GET['adr'];


$table = new TableStatitics();
$result = $table->get_data($drug,$adr);
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
                    <th>".$table->getDrugNameByID($row['drug_concept_id'])."</th>
                    <td>".$table->getOutcomeNameByID($row['outcome_concept_id'])."</td>
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


