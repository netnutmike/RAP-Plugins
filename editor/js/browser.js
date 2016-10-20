
//
// This is the main layout definition.
//
Ext.onReady(function(){
	
	//Ext.QuickTips.init();
	
	// This is an inner body element within the Details panel created to provide a "slide in" effect
	// on the panel body without affecting the body's box itself.  This element is created on
	// initial use and cached in this var for subsequent access.
	//var detailEl, detailE2;
	
	// This is the main content center region that will contain each example layout panel.
	// It will be implemented as a CardLayout since it will contain multiple panels with
	// only one being visible at any given time.
	var contentPanel = new Ext.Panel({
		id: 'content-panel',
		region: 'center', 
		layout: 'anchor',
		items: new Ext.TabPanel({
            border:false,
            anchor: '100% 100%',
            activeTab:0,
            tabPosition:'top',
            items:[editorPanel,
                   previewPanel
					]		//end of items in column layout				//end item2,
			})
		});
    
    var directorystore = new Ext.data.Store({			

		url: '/rap_admin/addons/GIS/editor/data/getjson.php',
		baseParams:{dataset: "filelist"},
				
		reader: new Ext.data.JsonReader({root: 'filelist',	totalProperty: 'totalCount'}, [
			{name: 'fileName', mapping: 'fileName'}
		 	])
			
		 });	
    
	var directorygrid = new Ext.grid.GridPanel({
	    store: directorystore,
	    columns: [
	        {id: 'filename', header: "File Name", width: 120, sortable: true, dataIndex: 'fileName'}
	        ],
		autoExpandColumn: 'filename',
	    layout: 'fit',
	    monitorResize: true,
        autoScroll: true,
        height: 400,
        tbar:[{
				xtype:'tbbutton',
				text: 'New File',
				cls: 'x-btn-text-icon bmenu',
				icon: '/rap_admin/addons/GIS/editor/images/add.png',
				listeners: {
        			click: function() { 
        				NewFileWindow();
					}
				}
			},{
				xtype:'tbseparator'
			}]
	    });
	
	directoryMenu = new Ext.menu.Menu({ 
		items : [
			new Ext.menu.Item({
				cls			: 'x-btn-text-icon bmenu', // icon and text class
				pressed		: false,
				enableToggle: false,
				text		: 'Edit File',
				tooltip		: 'Edit This File (Same as double click).',
				icon		: '/rap_admin/addons/GIS/editor/images/edit.png',
				scope		: this,
				handler		: function () {
					var ds = giftcardlist.getStore();
					var record = ds.getAt(SelectedRow);
					GiftCardDetailWindow(record.get('uid'));
				}
			}),'-',
			new Ext.menu.Item({
				cls			: 'x-btn-text-icon bmenu', // icon and text class
				pressed		: false,
				enableToggle: false,
				text		: 'Copy File',
				tooltip		: 'Copy this file to a new filename.',
				icon		: '/rap_admin/addons/GIS/editor/images/copy.png',
				scope		: this,
				handler		: function () {
					var ds = giftcardlist.getStore();
					var record = ds.getAt(SelectedRow);
					GiftCardDetailWindow(record.get('uid'));
				}
			}),'-',
			new Ext.menu.Item({
				cls			: 'x-btn-text-icon bmenu', // icon and text class
				pressed		: false,
				enableToggle: false,
				text		: 'Delete This File',
				tooltip		: 'Delete This File.  This cannot be undone!',
				icon		: '/rap_admin/addons/GIS/editor/images/delete.png',
				scope		: this,
				handler		: function () {
					DrawMarrWikiWindow('', "PaymentsPro: product list");
				}
			})
							]
													
				});	
					
	directorygrid.on('rowcontextmenu', function(grid, rowIndex, e){
		
			e.stopEvent(); // Stops the browser context menu from showing.
			
			SelectedRow = rowIndex;
			directoryMenu.showAt(e.getXY());
		});
	
	directorygrid.on('rowdblclick', function(grid, rowIndex, e){
		
		e.stopEvent(); // Stops the browser context menu from showing.
		
		var ds = directorygrid.getStore();
		var record = ds.getAt(rowIndex);
		loadTemplate(Ext.getCmp('productSelector').getValue(), record.get('fileName'));
	});


    var productstore = new Ext.data.Store({			

		url: '/rap_admin/addons/GIS/editor/data/getjson.php',
		baseParams:{dataset: "products"},
				
		reader: new Ext.data.JsonReader({root: 'products',	totalProperty: 'totalCount'}, [
			{name: 'id', mapping: 'id'},
			{name: 'ProductName', mapping: 'ProductName'},
			{name: 'InstallFolder', mapping: 'InstallFolder'}
		 	])
		 });			

	productstore.load();
	

	// Finally, build the main layout once all the pieces are ready.  This is also a good
	// example of putting together a full-screen BorderLayout within a Viewport.
    new Ext.Panel({
		layout: 'border',
		height: 500,
		renderTo: 'container',
		//title: 'Mosis Training',
		items: [{
			//layout: 'panel',
			//tbar: landingtb,
	        region:'north'
		},
    	{
			layout: 'form',
	    	//id: 'layout-browser',
			width: 200,
	        region:'west',
			items: [{
        		xtype: 'label',
        		text: 'Select A Product:'
    		},{
        		xtype: 'combo',
        		name: 'Product',
        		mode: 'remote',
        		fieldLabel: 'Product',
        		id: 'productSelector',
        		hideLabel: true,
        		width: 80,
        		hiddenName: 'Product',
        		valueField: 'id',
        		displayField:'ProductName',
        		store: productstore,					
        		//selectOnFocus: true,
        		editable: false,
        		//forceSelection: true,
        		triggerAction: 'all',
        		width: 180,
				listeners: {
	    			select: function() { 
    					directorystore.reload({
							params: {
								productid: Ext.getCmp('productSelector').getValue()
						}});
						}
	  				}
        	},{
        		type: 'label',
        		html: '<br>Select the File Below:<br>'
        	},directorygrid]
		},
			contentPanel,
		{
			//layout: 'panel',
			//tbar: mainstatusbar,
		    region:'south'
		}
		]
    });
});
