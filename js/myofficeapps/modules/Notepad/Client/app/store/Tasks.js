Ext.define('MyDesktop.Modules.Notepad.Client.app.store.Tasks', {
    extend: 'Ext.data.Store',
    model: 'SimpleTasks.model.Task',
    groupField: 'due'
});