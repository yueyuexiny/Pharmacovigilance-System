/**
 * Created by xchen2 on 8/9/16.
 */

function show_source_button(){
    var text = '<div class="btn-group" role="group" id="source_btn"  data-toggle="buttons"> ';
    var selected = '';
    for(var i=0;i<global_source.length;i++){
        if(i==0){
            selected = 'active';
        }
        else{
            selected = '';
        }
        text += '<label class="sourceBtn btn btn-default ' +selected+'" onclick="switch_table_by_source(\'' + global_source[i]+'\')" ><input type="radio" name="" id="">'+global_source[i]+'</label>';
    }
    text += '</div>';
    var div = document.getElementById("select_btn_div");
    div.innerHTML = text;
}


function switch_table_by_source(source){
    get_table_data(source);
}


/**************************************
 *
 * Functions for displaying table
 *
 * *************************************/

// Retrieve data from database and display in table
function get_table_data(source) {
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
    xmlhttp.open("GET", "ajax/get_table.php?drug=" + global_drugIDList+'&adr='+global_adrIDList+'&group_drug='+global_drugGroup+'&group_adr='+global_adrGroup+'&analysis='+global_analysis+'&source='+source, true);
    xmlhttp.send();
}

