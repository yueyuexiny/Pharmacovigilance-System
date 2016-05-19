<?php include dirname(__FILE__) . '/database/DrugName.php'; ?>
<?php include dirname(__FILE__) . '/database/ADRName.php'; ?>
<?php include dirname(__FILE__) . '/views/header.php'; ?>
<?php include dirname(__FILE__) . '/views/index.php'; ?>

<!---Visualizations--->
<h3>Result</h3>


<?php

// Generate heatmap data
require_once dirname(__FILE__) .'/database/heatmap.php';
$hm = new Heatmap();
$result = $hm->getDrugConceptId();
$rowNum = 1;
$colNum = 1;
$current = "";



$file = "/data/test.tsv";

$current .= "day\thour\tvalue\n";



foreach ($result as $row) {

    $current .=$rowNum."\t".$colNum."\t".$row["sum(case_count)"]."\n";

    if($colNum<20){
        $colNum ++;
    }else{
        $colNum = 1;
        $rowNum++;
    }
}
//$result = file_put_contents($file, $current);
?>

<?php include dirname(__FILE__) . '/views/heatmap.php'; ?>
<?php include dirname(__FILE__) . '/views/linechart.php'; ?>
<?php include dirname(__FILE__) . '/views/bar.php'; ?>
<?php include dirname(__FILE__) . '/views/table.php'; ?>
<?php include dirname(__FILE__) . '/views/footer.php'; ?>

</body>

</html>
