
/*var margin = { top: 50, right: 0, bottom: 50, left: 30 },
    width = 960 - margin.left - margin.right,
    height = 430 - margin.top - margin.bottom,
    gridSize = Math.floor(width / 22),
    legendElementWidth = gridSize*2,
    buckets = 9,
    colors = ["#ffffd9","#edf8b1","#c7e9b4","#7fcdbb","#41b6c4","#1d91c0","#225ea8","#253494","#081d58"], // alternatively colorbrewer.YlGnBu[9]
    days = [];//["1", "2", "3", "4", "5"],
    times = [];//["1a", "2a", "3a", "4a", "5a", "6a", "7a", "8a", "9a", "10a","11a", "12a", "13a", "14a", "15a", "16a", "17a", "18a", "19a", "20a"];


var svg = d3.select("#chart").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.left*4 + "," + margin.top + ")");

var dayLabels = svg.selectAll(".dayLabel")
    .data(days)
    .enter().append("text")
    .text(function (d) { return d; })
    .attr("x", 0)
    .attr("y", function (d, i) { return i * gridSize; })
    .style("text-anchor", "end")
    .attr("transform", "translate(-6," + gridSize / 1.5 + ")")
    .attr("class", function (d, i) { return ((i >= 0 && i <= 4) ? "dayLabel mono axis axis-workweek" : "dayLabel mono axis"); });

var timeLabels = svg.selectAll(".timeLabel")
    .data(times)
    .enter().append("text")
    .text(function(d) { return d; })
    .attr("x", function(d, i) { return i * gridSize; })
    .attr("y", 0)
    .style("text-anchor", "middle")
    .attr("transform", "translate(" + gridSize / 2 + ", -6)")
    .attr("class", function(d, i) { return ((i >= 7 && i <= 16) ? "timeLabel mono axis axis-worktime" : "timeLabel mono axis"); });

var heatmapChart = function(tsvFile) {
    d3.tsv(tsvFile,
        function(d) {

            return {
                day: +d.day,
                hour: +d.hour,
                value: +d.value,
                drug: d.drug,
                outcome: d.outcome
            };
        },
        function(error, data) {
            var colorScale = d3.scale.quantile()
                .domain([0, buckets - 1, d3.max(data, function (d) { return d.value; })])
                .range(colors);

            var tip = d3.tip()
                .attr('class', 'd3-tip')
                .style("visibility","visible")
                .offset([-20, 0])
                .html(function(d) {
                    //console.log(d);
                    return "Drug Name: "+ d.drug+ "<br> Outcome Name: " + d.outcome + "<br> Case Count:  <span style='color:red'>" + Math.round(d.value) ;
                    //return "Value:  <span style='color:red'>" + Math.round(d.value) ;
                });

            tip(svg.append("g"));


            var cards = svg.selectAll(".hour")
                .data(data, function(d) {return d.day+':'+d.hour;});

            cards.append("title");

            cards.enter().append("rect")
                .attr("x", function(d) { return (d.hour - 1) * gridSize; })
                .attr("y", function(d) { return (d.day - 1) * gridSize; })
                .attr("rx", 4)
                .attr("ry", 4)
                .attr("class", "hour bordered")
                .attr("width", gridSize)
                .attr("height", gridSize)
                .style("fill", colors[0])
                .on('mouseover', tip.show)
                .on('mouseout', tip.hide);

            cards.transition().duration(1000)
                .style("fill", function(d) {return colorScale(d.value); });

            cards.select("title").text(function(d) { return d.value; });

            cards.exit().remove();

            var legend = svg.selectAll(".legend")
                .data([0].concat(colorScale.quantiles()), function(d) { return d; });

            legend.enter().append("g")
                .attr("class", "legend");

            legend.append("rect")
                .attr("x", function(d, i) { return legendElementWidth * i; })
                .attr("y", height)
                .attr("width", legendElementWidth)
                .attr("height", gridSize / 2)
                .style("fill", function(d, i) { return colors[i]; });

            legend.append("text")
                .attr("class", "mono")
                .text(function(d) { return "≥ " + Math.round(d); })
                .attr("x", function(d, i) { return legendElementWidth * i; })
                .attr("y", height + gridSize);

            legend.exit().remove();
        });
};
*/

//heatmapChart(datasets[0]);

/*var datasetpicker = d3.select("#dataset-picker").selectAll(".dataset-button")
    .data(datasets);

datasetpicker.enter()
    .append("input")
    .attr("value", function(d){ return "Group by " + (d.split("/")[2]).split(".")[0] })
    .attr("type", "button")
    .attr("class", "dataset-button")
    .on("click", function(d) {
        heatmapChart(d);
        document.getElementById("grouplabel").innerHTML = "Group by " + (d.split("/")[2]).split(".")[0];
    });

*/




var data = {};
data.melted = [
    {
        "geneID":"Gene 4",
        "condition":"Treatment 1",
        "value":55.92
    },
    {
        "geneID":"Gene 4",
        "condition":"Treatment 10",
        "value":44.26
    },
    {
        "geneID":"Gene 4",
        "condition":"Treatment 26",
        "value":49.18
    },
    {
        "geneID":"Gene 4",
        "condition":"Treatment 73",
        "value":34.8
    },
    {
        "geneID":"Gene 6",
        "condition":"Treatment 1",
        "value":47.26
    },
    {
        "geneID":"Gene 6",
        "condition":"Treatment 10",
        "value":45.08
    },
    {
        "geneID":"Gene 6",
        "condition":"Treatment 26",
        "value":89.95
    },
    {
        "geneID":"Gene 6",
        "condition":"Treatment 73",
        "value":48.29
    },
    {
        "geneID":"Gene 8",
        "condition":"Treatment 1",
        "value":9.79
    },
    {
        "geneID":"Gene 8",
        "condition":"Treatment 10",
        "value":10.12
    },
    {
        "geneID":"Gene 8",
        "condition":"Treatment 26",
        "value":10.48
    },
    {
        "geneID":"Gene 8",
        "condition":"Treatment 73",
        "value":14.73
    },
    {
        "geneID":"Gene 9",
        "condition":"Treatment 1",
        "value":16.76
    },
    {
        "geneID":"Gene 9",
        "condition":"Treatment 10",
        "value":18.15
    },
    {
        "geneID":"Gene 9",
        "condition":"Treatment 26",
        "value":17.26
    },
    {
        "geneID":"Gene 9",
        "condition":"Treatment 73",
        "value":16.59
    },
];
data.ids = ['Gene 4','Gene 6','Gene 8','Gene 9'];
data.conditions = ['Treatment 1', 'Treatment 10', 'Treatment 26', 'Treatment 73'];

// d3.js
var margin = {
        top: 5,
        right: 5,
        bottom: 140,
        left: 60
    },
    width = 600 - margin.left - margin.right,
    height = 20*(data.ids.length);

// Create graph
var svg = d3.select('#expat-heatmap')
    .append('svg:svg')
    .attr({
        'viewBox': '0 0 ' + (width + margin.left + margin.right) + ' ' + (height + margin.top + margin.bottom),
        'preserveAspectRatio': 'xMidYMid meet'
    })
    .append('g')
    .attr({
        'transform': 'translate(' + margin.left + ',' + margin.top + ')',
        'width': width,
        'height': height
    });

// Coerce data
data.melted.forEach(function(d) {
    d.geneID = d.geneID;
    d.condition = d.condition;
    d.value = +d.value;
});

// Declare range
var min = d3.min(data.melted, function(d) { return d.value; }),
    max = d3.max(data.melted, function(d) { return d.value; });

var x = d3.scale.ordinal().domain(data.conditions).rangeBands([0, width]),
    y = d3.scale.ordinal().domain(data.ids).rangeBands([0, height]),
    z = d3.scale.log().base(2).domain([min, max]).range(['white','steelblue']);

// Get data
svg.selectAll('.tile')
    .data(data.melted)
    .enter()
    .append('rect')
    .attr({
        'x': function(d) { return x(d.condition); },
        'y': function(d) { return y(d.geneID); },
        'fill': function(d) { return z(d.value); },
        'width': x.rangeBand(),
        'height': y.rangeBand()
    });

// Add a legend for the color values.
var legend = svg.selectAll(".legend")
    .data(z.ticks())
    .enter()
    .append("g")
    .attr({
        'class': 'legend',
        'transform': function(d, i) {
            console.log(d);
            return "translate(" + (i * 40) + "," + (height + margin.bottom - 40) + ")";
        }
    });

legend.append("rect")
    .attr({
        'width': 40,
        'height': 20,
        'fill': z
    });

legend.append("text")
    .attr({
        'font-size': 10,
        'x': 0,
        'y': 30
    })
    .text(String);

svg.append("text")
    .attr({
        'class': 'label',
        'font-size': 10,
        'x': 0,
        'y': height + margin.bottom - 45
    })
    .text('Relative expression');

// Append axes
var x_axis = d3.svg.axis()
    .scale(x)
    .orient('bottom')
    .tickSize(3,0),
    y_axis = d3.svg.axis()
        .scale(y)
        .orient('left')
        .tickSize(0);

svg.append('g')
    .attr({
        'class': 'x axis',
        'transform': 'translate(0,'+height+')'
    })
    .call(x_axis)
    .selectAll('text')
    .style('text-anchor', 'start')
    .attr({
        'dx': '8',
        'dy': '-2',
        'transform': 'rotate(90)',
        'font-size': '10'
    });

svg.append('g')
    .attr({
        'class': 'y axis'
    })
    .call(y_axis)
    .selectAll('text')
    .style('text-anchor', 'end')
    .attr({
        'font-size': '10'
    })
    .selectAll('path.domain	')
    .attr({
        'stroke': '0'
    });

// Append borders
svg
    .append('svg:line')
    .attr({
        'class': 'border-top',
        'x1': 0,
        'x2': width,
        'y1': 0,
        'y2': 0
    });
svg.append('svg:line')
    .attr({
        'class': 'border-right',
        'x1': width,
        'x2': width,
        'y1': height,
        'y2': 0
    });