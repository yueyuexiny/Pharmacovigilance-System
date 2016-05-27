<?php
/**
 * Created by PhpStorm.
 * User: rliu1
 * Date: 5/19/16
 * Time: 10:10 AM
 */
class Heatmap
{
    private $dbconn;

    function __construct() {
        require_once dirname(__FILE__) .'/dbcontroller.php';

        $objDBController = new DBController();
        $this->dbconn=$objDBController->getConn();
    }

    // Get top 100 drugs
    function getDrugConceptId(){
        try{
            $sql = "SELECT drug_concept_id, sum(case_count)
                    FROM faers.standard_drug_outcome_statistics
                    group by drug_concept_id
                    order by sum(case_count) desc
                    limit 100";

            $result = $this->dbconn->query($sql);

            return $result;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }


    // Get top 100 outcomes
    function getOutcomeID(){
        try{
            $sql = "SELECT outcome_concept_id, sum(case_count)
                    FROM faers.standard_drug_outcome_statistics
                    group by outcome_concept_id
                    order by sum(case_count) desc
                    limit 100";

            $result = $this->dbconn->query($sql);

            return $result;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }


    function getDrugOutcomeCounts($drugID, $outcomeID){
        try{
            $sql = "SELECT case_count
                    FROM faers.standard_drug_outcome_statistics
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

