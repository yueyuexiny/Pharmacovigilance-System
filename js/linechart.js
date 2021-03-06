//# dc.js Getting Started and How-To Guide
'use strict';

/* jshint globalstrict: true */
/* global dc,d3,crossfilter,colorbrewer */

// ### Create Chart Objects

// Create chart objects associated with the container elements identified by the css selector.
// Note: It is often a good idea to have these objects accessible at the global scope so that they can be modified or
// filtered by other page controls.

//var moveChart = dc.lineChart('#monthly-move-chart');
var moveChart = dc.compositeChart('#monthly-move-chart');
var volumeChart = dc.barChart('#monthly-volume-chart');

var show_linechart_from_file = function(filename) {
    d3.csv(filename,function(data){

    var dateFormat = d3.time.format('%Y%m%d');
    var numberFormat = d3.format('.2f');
    var keys = Object.keys(data[0]);
    var drugnames = keys.slice(1,keys.length);//new data does not need -2

    data.forEach(function (d) {
        d.dd = dateFormat.parse(d.date);
        d.month = d3.time.month(d.dd); // pre-calculate month for better performance
        for(var i=0;i<drugnames.length;i++ )
            d[drugnames[i]]=+d[drugnames[i]];

    });

    //### Create Crossfilter Dimensions and Groups

    //See the [crossfilter API](https://github.com/square/crossfilter/wiki/API-Reference) for reference.
    var ndx = crossfilter(data);
    //var all = ndx.groupAll();

    // Dimension by year
    var yearlyDimension = ndx.dimension(function (d) {
        return d3.time.year(d.dd).getFullYear();
    });

    // Dimension by full date
    var dateDimension = ndx.dimension(function (d) {
        return d.dd;

    });
    // Dimension by month
    var moveMonths = ndx.dimension(function (d) {
        return d.month;
    });

    // Group by total volume within move, and scale down result
    var volumeByMonthGroup = moveMonths.group().reduceSum(function (d) {
        return d[drugnames[0]] /10;
    });

    // Group by total movement within month
    var tempNamespace = {};

    function add_one_line(i){
        tempNamespace["monthlyMoveGroup"+i] = moveMonths.group().reduceSum(function (d) {
            return d[drugnames[i]];
        });
        if(i==0){
            // Add the base layer of the stack with group. The second parameter specifies a series name for use in the
            // legend.
            // The `.valueAccessor` will be used for the base layer
        moveChart.group(tempNamespace['monthlyMoveGroup'+0], drugnames[0])
                .valueAccessor(function (d) {
                    return d.value;
                });
        }
       else{
            // Stack additional layers with `.stack`. The first paramenter is a new group.
            // The second parameter is the series name. The third is a value accessor.
        moveChart
            .stack(tempNamespace['monthlyMoveGroup'+i], drugnames[i], function (d) {
                return d.value;
            });

        }
    }


    //#### Stacked Area Chart

    //Specify an area chart by using a line chart with `.renderArea(true)`.
    // <br>API: [Stack Mixin](https://github.com/dc-js/dc.js/blob/master/web/docs/api-latest.md#stack-mixin),
    // [Line Chart](https://github.com/dc-js/dc.js/blob/master/web/docs/api-latest.md#line-chart)
    moveChart /* dc.lineChart('#monthly-move-chart', 'chartGroup') */
        .renderArea(true)
        .width(990)
        .height(200)
        .transitionDuration(1000)
        .margins({top: 30, right: 50, bottom: 25, left: 40})
        .dimension(moveMonths)
        .mouseZoomable(true)
        // Specify a "range chart" to link its brush extent with the zoom of the current "focus chart".
        .rangeChart(volumeChart)
        .x(d3.time.scale().domain([new Date(2004, 0, 1), new Date(2016, 6, 8)]))
        .round(d3.time.month.round)
        .xUnits(d3.time.months)
        .elasticY(true)
        .renderHorizontalGridLines(true)
        //##### Legend
        // Position the legend relative to the chart origin and specify items' height and separation.
        .legend(dc.legend().x(800).y(10).itemHeight(13).gap(5))
        .brushOn(false)

        for(var i=0;i<drugnames.length;i++){
            add_one_line(i);
        };

        // Title can be called by any stack layer.
        moveChart.title(function (d) {
            //var value = d.value.avg ? d.value.avg : d.value;
            var value = d.value;

            if (isNaN(value)) {
                value = 0;
            }
            return dateFormat(d.key) + '\n' + numberFormat(value);
        });
    //#### Range Chart

    // Since this bar chart is specified as "range chart" for the area chart, its brush extent
    // will always match the zoom of the area chart.
    volumeChart.width(990) /* dc.barChart('#monthly-volume-chart', 'chartGroup'); */
        .height(40)
        .margins({top: 0, right: 50, bottom: 20, left: 40})
        .dimension(moveMonths)
        .group(volumeByMonthGroup)
        .centerBar(true)
        .gap(1)
        .x(d3.time.scale().domain([new Date(2004, 0, 1), new Date(2016, 11, 31)]))
        .round(d3.time.month.round)
        .alwaysUseRounding(true)
        .xUnits(d3.time.months);
    //### Rendering

    //simply call `.renderAll()` to render all charts on the page
    dc.renderAll();

    });
};

var show_linechart = function(Jsondata) {
        var data = JSON.parse(Jsondata.slice());
        var dateFormat = d3.time.format('%Y%m%d');
        var numberFormat = d3.format('.2f');
        var keys = Object.keys(data[0]);
        var drugnames = keys.slice(1,keys.length);
        data.forEach(function (d) {

            d.dd = dateFormat.parse(d.date);
            d.month = d3.time.month(d.dd); // pre-calculate month for better performance
            for(var i=0;i<drugnames.length;i++ )
                d[drugnames[i]]=+d[drugnames[i]];

        });

        //### Create Crossfilter Dimensions and Groups

        //See the [crossfilter API](https://github.com/square/crossfilter/wiki/API-Reference) for reference.
        var ndx = crossfilter(data);
        //var all = ndx.groupAll();
        // Dimension by year
        var yearlyDimension = ndx.dimension(function (d) {
            return d3.time.year(d.dd).getFullYear();
        });

        // Dimension by full date
        var dateDimension = ndx.dimension(function (d) {
            return d.dd;

        });
        // Dimension by month
        var moveMonths = ndx.dimension(function (d) {
            return d.month;
        });

        // Group by total volume within move, and scale down result
        var volumeByMonthGroup = moveMonths.group().reduceSum(function (d) {
            return d[drugnames[0]] /10;
        });

        // Group by total movement within month
        var tempNamespace = {};
        var compose_array=[];

        var colors = d3.scale.category10();
        function add_one_line(i){
            tempNamespace["monthlyMoveGroup"+i] = moveMonths.group().reduceSum(function (d) {
                return d[drugnames[i]];
            });
                var line = dc.lineChart(moveChart)
                    .ordinalColors([colors(i)])
                    .group(tempNamespace['monthlyMoveGroup'+i], drugnames[i])
                    .valueAccessor(function (d) {
                        return d.value;
                    })
                    .renderArea(true);

                compose_array.push(line);
        }


      function render_plots(){
        var startyear = 2004;
        moveChart /* dc.lineChart('#monthly-move-chart', 'chartGroup') */
            //.renderArea(true)
            .width(990)
            .height(200)
            .transitionDuration(1000)
            .margins({top: 30, right: 50, bottom: 25, left: 40})
            .dimension(moveMonths)
            .mouseZoomable(true)
            // Specify a "range chart" to link its brush extent with the zoom of the current "focus chart".
            .rangeChart(volumeChart)
            .x(d3.time.scale().domain([new Date(startyear, 0, 1), new Date(2015, 12, 31)]))
            .round(d3.time.month.round)
            .xUnits(d3.time.months)
            .elasticY(true)
            .renderHorizontalGridLines(true)
            //##### Legend
            // Position the legend relative to the chart origin and specify items' height and separation.
            .legend(dc.legend().x(800).y(10).itemHeight(13).gap(5))
            .brushOn(false);

        for(var i=0;i<drugnames.length;i++){
            add_one_line(i);
        };
        moveChart.compose(compose_array);
          var monthNameFormat = d3.time.format('%Y/%m');
        // Title can be called by any stack layer.
        moveChart.title(function (d) {
            //var value = d.value.avg ? d.value.avg : d.value;
            var value = d.value;
            console.log(value);
            if (isNaN(value)) {
                value = 0;
            }
            return monthNameFormat(d.key) + '\n' + value;
        });

        //#### Range Chart

        // Since this bar chart is specified as "range chart" for the area chart, its brush extent
        // will always match the zoom of the area chart.
        volumeChart.width(990) /* dc.barChart('#monthly-volume-chart', 'chartGroup'); */
            .height(40)
            .margins({top: 0, right: 50, bottom: 20, left: 40})
            .dimension(moveMonths)
            .group(volumeByMonthGroup)
            .centerBar(true)
            .gap(1)
            .x(d3.time.scale().domain([new Date(startyear, 0, 1), new Date(2015, 12, 31)]))
            .round(d3.time.month.round)
            .alwaysUseRounding(true)
            .xUnits(d3.time.months);


        //### Rendering

        //simply call `.renderAll()` to render all charts on the page
        dc.renderAll();

    }

    ndx.remove();
    ndx.add(data);
    render_plots();
    document.getElementById("monthly-move-chart").style.display = "";
    document.getElementById("monthly-volume-chart").style.display = "";
    document.getElementById("clearAllLines").style.display = "";
    document.getElementById("monthOrYear").style.display = "";
};

var show_linechart_by_year = function(Jsondata,needgroup) {
    var data = JSON.parse(Jsondata.slice());
    var dateFormat = d3.time.format('%Y%m%d');
    if(needgroup==false){
        dateFormat = d3.time.format('%Y');
    }
    var numberFormat = d3.format('.2f');
    var keys = Object.keys(data[0]);
    var drugnames = keys.slice(1,keys.length);
    data.forEach(function (d) {

        d.dd = dateFormat.parse(d.date);
        d.year=d3.time.year(d.dd);
        for(var i=0;i<drugnames.length;i++ )
            d[drugnames[i]]=+d[drugnames[i]];

    });

    //### Create Crossfilter Dimensions and Groups

    //See the [crossfilter API](https://github.com/square/crossfilter/wiki/API-Reference) for reference.
    var ndx = crossfilter(data);

    // Dimension by year
    var yearlyDimension = ndx.dimension(function (d) {
        return d.year;
    });

    var volumeByYearGroup = yearlyDimension.group().reduceSum(function (d) {
        return d[drugnames[0]] /10;
    });

    // Group by total movement within month
    var tempNamespace = {};
    var compose_array=[];

    var colors = d3.scale.category10();
    function add_one_line(i){
        tempNamespace["yearlyMoveGroup"+i] = yearlyDimension.group().reduceSum(function (d) {
            return d[drugnames[i]];
        });
        var line = dc.lineChart(moveChart)
            .ordinalColors([colors(i)])
            .group(tempNamespace['yearlyMoveGroup'+i], drugnames[i])
            .valueAccessor(function (d) {
                return d.value;
            })
            .renderArea(true);

        compose_array.push(line);
    }


    function render_plots(){
        var startyear = 2004;
        moveChart /* dc.lineChart('#monthly-move-chart', 'chartGroup') */
        //.renderArea(true)
            .width(990)
            .height(200)
            .transitionDuration(1000)
            .margins({top: 30, right: 50, bottom: 25, left: 40})
            .dimension(yearlyDimension)
            .mouseZoomable(true)
            // Specify a "range chart" to link its brush extent with the zoom of the current "focus chart".
            .rangeChart(volumeChart)
            .x(d3.time.scale().domain([new Date(startyear, 0, 1), new Date(2015, 12, 31)]))
            //.round(d3.time.month.round)
            .xUnits(d3.time.years)
            .elasticY(true)
            .renderHorizontalGridLines(true)
            //##### Legend
            // Position the legend relative to the chart origin and specify items' height and separation.
            .legend(dc.legend().x(800).y(10).itemHeight(13).gap(5))
            .brushOn(false)

        for(var i=0;i<drugnames.length;i++){
            add_one_line(i);
        };
        moveChart.compose(compose_array);
        var monthNameFormat = d3.time.format('%Y');
        // Title can be called by any stack layer.
        moveChart.title(function (d) {
            //var value = d.value.avg ? d.value.avg : d.value;
            var value = d.value;
            if (isNaN(value)) {
                value = 0;
            }
            return monthNameFormat(d.key) + '\n' + value;
        });

        //#### Range Chart

        // Since this bar chart is specified as "range chart" for the area chart, its brush extent
        // will always match the zoom of the area chart.
        volumeChart.width(990) /* dc.barChart('#monthly-volume-chart', 'chartGroup'); */
            .height(40)
            .margins({top: 0, right: 50, bottom: 20, left: 40})
            .dimension(yearlyDimension)
            .group(volumeByYearGroup)
            .centerBar(true)
            .gap(1)
            .x(d3.time.scale().domain([new Date(startyear, 0, 1), new Date(2015, 12, 31)]))
            //.round(d3.time.month.round)
            .alwaysUseRounding(true)
            .xUnits(d3.time.years);


        //### Rendering

        //simply call `.renderAll()` to render all charts on the page
        dc.renderAll();

    }

    ndx.remove();
    ndx.add(data);
    render_plots();
    document.getElementById("monthly-move-chart").style.display = "";
    document.getElementById("monthly-volume-chart").style.display = "";
    document.getElementById("clearAllLines").style.display = "";
    document.getElementById("monthOrYear").style.display = "";
};

var show_linechart_by_quarter = function(Jsondata,needgroup) {
    var data = JSON.parse(Jsondata.slice());
    var dateFormat = d3.time.format('%Y%m%d');
    var numberFormat = d3.format('.2f');
    var keys = Object.keys(data[0]);
    var drugnames = keys.slice(1,keys.length);
    data.forEach(function (d) {

        d.dd = dateFormat.parse(d.date);
        var mon=d.dd.getMonth();
        var yr= d.dd.getFullYear();
        d.quarter = "";

        if ( mon <= 2 ) {
            d.quarter =  new Date(yr,0,1);
        } else if ( mon <= 5 ) {
            d.quarter = new Date(yr,3,1);
        } else if ( mon <= 8 ) {
            d.quarter = new Date(yr,6,1);
        } else {
            d.quarter =new Date(yr,9,1);
        }
        for(var i=0;i<drugnames.length;i++ )
            d[drugnames[i]]=+d[drugnames[i]];

    });

    //### Create Crossfilter Dimensions and Groups

    //See the [crossfilter API](https://github.com/square/crossfilter/wiki/API-Reference) for reference.
    var ndx = crossfilter(data);

    // Dimension by year
    var quarterDimension = ndx.dimension(function (d) {
        return d.quarter;
    });

    var volumeByQuarterGroup = quarterDimension.group().reduceSum(function (d) {
        return d[drugnames[0]] /10;
    });

    // Group by total movement within month
    var tempNamespace = {};
    var compose_array=[];

    var colors = d3.scale.category10();
    function add_one_line(i){
        tempNamespace["quarterMoveGroup"+i] = quarterDimension.group().reduceSum(function (d) {
            return d[drugnames[i]];
        });
        var line = dc.lineChart(moveChart)
            .ordinalColors([colors(i)])
            .group(tempNamespace['quarterMoveGroup'+i], drugnames[i])
            .valueAccessor(function (d) {
                return d.value;
            })
            .renderArea(true);

        compose_array.push(line);
    }


    function render_plots(){
        var startyear = 2004;
        moveChart /* dc.lineChart('#monthly-move-chart', 'chartGroup') */
        //.renderArea(true)
            .width(990)
            .height(200)
            .transitionDuration(1000)
            .margins({top: 30, right: 50, bottom: 25, left: 40})
            .dimension(quarterDimension)
            .mouseZoomable(true)
            // Specify a "range chart" to link its brush extent with the zoom of the current "focus chart".
            .rangeChart(volumeChart)
            .x(d3.time.scale().domain([new Date(startyear, 0, 1), new Date(2015, 11, 31)]))
            //.round(d3.time.month.round)
            //.xUnits(d3.time.years)
            .elasticY(true)
            .renderHorizontalGridLines(true)
            //##### Legend
            // Position the legend relative to the chart origin and specify items' height and separation.
            .legend(dc.legend().x(800).y(10).itemHeight(13).gap(5))
            .brushOn(false)

        for(var i=0;i<drugnames.length;i++){
            add_one_line(i);
        };
        moveChart.compose(compose_array);
        var monthNameFormat = d3.time.format('%Y/%m');
        // Title can be called by any stack layer.
        moveChart.title(function (d) {
            //var value = d.value.avg ? d.value.avg : d.value;
            var value = d.value;
            if (isNaN(value)) {
                value = 0;
            }
            return monthNameFormat(d.key) + '\n' + value;
        });

        //#### Range Chart

        // Since this bar chart is specified as "range chart" for the area chart, its brush extent
        // will always match the zoom of the area chart.
        volumeChart.width(990) /* dc.barChart('#monthly-volume-chart', 'chartGroup'); */
            .height(40)
            .margins({top: 0, right: 50, bottom: 20, left: 40})
            .dimension(quarterDimension)
            .group(volumeByQuarterGroup)
            .centerBar(true)
            .gap(1)
            .x(d3.time.scale().domain([new Date(startyear, 0, 1), new Date(2015, 11, 31)]))
            //.round(d3.time.month.round)
            .alwaysUseRounding(true);
            //.xUnits(d3.time.years);


        //### Rendering

        //simply call `.renderAll()` to render all charts on the page
        dc.renderAll();

    }

    ndx.remove();
    ndx.add(data);
    render_plots();
    document.getElementById("monthly-move-chart").style.display = "";
    document.getElementById("monthly-volume-chart").style.display = "";
    document.getElementById("clearAllLines").style.display = "";
    document.getElementById("monthOrYear").style.display = "";
};

function clearAllLines(){
    document.getElementById("monthly-move-chart").style.display = "none";
    document.getElementById("monthly-volume-chart").style.display = "none";
    document.getElementById("clearAllLines").style.display = "none";
    document.getElementById("monthOrYear").style.display = "none";
    selected_adrname = {};
    selected_drugname = {};
    selected_pairs = [];
}
//#### Versions

//Determine the current version of dc with `dc.version`
d3.selectAll('#version').text(dc.version);

// Determine latest stable version in the repo via Github API
d3.json('https://api.github.com/repos/dc-js/dc.js/releases/latest', function (error, latestRelease) {
    /*jshint camelcase: false */
    d3.selectAll('#latest').text(latestRelease.tag_name); /* jscs:disable */
});
