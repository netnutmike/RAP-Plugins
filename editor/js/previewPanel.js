var previewPanel = new Ext.Panel({
		id: 'preview-panel',
		title: 'Preview',
		tbar:[{
			xtype:'tbbutton',
			text: 'Refresh',
			cls: 'x-btn-text-icon bmenu',
			icon: '/rap_admin/addons/GIS/editor/images/refresh.png',
			listeners: {
    			click: function() { 
    				NewFileWindow();
				}
			}
		},{
			xtype:'tbseparator'
		}],
		items: []
		});