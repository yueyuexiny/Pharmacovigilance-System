<?php
/**
 * Created by PhpStorm.
 * User: xchen2
 * Date: 5/19/16
 * Time: 2:31 PM
 */
class TableStatitics
{
    private $dbconn;

    function __construct()
    {
        require_once dirname(__FILE__) . '/dbcontroller.php';

        $objDBController = new DBController();
        $this->dbconn = $objDBController->getConn();
    }

    function get_data($drugID,$adrID)
    {

        try {
            $sql = 'SELECT drug_concept_id,outcome_concept_id, case_count, prr,ror FROM faers.standard_drug_outcome_statistics  Where drug_concept_id in ('.$drugID.') and outcome_concept_id in ('.$adrID.')';
            $result = $this->dbconn->query($sql);

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    function getDrugNameByID($drugID){
        try{
            $sql = "SELECT drug_name FROM faers.concept_drug where drug_concept_id=".$drugID;
            $result = $this->dbconn->query($sql);

            foreach ($result as $row) {
                $drugName = $row['drug_name'];

            }
            return $drugName;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    function getOutcomeNameByID($outcomeConceptID){
        try{
            $sql = "SELECT outcome_name FROM faers.concept_outcome where outcome_concept_id=".$outcomeConceptID;
            $result = $this->dbconn->query($sql);

            foreach ($result as $row) {
                $outcomeName = $row['outcome_name'];

            }
            return $outcomeName;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}

?>