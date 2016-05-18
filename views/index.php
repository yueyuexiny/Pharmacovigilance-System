<div class="container">
    <div class="row">
        <h3>Adverse Drug Events in FAERS </h3>
    </div>

    <div style="margin-top: 30px">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Search Criteria</h4>
            </div>


            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-md-offset-2 row-fluid">
                        <h4>Source: <span id="select-result"></span>
                            <select class="selectpicker"
                                    style="overflow: hidden; padding-right: .5em;"
                                    name="dataset_datatype" onchange="showinputbox(this)">
                                <option value="FERAS">FAERS</option>
                                <option value="Twitter">Twitter/Forum</option>
                                <option value="Literature">Literature</option>
                                <option value="EHR">EHR</option>
                            </select>
                        </h4>
                    </div>


                    <div class="col-md-3">
                        <h4>Analysis: <span id="select-result"></span>
                            <select class="selectpicker" style="overflow: hidden; padding-right: .5em;"
                                    name="dataset_datatype"
                                    onchange="showinputbox(this)" value="<?php echo $_POST["dataset_datatype"]; ?>">
                                <option value="All">Number</option>
                                <option value="Brand">GPNN</option>
                                <option value="Generic">X2</option>
                            </select>
                        </h4>
                    </div>
                </div>

                <div class="row" id="drug">
                    <div class="col-xs-6 col-md-offset-2">
                        <div id="group_drug1">
                        <h4>Drug: <span id="select-result"></span>
                            <select class="selectpicker"  data-width="138px"
                                    name="dataset_datatype" onchange="showinputbox(this)">
                                <option value="All">All</option>
                                <option value="Brand">Brand</option>
                                <option value="Generic">Generic</option>
                            </select>

                            <select class="selectpicker" data-live-search="true" data-width="200px">
                                <option >Abacavir</option>
                                <option >Abagovomab</option>
                                <option >Abarelix</option>
                                <option >Acadesine</option>
                            </select>


                            <button type="button" id="btnAdddrug" class="btn btn-default add-more-drug "><span
                                    class="glyphicon glyphicon-plus"></span>Add Drug
                            </button>

                        </h4>
                    </div>
                </div>


                </div>

                <div class="row" id="ADR">
                    <div class="col-xs-6 col-md-offset-2">
                        <div id="group_adr1">
                        <h4>ADR: <span id="select-result1"></span>
                            <select class="selectpicker" data-width="138px"
                                    name="drugtype" onchange="showinputbox(this)">
                                <option value="All">All</option>
                                <option value="Brand">HOI</option>
                                <option value="Generic">medDRA</option>
                            </select>

                            <select class="selectpicker"  data-live-search="true" data-width="200px">
                                <option >ADR1</option>
                                <option >ADR2</option>
                                <option >ADR3</option>
                                <option >ADR4</option>
                            </select>
                            <button type="button" id="btnAddADR" class="btn btn-default add-more-ADR"><span
                                    class="glyphicon glyphicon-plus"></span>Add ADR
                            </button>
                        </h4>

                    </div>

                    </div>





               <!-- <div class="row" style="margin-bottom: 10px">
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
                                         aria-haspopup="true" aria-expanded="false">All Search Fields <span
                                         class="caret"></span>
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



            </div><!--/.panel-body-->

            <div class="panel-footer" style="height: 60px">
                <div>
                    <button type="submit" class="btn btn-warning pull-right" id="btn-search">Submit</button>
                </div>
            </div><!--/.panel-footer-->
        </div><!--/.panel-->


        <!---Visualizations--->
        <h3>Result</h3>

        <div class="heatmap">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">HeatMap</h3>
                </div>
                <div class="panel-body">
                    <div id="chart"></div>
                    <div id="dataset-picker"></div>
                </div>
            </div>

        </div>


        <div class="linechart">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Line Chart</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="container">
                            <div id="monthly-move-chart">
                                <strong>Monthly Index Abs Move & Volume/500,000 Chart</strong>
                                <span class="reset" style="display: none;">range: <span class="filter"></span></span>
                                <a class="reset"
                                   href="javascript:moveChart.filterAll();volumeChart.filterAll();dc.redrawAll();"
                                   style="display: none;">reset</a>

                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div id="monthly-volume-chart">
                        </div>
                        <p class="muted pull-right" style="margin-right: 15px;">select a time range to zoom in</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="barchart">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Bar Chart</h3>
                </div>
                <div class="panel-body">
                    <label><input type="checkbox"> Sort values</label>

                    <div id="bar"></div>
                </div>
            </div>
        </div>

        <div class="details">

            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Details</h3></div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Drug name</th>
                            <th>ADR</th>
                            <th>Score</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td colspan="2">Larry the Bird</td>
                            <td>@twitter</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>

</div>