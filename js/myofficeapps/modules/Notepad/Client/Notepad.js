/*

This file is part of Ext JS 4

Copyright (c) 2011 Sencha Inc

Contact:  http://www.sencha.com/contact

GNU General Public License Usage
This file may be used under the terms of the GNU General Public License version 3.0 as published by the Free Software Foundation and appearing in the file LICENSE included in the packaging of this file.  Please review the following information to ensure the GNU General Public License version 3.0 requirements will be met: http://www.gnu.org/copyleft/gpl.html.

If you are unsure which license is appropriate for your use, please contact the sales department at http://www.sencha.com/contact.

*/
/*!
 * Ext JS Library 4.0
 * Copyright(c) 2006-2011 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */

Ext.define('MyDesktop.Modules.Notepad.Client.Notepad', {
    extend: 'Ext.ux.desktop.Module',

    requires: [
    // 'Ext.form.field.HtmlEditor'
    'Ext.ux.desktop.Ckeditor'
    ],

    id:'notepad',

    init : function(){
        this.launcher = {
            text: 'Notepad',
            iconCls:'icon-notepad',
            handler : this.createWindow,
            scope: this
        }
    },

    createWindow : function(){
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('notepad');
        var editorCK = Ext.create('widget.ckeditor',{
            id:'editorCK',
            CKConfig: {
                customConfig : '/jsfrw/myofficeapps/ckeditor/config.js',
                height : 200,
                width: 500
            }

        });
         
        if(!win){
            win = desktop.createWindow({
                id: 'notepad',
                title:'Notepad',
                width:960,
                height:630,
                iconCls: 'icon-notepad',
                animCollapse:false,
                border: false,
                
                hideMode: 'offsets',

                layout: 'fit',
                items:  editorCK
                    
            });
        }
        win.show();
        return win;
    }
});

