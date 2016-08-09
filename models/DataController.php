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
            $result = $this->dbconn->query($sql);

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
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

            $result = $this->dbconn->query($sql);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }



    function get_data($drugID,$adrID,$group_drug,$group_adr,$source)
    {   $table="";
        if($group_drug=='ingredient'){
            if($group_adr=='medDRA'){
                $table='drug_ingredient_outcome_meddra_statistics_all';
                if($source=='EHR'){
                    $table='cerner_drug_ingredient_outcome_meddra_statistics_all';
                }
            }
            else{
                $table='drug_ingredient_outcome_hoi_statistics_all';
            }

        }
        elseif($group_drug=='name'){
            if($group_adr=='medDRA'){
                $table='drug_name_outcome_meddra_statistics_all';
            }
            else{
                $table='drug_ingredient_outcome_hoi_statistics_all';//no drug_name for hoi
            }
        }

        try {
            $sql = 'SELECT drug_concept_id,outcome_concept_id, case_count, prr,ror,rrr,chi,Q,IC,L FROM ' . $table . '  Where drug_concept_id in (' . $drugID . ') and outcome_concept_id in (' . $adrID . ')';
            $result = $this->dbconn->query($sql);

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    // Get case count by drug and outcome ID
    function getDrugOutcomeValue($drugID, $outcomeID, $group_drug, $group_adr, $analysis,$source)
    {

        $table="";
        if($group_drug=='ingredient'){
            if($group_adr=='medDRA'){
                if($source == 'EHR'){
                    $table='cerner_drug_ingredient_outcome_meddra_statistics_all';
                }else{
                    $table='drug_ingredient_outcome_meddra_statistics_all';
                }

            }
            else{
                $table='drug_ingredient_outcome_hoi_statistics_all';
            }
        }
        elseif($group_drug=='name'){
            if($group_adr=='medDRA'){
                $table='drug_name_outcome_meddra_statistics_all';
            }
            else{
                $table='drug_ingredient_outcome_hoi_statistics_all';//no drug_name dta for hoi
            }
        }

        try {
            $sql = " SELECT " . $analysis . " FROM " . $table . " where drug_concept_id=" . $drugID . " and outcome_concept_id=" . $outcomeID;

            $result = $this->dbconn->query($sql);

            $value = 0;
            foreach ($result as $row) {
                $value = $row[$analysis];
            }
            return $value;

        } catch (PDOException $e) {
            echo $e->getMessage();
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
            $sql = "SELECT name FROM " . $table . " where drug_concept_id=" . $drugID;
            $result = $this->dbconn->query($sql);

            foreach ($result as $row) {
                $drugName = $row['name'];

            }
            return $drugName;
        } catch (PDOException $e) {
            echo $e->getMessage();
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
            $sql = "SELECT name FROM ".$table." where outcome_concept_id=".$outcomeConceptID;
            $result = $this->dbconn->query($sql);

            foreach ($result as $row) {
                $outcomeName = $row['name'];

            }
            return $outcomeName;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function getCaseCountTimeline($drugID, $adrID, $group_drug, $group_adr)
    {
        $table="";
        if($group_drug=='ingredient'){
            if($group_adr=='medDRA'){
                $table='drug_ingredient_outcome_meddra_recieved_date_count';
            }
            else{
                $table='drug_ingredient_outcome_hoi_recieved_date_count';
            }

        }
        elseif($group_drug=='name'){
            if($group_adr=='medDRA'){
                $table='drug_name_outcome_meddra_recieved_date_count';
            }
            else{
                $table='drug_ingredient_outcome_hoi_recieved_date_count';//no drug_name data for hoi
            }
        }
        try {
            $sql = 'SELECT recieved_date,drug_concept_id,outcome_concept_id, case_count FROM ' . $table . '  Where drug_concept_id in (' . $drugID . ') and outcome_concept_id in (' . $adrID . ')';
            $result = $this->dbconn->query($sql);
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
            echo $e->getMessage();
        }
    }

    function getAnalysisTimeline($drugID, $adrID, $group_drug, $group_adr, $analysis, $quarteroryear)
    {

        $table = "";
        $quarter_table = ["1" => "0101", "2" => '0401', '3' => '0701', '4' => '1001'];
        if ($quarteroryear == 'year') {
            $column = "recieved_year";
            if($group_drug=='ingredient'){
                if($group_adr=='medDRA'){
                    $table='drug_ingredient_outcome_meddra_statistics_year';
                }
                else{
                    $table='drug_ingredient_outcome_hoi_statistics_year';
                }

            }
            elseif($group_drug=='name'){
                if($group_adr=='medDRA'){
                    $table='drug_name_outcome_meddra_statistics_year';
                }
                else{
                    $table='drug_ingredient_outcome_hoi_statistics_year';//no drug name for hoi
                }

            }
        }
        elseif($quarteroryear=='quarter'){
            $column = "recieved_year,recieved_quarter";
            if($group_drug=='ingredient'){
                if($group_adr=='medDRA'){
                    $table='drug_ingredient_outcome_meddra_statistics_quarter';
                }
                else{
                    $table='drug_ingredient_outcome_hoi_statistics_quarter';
                }

            }
            elseif($group_drug=='name'){
                if($group_adr=='medDRA'){
                    $table='drug_name_outcome_meddra_statistics_quarter';
                }
                else{
                    $table='drug_ingredient_outcome_hoi_statistics_quarter';//no drug name for hoi
                }
            }
        }


        try {
            $sql = 'SELECT ' . $column . ',drug_concept_id,outcome_concept_id, ' . $analysis . ' FROM ' . $table . '  Where drug_concept_id in (' . $drugID . ') and outcome_concept_id in (' . $adrID . ')';
            $result = $this->dbconn->query($sql);
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
            echo $e->getMessage();
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
            $table_name = strtolower("drug_".$drug_group."_outcome_".$adr_group."_statistics_all");

            if($source == "EHR"){
                $table_name = "cerner_".$table_name;
            }

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
            echo $e->getMessage();
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
            $table_name = strtolower("drug_".$drug_group."_outcome_".$adr_group."_statistics_all");
            if($source == "EHR"){
                $table_name = "cerner_".$table_name;
            }
            $sql = "SELECT drug_concept_id FROM ".$table_name
                ." where outcome_concept_id=:drug_concept_id order by "
                .$analysis." desc limit ".$n;

            $stmt = $this->dbconn->prepare($sql);
            $stmt -> execute(array(':drug_concept_id'=>$adr_ID,));
            $result = $stmt->fetchAll();

            $drug_ID_list = [];
            foreach ($result as $r){
                array_push($drug_ID_list, $r['drug_concept_id']);
            }
            return $drug_ID_list;
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }





}
?>