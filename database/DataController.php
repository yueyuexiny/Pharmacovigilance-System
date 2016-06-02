<?php
/**
 * Created by PhpStorm.
 * User: xchen2
 * Date: 6/2/16
 * Time: 1:44 PM
 */
class DataController
{
    private $dbconn;

    function __construct()
    {
        require_once dirname(__FILE__) . '/dbcontroller.php';

        $objDBController = new DBController();
        $this->dbconn = $objDBController->getConn();
    }

    function getDrugNameList($query,$group)
    {   $table="";
        if($group=='ingredient'){
            $table = 'drug_concept_id_ingredient';
        }
        elseif($group=='name'){
            $table='drug_concept_id_name';
        }
        try {
            $sql = 'SELECT * FROM '.$table.'  Where name like"'.$query.'%" limit 10';

            $result = $this->dbconn->query($sql);

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function getADRNameList($query,$group)
    {
        try {

            $sql = 'SELECT * FROM outcome_concept_id_meddra  Where name like"'.$query.'%" limit 10';
            $result = $this->dbconn->query($sql);

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    function get_data($drugID,$adrID,$group_drug,$group_adr)
    {   $table="";
        if($group_drug=='ingredient'){
            $table='drug_ingredient_outcome_meddra_statistics_all';
        }
        elseif($group_drug=='name'){
            $table='drug_name_outcome_meddra_statistics_all';
        }

        try {
            $sql = 'SELECT drug_concept_id,outcome_concept_id, case_count, prr,ror FROM '.$table.'  Where drug_concept_id in ('.$drugID.') and outcome_concept_id in ('.$adrID.')';
            $result = $this->dbconn->query($sql);

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



    // Get case count by drug and outcome ID
    function getDrugOutcomeCounts($drugID, $outcomeID){
        try{
            $sql = "SELECT case_count
                    FROM drug_name_outcome_meddra_statistics_all
                    where drug_concept_id=".$drugID.
                " and outcome_concept_id=".$outcomeID;

            //var_dump($sql);

            $result = $this->dbconn->query($sql);

            $case_count = 0;
            foreach ($result as $row) {
                $case_count = $row['case_count'];
            }
            return $case_count;

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }


    function getDrugNameByID($drugID,$group){
        $table="";
        if($group=='ingredient'){
            $table = 'drug_concept_id_ingredient';
        }
        elseif($group=='name'){
            $table='drug_concept_id_name';
        }

        try{
            $sql = "SELECT name FROM ".$table." where drug_concept_id=".$drugID;
            $result = $this->dbconn->query($sql);

            foreach ($result as $row) {
                $drugName = $row['name'];

            }
            return $drugName;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    function getOutcomeNameByID($outcomeConceptID,$group){
        try{
            $sql = "SELECT name FROM outcome_concept_id_meddra where outcome_concept_id=".$outcomeConceptID;
            $result = $this->dbconn->query($sql);

            foreach ($result as $row) {
                $outcomeName = $row['name'];

            }
            return $outcomeName;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }


}

?>