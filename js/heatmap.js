var heatmapChart = function(hmdata) {

// parse data
    dataObj = JSON.parse(hmdata);

    var data = {};
    data.melted = dataObj.data;
    //convert drug list from object to array
    var drugArray = $.map(dataObj.drug, function(value, index) {
        return [value];
    });
    data.ids = drugArray;
    data.conditions = dataObj.adr;

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
        d.drugName = d.drugName;
        d.adrName = d.adrName;
        d.value = +d.value;
    });

// Declare range
    var min = d3.min(data.melted, function(d) { return d.value; }),
        max = d3.max(data.melted, function(d) { return d.value; });

    console.log(min);
    console.log(max);

    var x = d3.scale.ordinal().domain(data.conditions).rangeBands([0, width]),
        y = d3.scale.ordinal().domain(data.ids).rangeBands([0, height]),
        z = d3.scale.log().base(2).domain([min, max]).range(['white','steelblue']);

// define color scale
    var buckets = 9,
        colors = ["#ffffd9","#edf8b1","#c7e9b4","#7fcdbb","#41b6c4","#1d91c0","#225ea8","#253494","#081d58"], // alternatively colorbrewer.YlGnBu[9]
        colorScale = d3.scale.quantile()
        .domain([0, buckets - 1, d3.max(data, function (d) { return d.value; })])
        .range(colors);

// Add tooltip
    var tip = d3.tip()
        .attr('class', 'd3-tip')
        .style("visibility","visible")
        .offset([-20, 0])
        .html(function(d) {
            //console.log(d);
            return "Drug Name: "+ d.drugName+ "<br> ADR Name: " + d.adrName + "<br> Case Count:  <span style='color:red'>" + Math.round(d.value) ;
            //return "Value:  <span style='color:red'>" + Math.round(d.value) ;
        });

    tip(svg.append("g"));

// Get data
    var cards = svg.selectAll('.tile')
        .data(data.melted)
        .enter().append('rect')
        .attr({
            'x': function(d) { return x(d.adrName); },
            'y': function(d) { return y(d.drugName); },
            'fill': function(d) {return colorScale(d.value);},
            'width': x.rangeBand(),
            'height': y.rangeBand(),

        })
        .on('mouseover', tip.show)
        .on('mouseout', tip.hide);

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
        });
        //.text('Relative expression');

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
}


