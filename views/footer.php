<div class="footer">
    <div class="container">
        <div class="row">
            <div  class="col-md-3">
        <a href="index.php"><img src="./img/ut-logo.png" alt="Mountain View" class="header-logo" style="width: 200px"></a>
                </div>
            <div class="col-md-9">
                <div class="container normal-text-footer text-center" style="color:white">
                    Contact Us | Emergency Information | Site Policies | Need help opening PDF files?
                    <br/>
                    &copy; 2008-Present - The University of Texas Health Science Center at Houston (UTHealth)
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="./js/js.cookie.js"></script>
<?php
/* ==== Page Specific Scripts ==== */
if (isset($scripts)) {
    foreach ($scripts as $script) {
        echo '<script type="text/javascript" src="' . $script . '"></script>';
        echo "\r\n";
    }
}
?>
<?php
/* Page Custom Scripts. */
$scripts = ["./js/page.scripts/advanced.js"];
?>
</body>

</html>

