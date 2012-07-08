/*

This file is part of Ext JS 4

Copyright (c) 2011 Sencha Inc

Contact:  http://www.sencha.com/contact

GNU General Public License Usage
This file may be used under the terms of the GNU General Public License version 3.0 as published by the Free Software Foundation and appearing in the file LICENSE included in the packaging of this file.  Please review the following information to ensure the GNU General Public License version 3.0 requirements will be met: http://www.gnu.org/copyleft/gpl.html.

If you are unsure which license is appropriate for your use, please contact the sales department at http://www.sencha.com/contact.

*/

Ext.Loader.setPath('Ext.ux', '/jsfrw/myofficeapps/client/ux');
    
Ext.define('MyDesktop.Modules.MenuManager.Client.MenuManager', {
    extend: 'Ext.ux.desktop.Module',
    requires: [
    'Ext.tip.QuickTipManager',    
    'Ext.layout.*',
    'Ext.form.Panel',
    'Ext.form.Label',
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.tree.*',   
    'Ext.selection.*',   
    'Ext.ux.layout.Center'
    ],
    id : 'menuManager',

    init : function(){
        var me = this;
        //
        // This is the main layout definition.

        this.launcher = {
            text: 'Menu Manager',											// 3.- The name of the shortcut aka launcher/
            iconCls:'icon-admin',									// 4.- Changes the icon of the module
            handler : this.createWindow,
            scope: this
        };
        
   
        // This is an inner body element within the Details panel created to provide a "slide in" effect
        // on the panel body without affecting the body's box itself.  This element is created on
        // initial use and cached in this var for subsequent access.
        me.detailEl = null;

        me.treePanel = null;

        /*  
    Ext.Object.each(getCombinationLayouts(), function(name, example){
        me.layoutExamples.push(example);
    });
    
    Ext.Object.each(getCustomLayouts(), function(name, example){
        me.layoutExamples.push(example);
    });
    */
        // This is the main content center region that will contain each example layout panel.
        // It will be implemented as a CardLayout since it will contain multiple panels with
        // only one being visible at any given time.
        if (! Ext.ClassManager.isCreated('MenuGroupsModel')) {
            Ext.define('MenuGroupsModel', {
                extend: 'Ext.data.Model',
                fields: [
                {
                    name: 'id', 
                    type: 'int'
                },
                {
                    name     : 'title'
                         
                },
                {
                    name     : 'alias' 
                           
                },
                {
                    name     : 'note' 
                           
                },
                {
                    name     : 'approved' 
                            
                },
                {
                    name     : 'access' 
                          
                }
                        
                ]
            }
            )
        };
     
        
    },
   
    createWindow : function(){
        var me = this;
        // Store Modules
        me.gridTree = Ext.create('Ext.data.Store',{
            id : 'GridTree', 
            model : 'MenuGroupsModel',
            autoLoad: true,
            proxy : {
                type: 'ajax',
                url: '/myofficeapps/api',
                method:'GET',
                extraParams: { 
                    object: 'Menu_ListGridMenu'
                    
                },	
                reader: {
                    type : 'json',
                    root : 'data',
                    successProperty : 'success'
                }
            }
        });
        
        me.store = Ext.create('Ext.data.TreeStore', {
            root: {
                title: 'Root Menu',
                id: -1,
                expanded: false
            },
            proxy : {
                type: 'ajax',
                url: '/myofficeapps/api',
                method:'GET',
                extraParams: { 
                    object: 'Menu_listMenu'
                    
                }
            }
        });
        this.treePanel = Ext.create('Ext.tree.Panel', {
            id: 'tree-panel',
            //  title: 'Website Menus',
            region:'north',
            // split: true,
            height: 300,
            minSize: 150,
            rootVisible: false,
            autoScroll: true,
            store: this.store,
            viewConfig: {
                plugins: {
                    ptype: 'treeviewdragdrop',
                    dragText: 'Drag to reorder'
                },
                listeners: {                                
                    drop: {
                        fn: this.onTreedragdroppluginDrop,
                        scope: this
                    }
                }
            },
            dockedItems: [

            {
                xtype: 'toolbar',
                dock: 'bottom',
                items: [
                {
                    iconCls: 'tasks-new-list',
                    tooltip: 'New List',
                    scope: this,
                    handler: function() {
                        var me = this;                     
                        if (this.treePanel.getSelectionModel().hasSelection()) {                 
                            
                            var selectedNode = this.treePanel.getSelectionModel().getSelection();
                            Ext.MessageBox.prompt('Add Node', 'Please enter node text:', function(btn, text){
                                if (btn == 'ok'){
                                    // send node text and parent id to server using ajax
                                    Ext.Ajax.request({
                                        url: '/myofficeapps/api',
                                        params: {
                                            object: 'Menu_CreateTree',
                                            name: text,
                                            leaf: 1,
                                            parentid : selectedNode[0].data.id
                                        },
                                        scope: me,
                                        success: function(response){
                                            var selectedNode = me.treePanel.getSelectionModel().getSelection();
                                            var result = Ext.decode(response.responseText);
                                            if (result.id > 0) {
                                                selectedNode[0].set('leaf', false);
	                                         
                                                selectedNode[0].appendChild({
                                                    leaf: true,
                                                    text: text,
                                                    id: result.id
                                                });            
                                                this.treePanel.getView().refresh();                  
                                                selectedNode[0].expand();                                  
                                            }
                                        }
                                    });
                                }
                            });
                        } else {
                            Ext.MessageBox.alert('Alert', 'Please select parent node to insert a new node!');
                        }
                    }
                },
                {
                    iconCls: 'tasks-delete-list',
                    id: 'delete-list-btn',
                    tooltip: 'Delete List',
                    scope: this,
                    handler: me.onTreedNodeDelete
                },
                {
                    iconCls: 'tasks-new-folder',
                    tooltip: 'New Folder',
                    scope:this,
                    handler: function() {
                        var me = this;
                        var selectedNode = this.treePanel.getSelectionModel().getSelection();
                        var parentNode = 0,  leaf = 0;
                        if (this.treePanel.getSelectionModel().hasSelection()) {   
                            parentNode = selectedNode[0].data.id;                           
                        }
                        Ext.MessageBox.prompt('Add Folder', 'Please enter Folder text:', function(btn, text){
                            if (btn == 'ok'){
                                // send node text and parent id to server using ajax
                                Ext.Ajax.request({
                                    url: '/myofficeapps/api',
                                    params: {
                                        object: 'Menu_CreateTree',
                                        name: text,
                                        leaf: leaf,
                                        parentid : parentNode
                                    },
                                    success: function(response){
                                        var res = Ext.decode(response.responseText);
                                        var selectedNode = me.treePanel.getSelectionModel().getSelection();
                                            
                                        if (res.id > 0) {
                                            selectedNode[0].set('leaf', false);
	                                         
                                            selectedNode[0].appendChild({
                                                leaf: false,
                                                text: text,
                                                id: res.id
                                            });            
                                            me.treePanel.getView().refresh();                  
                                            selectedNode[0].expand();                                  
                                        }
                                    }
                                });
                            }
                        });
                    }
                },
                {
                    iconCls: 'tasks-delete-folder',
                    id: 'delete-folder-btn',
                    tooltip: 'Delete Folder'
                }
                ]
            }
            ]
           
        }); 
          
        // Assign the changeLayout function to be called on tree node click.
       
        this.treePanel.getSelectionModel().on('select', function(selModel, record) {
            if (record.get('leaf')) {
            // alert(record.getId());
            /* Ext.getCmp('content-panel').layout.setActiveItem(record.getId() + '-panel');
                if (!me.detailEl) {
                    var bd = Ext.getCmp('details-panel').body;
                    bd.update('').setStyle('background','#fff');
                    me.detailEl = bd.createChild(); //create default empty div
                }
                me.detailEl.hide().update(Ext.getDom(record.getId() + '-details').innerHTML).slideIn('l', {
                    stopAnimation:true,
                    duration: 200
                });
                */
            } else {// get store for the slected folder tree
            //  alert(record.getId());
      
            }
        });
        
        
        
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('menuManager');
        if(!win){
            var winWidth = 960; //desktop.getWinWidth() / 1.1;
            var winHeight = 500;
           
            me.utoolbarContainer =  Ext.create('Ext.toolbar.Toolbar', {
                flex   : 1,
                id: 'upper-main-toolbar',
                autoDestroy: true,
                doc: 'top',

                items: [
                {
                    xtype: 'buttongroup',
                    height: 69,
                    fex:1,
                    title: 'Manage',
                    id: 'firstbutton',
                    columns: 3,
                    items: [
                    {
                        xtype: 'button',
                        id: 'home',
                        text: 'View List'
                    // handler: this.createArticleOne
                    },
                    {
                        xtype: 'button',
                        text: 'New Content',
                        scope: this
                    // handler: this.createArticleOne

                    },


                    {
                        xtype: 'button',
                        text: 'Open List',
                        scope: this
                    // handler: this.getGridWindow

                    },
                    ]
                },
                {
                    xtype: 'buttongroup',
                    height: 69,
                    flex:1,
                    title: 'Manage List',
                    id: 'manage-list',
                    columns: 3,
                    items: [
                    {
                        xtype: 'button',
                        id: 'delete-list',
                        text: 'Delete Local',
                        scope: this,
                        handler: function(){
                            var selection = Ext.getCmp('article-grid-window').getView().getSelectionModel().getSelection()[0];
                            if (selection) {
                                this.articleStore.remove(selection);

                            } else {
                                this.desktop.showNotification({
                                    html: 'No selection made',
                                    title: 'Make Selection'
                                })
                            }
                        }
                    },
                    {
                        xtype: 'button',
                        id: 'edit-selected',
                        text: 'Edit Selected',
                        scope: this,
                        handler: function(){
                            var me = this;
                            var selection = Ext.getCmp('article-grid-window').getView().getSelectionModel().getSelection()[0];
                            if (selection) {
                                var theForm = me.createArticleOne();
                                this.desktop.showNotification({
                                    html: 'Please wait..',
                                    title: 'Loading'
                                });
                                //  theForm = Ext.getCmp('form-article').getForm();
                           
                                theForm.load({
                                    url: '/myofficeapps/edit',
                                    params: {
                                        id: selection.get('id')
                                    },
                                    failure: function(form, action) {
                                        Ext.Msg.alert("Loading failed", action.result.errorMessage);
                                    }
                                });
                            } else {
                                this.desktop.showNotification({
                                    html: 'No selection made',
                                    title: 'Make Selection'
                                })
                            }
                        }

                    },{
                        xtype: 'button',
                        text: 'Save Changes',
                        id: 'save-changes',
                        scope: this,
                        handler: function(){
                            var selection = Ext.getCmp('article-grid-window').getView().getSelectionModel().getSelection()[0];
                            this.articleStore.sync();
                        }

                    },
                    ]
                },{
                    xtype: 'buttongroup',
                    height: 69,
                    flex: 1,
                    title: 'Form Manager',
                    id: 'form-manager',                
                    columns: 3,
                    items: [
                    {
                        xtype: 'button',
                        text: 'Save New',
                        scope: this,
                        handler: function() {
                            var form = Ext.getCmp('form-article').getForm();

                            if (form.isValid()) {
                                this.desktop.showNotification({
                                    html: 'Saving Data! Please wait ...',
                                    title: 'Saving Data'
                                });
                           
                                if (form.isValid()) { // make sure the form contains valid data before submitting

                                    form.submit({
                                        success: function(form, action) {                                      
                                            this.desktop.showNotification({
                                                html: action.result.msg.message,
                                                title: 'Save Successfully'
                                            })
                                        },
                                        failure: function(form, action) {
                                            Ext.MessageBox.show({
                                                title: 'Failed Saving data',
                                                msg: action.result.msg.message,
                                                icon: action.result.msg.type
                                            });
                                        }
                                    });
                                } else { // display error alert if the data is invalid
                                    Ext.Msg.alert('Invalid Data', 'Please correct form errors.')
                                }
                       
                            }
                        }
                    },
                    {
                        xtype: 'button',
                        text: 'Close'

                    },
                    {
                        xtype: 'button',
                        text: 'Refresh',
                        handler: function(){
                            //return this.CreateNew(desktop);
                            var theForm = Ext.getCmp('form-article').getForm().load({
                                url: '/myofficeapps/edit',
                                params: {
                                    id: 1
                                },
                                failure: function(form, action) {
                                    Ext.Msg.alert("Load failed", action.result.errorMessage);
                                }
                            });
                        }
                    //scope: this
                    }
                    ]
                },
                {
                    xtype: 'buttongroup',
                    height: 69,
                    flex: 1,
                    title: 'Help',
                    columns: 2,
                    items: [
                    {
                        xtype: 'button',
                        flex: 2,
                        text: 'Local Help'
                    },
                    {
                        xtype: 'button',
                        flex:2,
                        text: 'Online Help'
                    }
                    ]
                }
                ]

            });
            var form = Ext.widget('form', {
                
                border: false,
                bodyPadding: 10,
                id: 'form-menu-options',
                fieldDefaults: {
                    labelAlign: 'top',
                    labelWidth: 100                   
                },
                defaults: {
                    margins: '0 0 10 0'
                },
                
                items: [
                {
                    xtype: 'fieldset',
                    padding: 7,
                    collapsible:true,                        
                    title: 'Link Options',
                    items: [
                                
                    {
                        xtype: 'textfield',
                        id: 'link-css-style',
                        name: 'params[linkCSS]',
                        fieldLabel: 'Css Style'
                    },
                    {
                        xtype: 'textfield',
                        id: 'link-image',
                        name: 'params[linkImages]' ,
                        fieldLabel: 'Menu Icon'
                    },
                                   
                    {
                        xtype: 'radiogroup',
                        fieldLabel: 'Show Icon & Menu Title',                                   
                        items: [
                        {
                            xtype: 'radiofield',
                            name: 'params[showImageAndTitle]',
                            id: 'show-image-and-title',
                            inputValue: 1,
                            boxLabel: 'Yes'
                                        
                        },
                        {
                            xtype: 'radiofield',
                            name: 'params[showImageAndTitle]',
                            inputValue: 0,
                            boxLabel: 'No',
                            checked: true
                        }
                        ]
                    }
                    ]
                },
                {
                    xtype: 'fieldset',
                    padding: 7,
                    collapsible:true,
                    collapsed: true,
                    title: 'Page Display Options',
                    items: [
                    {
                        xtype: 'textfield',
                        id: 'page-title',
                        name: 'params[pageTitle]',
                        fieldLabel: 'Page Title',
                        labelAlign: 'top'
                    },
                              
                    {
                        xtype: 'radiogroup',
                        fieldLabel: 'Show Page Heading',
                        labelAlign: 'top',
                        items: [
                        {
                            xtype: 'radiofield',
                            name: 'params[showPageHeading]',
                            inputValue: 1,
                            boxLabel: 'Yes',
                            checked: true
                        },
                        {
                            xtype: 'radiofield',
                            name: 'params[showPageHeading]',
                            inputValue: 0,
                            boxLabel: 'No'
                        }
                        ]
                    }
                    ]
                },
                {
                    xtype: 'fieldset',
                    padding: 7,
                    collapsible:true,
                    collapsed: true,
                    title: 'Metadata Options',
                    items: [
                    {
                        xtype: 'textarea',
                        name: 'metadata',
                        fieldLabel: 'Meta Description',
                        labelAlign: 'top'
                                
                    },
                    {
                        xtype: 'textarea',
                        name: 'keywords',
                        fieldLabel: 'Meta Keywords',
                        labelAlign: 'top'
                    },
                            
                    {
                        xtype: 'radiogroup',
                        fieldLabel: 'Secure',
                        labelAlign: 'top',
                        items: [
                        {
                            xtype: 'radiofield',
                            name: 'params[ssl]',
                            inputValue: 1,
                            boxLabel: 'Yes'                                     
                        },
                        {
                            xtype: 'radiofield',
                            name: 'params[sss]',
                            inputValue: 0,
                            boxLabel: 'No',
                            checked: true
                        }
                        ]
                    }
                    ]
                    }]
            })
       
            var tool = Ext.create('Ext.PagingToolbar', {
                border: false,
                id: 'grid-toolbar',
                autoDestroy: true,
                store: me.gridTree,   // same store GridPanel is using                   
                displayInfo: true
            //renderTo: 'bottom-main-toolbar'           
            }) ;
       
            win = desktop.createWindow({
                id: 'menuManager',
                title:'Menu Manager',
                width:960,
                height:630,    
                iconCls: 'layout-icon',
                animCollapse:false,
                constrainHeader:true,
                minimizable:true,
                maximizable:true,
                dock: 'top',
                tbar: this.utoolbarContainer,
                layout: 'border',
				
                items:[{
                    region:'west',
                    id: 'layout-browser',
                    autoScroll:true,
                    collapsible:true,
                    cmargins:'0 0 0 0',
                    margins: '2 0 5 5',
                    split:true,
                    title:'Website Menu',
                    width:parseFloat(winWidth*0.3) < 201 ? parseFloat(winWidth*0.3) : 200,
                    items: [ this.treePanel,
                    {
                        id: 'details-panel',
                        title: 'Quick Tips',
                        region: 'center',
                        bodyStyle: 'padding-bottom:15px;background:#eee;',
                        autoScroll: true,
                        html: '<p class="details-info">When you select a layout from the tree, additional details will display here.</p>'
                    }]
                },{
                               
                    id: 'content-panel',
                    region: 'center', // this is what makes this panel into a region within the containing layout
                    layout: 'card',
                    margins: '2 0 5 0',
                    activeItem: 0,
                    border: false,
                    items: [{
                        title: 'Website Menu Details',
                        xtype: 'grid',
                        layout: 'fit',
                        //  selType: 'cellmodel',
                        plugins: [
                        Ext.create('Ext.grid.plugin.CellEditing', {
                            clicksToEdit: 2
                        })
                        ],
                        viewConfig: {
                            plugins: [{
                                ptype: 'gridviewdragdrop' 
                            //  dropGroup: 'treeDDGroup',
                            // enableDrag: true
          
                            }
                            ],
                            listeners: {                                
                                drop: {
                                    fn: me.onTreedragdroppluginDrop,
                                    scope: me
                                }
                            }
                        },
                        store: me.gridTree,
                        bbar : tool,
                        columns: [
                        {
                            text     : 'Title',
                            flex     : 1,
                            sortable : false, 
                            dataIndex: 'title',
                            editor: 'textfield'
                        },
                        {
                            text     : 'Alias', 
                            width    : 75, 
                            sortable : false,                             
                            dataIndex: 'alias',
                            editor: 'textfield'
                        },
                        {
                            text     : 'Note', 
                            width    : 75, 
                            sortable : true, 
                            // renderer : change, 
                            dataIndex: 'note'
                        },
                        {
                            text     : 'Approved', 
                            width    : 75, 
                            sortable : false, 
                            // renderer : pctChange, 
                            dataIndex: 'approved'
                        },
                        {
                            text     : 'Access Group', 
                            width    : 85, 
                            sortable : true, 
                            // renderer : Ext.util.Format.dateRenderer('m/d/Y'), 
                            dataIndex: 'access'
                        }
                        ],
                        stripeRows: true
                    }]
                },

                {
                    region:'east',
                    autoScroll:true,
                    collapsible:true,
                    cmargins: '0 0 0 0',
                    margins: '2 0 5 0',
                    split:true,
                    title: 'Menu Settings',					
                    elements:'body',
                    width:parseFloat(winWidth*0.3) < 211 ? parseFloat(winWidth*0.3) : 210,
                    items: form
                }],
                renderTo: Ext.getBody()
            //taskbuttonTooltip: '<b>Layout Window</b><br />A window with a layout'
            });
        }
        win.show();
        return win;
    },
    onTreedragdroppluginDrop: function (node, list, overList, position)
    {
        Ext.Ajax.request({
            url: '/myofficeapps/api',
            method: 'POST',
            jsonData: {
                id: list.records[0].data['id'],
                relatedId: overList.data['id'],
                position: position,
                object: 'Menu_MoveNode'
            },
            success: function(response, options) {
                var responseData = Ext.decode(response.responseText);

                if(!responseData.success) {
                    Ext.MessageBox.show({
                        title: 'Move Task Failed',
                        msg: responseData.message,
                        icon: Ext.Msg.ERROR,
                        buttons: Ext.Msg.OK
                    });
                }
            },
            failure: function(response, options) {
                Ext.MessageBox.show({
                    title: 'Move Task Failed',
                    msg: response.status + ' ' + response.statusText,
                    icon: Ext.Msg.ERROR,
                    buttons: Ext.Msg.OK
                });
            }
        });
        // refresh the lists view so the task counts will be updated.
        this.treePanel.getView().refresh(); 
    },
    onTreedNodeDelete: function ()
    {
        var me = this;
        me.selectedNode = me.treePanel.getSelectionModel().getSelection();
        // console.log(me.selectedNode[0].data['id']);
        Ext.Ajax.request({
            url: '/myofficeapps/api',
            method: 'DELETE',
            params: {
                id: me.selectedNode[0].data['id'],                    
                object: 'Menu_DeleteNode'
            },
            success: function(response, options) {
                var responseData = Ext.decode(response.responseText);

                if(!responseData.success) {
                    Ext.MessageBox.show({
                        title: 'Move Task Failed',
                        msg: responseData.message,
                        icon: Ext.Msg.ERROR,
                        buttons: Ext.Msg.OK
                    });
                }
            },
            failure: function(response, options) {
                Ext.MessageBox.show({
                    title: 'Move Task Failed',
                    msg: response.status + ' ' + response.statusText,
                    icon: Ext.Msg.ERROR,
                    buttons: Ext.Msg.OK
                });
            }
        });
        // refresh the lists view so the task counts will be updated.
        me.treePanel.getView().refresh(); 
    }
});
