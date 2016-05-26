<?php include dirname(__FILE__) . '/database/DrugName.php'; ?>
<?php include dirname(__FILE__) . '/database/ADRName.php'; ?>
<?php include dirname(__FILE__) . '/views/header.php'; ?>
<?php include dirname(__FILE__) . '/views/index.php'; ?>

<!---Visualizations--->
<h3>Result</h3>

<?php include dirname(__FILE__) . '/views/heatmap.php'; ?>
<?php include dirname(__FILE__) . '/views/bar.php'; ?>
<?php include dirname(__FILE__) . '/views/linechart.php'; ?>
<?php include dirname(__FILE__) . '/views/table.php'; ?>
<?php include dirname(__FILE__) . '/views/footer.php'; ?>

</body>

</html>
