
	
	var giftcardstore = new Ext.data.Store({			

		url: '/rap_admin/addons/GIS/paymentpro/data/getjson.php',
		baseParams:{dataset: "giftcardlist", SessionID: SessionID},
				
		reader: new Ext.data.JsonReader({root: 'giftcards',	totalProperty: 'totalCount'}, [
			{name: 'uid', mapping: 'uid'},
			{name: 'giftID', mapping: 'giftID'},
			{name: 'dateCreated', mapping: 'dateCreated'},
			{name: 'dateIssued', mapping: 'dateIssued'},
			{name: 'issuedToName', mapping: 'issuedToName'},
			{name: 'status', mapping: 'status'},
			{name: 'statusName', mapping: 'statusName'},
			{name: 'balance', mapping: 'balance'},
			{name: 'sales', mapping: 'sales'},
			{name: 'dateCompleted', mapping: 'dateCompleted'},
			{name: 'initialBalance', mapping: 'initialBalance'}
		 	])
			
		 });			

	giftcardstore.load();
	
	GiftCardsGridView = new Ext.grid.GridView({
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
	
	var giftcardlist = new Ext.grid.GridPanel({
	    store: giftcardstore,
	    columns: [
	        {id: 'giftcardgrid2', header: "Gift Card #", width: 120, sortable: true, dataIndex: 'giftID'},
            {header: "Issued To", width: 150, sortable: true, dataIndex: 'issuedToName'},
            {header: "Date Created", width: 150, sortable: true, dataIndex: 'dateCreated'},
            {header: "Date Issued", width: 150, sortable: true, dataIndex: 'dateIssued'},
            {header: "Initial Balance", width: 80, sortable: true, dataIndex: 'initialBalance'},
            {header: "Balance", width: 80, sortable: true, dataIndex: 'balance'},
            {header: "Status", width: 80, sortable: true, dataIndex: 'statusName'},
            {header: "Sales", width: 120, sortable: true, dataIndex: 'sales'},
            {header: "Date Completed", width: 120, sortable: true, dataIndex: 'dateCompleted'},
	        ],
		autoExpandColumn: 'giftcardgrid2',
		view: GiftCardsGridView,
	    title:'Gift Cards',
	    layout: 'fit',
	    monitorResize: true,
        autoScroll: true,
        autoHeight: true,
        tbar:[{
			xtype:'tbbutton',
			text: 'Add Gift Card',
			cls: 'x-btn-text-icon bmenu',
			icon: '/rap_admin/addons/GIS/paymentpro/images/add.png',
			listeners: {
				click: function() { 
        			NewGiftCardWindow();
				}
			}
		},{
			xtype:'tbseparator'
		},{
			xtype:'tbbutton',
			text: 'Add Multiple Gift Cards',
			cls: 'x-btn-text-icon bmenu',
			icon: '/rap_admin/addons/GIS/paymentpro/images/add.png',
			listeners: {
				click: function() { 
					NewGiftCardsWindow();
				}
			}
		},{
			xtype:'tbseparator'
		},{
			text: 'View:'
		},{
				xtype: 'combo',
				id: 'giftcardStatussearch',			
				name: 'giftcardStatussearch',
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
						giftcardstore.reload({
							params: {
								Keywords: Ext.getCmp('GiftcardListKeywords').getValue(),
								Status: Ext.getCmp('giftcardStatussearch').getValue(),
								Value: Ext.getCmp('GiftValueSearch').getValue()
						}});
						}
	  				}
			},{
				xtype:'tbseparator'
			},{
					xtype: 'combo',
					id: 'GiftValueSearch',			
					name: 'GiftValueSearch',
					mode: 'local',
					width: 100,
					//value: '______',
					valueField: 'Value',
					store: giftvaluestore,
					displayField:'Display',
					selectOnFocus: true,
					editable: false,
					forceSelection: true,
					triggerAction: 'all',
					listeners: {
		    			select: function() { 
							giftcardstore.reload({
								params: {
									Keywords: Ext.getCmp('GiftcardListKeywords').getValue(),
									Status: Ext.getCmp('giftcardStatussearch').getValue(),
									Value: Ext.getCmp('GiftValueSearch').getValue()
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
			name: 'GiftcardListKeywords',
			width: 200,				
			id: 'GiftcardListKeywords',
			listeners: {
				specialkey: function(field, e) {
					if (e.getKey() == 13) {
						giftcardstore.reload({
							params: {
								Keywords: Ext.getCmp('GiftcardListKeywords').getValue(),
								Status: Ext.getCmp('giftcardStatussearch').getValue(),
								Value: Ext.getCmp('GiftValueSearch').getValue()
							}});
						}
					}
				}
			},{
				xtype:'tbbutton',
				//text: 'Search',
				id: 'giftcardtoolbarclearbutton',
				cls: 'x-btn-text-icon bmenu',
				icon: '/rap_admin/addons/GIS/paymentpro/images/block.png',
				disabled: true,
				listeners: {
	    			click: function() { 
						Ext.getCmp('GiftcardListKeywords').setValue('');
						Ext.getCmp('giftcardtoolbarclearbutton').disable();
						giftcardstore.reload();
					}
				}
			},{
				xtype:'tbbutton',
				text: 'Search',
				cls: 'x-btn-text-icon bmenu',
				icon: '/rap_admin/addons/GIS/paymentpro/images/search.png',
				listeners: {
	    			click: function() { 
						Ext.getCmp('giftcardtoolbarclearbutton').enable();
						giftcardstore.reload({
							params: {
								Keywords: Ext.getCmp('GiftcardListKeywords').getValue(),
								Status: Ext.getCmp('giftcardStatussearch').getValue(),
								Value: Ext.getCmp('GiftValueSearch').getValue()
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


	giftcardMenu = new Ext.menu.Menu({ 
		items : [
			new Ext.menu.Item({
				cls			: 'x-btn-text-icon bmenu', // icon and text class
				pressed		: false,
				enableToggle: false,
				text		: 'Gift Card Options',
				tooltip		: 'Edit the options for this Gift Card.',
				icon		: '/rap_admin/addons/GIS/paymentpro/images/package.png',
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
				text		: 'Edit Products List Help',
				tooltip		: 'View Help about using the edit products list.',
				icon		: '/rap_admin/addons/GIS/paymentpro/images/help.png',
				scope		: this,
				handler		: function () {
					DrawMarrWikiWindow('', "PaymentsPro: product list");
				}
			})
							]
													
				});	
					
	giftcardlist.on('rowcontextmenu', function(grid, rowIndex, e){
		
			e.stopEvent(); // Stops the browser context menu from showing.
			
			SelectedRow = rowIndex;
			giftcardMenu.showAt(e.getXY());
		});
	
	giftcardlist.on('rowdblclick', function(grid, rowIndex, e){
		
		e.stopEvent(); // Stops the browser context menu from showing.
		
		var ds = giftcardlist.getStore();
		var record = ds.getAt(rowIndex);
		GiftCardDetailWindow(record.get('uid'));
	});

