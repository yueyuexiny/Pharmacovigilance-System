<?php include dirname(__FILE__) . '/models/DataController.php'; ?>
<?php include dirname(__FILE__) . '/views/header.php'; ?>


<?php include dirname(__FILE__) . '/views/index.php'; ?>

<!---Visualizations--->

<div class="panel-group" id="accordion">
<?php include dirname(__FILE__) . '/views/heatmap.php'; ?>
<?php include dirname(__FILE__) . '/views/table.php'; ?>
<?php include dirname(__FILE__) . '/views/linechart.php'; ?>
</div>

<?php include dirname(__FILE__) . '/views/footer.php'; ?>

</body>

</html>
