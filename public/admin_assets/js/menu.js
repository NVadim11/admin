$(document).ready(function () {
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
                    return '/admin/menus/tree';
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
        "plugins": [ "dnd", "state", "types"],
//        "plugins": ["contextmenu", "dnd", "state", "types"],
//        contextmenu: {items: customMenu}
    });

    $("#httre").on("load_node.jstree", function (e, data) {
        initBtns();
    });
    $("#httre").on("open_node.jstree", function (e, data) {
        initBtns();
    });
    $("#httre").on("redraw.jstree", function (e, data) {
        initBtns();
    });
    $("#httre").on("refresh.jstree", function (e, data) {
        initBtns();
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
        var id = $(this).data('id');
        
        swal(alertOptions,
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.post('/admin/menus/delnode',
                                {id: id},
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

/**
 * right click menu
 * @param {type} node
 * @returns {customMenu.items}
 */
function customMenu(node) {
    // The default set of all items
    var items = {
        renameItem: {// The "rename" menu item
            label: "Добавить подраздел",
            action: function () {
                document.location = '/admin/menus/addnode/' + node.li_attr.nodeid;
            }
        },
        editItem: {// The "rename" menu item
            label: "Редактировать",
            action: function () {
                document.location = '/admin/?mod=htdocs&act=editnode&id=' + node.li_attr.nodeid;
            }
        },
        docItem: {// The "rename" menu item
            label: "Документы",
            action: function () {
                document.location = '/admin/?mod=htdocs&act=docs&id=' + node.li_attr.nodeid;
            }
        },
        deleteItem: {// The "delete" menu item
            label: "Удалить",
            action: function (data) {
                var inst = $.jstree.reference(data.reference),
                        obj = inst.get_node(data.reference);

                swal(alertOptions,
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.post('/admin/menus/delnode',
                                        {id: node.li_attr.nodeid},
                                function (data) {
                                    if (data.sux === 0)
                                    {
                                        swal("Oops...", data.msg, "error");
                                    }
                                    else
                                    {
                                        if (inst.is_selected(obj)) {
                                            inst.delete_node(inst.get_selected());
                                        }
                                        else {
                                            inst.delete_node(obj);
                                        }
                                    }
                                },
                                        'json');
                            }
                        });
            }
        }
    };

    if ($(node).hasClass("folder")) {
        // Delete the "delete" menu item
        delete items.deleteItem;
    }

    return items;
}

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

function initBtns()
{
    var $nodes = $("#httre li a.jstree-anchor").not('.hasaction');
    $nodes.each(function () {
        var id = parseInt($(this).parent('li').attr('nodeid'));
        $(setButtons(id)).insertBefore(this);
        $(this).addClass('hasaction');
    });
}

function setButtons(id)
{
    var str = '<div class="htreebnts">';
    str += '<a class="btn btn-xs green" href="/admin/menus/addnode/'+id+'" title="Добавить подраздел"><i class="fa fa-plus"></i></a>';
    str += '<a class="btn btn-xs blue" href="/admin/menus/editnode/'+id+'" title="Редактировать"><i class="fa fa-pencil"></i></a>';
    str += '<a class="btn btn-xs red htdell" href="#" data-id="'+id+'" title="Удалить"><i class="fa fa-trash-o"></i></a>';
    str += '</div>';

    return str;
}