/**
 * plugin.js
 *
 * Copyright, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/*global tinymce:true */

tinymce.PluginManager.add('variable', function(editor) {
    // Add a button that opens a window
    editor.addButton('variable', {
        text: '{x}',
        title: 'Supported variables',
        icon: false,
        onclick: function() {
            // Open window
            editor.windowManager.open({
                title: 'Email Variables',
				url: 'admin/mail_templates/variables',
				width: 700,
				height: 550,
                //body: [
                //    {type: 'textbox', name: 'title', label: 'Title'}
                //],
                onsubmit: function(e) {
                    // Insert content when the window form is submitted
                    editor.insertContent('Title: ' + e.data.title);
                }
            });
        }
    });
});