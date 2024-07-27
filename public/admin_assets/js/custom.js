$(document).ready(function () {
    $('.group-checkable').change(function() {
        var set = $(this).parents('table').eq(0).find('tbody > tr > td:nth-child(1) input[type="checkbox"]');
        var checked = $(this).is(":checked");
        $(set).each(function() {
            $(this).attr("checked", checked);
        });
    });
    
    $('#deleteListItems').click(function(){
        var act = $(this).parent().find('select option:selected').val();
        var mod = $(this).data('mod');
        if(act=='delete' && mod)
        {
            var ids = new Array();
            $('.table-scrollable .table tbody input[type="checkbox"]:checked').each(function(){
                ids.push('id[]='+$(this).val());
            });
            if(ids.length)
            {
                del(ids, mod);
            }
            else
            {
                swal('Ошибка!','Выберете строку', 'warning');
            }
        }
        return false;
    });
    
    // $('.bs-select').selectpicker({
    //     iconBase: 'fa',
    //     tickIcon: 'fa-check'
    // });
    
       
    // var $countdown;
    // $('body').append('<div class="modal fade" id="idle-timeout-dialog" data-backdrop="static"><div class="modal-dialog modal-small"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Время сессии истекает.</h4></div><div class="modal-body"><p><i class="fa fa-warning"></i> Кабинет будет заблокирован через <span id="idle-timeout-counter"></span> секунд.</p><p>Хотите продлить сессию?</p></div><div class="modal-footer"><button id="idle-timeout-dialog-logout" type="button" class="btn btn-default">Нет, заблокировать</button><button id="idle-timeout-dialog-keepalive" type="button" class="btn btn-primary" data-dismiss="modal">Да, продолжить работу</button></div></div></div></div>');
    // $.idleTimeout('#idle-timeout-dialog', '.modal-content button:last', {
    //     idleAfter: 60*10, // 5 seconds
    //     pollingInterval: 60*10, // 5 seconds
    //     AJAXTimeout:3600*10,
    //     onTimeout: function(){
    //         window.location = "/admin/lock.php";
    //     },
    //     onIdle: function(){
    //         $('#idle-timeout-dialog').modal('show');
    //         $countdown = $('#idle-timeout-counter');
    //
    //         $('#idle-timeout-dialog-keepalive').on('click', function () {
    //             $('#idle-timeout-dialog').modal('hide');
    //         });
    //
    //         $('#idle-timeout-dialog-logout').on('click', function () {
    //             $('#idle-timeout-dialog').modal('hide');
    //             $.idleTimeout.options.onTimeout.call(this);
    //         });
    //     },
    //     onCountdown: function(counter){
    //         $countdown.html(counter); // update the counter
    //     }
    // });
       
    $('.multi-select').multiSelect({keepOrder:true});
    $('.spinnumber').spinner();
    $('.timepicker-24').timepicker({
        autoclose: true,
        minuteStep: 5,
        showSeconds: false,
        showMeridian: false
    });
    $('.timepicker').parent('.input-group').on('click', '.input-group-btn', function(e){
        e.preventDefault();
        $(this).parent('.input-group').find('.timepicker').timepicker('showWidget');
    });
    
    if($("a.lightbox").length){
        $("a.lightbox").fancybox();
    }
    
    map_open = false;
    $('a[href="#tab_map"]').on('shown.bs.tab', function (e) {
        if(!map_open){
            initialize();
            map_open = true;
        }
    });
    
    var handleColorPicker = function () {
        if (!jQuery().colorpicker) {
            return;
        }
        $('.colorpicker-default').colorpicker({
            format: 'hex'
        });
    }
    handleColorPicker();

    $('#clean_all_notification').click(function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/admin/notifications/clear",
            headers: {
                "X-CSRF-Token": $("meta[name='csrf-token']").attr("content")
            },
            success: function (data) {
                {
                    location.reload();
                }
            }
        });
    });

    $('#header_notification_bar .dropdown-menu-list a').click(function (e) {
        e.preventDefault();
        var url = $(this).data('url');
        var id = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "/admin/notifications/mark_as_read",
            data: {id: id },
            headers: {
                "X-CSRF-Token": $("meta[name='csrf-token']").attr("content")
            },
            success: function (data) {
                document.location = url;
            }
        });
    });
    
});

function del(id)
{
  swal({
        title: "Вы уверены что хотите удалить элемент из списка?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Да, удалить",
        cancelButtonText: "Нет, отмена"
        },
        function(isConfirm) {
            if (isConfirm) {
                // if(Array.isArray(id))
                // {
                //     document.location = act+'&'+(id.join('&')) ;
                // }
                // else
                // {
                document.getElementById(id).submit();
                // }
            }
        });
}

function custom_del(id, link)
{
  var act = link;  
  swal({
        title: "Вы уверены что хотите удалить элемент из списка?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Да, удалить",
        cancelButtonText: "Нет, отмена"
        },
        function(isConfirm) {
            if (isConfirm) {
                if(Array.isArray(id))
                {
                    document.location = act+'&'+(id.join('&')) ;
                }
                else
                {
                    document.location = act+'&id=' + id ;
                }
            }
        });
}

(function($){
    $.fn.serializeObject = function(){

        var self = this,
            json = {},
            push_counters = {},
            patterns = {
                "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                "key":      /[a-zA-Z0-9_]+|(?=\[\])/g,
                "push":     /^$/,
                "fixed":    /^\d+$/,
                "named":    /^[a-zA-Z0-9_]+$/
            };


        this.build = function(base, key, value){
            base[key] = value;
            return base;
        };

        this.push_counter = function(key){
            if(push_counters[key] === undefined){
                push_counters[key] = 0;
            }
            return push_counters[key]++;
        };

        $.each($(this).serializeArray(), function(){

            // skip invalid keys
            if(!patterns.validate.test(this.name)){
                return;
            }

            var k,
                keys = this.name.match(patterns.key),
                merge = this.value,
                reverse_key = this.name;

            while((k = keys.pop()) !== undefined){

                // adjust reverse_key
                reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                // push
                if(k.match(patterns.push)){
                    merge = self.build([], self.push_counter(reverse_key), merge);
                }

                // fixed
                else if(k.match(patterns.fixed)){
                    merge = self.build([], k, merge);
                }

                // named
                else if(k.match(patterns.named)){
                    merge = self.build({}, k, merge);
                }
            }

            json = $.extend(true, json, merge);
        });

        return json;
    };
})(jQuery);

$(function(){
	var today = new Date();
	$("#datetime").datetimepicker({
		format: 'yyyy-mm-dd hh:ii',
		autoclose: true,
		todayBtn: true
	});
})
