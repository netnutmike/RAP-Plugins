
	
	var offlinepromostore = new Ext.data.Store({			

		url: '/rap_admin/addons/GIS/paymentpro/data/getjson.php',
		baseParams:{dataset: "offlinepromolist", SessionID: SessionID},
				
		reader: new Ext.data.JsonReader({root: 'promos',	totalProperty: 'totalCount'}, [
			{name: 'id', mapping: 'id'},
			{name: 'promoCode', mapping: 'promoCode'},
			{name: 'promoDescription', mapping: 'promoDescription'},
			{name: 'productID', mapping: 'productID'},
			{name: 'productName', mapping: 'productName'},
			{name: 'status', mapping: 'status'},
			{name: 'statusName', mapping: 'statusName'},
			{name: 'maxCount', mapping: 'maxCount'},
			{name: 'Price', mapping: 'Price'},
			{name: 'ProdURL', mapping: 'ProdURL'}
		 	])
			
		 });			

	offlinepromostore.load();

	
	offlinepromosGridView = new Ext.grid.GridView({
		getRowClass : function (row, index) {
			var cls = '';
			var data = row.data;

			switch (data.Status) {
				case '0':
					cls = 'DataGridYellow';
					break;
				case '2':
					cls = 'DataGridOrange';
					break;
				case '3':
					cls = 'DataGridRed';
					break;
				default:
					cls = '';
					break;
			}
			return cls;
		}
		});	
	
	// pluggable renders
    function renderpromoqrcode(value, p, record){
        return '<img src="http://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=' + record.data.ProdURL + '" width="75" height="75">';
    }
    
    
	var offlinepromolist = new Ext.grid.GridPanel({
	    store: offlinepromostore,
	    columns: [
	        {header: "QR", wwidth: 120, sortable: false, dataIndex: 'ProdURL', renderer: renderpromoqrcode},
	        {header: "Promo Code", width: 120, sortable: true, dataIndex: 'promoCode'},
            {id: 'offlinepromogrid2', header: "Description", width: 150, sortable: true, dataIndex: 'promoDescription'},
            {header: "Product", width: 150, sortable: true, dataIndex: 'productName'},
            {header: "Price", width: 150, sortable: true, dataIndex: 'Price'},
            {header: "Max Count", width: 80, sortable: true, dataIndex: 'maxCount'},
            {header: "Status", width: 80, sortable: true, dataIndex: 'statusName'}
	        ],
		autoExpandColumn: 'offlinepromogrid2',
		view: offlinepromosGridView,
	    title:'Offline Promos',
	    layout: 'fit',
	    monitorResize: true,
        autoScroll: true,
        //autoHeight: true,
        tbar:[{
			xtype:'tbbutton',
			text: 'Add New Promotion',
			cls: 'x-btn-text-icon bmenu',
			icon: '/rap_admin/addons/GIS/paymentpro/images/add.png',
			listeners: {
				click: function() { 
        	NewOfflinePromoWindow();
				}
			}
		},{
			xtype:'tbseparator'
		},{
			text: 'View:'
		},{
				xtype: 'combo',
				id: 'offlinepromoStatussearch',			
				name: 'offlinepromoStatussearch',
				mode: 'local',
				width: 200,
				value: '1',
				valueField: 'Index',
				store: GiftCardStatusstore,
				displayField:'Description',
				selectOnFocus: true,
				editable: false,
				forceSelection: true,
				triggerAction: 'all',
				listeners: {
	    			select: function() { 
						offlinepromostore.reload({
							params: {
								Keywords: Ext.getCmp('OfflinepromoListKeywords').getValue(),
								Status: Ext.getCmp('offlinepromoStatussearch').getValue()
						}});
						}
	  				}
			},{
				xtype:'tbseparator'
			},{
				xtype: 'label',
				text: 'Search:'
			},{
			xtype: 'textfield',
			name: 'OfflinepromoListKeywords',
			width: 200,				
			id: 'OfflinepromoListKeywords',
			listeners: {
				specialkey: function(field, e) {
					if (e.getKey() == 13) {
						Ext.getCmp('offlinepromotoolbarclearbutton').enable();
						offlinepromostore.reload({
							params: {
								Keywords: Ext.getCmp('OfflinepromoListKeywords').getValue(),
								Status: Ext.getCmp('offlinepromoStatussearch').getValue()
							}});
						}
					}
				}
			},{
				xtype:'tbbutton',
				//text: 'Search',
				id: 'offlinepromotoolbarclearbutton',
				cls: 'x-btn-text-icon bmenu',
				icon: '/rap_admin/addons/GIS/paymentpro/images/block.png',
				disabled: true,
				listeners: {
	    			click: function() { 
						Ext.getCmp('OfflinepromoListKeywords').setValue('');
						Ext.getCmp('offlinepromotoolbarclearbutton').disable();
						offlinepromostore.reload();
					}
				}
			},{
				xtype:'tbbutton',
				text: 'Search',
				cls: 'x-btn-text-icon bmenu',
				icon: '/rap_admin/addons/GIS/paymentpro/images/search.png',
				listeners: {
	    			click: function() { 
						Ext.getCmp('offlinepromotoolbarclearbutton').enable();
						offlinepromostore.reload({
							params: {
								Keywords: Ext.getCmp('OfflinepromoListKeywords').getValue(),
								Status: Ext.getCmp('offlinepromoStatussearch').getValue()
					}});
					}
				}
			},'-',{
				xtype: 'tbfill'
			},{
				xtype: 'tbbutton',
				text: 'Help',
				name: 'ReactiveHelp',
				icon: '/rap_admin/addons/GIS/paymentpro/images/help.png',
				listeners: {
			    	click: function() { 
						DrawMarrWikiWindow(landingtabs, "wiki: BigFix Status");							
						}
	  				}			
			}
		]
	    });


	offlinepromoMenu = new Ext.menu.Menu({
		items : [
			new Ext.menu.Item({
				cls			: 'x-btn-text-icon bmenu', // icon and text class
				pressed		: false,
				enableToggle: false,
				text		: 'Offline Promo Details',
				tooltip		: 'Edit the options for this Offline Promo.',
				icon		: '/rap_admin/addons/GIS/paymentpro/images/package.png',
				scope		: this,
				handler		: function () {
					var ds = productgrid.getStore();
					var record = ds.getAt(SelectedRow);
					offlinepromoDetailWindow(record.get('id'));
				}
			}),'-',
			new Ext.menu.Item({
				cls			: 'x-btn-text-icon bmenu', // icon and text class
				pressed		: false,
				enableToggle: false,
				text		: 'Promos List Help',
				tooltip		: 'View Help about using the Promos list.',
				icon		: '/rap_admin/addons/GIS/paymentpro/images/help.png',
				scope		: this,
				handler		: function () {
					DrawMarrWikiWindow('', "PaymentsPro: Promos List");
				}
			})
							]
													
				});	
					
	offlinepromolist.on('rowcontextmenu', function(grid, rowIndex, e){
		
			e.stopEvent(); // Stops the browser context menu from showing.
			
			SelectedRow = rowIndex;
			offlinepromoMenu.showAt(e.getXY());
		});
	
	offlinepromolist.on('rowdblclick', function(grid, rowIndex, e){
		
		e.stopEvent(); // Stops the browser context menu from showing.
		
		var ds = productgrid.getStore();
		var record = ds.getAt(rowIndex);
		offlinepromoDetailWindow(record.get('id'));
	});

