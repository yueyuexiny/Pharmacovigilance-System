<?php

$drugname = new DrugName();
$result=$drugname->getDrugNameList("");

$ADRname = new ADRName();
$result_ADR=$ADRname->getADRNameList("");
$default_drug_list=[];
foreach ($result as $row) {
    array_push($default_drug_list,$row['drug_name']);
}
$default_ADR_list=[];
foreach ($result_ADR as $row) {
    array_push($default_ADR_list,$row['outcome_name']);
}

?>



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
                      <h4> Drug:
                             <span>
                                <label class="radio" ><input type="radio" name="Name">By Name</label>
                                <label class="radio" ><input type="radio" name="Ingredient">By Ingredient</label>
                            </span>

                            <input type="text" size="25"  class="input-group form-control" style = "width:40%" id="searchbox" autocomplete="off" placeholder="All" onkeyup="showResult(this.value)">
                            <div id="livesearch" style="width:40%"></div>

                            <!--
                            <select class="selectpicker" data-live-search="true" data-width="200px">
                                <option >All</option>
                                <?php //include include dirname(__FILE__) ."/../database/druglist.php";?>
                                <?php foreach($default_drug_list as $drug ):?>
                                    <option ><?php echo $drug;?></option>
                                <?php endforeach;?>
                                <!--<option >Abagovomab</option>
                                <option >Abarelix</option>
                                <option >Acadesine</option>-->
                           <!-- </select>-->


                            <button type="button" id="btnAdddrug" class="btn btn-default add-more-drug "><span
                                    class="glyphicon glyphicon-plus"></span>Add Drug
                            </button>
                        </div>
                        </h4>

                    </div>
                </div>

                <div class="row" id="ADR">
                    <div class="col-xs-6 col-md-offset-2">
                        <div id="group_adr1">
                        <h4>ADR: <span id="select-result1"></span>
                            <select class="selectpicker" data-width="138px"
                                    name="drugtype" onchange="showinputbox(this)">
                                <option value="Generic">medDRA</option>
                                <option value="All">All</option>
                                <option value="Brand">HOI</option>

                            </select>

                            <select class="selectpicker"  data-live-search="true" data-width="200px">
                                <option >All</option>
                                <?php //include dirname(__FILE__) ."/../database/ADRlist.php";?>
                                <?php foreach($default_ADR_list as $ADR ):?>
                                    <option ><?php echo $ADR;?></option>
                                <?php endforeach;?>

                            </select>
                            <button type="button" id="btnAddADR" class="btn btn-default add-more-ADR"><span
                                    class="glyphicon glyphicon-plus"></span>Add ADR
                            </button>
                        </h4>

                    </div>

                    </div>

            </div><!--/.panel-body-->

            <div class="panel-footer" style="height: 60px">
                <div>
                    <button type="submit" class="btn btn-warning pull-right" id="btn-search">Submit</button>
                </div>
            </div><!--/.panel-footer-->
        </div><!--/.panel-->
    </div>

</div>

