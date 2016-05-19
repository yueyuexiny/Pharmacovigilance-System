<?php
/**
 * Created by PhpStorm.
 * User: xchen2
 * Date: 5/19/16
 * Time: 2:31 PM
 */
class DrugName
{
    private $dbconn;

    function __construct()
    {
        require_once dirname(__FILE__) . '/dbcontroller.php';

        $objDBController = new DBController();
        $this->dbconn = $objDBController->getConn();
    }

    function getDrugNameList($query)
    {
        try {
            $sql = 'SELECT * FROM faers.concept_drug limit 50';//'  Where drug_name like"'.$query.'%" limit 100';

            $result = $this->dbconn->query($sql);

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
/*require_once 'DrugName.php';
require_once 'ADRName.php';
$drugname = new ADRName();
$result=$drugname->getADRNameList("");

$myfile = fopen("ADRlist.php", "w") or die("Unable to open file!");
foreach ($result as $row) {
    //var_dump($row);
    $line = '<option value="'.$row['outcome_concept_id']. '">'.$row['outcome_name'].'</option>'."\n";
    fwrite($myfile,$line);
}
fclose($myfile);*/
?>