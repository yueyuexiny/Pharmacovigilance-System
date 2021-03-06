<div class="container" style="margin-bottom: 30px">

    <div id="search_criteria">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Search Criteria</h4>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-1 col-xs-offset-1">
                        <h4>Source:</h4>
                    </div>

                    <div class="col-xs-5">
                        <div class="checkbox" id = "source">
                        <label class="checkbox-inline"><input type="checkbox" name ="sourcechk" value="FAERS" checked>FAERS</label>
                       <!-- <label class="checkbox-inline"><input type="checkbox" name ="sourcechk" value="Twitter">Twitter/Forum</label>-->
                        <label class="checkbox-inline"><input type="checkbox" name ="sourcechk" value="Literature">Literature</label>
                        <label class="checkbox-inline"><input type="checkbox" name ="sourcechk" value="EHR">EHR</label>
                            </div>
                    </div>

                    <div class="col-xs-1 ">
                        <label for="analysis"> <h4>Analysis: </h4></label>
                    </div>
                    <div class="col-xs-3">

                        <select class="selectpicker" name="analysis" id="analysis">
                            <option value="case_count"> Case Count</option>
                            <option value="ror"> Reporting Odds Ratio</option>
                            <option value="prr"> Proportional Reporting Ratio</option>
                            <option value="chi"> Chi-Squared test</option>
                            <option value="Q"> Yules Q ratio</option>
                            <option value="IC"> Information Componet</option>
                            <option value="L"> Leverage(X->Y)</option>
                        </select>
                    </div>
                </div>

                <div class="row rowforsearch">
                    <div id="group_drug1 form-group">
                        <div class="col-xs-1 col-xs-offset-1">
                            <label for="searchbox"><h4>Drug</h4></label>
                        </div>
                        <div class="col-xs-2">

                            <div class="radio">
                                <label><input type="radio" name="Drug" value="ingredient" checked
                                              onclick="clear_chosen('drug')"/>By Ingredient</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="Drug" value="name"
                                              onclick="clear_chosen('drug')"/>By Name</label>
                            </div>

                        </div>
                        <div class="col-xs-6">

                            <input type="text" class="form-control"
                                   id="searchbox" autocomplete="off" placeholder="Please enter to search"
                                   name="drugname"
                                   onkeyup='showResult(this.value,"drug")'>
                            <div id="livesearch"></div>
                            <div id="searchresult"></div>
                        </div>

                    </div>
                </div>

                <div class="row rowforsearch">
                    <div id="group_adr1">
                        <div class="col-xs-1 col-xs-offset-1">
                            <label for="searchbox_adr"><h4>ADR</h4></label>
                        </div>
                        <div class="col-xs-2">
                            <div class="radio">
                                <label><input type="radio" name="ADR" value="medDRA" checked
                                              onclick="clear_chosen('adr')"/>MedDRA</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="ADR" value="HOI"
                                              onclick="clear_chosen('adr')"/>HOI</label>
                            </div>

                        </div>
                        <div class="col-xs-6">
                            <input type="text" size="25" class="input-group form-control"
                                   id="searchbox_adr" autocomplete="off" placeholder="Please enter to search"
                                   name="adrname"
                                   onkeyup='showResult(this.value,"adr")'>
                            <div id="livesearch_adr"></div>
                            <div id="searchresult_adr"></div>
                        </div>
                    </div>
                </div>


            </div><!--panel-body-->
            <div class="panel-footer">
                <div>

                    <button class="btn btn-primary pull-right" id="btn-search" onclick="submit()">Submit</button>
                    <span id="result"></span>
                    <span id="result_adr"></span>
                    <span id="result_source"></span>

                </div>
            </div><!--/.panel-footer-->

        </div><!--panel-->
    </div><!--search_criteria-->

