var rowCount = 0;

$(document).ready(function () {

    /*** Add/remove criteria ***/
    var groupNum = [1]; // track id of existing input group
    var groupNum_drug = [1]; // track id of existing input group
    var groupNum_adr = [1]; // track id of existing input group

    $(".add-more").click(function (e) {
        e.preventDefault();

        var addto = "#group" + groupNum[groupNum.length - 1];
        var addRemove = "#group" + groupNum[groupNum.length - 1];
        var next = groupNum[groupNum.length - 1] + 1;
        groupNum.push(next);

        var newOp = '<button type="button" class="btn btn-default dropdown-toggle inner' + next + ' opul' + next + '" id="op' + next + '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">AND <span class="caret"></span></button> ' +
                    '<ul class="dropdown-menu inner' + next + ' opul' + next + '"> <li><a href="#">AND</a></li><li><a href="#">OR</a></li><li><a href="#">NOT</a></li> </ul>';
        var newOper = $(newOp);
        var newDrop = '<button type="button" class="btn btn-default dropdown-toggle inner' + next + ' fieldul' + next + '" id="drop' + next + '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Search Fields <span class="caret"></span> </button> ' +
                    '<ul class="dropdown-menu inner' + next + ' fieldul' + next + '"> <li><a href="#">All Search Fields</a></li> <li><a href="#">Title</a></li> <li><a href="#">Author</a></li> <li><a href="#">Description</a></li></ul>';
        var newDropDown = $(newDrop);
        var newIn = '<input autocomplete="off" class="input inner' + next + '" id="field' + next + '" type="text">';
        var newInput = $(newIn);
        var removeBtn = '<button id="remove' + next + '" class="btn btn-danger remove-me inner' + next + '" >-</button>';
        var removeButton = $(removeBtn);
        $(addRemove).after(removeButton);
        $(addto).after(newInput);
        $(addto).after(newDropDown);
        $(addto).after(newOper);

        var div = '<div id="group' + next + '"></div>';
        $(".inner" + next).wrapAll(div);

        var div = '<div class="dropdown"></div>';
        $(".opul" + next).wrapAll(div);
        $(".fieldul" + next).wrapAll(div);

        $("#field" + next).attr('data-source', $(addto).attr('data-source'));


        $('.remove-me').unbind().click(function (e) {
            e.preventDefault();
            var fieldNum = parseInt(this.id.match(/\d+/));
            var groupID = "#group" + fieldNum;
            groupNum.splice(groupNum.indexOf(fieldNum), 1);
            $(groupID).remove();

        });
    });

    /*** dynamically generated dropdown menus show selected text***/
    $(document).on('click', '.dropdown-menu li a', function () {
        var selText = $(this).text() + " ";
        $(this).parents('.dropdown').find('.dropdown-toggle').html(selText + '<span class="caret"></span>');
        $(this).focus();
    });


    $('#btn-search').click(function(){

    });

    $(".add-more-ADR").click(function (e) {
        e.preventDefault();

        var addto = "#group_adr" + groupNum_adr[groupNum_adr.length - 1];
        var addRemove = "#group_adr" + groupNum_adr[groupNum_adr.length - 1];
        var next = groupNum_adr[groupNum_adr.length - 1] + 1;
        groupNum_adr.push(next);

        var newSelect = '<select class="selectpicker inner_adr' + next +'"data-live-search="true" data-width="200px">\
            <option >ADR1</option>\
            <option >ADR2</option>\
            <option >ADR3</option>\
            <option >ADR4</option>\
            </select>';
        var newSelected=$(newSelect);


        var removeBtn = '<button id="remove' + next + '" class="btn btn-danger remove-me-adr inner_adr' + next + '" >-</button>';
        var removeButton = $(removeBtn);
        $(addRemove).after(removeButton);

        $(addto).after(newSelected);


        var div = '<div id="group_adr' + next + '" class="col-xs-6 col-md-offset-4"></div>';
        $(".inner_adr" + next).wrapAll(div);


        $('.remove-me-adr').unbind().click(function (e) {
            e.preventDefault();
            var fieldNum = parseInt(this.id.match(/\d+/));
            var groupID = "#group_adr" + fieldNum;
            groupNum_adr.splice(groupNum_adr.indexOf(fieldNum), 1);
            $(groupID).remove();

        });
    });
    $(".add-more-drug").click(function (e) {
        e.preventDefault();

        var addto = "#group_drug" + groupNum_drug[groupNum_drug.length - 1];
        var addRemove = "#group_drug" + groupNum_drug[groupNum_drug.length - 1];
        var next = groupNum_drug[groupNum_drug.length - 1] + 1;
        groupNum_drug.push(next);

        var newSelect = '<select class="selectpicker inner' + next + ' fieldul' + next + '" id="drop_drug' + next + '"  data-live-search="true" data-width="200px">\
            <option >Abacavir</option>\
            <option >Abagovomab</option>\
            <option >Abarelix</option>\
            <option >Acadesine</option>\
            </select>';
        var newSelected=$(newSelect);

        var removeBtn = '<button id="remove_drug' + next + '" class="btn btn-danger remove-me inner' + next + '" >-</button>';
        var removeButton = $(removeBtn);
        $(addRemove).after(removeButton);
        $(addto).after(newSelected);


        var div = '<div id="group_drug' + next + '" class="col-xs-6 col-md-offset-4"></div>';
        $(".inner" + next).wrapAll(div);


        $('.remove-me').unbind().click(function (e) {
            e.preventDefault();
            var fieldNum = parseInt(this.id.match(/\d+/));
            var groupID = "#group_drug" + fieldNum;
            groupNum_drug.splice(groupNum_drug.indexOf(fieldNum), 1);
            $(groupID).remove();

        });
    });

});





