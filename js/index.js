var groupNum_drug = [1]; // track id of existing input group
var groupNum_adr = [1]; // track id of existing input group



var global_source = ["FAERS"]; // selected data source
var global_analysis = ""; // selected analysis method
var global_drugGroup = "";  // selected drug group
var global_drugIDList = "";  // selected drugs' ID
var global_adrGroup = "";   // selected adr group
var global_adrIDList = "";  // selected adrs' ID

var global_month_or_year="month"; //default select month line chart
var global_timeline_data = ""; //store the data for switch month or year line chart

/*select drug ID and name, selected adr ID and name*/
var selected_drugID = "";
var selected_adrID = "";
var selected_adrname = {};
var selected_drugname = {};
var selected_pairs = [];



function submit(){


    // Get drug IDs
    var drugID=document.querySelectorAll(".drugid");
    var drug="";
    for (i = 0; i < drugID.length; i++) {
        drug += drugID[i].innerHTML + ",";
        $( "#drugList" ).append('<div><label for="name"></label></div>');
    }
    global_drugIDList=drug.slice(0,-1);

    // Get adr IDs
    var adrID=document.querySelectorAll(".adrid");
    var adr="";
    for (i = 0; i < adrID.length; i++) {
        adr += adrID[i].innerHTML + ",";
    }
    global_adrIDList=adr.slice(0,-1);

    //Get data source and analysis method
    var x = get_source_analysis();
    global_source = x[0];
    global_analysis = x[1];


    // Get drug and adr groups
    global_drugGroup = document.querySelector('input[name="Drug"]:checked').value;
    global_adrGroup = document.querySelector('input[name="ADR"]:checked').value;

    if(global_drugIDList == "" && global_adrIDList==""){
        alert("Please Enter at Least One Drug or ADR");
    }else{
        // Display Heatmap
        d3.selectAll("svg").remove();
        $('#img').show();
        for (i=0;i<global_source.length;i++){
            show_heatmap(global_source[i]);
        }


        // Display data in table
        get_table_data();

        // Hide line chart
        document.getElementById("monthly-move-chart").style.display = "none";
        document.getElementById("monthly-volume-chart").style.display = "none";
    }



    // Clear the selected elements
    selected_drugID = "";
    selected_adrID = "";
    selected_adrname = {};
    selected_drugname = {};
    selected_pairs = [];
}


/********************************************
 *
 * Functions for search creiteria panel
 *
 * ******************************************/

// Clear selected drugs
function clear_chosen(str){
    var id = "searchresult";
    var id_live = "livesearch";
    if(str=='adr'){
        id="searchresult_adr";
        id_live = "livesearch_adr";
    }
    document.getElementById(id).innerHTML="";
    document.getElementById(id_live).innerHTML="";

}

// Get selected data source and analysis method
function get_source_analysis(){
    var source = [];
    $.each($("input[name='sourcechk']:checked"), function(){
        source.push($(this).val());
    });

    var y = document.getElementById("analysis");
    var result = [source,y.value];
    return result;
}

// Return search results based on characters entered by the user
function showResult(str,type) {
    var searchboxid = "livesearch";
    var group = document.querySelector('input[name="Drug"]:checked').value;
    if(type=="adr"){
        searchboxid = "livesearch_adr";
        group = document.querySelector('input[name="ADR"]:checked').value;
    }

    var source = global_source[0];
    var analysis = global_analysis;
    var x = document.getElementById(searchboxid);

    x.style.display = "";

    if (str.length == 0) {
        document.getElementById(searchboxid).innerHTML = "";
        document.getElementById(searchboxid).style.border = "0px";
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById(searchboxid).innerHTML = xmlhttp.responseText;
            document.getElementById(searchboxid).style.border = "1px solid #A5ACB2";
            document.getElementById(searchboxid).style.width = "auto";

        }
    }
    xmlhttp.open("GET", "livesearch.php?q=" + str + '&type='+type+'&source='+source+'&analysis='+analysis+'&group='+group, true);
    xmlhttp.send();
}


// Display selected drugs
function select_drug(str,id) {
    var next = groupNum_drug[groupNum_drug.length - 1] + 1;
    groupNum_drug.push(next);

    document.getElementById("searchbox").value = "";
    var x = document.getElementById("livesearch").style.display = "none";
    var div = document.getElementById('searchresult');

    if(str.length>52){
        str = str.slice(0,52)+"...";
    }
    var text = ' <div class="row rowstyle" id="moredrug' + next + '">\
                   <div class="input-group input-group-lg ">\
                     <span class="input-group-addon drug">' + str + '<span class="drugid" style="display:none">'+id+'</span></span>\
                     <button type="button" class="btn btn-danger" onclick="remove_me(\'moredrug' + next + '\')">-</button>\
                   </div>\
                </div>';
    div.innerHTML = div.innerHTML + text;

};

// Display selected adrs
function select_adr(str,id) {

    var next = groupNum_adr[groupNum_adr.length - 1] + 1;
    groupNum_adr.push(next);

    document.getElementById("searchbox_adr").value="";
    var x = document.getElementById("livesearch_adr").style.display = "none";
    var div = document.getElementById('searchresult_adr');
    if(str.length>52){
        str = str.slice(0,52)+"...";
    }
    var text = ' <div class="row rowstyle" id="moredadr' + next + '">\
                    <div class="input-group input-group-lg ">\
                        <span class="input-group-addon adr">' + str + '<span class="adrid" style="display:none">'+id+'</span></span>\
                        <button type="button" class="btn btn-danger " onclick="remove_me(\'moredadr' + next + '\')">-</button>\
                   </div>\
                 </div>';

    div.innerHTML = div.innerHTML + text;
};

// Remove selected drug or adr
function remove_me(id) {
    document.getElementById(id).remove();
}


/**************************************
 *
 * Functions for displaying table
 *
 * *************************************/

// Retrieve data from database and display in table
function get_table_data() {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("table_data").innerHTML = xmlhttp.responseText;

        }
    };
    xmlhttp.open("GET", "get_table.php?drug=" + global_drugIDList+'&adr='+global_adrIDList+'&group_drug='+global_drugGroup+'&group_adr='+global_adrGroup, true);
    xmlhttp.send();
}

/********************************************
 *
 * Functions for displaying heatmap chart
 *
 * ******************************************/

// Show heatmap
function show_heatmap(source) {
    var data = {
        "drug": global_drugIDList,
        "adr": global_adrIDList,
        'drug_group':global_drugGroup,
        'adr_group':global_adrGroup,
        'source':source
    };

    $.ajax({
        type:"POST",
        url:"ajax/HeatmapData.php",
        data:data,
        success:function(result){
            heatmapChart(result);
            $('#img').hide();

        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
}


/********************************************
 *
 * Functions for displaying timeline chart
 *
 * ******************************************/

// Retrieve timeline data for different drug and adr combinations
function get_timeline_data(adr,selected_drugname,selected_adrname){
    var data = {
        "drug": global_drugIDList,
        "adr": adr,
        "group_drug":global_drugGroup,
        "group_adr":global_adrGroup,
        "adrnames":selected_adrname,
        "drugnames":selected_drugname
    };
    $.ajax({
        type: "POST",
        url: "get_timeline.php",
        data: data,
        success: function (result) {
            var timelinedata = result;
            //show_linechart(timelinedata.slice(),selected_drugname,selected_adrname);
            console.log("hi");
            show_linechart_by_year(timelinedata.slice(),selected_drugname,selected_adrname);
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
}


// Retrieve timeline data for one drug and adr pair
function get_timeline_data_pair(pairs,selected_drugname,selected_adrname){
    //console.log(selected_adrname);
    var data = {
        "pairs": pairs,
        "group_drug":global_drugGroup,
        "group_adr":global_adrGroup,
        "adrnames":selected_adrname,
        "drugnames":selected_drugname,
        "analysis":global_analysis,
    };

    $.ajax({
        type: "POST",
        url: "get_timeline_pairs.php",
        data: data,
        success: function (result) {
            global_timeline_data = result;
            //console.log(result);
            if(global_analysis!="case_count"){
                global_month_or_year=="year"
                show_linechart_by_year(global_timeline_data,false);
                document.getElementById("monthOrYear").style.display="none";
            }
            else{
                if(global_month_or_year=="month"){
                    show_linechart(global_timeline_data,true);
                }
                else if(global_month_or_year=="quarter"){
                    show_linechart_by_quarter(global_timeline_data,true);
                }
                else{
                    show_linechart_by_year(global_timeline_data,true);
                }
            }

        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });


}

// Update drugID and adrID
function update_id(drug,adr,drugname,adrname){
    if(selected_drugID.length==0){
        selected_drugID=drug;
    }
    else{
        selected_drugID = selected_drugID+','+drug;
    }
    selected_drugname[drug] = drugname;
    if(selected_adrID.length==0){
        selected_adrID=adr;
    }
    else{
        selected_adrID = selected_adrID+','+adr;
    }
    selected_adrname[adr] = adrname;
    get_timeline_data(selected_drugID,selected_adrID,global_drugGroup,global_adrGroup,selected_drugname,selected_adrname);
}


// Check if a drug-adr pair is already on the timeline chart
function check_if_exists(pairs, pair) {

    for (var i=0, l=pairs.length; i<l; i++) {
        if (pairs[i][0] == pair[0] && pairs[i][1] === pair[1]) {
            return true;
        }
    }
    return false;
}

// Update a pair of drugID and adrID
function update_id_pair(drug,adr,drugname,adrname){
    if(!check_if_exists(selected_pairs,[drug,adr])){
        selected_pairs.push([drug,adr]);
    }
    selected_drugname[drug] = drugname;
    selected_adrname[adr] = adrname;

    get_timeline_data_pair(selected_pairs,selected_drugname,selected_adrname);

}


//switch month or year linechart
function switch_year_or_month(a){
    global_month_or_year = a;
    if(global_month_or_year=="month"){
        show_linechart(global_timeline_data,selected_drugname,selected_adrname);
    }
    else if(global_month_or_year=="quarter"){
        show_linechart_by_quarter(global_timeline_data,selected_drugname,selected_adrname);
    }
    else{
        show_linechart_by_year(global_timeline_data,selected_drugname,selected_adrname);
    }
}

$(document).ready(function() {
    $(".monthOrYearBtn").first().button("toggle");
});