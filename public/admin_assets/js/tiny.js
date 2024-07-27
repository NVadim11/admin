window.onload = function(){
    $(".preloader").hide();
}
jQuery(document).ready(function() {
    var $lang = jQuery("html").attr('lang');
    tinymce.init({
        selector: 'textarea.ckeditor',
        plugins: 'autoresize preview importcss searchreplace autolink save directionality code visualblocks visualchars image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
        imagetools_cors_hosts: ['picsum.photos'],
        valid_elements : '*[*]',
        custom_elements:"style,link,~link",
        branding: false,
        menubar: true,
        // menubar: 'file edit view insert format tools table help',
        toolbar: 'code | undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | numlist bullist | forecolor backcolor removeformat | charmap | preview save | link image media | template anchor codesample | ltr rtl | outdent indent',
        toolbar_sticky: true,
        image_advtab: true,
        link_list: [
            { title: 'My page 1', value: 'https://www.tiny.cloud' },
            { title: 'My page 2', value: 'http://www.moxiecode.com' }
        ],
        image_list: [
            { title: 'My page 1', value: 'https://www.tiny.cloud' },
            { title: 'My page 2', value: 'http://www.moxiecode.com' }
        ],
        image_class_list: [
            { title: 'None', value: '' },
            { title: 'Some class', value: 'class-name' }
        ],
        importcss_append: true,
        height: 400,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image imagetools table',
        // skin: useDarkMode ? 'oxide-dark' : 'oxide',
        // content_css: useDarkMode ? 'dark' : 'default',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        language: $lang,
        content_langs: [
            { title: 'English', code: 'en' },
            { title: 'Russian', code: 'ru' }
        ],
        skin: 'snow'
    });

    tinymce.init({
        selector: 'textarea.mini',
        plugins: 'autoresize preview importcss searchreplace autolink save directionality code visualblocks visualchars image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
        imagetools_cors_hosts: ['picsum.photos'],
        valid_elements : '*[*]',
        custom_elements:"style,link,~link",
        branding: false,
        menubar: false,
        // menubar: 'file edit view insert format tools table help',
        toolbar: 'code | undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | numlist bullist | forecolor backcolor removeformat | charmap | preview save | link image media | template anchor codesample | ltr rtl | outdent indent',
        toolbar_sticky: true,
        image_advtab: true,
        link_list: [
            { title: 'My page 1', value: 'https://www.tiny.cloud' },
            { title: 'My page 2', value: 'http://www.moxiecode.com' }
        ],
        image_list: [
            { title: 'My page 1', value: 'https://www.tiny.cloud' },
            { title: 'My page 2', value: 'http://www.moxiecode.com' }
        ],
        image_class_list: [
            { title: 'None', value: '' },
            { title: 'Some class', value: 'class-name' }
        ],
        importcss_append: true,
        height: 400,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image imagetools table',
        // skin: useDarkMode ? 'oxide-dark' : 'oxide',
        // content_css: useDarkMode ? 'dark' : 'default',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        language: $lang,
        content_langs: [
            { title: 'English', code: 'en' },
            { title: 'Russian', code: 'ru' }
        ],
        skin: 'snow'
    });
});
document.addEventListener('focusin', (e) => {
    if (e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
        e.stopImmediatePropagation();
    }
});