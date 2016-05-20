
var margin = { top: 50, right: 0, bottom: 50, left: 30 },
    width = 960 - margin.left - margin.right,
    height = 430 - margin.top - margin.bottom,
    gridSize = Math.floor(width / 22),
    legendElementWidth = gridSize*2,
    buckets = 10,
    colors = ["#ffffd9","#edf8b1","#c7e9b4","#7fcdbb","#41b6c4","#1d91c0","#225ea8","#253494","#081d58"], // alternatively colorbrewer.YlGnBu[9]
    days = [];//["1", "2", "3", "4", "5"],
    times = [];//["1a", "2a", "3a", "4a", "5a", "6a", "7a", "8a", "9a", "10a","11a", "12a", "13a", "14a", "15a", "16a", "17a", "18a", "19a", "20a"];
datasets = ["./data/drug.tsv", "./data/outcome.tsv"];

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
                drug: d.drug
            };
        },
        function(error, data) {
            var colorScale = d3.scale.quantile()
                .domain([d3.min(data, function (d) { return d.value; })*2.5, buckets - 1, d3.max(data, function (d) { return d.value; })])
                .range(colors);

            var tip = d3.tip()
                .attr('class', 'd3-tip')
                .style("visibility","visible")
                .offset([-20, 0])
                .html(function(d) {
                    //console.log(d);
                    return "Drug: "+ d.drug+ "<br> Case Count:  <span style='color:red'>" + Math.round(d.value) ;
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
                .style("fill", function(d) { return colorScale(d.value); });

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

var tip = d3.tip()
    .attr('class', 'd3-tip')
    .offset([10, 0])
    .html(function (d) {
        var k = d3.mouse(this);
        var m = Math.floor(scale[X].invert(k[0]));//will give the scale x
        var n = Math.floor(scale[Y].invert(k[1]));//will give the scale y
        return "Intensity Count: " + heatmap[n][m];
    })

svg.call(tip);

heatmapChart(datasets[0]);

var datasetpicker = d3.select("#dataset-picker").selectAll(".dataset-button")
    .data(datasets);

datasetpicker.enter()
    .append("input")
    .attr("value", function(d){ return "Group by " + (d.split("/")[2]).split(".")[0] })
    .attr("type", "button")
    .attr("class", "dataset-button")
    .on("click", function(d) {
        heatmapChart(d);
    });



