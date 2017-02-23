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

    var source = dataObj.source;

    //$('#expat-heatmap').text(source);

    //Add label


    // d3.js
    var margin = {
            top: 5,
            right: 5,
            bottom: 200,
            left: 80
        }
    if((data.conditions.length)>25){
        var width = 1000;
    }else{
        var width = (data.conditions.length)*40;
    }

    if(data.ids.length>25){
        var height = 1000;
        yvalue = 20*(data.ids.length/data.conditions.length + 5);
    }else{
        var height = 40*(data.ids.length);
        yvalue = 40*(data.ids.length + 4);
    }


// Create graph
    var svg = d3.select('#expat-heatmap')
        .append('svg:svg')
        .attr('width',width- margin.right)
        .attr('height',yvalue + 80)
        .append('g')
        .attr({
            'transform': 'translate(' + margin.left + ',' + margin.top + ')',
            'width': width- margin.left - margin.right,
            'height': height
        });



// Coerce data
    data.melted.forEach(function(d) {
        d.drugName = d.drugName;
        d.adrName = d.adrName;
        d.drugId = d.drugId;
        d.adrId = d.adrId;
        d.value = +d.value;
    });



// Declare range
    var min = d3.min(data.melted, function(d) { return d.value; }),
        max = d3.max(data.melted, function(d) { return d.value; });


    // define color scale
    var buckets = 9,
        colors = ["#ffffd9","#edf8b1","#c7e9b4","#7fcdbb","#41b6c4","#1d91c0","#225ea8","#253494","#081d58"], // alternatively colorbrewer.YlGnBu[9]
        colorScale = d3.scale.quantile()
            .domain([0, buckets - 1,max/2])
            .range(colors);

    var x = d3.scale.ordinal().domain(data.conditions).rangeBands([0, width]),
        y = d3.scale.ordinal().domain(data.ids).rangeBands([0, height]),
        z = d3.scale.log().base(2).domain([min, max]).range(colors);


// Add tooltip
    var tip = d3.tip()
        .attr('class', 'd3-tip')
        .style("visibility","visible")
        .offset([-20, 0])
        .html(function(d) {
            return "Drug Name: "+ d.drugName.split("||",1)+ "<br> ADR Name: " + d.adrName.split("||",1) + "<br> "+ dataObj.analysis +":  <span style='color:red'>" + Math.round(d.value) ;
        });

    tip(svg.append("g"));


// Get data

    var cards = svg.selectAll('.tile')
        .data(data.melted)

    cards.enter().append("rect")
        .attr("x",function(d) { return x(d.adrName); })
        .attr("y",function(d) { return y(d.drugName); })
        .attr("rx",0)
        .attr("ry",0)
        .attr('transform', 'translate(0,120)')
        .attr('fill', function(d) {return colorScale(d.value);})
        .attr('width',function(){
            if(x.rangeBand()< 15){
                return 15;
            }else if(x.rangeBand()>40){
                return 40;
            }else{
                return x.rangeBand();
            }
        })


        .attr('height', y.rangeBand())
        .on('mouseover', tip.show)
        .on('mouseout', tip.hide)
        .on('click',function(d){
            if(d.value>0){
                update_id_pair(d.drugId,d.adrId, d.drugName, d.adrName,source,"b");
            }

        })
    ;

    if((data.conditions.length)>25){
        var gridSize = 40;
            legendElementWidth = gridSize*2;
    }else{
        var gridSize = Math.floor(width / data.conditions.length),
            legendElementWidth = gridSize*2;
    }

    var legend = svg.selectAll(".legend")
        .data([0].concat(colorScale.quantiles()), function(d) { return d; });

    legend.enter().append("g")
        .attr("class", "legend");

    legend.append("rect")
        .attr("x", function(d, i) {return legendElementWidth * i; })
        .attr("y", yvalue-20)
        .attr("width", legendElementWidth)
        .attr("height", gridSize / 2)
        .style("fill", function(d, i) { return colors[i]; });

    legend.append("text")
        .attr("class", "mono")
        .text(function(d) { return "≥ " +Math.round(d); })
        .attr("x", function(d, i) { return legendElementWidth * i; })
        .attr("y", yvalue + gridSize-20);

    svg.append("text")
        .attr("class", "mono")
        .text(source)
        .attr("x", -10)
        .attr("y",5);

    legend.exit().remove();


// Append axes
    var x_axis = d3.svg.axis()
        .scale(x)
        .orient('top')
        .tickSize(3,0),
        y_axis = d3.svg.axis()
            .scale(y)
            .orient('left')
            .tickSize(0);

    svg.append('g')
        .attr({
            'class': 'x axis',
            'transform': 'translate(0,120)'
        })
        .call(x_axis)
        .selectAll('text')
        .style('text-anchor', 'start')
        .attr({
            'dx': '8',
            'dy': '-2',
            'transform': 'rotate(270)',
            'font-size': '10'
        });

    svg.append('g')
        .attr({
            'class': 'y axis',
            'transform': 'translate(0,120)'
        })
        .call(y_axis)
        .selectAll('text')
        .style('text-anchor', 'end')
        .attr({
            'font-size': '10'
        });
}


