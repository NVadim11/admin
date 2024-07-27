$(document).ready(function () {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
    var base_url = $("#httre").data('url');
    var $httree = $("#httre").jstree({
        "core": {
            "themes": {
                "responsive": false
            },
            // so that create works
            "check_callback": function (operation, node, node_parent, node_position, more) {

                if (operation == 'move_node' && more.core === true)
                {
                    updateNodePos(node_position, node.li_attr.nodeid, node_parent.li_attr.nodeid);
                }
            },
            'data': {
                'url': function (node) {
                    return base_url+'/list';
                }
            }
        },
        "types": {
            "default": {
                "icon": "fa fa-folder icon-state-warning icon-lg"
            },
            "file": {
                "icon": "fa fa-file icon-state-warning icon-lg"
            }
        },
        "state": {"key": "demo2"},
        "plugins": [ "state", "types"],
//        "plugins": ["contextmenu", "dnd", "state", "types"],
//        contextmenu: {items: customMenu}
    });

    $("#httre").on("load_node.jstree", function (e, data) {
        initBtns(base_url);
    });
    $("#httre").on("open_node.jstree", function (e, data) {
        initBtns(base_url);
    });
    $("#httre").on("redraw.jstree", function (e, data) {
        initBtns(base_url);
    });
    $("#httre").on("refresh.jstree", function (e, data) {
        initBtns(base_url);
    });

    $(document).on("mouseover", '#httre.jstree-default .jstree-anchor', function () {
        $(this).prev().addClass('hover');
    });

    $(document).on("mouseleave", '#httre.jstree-default .jstree-anchor', function () {
        $(this).prev().removeClass('hover');
    });

    $(document).on("mouseover", '#httre .htreebnts', function () {
        $(this).next().addClass('jstree-hovered');
        $(this).addClass('hover');
    });

    $(document).on("mouseleave", '#httre .htreebnts', function () {
        $(this).next().removeClass('jstree-hovered');
        $(this).removeClass('hover');
    });

    $(document).on("click", '#httre .htreebnts .htdell', function () {
        var $node = $(this).parents('li').eq(0);
        var url = $(this).data('url');

        swal(alertOptions,
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.post(url,{'_method': 'DELETE'},
                        function (data) {
                            if (data.sux === 0)
                            {
                                swal("Oops...", data.msg, "error");
                            }
                            else
                            {
                                var inst = $.jstree.reference($node);
                                inst.delete_node($node);
                                inst.trigger('refresh');
                            }
                        },
                                'json');
                    }
                });
        return false;
    });

});


function updateNodePos(pos, nodeid, parentid)
{
    var datas = new Object();
    datas['pos'] = pos;
    datas['nodeid'] = nodeid;
    datas['parentid'] = parentid;
    $.post('/admin/?mod=htdocs&act=movenode',
            {data: datas},
    function (data) {
        if (data.sux === 0)
        {
            swal("Oops...", "Ошибка при изменении положения", "error");
        }
    },
            'json');
}

var alertOptions = {
    title: "Вы уверены что хотите удалить элемент?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Да, удалить",
    cancelButtonText: "Нет, отмена"
};

function initBtns(base_url)
{
    var $nodes = $("#httre li a.jstree-anchor").not('.hasaction');
    $nodes.each(function () {
        var id = parseInt($(this).parent('li').attr('nodeid'));
        $(setButtons(base_url, id)).insertBefore(this);
        $(this).addClass('hasaction');
    });
}

function setButtons(base_url, id)
{
    var str = '<div class="htreebnts">';
    str += '<a class="btn btn-xs green" href="'+base_url+'/create/'+id+'" title="Добавить подраздел"><i class="fa fa-plus"></i></a>';
    str += '<a class="btn btn-xs blue" href="'+base_url+'/'+id+'/edit" title="Редактировать"><i class="fa fa-pencil"></i></a>';
    str += '<a class="btn btn-xs red htdell" href="#" data-url="'+base_url+'/'+id+'/delete" title="Удалить"><i class="fa fa-trash-o"></i></a>';
    str += '</div>';

    return str;
}