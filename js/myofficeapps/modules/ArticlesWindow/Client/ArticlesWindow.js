Ext.override(Ext.data.proxy.Server, {

    constructor: function(config)
    {
        this.callOverridden([config]);

        this.addListener("exception",  function (proxy, response, operation) {
            if (response.responseText != null)
            {
               // Ext.Msg.alert('Error', Error.msg );
               
                Err=Ext.decode(response.responseText)
                Ext.Msg.show({
                title: Err.error.title,
                msg: Err.error.message,
                buttons: Ext.Msg.OK,
                icon: Ext.Msg.ERROR
            });
            
            }
        });

    }

});


Ext.define('MyDesktop.Modules.ArticlesWindow.Client.ArticlesWindow', {
    extend: 'Ext.ux.desktop.Module',
  
    requires: [
    'MyDesktop.Modules.ArticlesWindow.Client.Models.Articles',
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.util.*',
    'Ext.toolbar.Paging', 
    'Ext.ModelManager',
    'Ext.tip.QuickTipManager'
   
    ],
  
    id:'grid-win',
    articleStore: null,
    gridWindow: null,
    desktop: null,
    utoolbarContainer: null,
    btoolbarContainer:  Ext.create('Ext.toolbar.Toolbar', {        
        flex   : 1,
        id: 'bottom-main-toolbar', 
        autoDestroy: true,
        doc: 'bottom',
        items: [{
            text: 'Example Button'
        }]
    }),
    
    init : function(){
        // this.btoolbarContainer.destroy();        
        this.articleStore =   Ext.create('Ext.data.Store', {
            model: 'MyDesktop.Modules.ArticlesWindow.Client.Models.Articles',
            autoLoad: false,
            appendId: false,
            pageSize: 20,
            remoteSort: true,          
            proxy: {
                type: 'ajax',
                url : '/myofficeapps/articleGridManager',
                api: {
                    read: '/myofficeapps/api?object=Article_ListArticles',
                    create: '/myofficeapps/ArticleCreator',
                    update: '/myofficeapps/ArticleUpdator',
                    destroy: '/myofficeapps/ArticleDestroyer'
                },

                reader: {
                    type: 'json',
                    root: 'articles',
                    totalProperty: 'total'
                },
                simpleSortMode: true
            },
            sorters: [{
                property: 'id',
                direction: 'DESC'
            }]
        });
        this.utoolbarContainer =  Ext.create('Ext.toolbar.Toolbar', {
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
                    text: 'View List',
                    handler: this.createArticleOne
                },
                {
                    xtype: 'button',
                    text: 'New Content',
                    scope: this,
                    handler: this.createArticleOne

                },


                {
                    xtype: 'button',
                    text: 'Open List',
                    scope: this,
                    handler: this.getGridWindow

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
        this.launcher = {
            text: 'Grid Window',
            iconCls:'icon-grid',
            handler : this.createWindow,
            scope: this
        };
    },
  

    createWindow : function( ){
        this.desktop = this.app.getDesktop();
        if( null != this.gridWindow)  this.gridWindow.destroy();
        var win = this.desktop.getWindow('grid-win');
        this.articleStore.load();
        if(!win){
          
            win = this.desktop.createWindow({
                id: 'grid-win',
                title:'Grid Window',
                width:900,
                height:650,
                x: 200,
                y: 10,
                iconCls: 'icon-grid',
                animCollapse:true,
                constrainHeader:true,
                layout: 'fit',
                items: [{
                  
                    xtype: 'panel',
                    flex: 1,
                    id: 'main-container',   
                    anchor: '100%',
                    layout: {
                        type: 'fit'
                    },
                    dock: 'top',
                    tbar: this.utoolbarContainer,
                    bbar: this.btoolbarContainer
                }
                ]
                         
            });
        }        
        win.show();
        this.getGridWindow();
        return win;
    },
   
    getGridWindow: function() {
        //  this.articleStore.load();
        this.desktop.showNotification({
             html: 'Please wait..',
             title: 'Loading'
          });
        Ext.getCmp('main-container').body.dom.innerHTML='';
        Ext.getCmp('form-manager').disable();
        Ext.getCmp('manage-list').enable();
        this.gridWindow =  Ext.create('Ext.grid.Panel', {           
            border: true,       
            layout:'fit',                  
            renderTo: 'main-container-body',
            stateful:false,

            store: this.articleStore,                  
            id: 'article-grid-window',
                   
            flex: 1,
            // autoHeight: true,
            //  autoWidth: true,
            anchor: '100%',
            columns: [
            new Ext.grid.RowNumberer(),
            {
                text: "ID",
                //  flex: 1,
                hidden: true,
                dataIndex: 'id'
            },
            {//'id', 'title', 'alias', 'content_type', 'published', 'created', 'ordering', 'hits'
                text: "Title",                        
                sortable: true,
                flex: 0.3,
                //renderer: Ext.util.Format.usMoney,
                dataIndex: 'title'
            },
            {
                text: "Alias",                        
                sortable: true,
                flex: 0.2,
                dataIndex: 'alias'
            },
            {
                text: "Content Type",
                flex: 0.1,
                sortable: true,
                dataIndex: 'content_type'
            },
            {
                text: "Date Published",
                // width: 50, 2011-01-01 00:00:01
                flex: 0.25,
                sortable: true,
                dataIndex: 'created',
                renderer: Ext.util.Format.dateRenderer('Y-m-d')
            },                     
            {
                text: "Active",
                flex: 0.1,
                sortable: true,
                dataIndex: 'published'
            },
            {
                text: "Views",
                flex: 0.1,
                sortable: true,
                dataIndex: 'hits'
            }
            ]  
                    
        });
        this.btoolbarContainer.removeAll();
        var tool = Ext.create('Ext.PagingToolbar', {
            border: false,
            id: 'grid-toolbar',
            autoDestroy: true,
            store: this.articleStore,   // same store GridPanel is using                   
            displayInfo: true,
            renderTo: 'bottom-main-toolbar'           
        }) ;
        this.btoolbarContainer.add(tool);
        this.gridWindow.show();        
    },
    createArticleOne: function(){
        Ext.getCmp('form-manager').enable();
        Ext.getCmp('manage-list').disable();
        if('undefined' !== typeof Ext.getCmp('grid-toolbar')) Ext.getCmp('grid-toolbar').destroy();
        if( this.gridWindow !== null)  this.gridWindow.destroy();

        Ext.getCmp('main-container').body.dom.innerHTML='';
        var formOne = Ext.create('Ext.form.Panel', {
            layout: {
                type: 'fit'
            },
            id: 'form-article',
             url: 'myofficeapps/process',
            renderTo: 'main-container-body',
            bodyPadding: 1,
            items: [
            {
                xtype: 'tabpanel',
                activeTab: 0,
                items: [
                {
                    xtype: 'panel',
                    
                    layout: {
                        type: 'anchor'
                    },
                    bodyPadding: 10,
                     defaults: {
                        anchor: '100%'
                    },
                    title: 'Tab 1',
                    items: [
                            {
                                xtype: 'textfield',                               
                                name : 'title',
                                fieldLabel: 'Title'
                            },
                            {
                               
                                xtype:          'combo',
                                mode:           'local',
                                value:          '1',
                                triggerAction:  'all',
                                forceSelection: true,
                                editable:       false,
                                fieldLabel:     'Access',
                                name:           'access',
                                displayField:   'name',
                                valueField:     'value',
                                queryMode: 'local',
                                store:          Ext.create('Ext.data.Store', {
                                    fields : ['name', 'value'],
                                    data   : [
                                    {
                                        name : 'Public',
                                        value: '1'
                                    },

                                    {
                                        name : 'Registered',
                                        value: '2'
                                    },

                                    {
                                        name : 'Special',
                                        value: '3'
                                    },

                                    {
                                        name : 'Restricted',
                                        value: '4'
                                    }
                                    ]
                                })
                            },
                            {
                                xtype:          'combo',
                                mode:           'local',
                                value:          '1',
                                triggerAction:  'all',
                                forceSelection: true,
                                editable:       false,
                                fieldLabel:     'Published',
                                name:           'published',
                                displayField:   'name',
                                valueField:     'value',
                                queryMode: 'local',
                                store:          Ext.create('Ext.data.Store', {
                                    fields : ['name', 'value'],
                                    data   : [
                                    {
                                        name : 'UnPublished',
                                        value: '0'
                                    },

                                    {
                                        name : 'Published',
                                        value: '1'
                                    },

                                    {
                                        name : 'Archived',
                                        value: '2'
                                    },

                                    {
                                        name : 'Trashed',
                                        value: '3'
                                    }
                                    ]
                                })
                            },
                            {
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
                            },
                            {
                                xtype: 'htmleditor',
                                name: 'introtext',
                                fieldLabel: 'Content Intro',
                                style: 'background-color: white;',
                                enableColors: false,
                                enableFont: false,
                                enableLinks: false,
                                enableLists: false,
                                enableSourceEdit: false
                            },
                            {
                                xtype: 'htmleditor',                                
                                style: 'background-color: white;',
                                name: 'fulltext',
                                fieldLabel: 'Full COntent',
                                autoHeight:true
                            }, {
                                xtype: 'hiddenfield',
                                name: 'content_type',
                                value: 'article'
                            }, {
                                xtype: 'hiddenfield',
                                name: 'id'
                            }
                            ]
                },
                {
                    xtype: 'panel',
                    layout: {
                        type: 'anchor'
                    },
                    bodyPadding: 10,
                    title: 'Tab 2',
                    items: [
                    {
                        xtype: 'fieldset',
                        padding: 10,
                        title: 'Settings',
                        items: [
                                {
                                    xtype: 'radiogroup',
                                    fieldLabel: 'Show Title',
                                    items: [
                                    {
                                        xtype: 'radiofield',
                                        id: 'show-title-yes',
                                        boxLabel: 'Yes',
                                        name: 'ioptions[show_title]',
                                        inputValue: 1,
                                        checked: true
                                    },
                                    {
                                        xtype: 'radiofield',
                                        id: 'show-title-no',
                                        name: 'ioptions[show_title]',
                                        inputValue: 0,
                                        boxLabel: 'No'
                                    }
                                    ]
                                },
                                {
                                    xtype: 'radiogroup',
                                    fieldLabel: 'Show Author',
                                    items: [
                                    {
                                        xtype: 'radiofield',
                                        name: 'ioptions[show_author]',
                                        inputValue: 1,
                                        boxLabel: 'Yes',
                                        checked: true
                                    },
                                    {
                                        xtype: 'radiofield',
                                        name: 'ioptions[show_author]',
                                        inputValue: 0,
                                        boxLabel: 'No'
                                    }
                                    ]
                                },
                                {
                                    xtype: 'radiogroup',
                                    fieldLabel: 'Show Intro',
                                    items: [
                                    {
                                        xtype: 'radiofield',
                                        boxLabel: 'Yes',
                                        name: 'ioptions[show_intro]',
                                        inputValue: 1
                                    },
                                    {
                                        xtype: 'radiofield',
                                        boxLabel: 'No',
                                        name: 'ioptions[show_intro]',
                                        inputValue: 0,
                                        checked: true
                                    }
                                    ]
                                },
                                {
                                    xtype: 'radiogroup',
                                    fieldLabel: 'Show Created',
                                    items: [
                                    {
                                        xtype: 'radiofield',
                                        boxLabel: 'Yes',
                                        name: 'ioptions[show_create_date]',
                                        inputValue: 1,
                                        checked: true
                                    },
                                    {
                                        xtype: 'radiofield',
                                        boxLabel: 'No',
                                        name: 'ioptions[show_create_date]',
                                        inputValue: 0
                                    }
                                    ]
                                },
                                {
                                    xtype: 'radiogroup',
                                    fieldLabel: 'Show Modified',
                                    items: [
                                    {
                                        xtype: 'radiofield',
                                        boxLabel: 'Yes',
                                        name: 'ioptions[show_modify_date]',
                                        inputValue: 1
                                    },
                                    {
                                        xtype: 'radiofield',
                                        boxLabel: 'No',
                                        name: 'ioptions[show_modify_date]',
                                        inputValue: 0,
                                        checked: true
                                    }
                                    ]
                                },
                                {
                                    xtype: 'radiogroup',
                                    fieldLabel: 'Show Hits',
                                    items: [
                                    {
                                        xtype: 'radiofield',
                                        boxLabel: 'Yes',
                                        name: 'ioptions[show_hits]',
                                        inputValue: 1
                                    },
                                    {
                                        xtype: 'radiofield',
                                        name: 'ioptions[show_hits]',
                                        inputValue: 0,
                                        boxLabel: 'No',
                                        checked: true
                                    }
                                    ]
                                },
                                {
                                    xtype: 'radiogroup',
                                    fieldLabel: 'Show Vote',
                                    items: [
                                    {
                                        xtype: 'radiofield',
                                        boxLabel: 'Yes',
                                        name: 'ioptions[show_vote]',
                                        inputValue: 1

                                    },
                                    {
                                        xtype: 'radiofield',
                                        name: 'ioptions[show_vote]',
                                        inputValue: 0,
                                        boxLabel: 'No',
                                        checked: true
                                    }
                                    ]
                            }
                            ]
                    }
                    ]
                },
                {
                    xtype: 'panel',
                    layout: {
                        type: 'anchor'
                    },
                    bodyPadding: 10,
                    title: 'Tab 3',
                    items: [
                    
                    {
                        xtype: 'htmleditor',
                        height: 150,
                        name: 'metadesc',
                        style: 'background-color: white;',
                        enableAlignments: false,
                        enableColors: false,
                        enableFont: false,
                        enableFontSize: false,
                        enableFormat: false,
                        enableLinks: false,
                        enableLists: false,
                        enableSourceEdit: false,
                        fieldLabel: 'Meta Description',
                        anchor: '100%'
                    },
                    {
                        xtype: 'htmleditor',
                        height: 150,
                        style: 'background-color: white;',
                        name: 'metakey',
                        enableAlignments: false,
                        enableColors: false,
                        enableFont: false,
                        enableFontSize: false,
                        enableFormat: false,
                        enableLinks: false,
                        enableLists: false,
                        enableSourceEdit: false,
                        fieldLabel: 'Meta Key',
                        anchor: '100%'
                    }
                    ]
                }
                ]
            }
            ]
        });
        formOne.show();
        return formOne;
    }
});
