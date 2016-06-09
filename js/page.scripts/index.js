var groupNum_drug = [1]; // track id of existing input group
var groupNum_adr = [1]; // track id of existing input group

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
function get_source_analysis(){
    var x = document.getElementById("source");
    var y = document.getElementById("analysis");
    var result = [x.value,y.value];
    return result;
}

function showResult(str,type) {
    var searchboxid = "livesearch";
    var group = document.querySelector('input[name="Drug"]:checked').value;
    if(type=="adr"){
        searchboxid = "livesearch_adr";
        group = document.querySelector('input[name="ADR"]:checked').value;
    }
    var result = get_source_analysis();
    var source = result[0];
    var analysis = result[1];
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

function remove_me(id) {
    document.getElementById(id).remove();
}
var global_drugID = "";
var global_adrID = "";
var global_adrname = {};
var global_drugname = {};
function pass_value(){
    var x = get_source_analysis();

    var drugID=document.querySelectorAll(".drugid");

    var drug="";
    for (i = 0; i < drugID.length; i++) {
        drug += drugID[i].innerHTML + ",";
        $( "#drugList" ).append('<div><label for="name"></label></div>');
    }

    drug=drug.slice(0,-1);
    var adrID=document.querySelectorAll(".adrid");
    var adr="";
    for (i = 0; i < adrID.length; i++) {
        adr += adrID[i].innerHTML + ",";
    }
    adr=adr.slice(0,-1);
    var group_drug = document.querySelector('input[name="Drug"]:checked').value;
    var group_adr = document.querySelector('input[name="ADR"]:checked').value;

    global_drugID = "";
    global_adrID = "";
    global_adrname = {};
    global_drugname = {};
    // Display Heatmap

    $('#img').show();
    get_heatmap_data(drug,adr,group_drug,group_adr);


    // Display data in table
    get_table_data(drug,adr,group_drug,group_adr);


    //Display timeline data line chart
    //get_timeline_data(drug,adr,group_drug,group_adr)
}


function get_table_data(drug,adr,group_drug,group_adr) {
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
    }
    xmlhttp.open("GET", "get_table.php?drug=" + drug+'&adr='+adr+'&group_drug='+group_drug+'&group_adr='+group_adr, true);
    xmlhttp.send();
}


function get_heatmap_data(drug,adr,group_drug,group_adr) {
    var data = {
        "drug": drug,
        "adr": adr,
        'drug_group':group_drug,
        'adr_group':group_adr
    }


    $.ajax({

        type:"POST",
        url:"HeatmapData.php",
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
function get_timeline_data(drug,adr,group_drug,group_adr,global_drugname,global_adrname){


    var data = {
        "drug": drug,
        "adr": adr,
        "group_drug":group_drug,
        "group_adr":group_adr,
        "adrnames":global_adrname,
        "drugnames":global_drugname
    };
    $.ajax({
        type: "POST",
        url: "get_timeline.php",
        data: data,
        success: function (result) {

            var timelinedata = result;
            //console.log(result);
            show_linechart(timelinedata.slice(),global_drugname,global_adrname);


            

        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });


}

function update_id(drug,adr,drugname,adrname,group_drug,group_adr){
    if(global_drugID.length==0){
        global_drugID=drug;

    }
    else{
        global_drugID = global_drugID+','+drug;
    }
    global_drugname[drug] = drugname;
    if(global_adrID.length==0){
        global_adrID=adr;
    }
    else{
        global_adrID = global_adrID+','+adr;
    }
    global_adrname[adr] = adrname;
    get_timeline_data(global_drugID,global_adrID,group_drug,group_adr,global_drugname,global_adrname);

}



