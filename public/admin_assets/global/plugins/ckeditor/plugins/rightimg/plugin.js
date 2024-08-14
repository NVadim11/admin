CKEDITOR.plugins.add( 'rightimg', {
    requires: 'widget',

    icons: 'rightimg',

    init: function( editor ) {
        editor.widgets.add( 'rightimg', {
            button: 'Картинка справа',
            pathName: 'custom',
            template:
            '<div class="image right"><img src="/images/pic_1.jpg" width="242" alt="">'
              +'<div class="name">Описание картинки</div>'
            +'</div>',
            editables: {
                content: {
                    selector: '.image'
                }
            },
            requiredContent: 'div(image)',

            upcast: function( element ) {
                return element.name == 'div' && element.hasClass( 'image' );
            }
        } );
    }
} );


