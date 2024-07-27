/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.scayt_autoStartup = false;
    config.startupFocus = false;
    config.skin = 'bootstrapck';
    config.allowedContent = true;
    config.extraAllowedContent = 'span';
    config.toolbarGroups = [
            { name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
            { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
            { name: 'links' },
            '/',
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align'] },
            { name: 'insert' },
            '/',
            { name: 'styles' },
            { name: 'colors' },
            { name: 'tools' },
            { name: 'others'}
    ];
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        config.filebrowserBrowseUrl = '/admin_assets/global/plugins/ckeditor/plugins/kcfinder/browse.php?opener=ckeditor&type=files';
        config.filebrowserImageBrowseUrl = '/admin_assets/global/plugins/ckeditor/plugins/kcfinder/browse.php?opener=ckeditor&type=images';
        config.filebrowserFlashBrowseUrl = '/admin_assets/global/plugins/ckeditor/plugins/kcfinder/browse.php?opener=ckeditor&type=flash';
        config.filebrowserUploadUrl = '/admin_assets/global/plugins/ckeditor/plugins/kcfinder/upload.php?opener=ckeditor&type=files';
        config.filebrowserImageUploadUrl = '/admin_assets/global/plugins/ckeditor/plugins/kcfinder/upload.php?opener=ckeditor&type=images';
        config.filebrowserFlashUploadUrl = '/admin_assets/global/plugins/ckeditor/plugins/kcfinder/upload.php?opener=ckeditor&type=flash'

//        config.contentsCss = ['/css/style.css', '/css/editor.css'];
};
