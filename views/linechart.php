<div class="panel panel-default linechart">

    <div class="panel-heading">
       <h3 class="panel-title"> <a role="button" data-target="#collapseThree" data-toggle="collapse" aria-expanded="true" aria-controls="collapseThree">
               <i class="glyphicon glyphicon-plus"></i>  Line Chart</a>
       </h3>
    </div>

    <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">

        <div class="panel-body">
            <div class="row">
                <div class="container">
                    <div id="monthly-move-chart">
                        <strong>Analysis result of Drug and ADR</strong>
                        <span class="reset" style="display: none;">range: <span class="filter"></span></span>
                        <a class="reset"
                           href="javascript:moveChart.filterAll();volumeChart.filterAll();dc.redrawAll();"
                           style="display: none;">reset time line</a>

                        <input class='btn-primary' id="clearAllLines" style="display: none;" type="button" onclick="clearAllLines()" value="Clear"/>

                        <div class="btn-group" role="group" id="monthOrYear" style="display: none;" data-toggle="buttons">
                            <label class="monthOrYearBtn btn btn-default" onclick="switch_year_or_month('month')" ><input type="radio" name="monthoryear" id="month" >By Month</label>
                            <label class="monthOrYearBtn btn btn-default" onclick="switch_year_or_month('year')"><input type="radio" name="monthoryear" id="year" >By Year</label>
                        </div>

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



