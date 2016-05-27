<?php
/**
 * Created by PhpStorm.
 * User: xchen2
 * Date: 5/19/16
 * Time: 2:31 PM
 */
class ADRName
{
    private $dbconn;

    function __construct()
    {
        require_once dirname(__FILE__) . '/dbcontroller.php';

        $objDBController = new DBController();
        $this->dbconn = $objDBController->getConn();
    }

    function getADRNameList($query)
    {
        try {
            $sql = 'SELECT * FROM faers.concept_outcome limit 50';//'  Where outcome_name like"'.$query.'%" limit 10';
            //$sql = 'SELECT * FROM faers.concept_outcome  Where outcome_name like"'.$query.'%" limit 10';

            $result = $this->dbconn->query($sql);

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>