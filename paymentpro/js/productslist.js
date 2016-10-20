
	
	var productstore = new Ext.data.Store({			

		url: '/rap_admin/addons/GIS/paymentpro/data/getjson.php',
		baseParams:{dataset: "products", SessionID: SessionID},
				
		reader: new Ext.data.JsonReader({root: 'products',	totalProperty: 'totalCount'}, [
			{name: 'id', mapping: 'id'},
			{name: 'ProductName', mapping: 'ProductName'},
			{name: 'PaymentProcessor', mapping: 'PaymentProcessor'},
			{name: 'PaymentType', mapping: 'PaymentType'},
			{name: 'AutoClickbank', mapping: 'AutoClickbank'},
			{name: 'Status', mapping: 'Status'},
			{name: 'Upsells', mapping: 'Upsells'},
			{name: 'Terms', mapping: 'Terms'}
		 	])
			
		 });			

	productstore.load();

	
	ProductListGridView = new Ext.grid.GridView({
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
	
	var productgrid = new Ext.grid.GridPanel({
	    store: productstore,
	    columns: [
	        {id: 'productgrid2', header: "Product Name", width: 120, sortable: true, dataIndex: 'ProductName'},
            {header: "Payment Processor", width: 150, sortable: true, dataIndex: 'PaymentProcessor'},
            {header: "Payment Type", width: 150, sortable: true, dataIndex: 'PaymentType'},
            {header: "Auto-Clickbank", width: 150, sortable: true, dataIndex: 'AutoClickbank'},
            {header: "Status", width: 80, sortable: true, dataIndex: 'Status'},
            {header: "Upsells", width: 80, sortable: true, dataIndex: 'Upsells'},
            {header: "Terms", width: 120, sortable: true, dataIndex: 'Terms'}
	        ],
		autoExpandColumn: 'productgrid2',
		view: ProductListGridView,
	    title:'Product List',
	    layout: 'fit',
	    monitorResize: true,
        autoScroll: true,
        //autoHeight: true,
        tbar:[{
				xtype: 'label',
				text: 'Search:'
			},{
			xtype: 'textfield',
			name: 'ProductListKeywords',
			width: 200,				
			id: 'ProductListKeywords',
			listeners: {
				specialkey: function(field, e) {
					if (e.getKey() == 13) {
						productstore.reload({
							params: {
								Keywords: Ext.getCmp('ProductListKeywords').getValue()
							}});
						}
					}
				}
			},{
				xtype:'tbbutton',
				//text: 'Search',
				id: 'producttoolbarclearbutton',
				cls: 'x-btn-text-icon bmenu',
				icon: '/rap_admin/addons/GIS/paymentpro/images/block.png',
				disabled: true,
				listeners: {
	    			click: function() { 
						Ext.getCmp('ProductListKeywords').setValue('');
						Ext.getCmp('producttoolbarclearbutton').disable();
						productstore.reload({
							params: {
								Keywords: Ext.getCmp('ProductListKeywords').getValue()
							}});
					}
				}
			},{
				xtype:'tbbutton',
				text: 'Search',
				cls: 'x-btn-text-icon bmenu',
				icon: '/rap_admin/addons/GIS/paymentpro/images/search.png',
				listeners: {
	    			click: function() { 
						Ext.getCmp('producttoolbarclearbutton').enable();
						productstore.reload({
							params: {
								Keywords: Ext.getCmp('ProductListKeywords').getValue()
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
						DrawMarrWikiWindow(landingtabs, "MOSIS: BigFix Status");							
						}
	  				}			
			}
		]
	    });


	productMenu = new Ext.menu.Menu({
		items : [
			new Ext.menu.Item({
				cls			: 'x-btn-text-icon bmenu', // icon and text class
				pressed		: false,
				enableToggle: false,
				text		: 'Edit Product Options',
				tooltip		: 'Edit the payment options for this product.',
				icon		: '/rap_admin/addons/GIS/paymentpro/images/package.png',
				scope		: this,
				handler		: function () {
					var ds = productgrid.getStore();
					var record = ds.getAt(SelectedRow);
					ProductDetailWindow(record.get('id'));
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
					
	productgrid.on('rowcontextmenu', function(grid, rowIndex, e){
		
			e.stopEvent(); // Stops the browser context menu from showing.
			
			SelectedRow = rowIndex;
			productMenu.showAt(e.getXY());
		});
	
	productgrid.on('rowdblclick', function(grid, rowIndex, e){
		
		e.stopEvent(); // Stops the browser context menu from showing.
		
		var ds = productgrid.getStore();
		var record = ds.getAt(rowIndex);
		ProductDetailWindow(record.get('id'));
	});

