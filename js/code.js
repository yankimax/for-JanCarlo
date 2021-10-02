var selectedTile, selectedNode, actions = [];
$(document).ready(function(){});

function selectTile(selectedTileCurrent){
    $(selectedTile).css({border: ""});
    selectedTile = selectedTileCurrent;
    $(selectedTile).css({border: "1px solid red"});
    draw();
}

function selectNode(selectedNodeCurrent){
    $(selectedNode).css({border: ""});
    selectedNode = selectedNodeCurrent;
    $(selectedNode).css({border: "1px solid red"});
    draw();
}

function draw(){
    if(selectedTile !== undefined && selectedNode !== undefined){
        $(selectedNode).html($("<img>", {src: $(selectedTile).attr("src")}));
        genMap();
    }
    elementSettings($(selectedNode).attr("id"));
}
function unSelect(){
    $(selectedTile).css({border: ""});
    $(selectedNode).css({border: ""});
    selectedTile = undefined;
    selectedNode = undefined;
    $(".elementSettings div").hide();
}
function elementSettings(id){
    if(id in actions){
        $("input[name='moving[up]'][value='"+actions[id]["moving"]["up"]+"']").prop('checked', true);
        $("input[name='moving[down]'][value='"+actions[id]["moving"]["down"]+"']").prop('checked', true);
        $("input[name='moving[left]'][value='"+actions[id]["moving"]["left"]+"']").prop('checked', true);
        $("input[name='moving[right]'][value='"+actions[id]["moving"]["right"]+"']").prop('checked', true);
    }else{
        $("input[name='moving[up]'][value='T']").prop('checked', true);
        $("input[name='moving[down]'][value='T']").prop('checked', true);
        $("input[name='moving[left]'][value='T']").prop('checked', true);
        $("input[name='moving[right]'][value='T']").prop('checked', true);
    }
    $(".elementSettings div").show();
}
$.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
function saveSettings(){
    var id = parseInt($(selectedNode).attr("id"));
    
    actions[id] = {
        ["moving"]: {
            "up":     $("input[name='moving[up]']:checked").val(),
            "down":   $("input[name='moving[down]']:checked").val(),
            "left":   $("input[name='moving[left]']:checked").val(),
            "right":  $("input[name='moving[right]']:checked").val()
        },
        ["event"]: {
            "type":  $("select[name='event[type]']").val(),
            "value":  $("input[name='event[value]']").val(),
            "chance":  $("input[name='event[chance]']").val(),
        }
    };
    genMap();
}

$(".collapse.dirname > span").on("click", function(){
    $(this).siblings("div.elements").toggle();
});
    
function addTd(side){
    var lastId = parseInt($("input[name='lastid']").val());
    $("table#tileset tbody >tr").each(function(index){
        if(side == 1){
            $(this).append($("<td>",{onclick: "selectNode(this);",id: ++lastId}));
        }else{
            $(this).prepend($("<td>",{onclick: "selectNode(this);",id: ++lastId}));
        }
    });
    $("input[name='lastid']").val(lastId);
}
function addTr(side){
    var tr = $("<tr>");
    var lastId = parseInt($("input[name='lastid']").val());
    var count = $("table#tileset tbody").find("tr:first td").length;
    for(var i=0; i<count; i++){
        tr.append($("<td>",{onclick: "selectNode(this);",id: ++lastId}));
    };
    if(side == 1){
        $("table#tileset tbody").append(tr);
    }else{
        $("table#tileset tbody").prepend(tr);
    }
    $("input[name='lastid']").val(lastId);
}
function genMap(){
    var data = [];
    $("table#tileset tbody >tr").each(function(index){
        var td = [];
        $("td",this ).each(function(tr){
            var element = {"sprite": $("img",this).attr("src")},
            id = parseInt($(this).attr("id"));
            if(id in actions){
                element["event"] = actions[id]["event"];
                element["moving"] = actions[id]["moving"];
            }

            td.push(element);
        });
        data.push(td);

    });
    console.log(JSON.stringify(data));
    $(".settings").html(JSON.stringify(data));
}