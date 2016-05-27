var groupNum_drug = [1]; // track id of existing input group
var groupNum_adr = [1]; // track id of existing input group

function get_source_analysis(){
    var x = document.getElementById("source");
    var y = document.getElementById("analysis");
    var result = [x.value,y.value];
    return result;
}

function showResult(str,type) {
    var searchboxid = "livesearch";

    if(type=="adr"){
        searchboxid = "livesearch_adr";
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
    xmlhttp.open("GET", "livesearch.php?q=" + str + '&type='+type+'&source='+source+'&analysis='+analysis, true);
    xmlhttp.send();


}

function select_drug(str,id) {

    var next = groupNum_drug[groupNum_drug.length - 1] + 1;
    groupNum_drug.push(next);

    document.getElementById("searchbox").value = "";
    var x = document.getElementById("livesearch").style.display = "none";
    var div = document.getElementById('searchresult');

    /*var text = ' <div class="row rowstyle" id="moredrug' + next + '">\
                   <div class="input-group input-group-lg ">\
                     <span class="input-group-addon drug">' + str + '</span>\
                     <button type="button" class="btn btn-danger" onclick="remove_me(\'moredrug' + next + '\')">-</button>\
                   </div>\
                </div>';*/
    var text = ' <div class="row rowstyle" id="moredrug' + next + '">\
                   <div class="input-group input-group-lg ">\
                     <span class="input-group-addon drug">' + str + '<span class="drugid" style="display:none">'+id+'</span></span>\
                     <button type="button" class="btn btn-danger" onclick="remove_me(\'moredrug' + next + '\')">-</button>\
                   </div>\
                </div>';
    //alert(text);
    div.innerHTML = div.innerHTML + text;

};


function select_adr(str,id) {

    var next = groupNum_adr[groupNum_adr.length - 1] + 1;
    groupNum_adr.push(next);

    document.getElementById("searchbox_adr").value="";
    var x = document.getElementById("livesearch_adr").style.display = "none";
    var div = document.getElementById('searchresult_adr');

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

function pass_value(){
    var x = get_source_analysis();

    //document.getElementById("result_source").innerHTML=x[0]+' '+x[1];
    var drug=document.querySelectorAll(".drugid");

    var text="drug:"
    for (i = 0; i < drug.length; i++) {
        text += drug[i].innerHTML + "<br>";
    }
    //document.getElementById("result").innerHTML=text;

    var text="ADR:"
    var adr=document.querySelectorAll(".adrid");
    for (i = 0; i < adr.length; i++) {
        text += adr[i].innerHTML + "<br>";
    }
    //document.getElementById("result_adr").innerHTML=text;

}
