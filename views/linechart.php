<div class="panel panel-default linechart">

    <div class="panel-heading">
       <h3 class="panel-title"> <a role="button" data-target="#collapseThree" data-toggle="collapse" aria-expanded="true" aria-controls="collapseThree">
            <i class="fa fa-expand"></i> Line Chart</a>
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



