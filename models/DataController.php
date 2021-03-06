<?php

/**
 * Created by PhpStorm.
 * User: xchen2
 * Date: 6/2/16
 * Time: 1:44 PM
 */
error_reporting(E_ERROR);
class DataController
{
    private $dbconn;

    function __construct()
    {
        require_once dirname(__FILE__) . '/dbcontroller.php';

        $objDBController = new DBController();
        $this->dbconn = $objDBController->getConn();
    }

    function constructTableName($source,$group_drug,$group_adr){
        $tablename = "";

        switch($source){
            case "EHR":
                $tablename = "cerner_";
                break;
            case "FAERS":
                $tablename = "faers_";
                break;
            case "Literature":
                $tablename = "pubmed_";
                break;
        }

        switch($group_drug){
            case "name":
                $tablename = $tablename . "drug_name_";
                break;
            case "ingredient":
                $tablename = $tablename . "drug_ingredient_";
                break;
        }

        switch($group_adr){
            case "medDRA":
                $tablename .="outcome_meddra_";
                break;
            case "HOI":
                $tablename .="outcome_hoi_";
                break;
        }

        return $tablename;

    }


    function getDrugNameList($query, $group)
    {
        $table = "";
        if ($group == 'ingredient') {
            $table = 'drug_concept_id_ingredient';
        } elseif ($group == 'name') {
            $table = 'drug_concept_id_name';
        }
        try {
            $sql = 'SELECT * FROM ' . $table . '  Where name like"' . $query . '%" limit 10';
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOException $e) {
            die("Drug name not Found");
        }
    }

    function getADRNameList($query, $group)
    {
        $table="";
        if($group=='medDRA'){
            $table = 'outcome_concept_id_meddra';
        }
        elseif($group=='HOI'){
            $table='outcome_concept_id_hoi';
        }
        try {
            $sql = 'SELECT * FROM '.$table.'  Where name like"'.$query.'%" limit 10';
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            die("ADR not Found");
        }

    }



    function get_data($drugID,$adrID,$group_drug,$group_adr,$source)
    {
        $table=$this->constructTableName($source,$group_drug,$group_adr)."statistics_all";

        try {
            $sql = 'SELECT drug_concept_id,outcome_concept_id, case_count, prr,ror,rrr,chi,Q,IC,L FROM ' . $table . '  Where drug_concept_id in (' . $drugID . ') and outcome_concept_id in (' . $adrID . ')';
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOException $e) {
	    die($table);
            die("Data not Found");
        }
    }


    // Get case count by drug and outcome ID
    function getDrugOutcomeValue($drugID, $outcomeID, $group_drug, $group_adr, $analysis,$source)
    {
         $table=$this->constructTableName($source,$group_drug,$group_adr)."statistics_all";

        try {
            $sql = " SELECT " . $analysis . " FROM " . $table . " where drug_concept_id=" . $drugID . " and outcome_concept_id=" . $outcomeID;
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll();

            $value = 0;
            foreach ($result as $row) {
                $value = $row[$analysis];
            }
            return $value;

        } catch (PDOException $e) {
            die("Drug outcome not Found");
        }
    }



    function getDrugNameByID($drugID, $group)
    {
        $table = "";
        if ($group == 'ingredient') {
            $table = 'drug_concept_id_ingredient';
        } elseif ($group == 'name') {
            $table = 'drug_concept_id_name';
        }

        try {
            $sql = "SELECT name FROM " . $table . " where drug_concept_id=:drugID";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute(array(':drugID'=>$drugID));
            $result = $stmt->fetchAll();

            foreach ($result as $row) {
                $drugName = $row['name'];
            }
            return $drugName;
        } catch (PDOException $e) {
            die("Drug name not Found");
        }
    }


    function getOutcomeNameByID($outcomeConceptID,$group){
        $table="";
        if($group=='medDRA'){
            $table = 'outcome_concept_id_meddra';
        }
        elseif($group=='HOI'){
            $table='outcome_concept_id_hoi';
        }
        try{
            $sql = "SELECT name FROM ".$table." where outcome_concept_id=:outcome_concept_id";//.$outcomeConceptID;
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute(array(':outcome_concept_id'=>$outcomeConceptID));
            $result = $stmt->fetchAll();

            foreach ($result as $row) {
                $outcomeName = $row['name'];
            }
            return $outcomeName;
        } catch (PDOException $e) {
            die("Outcome name not Found");
        }
    }

    function getCaseCountTimeline($drugID, $adrID, $group_drug, $group_adr)
    {
        $table=$this->constructTableName("FAERS",$group_drug,$group_adr)."recieved_date_count";

        try {
            $sql = 'SELECT recieved_date,drug_concept_id,outcome_concept_id, case_count FROM ' . $table . '  Where drug_concept_id in (' . $drugID . ') and outcome_concept_id in (' . $adrID . ')';
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();

            $data = array();
            foreach ($result as $row) {
                $item = [];
                $item['recieved_date'] = $row['recieved_date'];
                $item['outcome_concept_id'] = $row['outcome_concept_id'];
                $item['drug_concept_id'] = $row['drug_concept_id'];
                $item['case_count'] = $row['case_count'];
                array_push($data, $item);
            }

            return $data;
        } catch (PDOException $e) {
            die("Case count data not Found");
        }
    }

    function getAnalysisTimeline($drugID, $adrID, $group_drug, $group_adr, $analysis, $quarteroryear,$source)
    {
        $table = "";
        $quarter_table = ["1" => "0101", "2" => '0401', '3' => '0701', '4' => '1001'];

        if ($quarteroryear == 'year') {
            $column = "recieved_year";
            $table=$this->constructTableName($source,$group_drug,$group_adr)."statistics_year";
        }
        elseif($quarteroryear=='quarter'){
            $column = "recieved_year,recieved_quarter";
            $table=$this->constructTableName($source,$group_drug,$group_adr)."statistics_quarter";
	    }

        try {
            $sql = 'SELECT ' . $column . ',drug_concept_id,outcome_concept_id, ' . $analysis . ' FROM ' . $table . '  Where drug_concept_id in (' . $drugID . ') and outcome_concept_id in (' . $adrID . ')';
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();

            $data = array();
            foreach ($result as $row) {
                $item = [];
                if (isset($row['recieved_quarter'])) {
                    $item['recieved_date'] = $row['recieved_year'] . $quarter_table[$row['recieved_quarter']];
                } else {
                    $item['recieved_date'] = $row['recieved_year'];
                }

                $item['outcome_concept_id'] = $row['outcome_concept_id'];
                $item['drug_concept_id'] = $row['drug_concept_id'];
                $item[$analysis] = $row[$analysis];
                array_push($data, $item);
            }
            return $data;
        } catch (PDOException $e) {
            die("Analysis data not Found");
        }
    }

    /*
     * Get top n adr by drug ID
     * @param:
     *      $drug_ID : string, drug ID
     *      $drug_group: string, drug group
     *      $n: string, number of adr ID
     *      $analysis: analysis method
     * @return:
     *      $adr_ID_list: a list of adr ids
     * */
    function getTopNAdr($drug_ID, $drug_group,$adr_group, $n, $analysis,$source)
    {
        try{
           $table_name=$this->constructTableName($source,$drug_group,$adr_group)."statistics_all";
            $sql = "SELECT outcome_concept_id FROM ".$table_name
                ." where drug_concept_id=:drug_concept_id order by "
                .$analysis." desc limit ".$n;

            $stmt = $this->dbconn->prepare($sql);
            $stmt -> execute(array(':drug_concept_id'=>$drug_ID,));
            $result = $stmt->fetchAll();

            $adr_ID_list = [];
            foreach ($result as $r){
                array_push($adr_ID_list, $r['outcome_concept_id']);
            }
            return $adr_ID_list;
        }catch(PDOException $e) {
		    die("Top N ADR names not Found");
        }
    }

    /*
     * Get top n adr by drug ID
     * @param:
     *      $drug_ID : string, drug ID
     *      $drug_group: string, drug group
     *      $n: string, number of adr ID
     *      $analysis: analysis method
     * @return:
     *      $adr_ID_list: a list of adr ids
     * */
    function getTopNDrug($adr_ID, $drug_group,$adr_group, $n, $analysis,$source){
        try{
            $table_name=$this->constructTableName($source,$adr_group,$drug_group)."statistics_all";

            $sql = "SELECT drug_concept_id FROM ".$table_name
                ." where outcome_concept_id=:drug_concept_id order by :analysis desc limit ".$n;

            $stmt = $this->dbconn->prepare($sql);
            $stmt -> execute(array(':drug_concept_id'=>$adr_ID,':analysis'=>$analysis));
            $result = $stmt->fetchAll();

            $drug_ID_list = [];
            foreach ($result as $r){
                array_push($drug_ID_list, $r['drug_concept_id']);
            }
            return $drug_ID_list;
        }catch(PDOException $e) {
            die("Top N Drug names not Found");
        }
    }

}
?>
