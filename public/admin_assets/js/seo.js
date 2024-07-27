var SeoModals = function () {

    return {
        //main function to initiate the module
        init: function () {

            $('.seo-edit').on('click', function () {
                $('#seo-ajax-modal').remove();
                // create the backdrop and wait for next modal to be triggered
                $.post('/admin/?mod=seo&act=getmodal', {id: $(this).data('id')}, function (data) {
                    if (data.sux == 1)
                    {
                        $('body').append(data.html);
                        $('#seo-ajax-modal').modal();
                    }
                    else
                    {
                        swal(data.msg, '', "error");
                    }
                }, 'json');

                return false;
            });
            
            $(document).on('click', '#seo-ajax-modal .seo-save', function(){
                var datas = new Object();
                $('#seo-ajax-modal .form-control').each(function(){
                    datas[$(this).attr('name')] = $(this).val();
                });
                
                datas['id'] = $(this).data('id');
                
                $.post('/admin/?mod=seo&act=saveseo', {data:datas}, function(data){
                    $('#seo-ajax-modal').modal('hide');
                    if(data.sux == 1)
                    {
                        swal(data.msg, '', "success");
                        var $table = $('.seorow'+datas['id']+' td');
                        $table.eq(1).text(datas['title']);
                        $table.eq(2).text(datas['description']);
                        $table.eq(3).text(datas['keywords']);
                    }
                    else
                    {
                        swal(data.msg, '', "error");
                    }
                }, 'json');
            });
        }

    };

}();

$(document).ready(function () {
    SeoModals.init();
});