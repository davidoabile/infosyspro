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
    'Ext.ux.layout.Center',
    'Ext.ux.desktop.Ckeditor'
    ],
    id : 'menuManager',
    menuFormSideBar: null,
    gridWindow: null,
    
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
            appendId: false, 
            pageSize: 20,
            proxy : {
                type: 'rest',
               
                api: {
                    read: '/myofficeapps/api?object=Menu_ListGridMenu',
                    create: '/myofficeapps/api?object=Menu_CreateTree',
                    update: '/myofficeapps/api?object=Menu_UpdateNode',
                    destroy: '/myofficeapps/api?object=Menu_DeleteNode'
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
                text: 'Website Menu',
                // id: -1,
                expanded: true,
                leaf: false
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
        Ext.override(Ext.data.AbstractStore,{
            indexOf: Ext.emptyFn
        }); 


        this.treePanel = Ext.create('Ext.tree.Panel', {
            id: 'tree-panel',
            //  title: 'Website Menus',
            region:'north',
            
            split: true,
            // align:'stretch',
            // flex: 1,
            useArrows:true,
            rootVisible: false,
            autoScroll: true,
            // singleExpand : true,
            store: this.store,
            viewConfig: {
                plugins:[ {
                    ptype: 'treeviewdragdrop',
                    dragText: 'Drag to reorder'
                }],
                toggleOnDblClick: false, 
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
                    handler: this.addNewLeaf
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
                    handler: this.addNewFolder
                },
                {
                    iconCls: 'tasks-delete-folder',
                    id: 'delete-folder-btn',
                    tooltip: 'Delete Folder'
                }
                ]
            }
            ],
            // selType: 'cellmodel',
            plugins: [
            Ext.create('Ext.grid.plugin.CellEditing', {
                clicksToEdit:2
            })
            ],
            columns:[{
                xtype:'treecolumn',
                text:'Product Group / Parts',
                dataIndex:'text',
                flex:1,
                sortable:true,
                editor:{
                    xtype:'textfield',
                    allowBlank:false
                }
            }]

           
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
                scope:this;
            me.edit();
            } else    me.gridTree.load({
                params: {
                    id : record.getId()
                }
            });
          
        });
        
        
        
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('menuManager');
        if(!win){
            var winWidth = 960; //desktop.getWinWidth() / 1.1;
            var winHeight = 500;
            
            me.utoolbarContainer =  Ext.create('Ext.toolbar.Toolbar', {
                flex   : 1,
                scope: this,
                id: 'upper-main-toolbar',
                autoDestroy: true,
                doc: 'top',
                
                items: [{
                    xtype:'buttongroup',
                    flex: 1,
                    id: 'btn-view',
                    items: [{
                        text: 'View',
                        flex: 1,
                        iconCls: 'task-add-new',
                        scale: 'large',
                        menu: [{
                            text: 'Paste Menu Item', 
                            iconCls: 'task-add-new'
                        }]
                    }]
                },{
                    xtype:'buttongroup',
                    flex: 1,
                    id: 'btn-new',
                    items: [{
                        text: 'New',
                        iconCls: 'admin-help-32',
                        scale: 'large',               
                        menu: [{
                            text: 'Node',
                            scope: this,
                            handler: this.addNewLeaf, 
                            iconCls: 'task-add-new'
                        } ,
{
                            text: 'Parent Node',
                            scope: this,
                            handler: this.addNewFolder
                        }]
                    }]
                },{
                    xtype:'buttongroup',
                    flex: 1,
                    id: 'btn-edit',
                    items: [{
                        text: 'Edit',
                        iconCls: 'admin-help-32',
                        scale: 'large',
                        scope: this,
                        handler: this.edit
                    }]
                },{
                    xtype:'buttongroup',
                    flex: 1,
                    id: 'btn-preview',
                    items: [{
                        text: 'Preview',
                        iconCls: 'help-32',
                        scale: 'large'
                    }]
                },{
                    xtype:'buttongroup',
                    flex: 1,
                    id: 'btn-security',
                    items: [{
                        text: 'View Security',               
                        scale: 'large'
                    }]
                },{
                    xtype:'buttongroup',
                    flex: 1,
                    id: 'btn-save',
                    items: [{
                        text: 'Save',
                        iconCls: 'admin-help-32',
                        scale: 'large',
                        scope: this,
                        handler: this.save
                    }]
                },{
                    xtype:'buttongroup',
                    flex: 1,
                    id: 'btn-cancel',
                    items: [{
                        text: 'Cancel',                              
                        iconCls: 'admin-help-32',
                        scale: 'large',
                        scope: this,
                        handler: this.cancel
                    }]
                },{
                    xtype:'buttongroup',
                    flex: 1,
                    id: 'btn-trash',
                    items: [{
                        text: 'Trash',
                        iconCls: 'admin-help-32',
                        scale: 'large',
                        scope: this,
                        handler: this.onTreedNodeDelete
                    }]
                }, {
                    xtype:'buttongroup',
                    flex: 1,
                    id: 'btn-help',
                    items: [{
                        text: 'Help',
                        iconCls: 'admin-help-32',
                        scale: 'large'
                    }]
                }]

            });
           
       
            
       
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
                    layout: 'card',                  
                    cmargins:'0 0 0 0',
                    margins: '2 0 5 5',
                    split:true,
                    title:'Website Menu',
                    width:parseFloat(winWidth*0.3) < 201 ? parseFloat(winWidth*0.3) : 200,
                    items:  this.treePanel
                },{
                               
                    id: 'content-panel',
                    region: 'center', // this is what makes this panel into a region within the containing layout
                    layout: 'card',
                    margins: '2 0 5 0',
                    // activeItem: 0,
                    border: false
                },

                {
                    region:'east',
                    autoScroll:true,
                    collapsible:true,
                    // collapsed: true,
                    cmargins: '0 0 0 0',
                    margins: '2 0 5 0',
                    split:true,
                    title: 'Menu Settings',
                    id: 'menu-settings',
                    elements:'body',
                    width:parseFloat(winWidth*0.3) < 211 ? parseFloat(winWidth*0.3) : 210,
                    html: '<p class="details-info">Before creating a new menu, you should have created a page to link to.<br /><br /> Click on view then  Content Manager to create one</p>'
                   
                }],
                renderTo: Ext.getBody()
            //taskbuttonTooltip: '<b>Layout Window</b><br />A window with a layout'
            });
        }
        //var panel = Ext.getCmp('menu-settings');
        //panel.add(getSideForm());
        Ext.getCmp('btn-cancel').disable();
        Ext.getCmp('btn-save').disable();
        var  panel = Ext.getCmp('content-panel');
        panel.add(this.getGridWindow());
        win.show();
        
        //panel.collapse();
        //panel.getLayout().regions.north.expand();

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
    deleteNode: function() {
        var me = this;
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
        
    }, 
    
    onTreedNodeDelete: function ()
    {
        var me = this;
        if (me.treePanel.getSelectionModel().hasSelection()) { 
            me.selectedNode = me.treePanel.getSelectionModel().getSelection();
            // console.log(me.selectedNode[0].data.depth);
            var isleaf = me.selectedNode[0].data.leaf;
            if(me.selectedNode[0].data.depth < 3 ) {
                //  console.log(me.selectedNode);
                Ext.Msg.show({
                    title:'Cannot Delete Node',
                    msg: 'You cannot delete the root menu',
                    buttons: Ext.Msg.OK,
                    icon: Ext.Msg.ERROR
                });
        
                return false;
            }
            if(isleaf) {
                Ext.Msg.confirm("Please Confirm","This will delete Node <b>"+ me.selectedNode[0].data.text +"</b><br />Would you like to proceed?",function(btn, text){
                    if (btn == 'yes'){
                        scope: me;
                    me.deleteNode();
                    }
                })
            } else {
                Ext.Msg.confirm("Please Confirm","This will delete Parent <b>"+ me.selectedNode[0].data.text +"</b> and all its children<br />Would you like to proceed?",function(btn, text){
                    if (btn == 'yes'){
                        scope: me;
                    me.deleteNode();
                    }
                })
            }
        }else  Ext.MessageBox.alert('Alert', 'Please select parent node to delete!');
    },
     
    edit: function() {
        var panel; 
        var selection;
        var id = 0;
        if (this.treePanel.getSelectionModel().hasSelection()) {  
            var selectedNode = this.treePanel.getSelectionModel().getSelection();
            id = selectedNode[0].data['id'];
            console.log(selectedNode);
        } 
        
        var grid = Ext.getCmp('grid-tree')
        if(grid) {
            selection = grid.getView().getSelectionModel().getSelection()[0];
            if (selection) {
                id = selection.get('id');
                console.log( selection.get('id'));
                console.log(selectedNode)
            // selectedNode.select(0);
            }
        } else {
            Ext.MessageBox.alert('Alert', 'Click on cancel in order to proceed!');
            return false;
        } 
       
        panel = Ext.getCmp('grid-tree');
        if( panel)  panel.destroy();
       
        Ext.getCmp('btn-new').disable();
        Ext.getCmp('btn-view').disable();
        Ext.getCmp('btn-edit').disable();         
        Ext.getCmp('btn-cancel').enable();
        Ext.getCmp('btn-save').enable();
        Ext.getCmp('btn-preview').disable();
        Ext.getCmp('btn-security').disable();
        panel = Ext.getCmp('layout-browser');
        panel.collapse();
      
        var formSettings = Ext.create('Ext.form.Panel', { 
            layout: {
                type: 'anchor'
            },
            title: 'Edit New Menu',
            bodyPadding: 10,         
            id: 'form-main-settings',
            fieldDefaults: {
                labelWidth: 100 , 
                anchor: '100%'
            },
            defaults: {
                margins: '0 0 10 0'
            },
                
            items: [ {
                xtype: 'fieldset',
                padding: 7,            
                title: 'Menu Configurations',
                items: [{
                    xtype: 'textfield',
                    id: 'fld-title',
                    name: 'title',
                    fieldLabel: 'Title',
                    allowBlank: false,
                    listeners : {                 
                        'change': function(textfield,newValue,oldValue) {
                            var  alias = Ext.getCmp('fld-alias');
                            // if(!alias.getValue()){
                            alias.setValue(newValue);
                        // }
                        }
                    }
            },{
                xtype: 'textfield',
                id: 'fld-alias',
                name: 'alias' ,
                fieldLabel: 'Internal Link'
            },{
                xtype: 'textfield',
                id: 'fld-link',
                name: 'link' ,
                fieldLabel: 'External Link'
            },{
                xtype: 'radiogroup',
                fieldLabel: 'Published',                                   
                items: [
                {
                    xtype: 'radiofield',
                    name: 'published',
                    id: 'is-published',
                    inputValue: 1,
                    boxLabel: 'Yes',
                    checked: true                                        
                },
                {
                    xtype: 'radiofield',
                    name: 'published',
                    inputValue: 0,
                    boxLabel: 'No'
                        
                }
                ]
            },{
                xtype:          'combo',
                mode:           'local',
                value:          'en',
                triggerAction:  'all',
                forceSelection: true,
                editable:       false,
                fieldLabel:     'Language',
                name:           'language',
                displayField:   'name',
                valueField:     'value',
                queryMode: 'local',
                store:          Ext.create('Ext.data.Store', {
                    fields : ['name', 'value'],
                    data   : [
                    {
                        name : 'English',
                        value: 'en'
                    }

                    ]
                })
            },{
                xtype:          'combo',
                mode:           'local',
                value:          'access',
                triggerAction:  'all',
                forceSelection: true,
                editable:       false,
                fieldLabel:     'Access Group',
                name:           'access',
                displayField:   'name',
                valueField:     'value',
                queryMode: 'local',
                store:          Ext.create('Ext.data.Store', {
                    fields : ['name', 'value'],
                    data   : [
                    {
                        name : 'Guest',
                        value: '1'
                    }

                    ]
                })
            }]
            },{
            xtype: 'fieldset',
            padding: 7,    
            collapsible:true,
            collapsed: true,
            title: 'Metadata Options',
            items: [
            {
                xtype: 'textarea',
                name: 'metadata',
                fieldLabel: 'Meta Description'
            },
            {
                xtype: 'textarea',
                name: 'keywords',
                fieldLabel: 'Meta Keywords'
            }
            ]
        },
        {
            xtype: 'hiddenfield',
            id: 'fld-id',
            name: 'id'
        }
        ]
        });
       
    panel = Ext.getCmp('content-panel');
    panel.add(formSettings);
     var  idField = Ext.getCmp('fld-id');
     idField.setValue(id);
    this.menuSettings();
     
},
save: function() {
    if (this.treePanel.getSelectionModel().hasSelection()) {  
        var selectedNode = this.treePanel.getSelectionModel().getSelection();
        console.log(selectedNode);
    } 
        
    this.cancel();  
},
cancel: function() {
    Ext.getCmp('btn-new').enable();
    Ext.getCmp('btn-view').enable();
    Ext.getCmp('btn-edit').enable();
    Ext.getCmp('btn-cancel').disable();
    Ext.getCmp('btn-save').disable();
    Ext.getCmp('btn-preview').enable();
    Ext.getCmp('btn-security').enable();
       
    var panel;
    panel = Ext.getCmp('layout-browser');
    panel.expand();
        
    panel = Ext.getCmp('form-main-settings');
    if( panel)  panel.destroy();
         
    panel = Ext.getCmp('content-panel');
    panel.add(this.getGridWindow());
        
    panel = Ext.getCmp('menu-settings');
    panel.body.dom.innerHTML='Drag and drop nodes to reorder';
//panel.collapse();
},
getGridWindow: function() {
    var tool = Ext.create('Ext.PagingToolbar', {
        border: false,
        id: 'grid-toolbar',
        autoDestroy: true,
        store: this.gridTree,   // same store GridPanel is using                   
        displayInfo: true         
    }) ;
            
    var  gridWindow =  Ext.create('Ext.grid.Panel', {   
        xtype: 'grid',
        layout: 'fit',
        id: 'grid-tree',
        renderTo: 'content-panel',
        //  selType: 'cellmodel',
        //  plugins: [
        // Ext.create('Ext.grid.plugin.CellEditing', {
        //    clicksToEdit: 2
        // })
        // ],
        viewConfig: {
            plugins: [{
                ptype: 'gridviewdragdrop' 
            //  dropGroup: 'treeDDGroup',
            // enableDrag: true
          
            }
            ],
            listeners: {                                
                drop: {
                    fn: this.onTreedragdroppluginDrop,
                    scope: this
                }
            }
        },
        store: this.gridTree,
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
            text     : 'Internal Url', 
            flex    : 1, 
            sortable : false,                             
            dataIndex: 'alias',
            editor: 'textfield'
        },
        {
            text     : 'External Url', 
            flex    : 1, 
            sortable : false,                             
            dataIndex: 'note',
            editor: 'textfield'
        },
        {
            text     : 'Active', 
            width    : 45, 
            sortable : false, 
            // renderer : pctChange, 
            dataIndex: 'approved'
        },
        {
            text     : 'Access', 
            width    : 45, 
            sortable : false, 
            // renderer : Ext.util.Format.dateRenderer('m/d/Y'), 
            dataIndex: 'access'
        }
        ],
        stripeRows: true
    });
       
    return gridWindow;
},
addNewLeaf: function() {
    var me = this;                     
    if (this.treePanel.getSelectionModel().hasSelection()) {                 
                       
        var selectedNode = this.treePanel.getSelectionModel().getSelection();
        if (selectedNode[0].data.depth < 1) { 
            Ext.MessageBox.alert('NO NO NO', 'You cannot add a new Node on the selected parent!');
            return false;
        }
            
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
},
addNewFolder : function() {
    var me = this;
    var selectedNode = this.treePanel.getSelectionModel().getSelection();
    var parentNode = 0,  leaf = 0;
    if (this.treePanel.getSelectionModel().hasSelection()) {      
        if (selectedNode[0].data.depth < 2) { 
            Ext.MessageBox.alert('NO NO NO', 'You cannot add a new Node on the selected parent!');
            return false;
        }
        parentNode = selectedNode[0].data.id;                           
   
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
    } else  Ext.MessageBox.alert('Alert', 'Please select a parent node!');
},
menuSettings : function() {
    var formSettings = Ext.widget('form', {                
        border: false,
        bodyPadding: 10,             
        id: 'form-settings',
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
        }
        ]
    });
    var panel = Ext.getCmp('menu-settings');
    panel.body.dom.innerHTML='';
    panel.add(formSettings);
    panel.expand();
        
}
                
});
