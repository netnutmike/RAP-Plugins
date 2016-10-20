/**
 * @author Mike Myers
 */

var offlinepromoDetailWin;
var gPromoID;
var CPURL;

	editofflinepromo = new Ext.FormPanel({
		layout: 'form',
		border: false,
		title: "Gift Card Settings",
		style: 'margin-left:20px; margin-top:20px; margin-bottom:20px',
		reader: new Ext.data.JsonReader({root: 'offlinepromo',	totalProperty: 'totalCount'}, [
		        {name: 'uid', mapping: 'uid'},
		        {name: 'promoCode', mapping: 'promoCode'},
		        {name: 'promoDescription', mapping: 'promoDescription'},
				{name: 'productID', mapping: 'productID'},
				{name: 'status', mapping: 'status'},
				{name: 'maxCount', mapping: 'maxCount'},
				{name: 'Price', mapping: 'Price'},
				{name: 'ProdURL', mapping: 'ProdURL'}
				]),
		items: [{
		    xtype:'fieldset',
		    title: 'Promotion Information',
		    autoHeight:true,
		    width: 500,
			defaultType: 'textfield',
			items :[{
				xtype: 'panel',
				layout:'column',
				border: false,
				//style:'border-style: none;',
				items:[{
					columnWidth: 0.65,
					border:false,
					layout: 'form',
					items:[{
						xtype:'textfield',
						fieldLabel: 'Promo Code',
						name: 'promoCode',
						width: 180
					},{
						xtype:'textarea',
						fieldLabel: 'Promo Description',
						name: 'promoDescription',
						width: 180
					},{
						xtype: 'combo',
						name: 'status',
						mode: 'local',
						fieldLabel: 'Status',
						width: 80,
						hiddenName: 'status',
						valueField: 'Index',
						displayField:'Description',
						store: PromoStatusstore,					
						selectOnFocus: true,
						editable: false,
						forceSelection: true,
						triggerAction: 'all',
						width: 180
					},{
						xtype:'textarea',
						name: 'ProdURL',
						readOnly: true,
						fieldLabel: 'Promo URL',
						width: 180,
						id: 'ProdURLid'
					}]},
					{
						columnWidth: 0.35,
						border:false,
						layout: 'form',
						items:[{
							xtype: 'label',
							html: '<img src="http://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=' + CPURL + '" width="150" height="150" valign="top">',
							id: 'xqrimageid'
						}
						]
					}]
				}]
			},{
		    xtype:'fieldset',
		    title: 'Product Details',
		    autoHeight:true,
		    width: 500,
			items :[{
				xtype: 'combo',
				name: 'productID',
				mode: 'local',
				fieldLabel: 'Product',
				width: 80,
				hiddenName: 'productID',
				valueField: 'id',
				displayField:'ProductName',
				store: ProductListstore,					
				selectOnFocus: true,
				editable: false,
				forceSelection: true,
				triggerAction: 'all',
				width: 180
			},{
				xtype:'textfield',
				fieldLabel: 'Price',
				name: 'Price',
				anchor:'95%'
			},{
				xtype:'textfield',
				fieldLabel: 'Max Purchases',
				name: 'maxCount',
				anchor:'95%'
			}]}]});
	
var offlinepromoActivitystore = new Ext.data.Store({			

	url: '/rap_admin/addons/GIS/paymentpro/data/getjson.php',
	baseParams:{Refunded: "999", dataset: "offlinepromosales", SessionID: SessionID},

	reader: new Ext.data.JsonReader({root: 'offlinepromosales',	totalProperty: 'totalCount'}, [
	      {name: 'uid', mapping: 'uid'},
	      {name: 'TransactionID', mapping: 'TransactionID'},
	      {name: 'DateTime', mapping: 'DateTime'},
	      {name: 'ProductID', mapping: 'ProductID'},
	      {name: 'ProductName', mapping: 'ProductName'},
	      {name: 'PurchaseAmount', mapping: 'PurchaseAmount'},
	      {name: 'GiftAmount', mapping: 'GiftAmount'},
	      {name: 'Status', mapping: 'Status'},
	      {name: 'StatusName', mapping: 'StatusName'}
	      ])

});			 		

offlinepromoActivityMenu = new Ext.menu.Menu({
	items : [
		new Ext.menu.Item({
			cls			: 'x-btn-text-icon bmenu', // icon and text class
			pressed		: false,
			enableToggle: false,
			text		: 'View Sales Record Detail',
			tooltip		: 'View The Sales Record Detail',
			icon		: '/images/shopping_cart.png',
			scope		: this,
			handler		: function () {
				var ds = offlinepromoActivity.getStore();
				var record = ds.getAt(SelectedRow);
				SalesDetailWindow(record.get('uid'));
			}
		}),'-',
		new Ext.menu.Item({
			cls			: 'x-btn-text-icon bmenu', // icon and text class
			pressed		: false,
			enableToggle: false,
			text		: 'Sales List Help',
			tooltip		: 'View Help about using the Offline Promo Sales List.',
			icon		: '/images/help_balloon.png',
			scope		: this,
			handler		: function () {
				DrawMarrWikiWindow(landingtabs, "iDavi: Product Details Sales List");
			}
		})
	]
									
});	
	

offlinepromoActivityListGridView = new Ext.grid.GridView({
	getRowClass : function (row, index) {
		var cls = '';
		var data = row.data;

		switch (data.Refunded) {
			case '1':
				cls = 'DataGridYellow';
				break;
		
			default:
				cls = '';
				break;
		}
		return cls;
	}
	});	


var offlinepromoActivity = new Ext.grid.GridPanel({
	store: offlinepromoActivitystore,
	view: offlinepromoActivityListGridView,
	columns: [
	          {header: "Date", width: 120, sortable: true, dataIndex: 'DateTime'},
	          {id: 'ProdutNameofflinepromo', header: "Product Name", width: 100, sortable: true, dataIndex: 'ProductName'},
	          {header: "Sale Amount", width: 100, sortable: true, dataIndex: 'PurchaseAmount'},
	          {header: "Gift Amount", width: 100, sortable: true, dataIndex: 'GiftAmount'},
	          {header: "Status", width: 100, sortable: true, dataIndex: 'StatusName'}
	          ],
	autoExpandColumn: 'ProdutNameofflinepromo',
	title:'Promo Sales Details'
});

offlinepromoActivity.on('rowcontextmenu', function(grid, rowIndex, e){
	
	e.stopEvent(); // Stops the browser context menu from showing.
	
	SelectedRow = rowIndex;
	offlinepromoActivityMenu.showAt(e.getXY());
});


offlinepromoActivity.on('rowdblclick', function(grid, rowIndex, e){
	
	e.stopEvent(); // Stops the browser context menu from showing.
	
	var ds = offlinepromoActivity.getStore();
	var record = ds.getAt(rowIndex);
	offlinepromoSalesDetailWindow(record.get('uid'));
});




function doSave()
{

	editproduct.getForm().items.get('prddetfrmSessionID').setValue(SessionID);
	editproduct.getForm().submit({url:'/rap_admin/addons/GIS/paymentpro/data/updateProduct.php', waitMsg:'Saving Data...',
		success: function(form, action) {
			productstore.reload({
				params: {
					Keywords: Ext.getCmp('ProductListKeywords').getValue()
				}
			});
			productDetailWin.hide();
		},
		
        failure: function(form, action){
			switch (action.failureType) {
            case Ext.form.Action.CLIENT_INVALID:
                Ext.Msg.alert('Error', 'Form Validation has Failed, Please check the values in the fields');
                break;
            case Ext.form.Action.CONNECT_FAILURE:
                Ext.Msg.alert('Failure', 'Ajax communication failed');
                break;
            case Ext.form.Action.SERVER_INVALID:
               Ext.Msg.alert('Failure', action.result.msg);
       }

        }

	});
}

function offlinepromoDetailWindow(promoid){
		
	gPromoID = promoid;
	offlinepromoActivitystore.reload({params: {promoid : promoid}});
	
	
	if (!offlinepromoDetailWin) {
		offlinepromoDetailWin = new Ext.Window({
			autoCreate: true,
			animateTarget: 'toolbar',
			shadow: true,
			modal: true,
			constrain: true,
			resizable: false,
			animCollapse: true,
			layout: 'fit',
			width: 560,
			height: 450,
			closeAction: 'hide',
			//plain: true,
			title: 'Offline Promo Details',
			tbar: [{
				
				xtype: 'tbbutton',
				text: 'Save',
				name: 'Save',
				cls: 'x-btn-text-icon bmenu',
				icon: '/rap_admin/addons/GIS/paymentpro/images/save.png',
				listeners: {
	    			click: function() { 
						
							doSave();
						}							
					}
									
				
	},{
		xtype:'tbseparator',
		id: 'editproducttbsep1'
	},{
		xtype:'tbbutton',
		text: 'Cancel',
		cls: 'x-btn-text-icon bmenu',
		icon: '/rap_admin/addons/GIS/paymentpro/images/delete.png',
		listeners: {
			click: function() { 
				offlinepromoDetailWin.hide();
				}
			}
	},{
		xtype:'tbseparator'
	},{
		xtype: 'tbfill'
	},
	{
		xtype:'tbbutton',
		text: 'Help',
		cls: 'x-btn-text-icon bmenu',
		icon: '/rap_admin/addons/GIS/paymentpro/images/help.png',
		listeners: {
			click: function() { 
				DrawMarrWikiWindow(landingtabs, "iDavi: Product Detail Window");
				}
			}
	}
],
		items: [new Ext.TabPanel({
                        border:false,
                        activeTab:0,
                        tabPosition:'top',
                        items:[editofflinepromo,
                               offlinepromoActivity
								]		//end of items in column layout				//end item2,

		})]
		})
		
		editofflinepromo.getForm().load({url:'/rap_admin/addons/GIS/paymentpro/data/getjson.php?uid=' + promoid + '&dataset=offlinepromo&SessionID=' + SessionID, waitMsg:'Loading',
			success: function(form, action) {
				CPURL = Ext.getCmp('ProdURLid').getValue();
				Ext.getCmp('xqrimageid').setText('<img src="http://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=' + Ext.getCmp('ProdURLid').getValue() + '" width="150" height="150" valign="top">',false);
			}
			});	
		
		

		
		offlinepromoDetailWin.show();

		//end of !EditIncidentWin
	} else {
		
		editofflinepromo.getForm().load({url:'/rap_admin/addons/GIS/paymentpro/data/getjson.php?uid=' + promoid + '&dataset=offlinepromo&SessionID=' + SessionID, waitMsg:'Loading',
				success: function(form, action) {
					CPURL = Ext.getCmp('ProdURLid').getValue();
					Ext.getCmp('xqrimageid').setText('<img src="http://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=' + Ext.getCmp('ProdURLid').getValue() + '" width="150" height="150" valign="top">',false);
				}
		});
		
		
		
		offlinepromoDetailWin.show();
	}
	
	
}