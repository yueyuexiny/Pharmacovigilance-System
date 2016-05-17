<?php

include dirname(__FILE__) . '/views/header.php';

?>

<div class="container">
    <div class="row">
        <h3>Adverse Drug Events in FAERS </h3>
    </div>

    <div  style="margin-top: 30px">
        <!-- <form action='./search.php' method='get' autocomplete='off' id="search-form"> -->
        <!--  <form>-->
   <table>
       <tr>
           <td>
        <div class="panel panel-primary">
           <div class="panel-heading">
                <h4>Server: <span id="select-result"></span>
           <!--style="overflow: hidden; padding-right: .5em;" class="dropdown">-->
            <select class="selectpicker" style="overflow: hidden; padding-right: .5em;" name="dataset_datatype" onchange="showinputbox(this)">
                <option  value="FERAS">FERAS</option>
                <option  value="Twitter">Twitter/Forum</option>
                <option  value="Literature">Literature</option>
                <option  value="EHR">EHR</option>
            </select>
                </h4>
           </div>
        </div>
           </td>
           <td>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Drug: <span id="select-result"></span>
                    <!--style="overflow: hidden; padding-right: .5em;" class="dropdown">-->
                    <select class="selectpicker" style="overflow: hidden; padding-right: .5em;" name="dataset_datatype" onchange="showinputbox(this)" >
                        <option  value="All">All</option>
                        <option  value="Brand">Brand</option>
                        <option  value="Generic">Generic</option>
                    </select>
                </h4>
            </div>
        </div>
           </td>
           <td>
               <div class="panel panel-primary">
                   <div class="panel-heading">
                       <h4>Drug name: <span id="select-result"></span>
                           <!--style="overflow: hidden; padding-right: .5em;" class="dropdown">-->
                           <select class="selectpicker" style="overflow: hidden; padding-right: .5em;" name="dataset_datatype" onchange="showinputbox(this)" >
                               <option  selected value="default">    </option>
                               <option  value="All">drug1</option>
                               <option  value="Brand">drug2</option>
                               <option  value="Generic">drug3</option>
                           </select>
                       </h4>
                   </div>
               </div>
           </td>

           <td>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>ADR: <span id="select-result"></span>
                    <!--style="overflow: hidden; padding-right: .5em;" class="dropdown">-->
                    <select class="selectpicker" style="overflow: hidden; padding-right: .5em;" name="dataset_datatype" onchange="showinputbox(this)" >
                        <option  value="All">All</option>
                        <option  value="Brand">HCI</option>
                        <option  value="Generic">medRA</option>
                    </select>
                </h4>
            </div>
        </div>
           </td>
       </tr>
   </table>

        <div class="form-group" style="margin-top: 20px;margin-bottom: 20px">
            <button type="button" id="btnAdd" class="btn btn-default add-more pull-right"><span
                    class="glyphicon glyphicon-plus"></span>Add Criteria
            </button>
        </div>
        <br><br><br>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Analysis: <span id="select-result"></span>
                    <!--style="overflow: hidden; padding-right: .5em;" class="dropdown">-->
                    <select class="selectpicker" style="overflow: hidden; padding-right: .5em;" name="dataset_datatype" onchange="showinputbox(this)" value="<?php echo $_POST["dataset_datatype"];?>">
                        <option  value="All">Number</option>
                        <option  value="Brand">GPNN</option>
                        <option  value="Generic">X2</option>
                    </select>
                </h4>
            </div>
        </div>





        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Search Criteria</h4>
            </div>


            <div class="panel-body">
                <div class="row" style="margin-bottom: 10px">
                    <div class="col-lg-12">
                        <div id="group1">
                            <div class="dropdown" style="visibility: hidden">
                                <button id="op1" type="button" class="btn btn-default dropdown-toggle inner1 opul1 op1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">AND <span
                                        class="caret"></span>
                                </button>
                                <ul class="dropdown-menu inner1 opul1">
                                    <li><a href="#">AND</a></li>
                                    <li><a href="#">OR</a></li>
                                    <li><a href="#">NOT</a></li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <button type="button" class="btn btn-default dropdown-toggle inner1 fieldul1" id="drop1"
                                        data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">All Search Fields <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu inner1 fieldul1">
                                    <li><a href="#">All Search Fields</a></li>
                                    <li><a href="#">Date Received</a></li>
                                    <li><a href="#">Country of Occurrecy</a></li>
                                    <li><a href="#">Patient's Sex</a></li>
                                    <li><a href="#">......</a></li>
                                </ul>
                            </div>
                            <input class="input inner1" id="field1" type="text"
                                   placeholder="Type something""/>
                        </div>
                    </div>
                </div><!-- /row -->

                <div class="form-group" style="margin-top: 20px;margin-bottom: 20px">
                    <button type="button" id="btnAdd" class="btn btn-default add-more pull-right"><span
                            class="glyphicon glyphicon-plus"></span>Add Criteria
                    </button>
                </div>
                <!--
                    <div class="form-inline form-group col-lg-offset-4">
                        <label class="radio-inline">
                            <input name="searchtype" id="radio1" value="data" type="radio" name="searchtype" checked>
                            <p class="search-text-md">Search for data set</p>
                        </label>
                        <label class="radio-inline">
                            <input name="searchtype" id="radio2" value="repository" type="radio" name="searchtype">
                            <p class="search-text-md">Search for repository</p>
                        </label>
                    </div>
                    <hr>

                    <div class="form-group">
                        <input class="form-control" id="query" name='query'
                               placeholder="Use the builder below to create your search ">
                    </div>
                    <button type="button" class="btn btn-default pull-right" id="btn-show">Generate query</button>
                -->
            </div><!--/.panel-body-->

            <div class="panel-footer" style="height: 60px">
                <div>
                    <!--<a class="hyperlink" href="help.php">Help</a> -->
                    <button type="submit" class="btn btn-warning pull-right" id="btn-search">Submit</button>
                </div>
            </div><!--/.panel-footer-->

            <div class="panel-body" >
                <div id="effect" >
                    <h3 >Result</h3>
                    <p>
                        <img src="rslt.png" width="100%">
                    </p>
                </div>
            </div>
        </div><!--/.panel-->       <!-- </form>-->
    </div>

</div>


<?php include dirname(__FILE__) . '/views/footer.php'; ?>

</body>

</html>
