CKEDITOR.plugins.add( 'stylelist', {
    requires: 'widget',

    icons: 'stylelist',

    init: function( editor ) {
        editor.widgets.add( 'stylelist', {
            button: 'Стилизованный список',
            template:
            '<div class="custlist"><ul class="text_list">'
              +'<li>Первый</li>'
              +'<li>Второй</li>'
              +'<li>Третий</li>'
            +'</ul></div>',
            editables: {
                content: {
                    selector: '.custlist'
                }
            },
            requiredContent: 'div(custlist)',

            upcast: function( element ) {
                return element.name == 'div' && element.hasClass( 'custlist' );
            }
        } );
    }
} );


