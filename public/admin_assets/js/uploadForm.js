function createUploader(){  
    
    var $up_el = $('#file-uploader');
    var link = $up_el.data('link');
    var table = $up_el.data('table');
    var item_id = $up_el.data('item_id');
    var backFunction = $up_el.data('back');
    var initFunction = $up_el.data('init');

    // var uploader2 = new qq.FileUploader({
    //     element: document.getElementById('file-uploader'),
    //     action: '/admin/images/upload/',
    //     params: {id:item_id, table:table ,link:link},
    //     allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
    //     sizeLimit: 0, // max size
    //     minSizeLimit: 0, // min size
    //     onComplete: function(id, fileName, responseJSON){
    //         if (responseJSON.success) {
    //             var imgUrl = '/getimg.php?w=150&h=150&path=';
    //             $('#franchise-photo').append('<div class="gal_img" style="text-align: center; height: 175px" id="'+responseJSON.id+'">'
    //                 +' <a href="#" style="display: block">'
    //                 +'<img  src="'+imgUrl+responseJSON.filename+'">'
    //                 +'</a><a class="del_fr_foto" href="#" link="'+link+'" rel="'+responseJSON.img+'" cat="'+responseJSON.link+'" tbl="'+table+'"></a>'
    //                 +'<a class="lightbox" rel="group"  href="/upload/images/'+responseJSON.filename+'" style="font-size: 10px">Увеличить</a>'
    //                 +'<br></div>');
    //             $("a.lightbox").fancybox();
    //         }
    //     },
    //     debug: false
    // });

    var galleryUploader = new qq.FineUploader({
        element: document.getElementById("file-uploader"),
        template: 'qq-template-gallery',
        request: {
            endpoint: '/admin/images/upload',
            params: {
                id: item_id,
                table: table,
                link: link
            },
            customHeaders: {
                "X-CSRF-Token": $("meta[name='csrf-token']").attr("content")
            }
        },
        callbacks:{
            onComplete: window[backFunction],
            onSessionRequestComplete: window[initFunction]
        },
        session: {
            endpoint: '/admin/images/files_list',
            params: {
                id: item_id,
                table: table,
                link: link
            },
            customHeaders: {
                "X-CSRF-Token": $("meta[name='csrf-token']").attr("content")
            }
        },
        deleteFile: {
            enabled: false
            // endpoint: '/admin/images/destroy',
            // params: {
            //     table: table,
            // },
            // customHeaders: {
            //     "X-CSRF-Token": $("meta[name='csrf-token']").attr("content")
            // }
        },
        thumbnails: {
            placeholders: {
                waitingPath: '/admin/js/fine-uploader/placeholders/waiting-generic.png',
                notAvailablePath: '/admin/js/fine-uploader/placeholders/not_available-generic.png'
            },
            timeBetweenThumbs: 0
        },
        validation: {
            allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
        },
    });

};

function default_gallery_response(id, name, response) {
    if (response.success) {
        var $el = $('.qq-file-id-'+id)
        $el.find('.js-delete-gallery-image').data(response.uuid);
    }else{
        alert('Ошибка при загрузке');
    }
}

function default_gallery_init(response) {
    $.each(response, function (num, obj) {
        var $el = $('.qq-file-id-'+num);
        $el.find('.js-delete-gallery-image').data('id', obj.uuid);
    });
}

$(document).ready(function () {
    createUploader();
    
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
    
    $('.del_fr_foto').live('click',function(){
        var img = $(this).attr('rel'),
        tbl = $(this).attr('tbl'),

        obj = $(this);
        $.post('/admin/images/delete/'+img, {tbl:tbl}, function(data){
            if(data == 1)
            {
                $(obj).parent().remove();
            }
            else
                alert('Ошибка доступа');
        })
        return false;
    });

    $(document).on('click', '.js-delete-gallery-image', function(e){
        e.preventDefault();
        var $element = $(this).parents('li').first();
        var table = $('#file-uploader').data('table');

        $.ajax({
            url : "/admin/images/destroy",
            type: "DELETE",
            data : {id:$(this).data('id'), table:table},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response, textStatus, jqXHR){
                if(response.result == true){
                    $element.remove();
                }else{
                    alert('Ошибка при удалении');
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('Ошибка при удалении')
            }
        });
    });
});