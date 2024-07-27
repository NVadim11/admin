function createUploader(){

    var $up_el = $('#file-uploader');
    var link = $up_el.data('link');
    var table = $up_el.data('table');
    var item_id = $up_el.data('item_id');

    var uploader2 = new qq.FileUploader({
        element: document.getElementById('file-uploader'),
        action: '/admin/images/upload',
        params: {id:item_id, table:table ,link:link},
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        sizeLimit: 0, // max size   
        minSizeLimit: 0, // min size
        onComplete: function(id, fileName, responseJSON){
            if (responseJSON.success) {
                var str = '<tr>\
                        <td>\
                            <a href="/upload/images/' + responseJSON.filename + '" class="fancybox-button" data-rel="fancybox-button">\
                            <img class="img-responsive" src="/upload/images/' + responseJSON.filename + '" alt="">\
                            </a>\
                        </td>\
                        <td>\
                            <input class="form-control" name="images[' + responseJSON.id + '][link]" value="" type="text">\
                        </td>\
                        <td>\
                            <a href="javascript:;" class="btn default btn-sm"  link="' + link + '" rel="' + responseJSON.img + '" cat="' + responseJSON.link + '" tbl="' + table + '">\
                            <i class="fa fa-times"></i> Удалить </a>\
                        </td>\
                    </tr>';
                $('#photos tbody').append(str);
                $("a.lightbox").fancybox();
            }
        },
        debug: false
    });
};

$(document).ready(function () {
    if($('#photos').length){
        createUploader();
    }

    var $up_el = $('#file-uploader');
    var table = $up_el.data('table');

    $( "#franchise-photo" ).sortable({
        placeholder: "gal_img",
        update:function(event, ui){
            var sorted = $( "#franchise-photo" ).sortable( "toArray");
            $.post('/admin/images/sort', {ids:sorted, tbl:table}, function(data){
                if(data == 0)
                    alert('Ошибка доступа');
            })
        }
    });
    $( "#franchise-photo" ).disableSelection();

    $('.del_foto').live('click',function(){
        var img = $(this).attr('rel'),
            tbl = $(this).attr('tbl'),

            obj = $(this);
        $.post('/admin/images/destroy/'+img, {tbl:tbl}, function(data){
            if(data == 1)
            {
                $(obj).parents('tr').first().remove();
            }
            else
                alert('Ошибка доступа');
        })
        return false;
    });
});