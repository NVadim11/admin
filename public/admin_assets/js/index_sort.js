$("document").ready(function () {
    $(".container .item").hover(function () {
            var item = $(this).parent().find(".item").attr("id");
            $(this).parent().find(".item span").hide();
            $(this).parent().find(".item input").fadeIn(270);
        }, function () {
            if ($(".item input").css("border") == "solid 2px #b2f47d") {
            } else {
                $(this).parent().find(".item input").hide();
                $(this).parent().find(".item span").fadeIn(200);
            }
        }
    );
    $(".item input").click(function () {
        $(this).css("border", "solid 2px #b2f47d");
        $(this).val("");
        return false;
    });
    $(".item input").keypress(function (e) {
        if (e.which == 13) {
            newpos(this, 0);
        }
    });
    $(".table tbody").sortable({
        helper: fixHelper, opacity: 0.8, update: function (event, ui) {

            if (ui.position.top > ui.originalPosition.top)
                newpos(ui.item.find('.inp'), 2);
            else
                newpos(ui.item.find('.inp'), 1);
        }
    });

});
var fixHelper = function (e, ui) {
    ui.children().each(function () {
        $(this).width($(this).width());
    });
    return ui;
};

function newpos(obj, act) {
    if (act == 0) {
        var new_pos = parseInt($(obj).val());
    }
    if (act == 1 || act == 2) {
        if (act == 1)
            var pred = parseInt($(obj).parent().parent().nextAll('tr:first').find('.inp').val());
        else
            var pred = parseInt($(obj).parent().parent().prevAll('tr:first').find('.inp').val());

        if (pred || pred == 0) {
            new_pos = pred;
        }
        else {
            new_pos = 0;
        }

    }
    var id = $(obj).attr("id"),
        table = $(obj).attr("rel"),
        cat = $(obj).attr("cat"),
        cat_val = $(obj).attr("cat_val"),
        old = $(obj).attr('value');
    $.ajax({
        type: "POST",
        url: "/admin/index_sort",
        data: "id=" + id + "&&" + "new=" + new_pos + "&&old=" + old + "&&table=" + table + "&cat=" + cat + '&cat_val=' + cat_val,
        headers: {
            "X-CSRF-Token": $("meta[name='csrf-token']").attr("content")
        },
        success: function (data) {
            {
                location.reload();
            }
        }
    });
    return false;
}
