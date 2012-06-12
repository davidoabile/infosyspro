Ext.define('MyDesktop.Modules.ArticlesWindow.Client.Models.Articles', {   
        extend: 'Ext.data.Model',          
       
        fields: [
            'title', 'alias', 'content_type',
            {name: 'id', type: 'int'},
             {name: 'created', type: 'date'},
            {name: 'published', type: 'int'},
            {name : 'hits', type: 'int' }, 
           
        ],
        idProperty: 'id'

    });
