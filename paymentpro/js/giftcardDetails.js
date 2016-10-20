/**
 * @author Mike Myers
 */

var giftcardDetailWin;
var gGiftID;

	editgiftcard = new Ext.FormPanel({
		layout: 'form',
		border: false,
		title: "Gift Card Settings",
		style: 'margin-left:20px; margin-top:20px; margin-bottom:20px',
		reader: new Ext.data.JsonReader({root: 'giftcard',	totalProperty: 'totalCount'}, [
		        {name: 'id', mapping: 'uid'},
		        {name: 'GiftID', mapping: 'GiftID'},
		        {name: 'DateCreated', mapping: 'DateCreated'},
				{name: 'DateIssued', mapping: 'DateIssued'},
				{name: 'IssuedToName', mapping: 'IssuedToName'},
				{name: 'Status', mapping: 'Status'},
				{name: 'Balance', mapping: 'Balance'},
				{name: 'DateCompleted', mapping: 'DateCompleted'}
				]),
		items: [{
		    xtype:'fieldset',
		    title: 'Details',
		    autoHeight:true,
		    width: 500,
			defaultType: 'textfield',
			items :[{
				xtype:'textfield',
				fieldLabel: 'Gift ID',
				name: 'GiftID',
				readOnly: true,
				width: 180
			},{
				xtype:'textfield',
				fieldLabel: 'Date Created',
				name: 'DateCreated',
				readOnly: true,
				width: 180
			}]},{
		    xtype:'fieldset',
		    title: 'Issued Information',
		    autoHeight:true,
		    //height: 125,
		    width: 500,
		  //defaults: {
		  //    anchor: '-20' // leave room for error icon
		  //},
			//defaultType: 'textfield',
			items :[{
				xtype:'textfield',
				fieldLabel: 'Issued To',
				name: 'IssuedToName',
				anchor:'95%'
			},{
				xtype:'datefield',
				fieldLabel: 'Issued Date',
				name: 'DateIssued',
				width: 180
				//anchor:'95%'
			}]},{
			    xtype:'fieldset',
			    title: 'Status Details',
			    autoHeight:true,
			    //height: 125,
			    width: 500,
			  
				items :[{
					xtype: 'combo',
					name: 'Status',
					mode: 'local',
					fieldLabel: 'Status',
					width: 80,
					hiddenName: 'Status',
					valueField: 'Value',
					displayField:'Description',
					store: GiftCardStatusstore,					
					selectOnFocus: true,
					editable: false,
					forceSelection: true,
					triggerAction: 'all',
					width: 180
				},{
					xtype:'textfield',
					fieldLabel: 'Balance',
					name: 'Balance',
					readOnly: true,
					width: 180
				},{
					xtype:'textfield',
					fieldLabel: 'Date Completed',
					name: 'DateCompleted',
					readOnly: true,
					width: 180
				}]
	}]});
	
var giftcardActivitystore = new Ext.data.Store({			

	url: '/rap_admin/addons/GIS/paymentpro/data/getjson.php',
	baseParams:{Refunded: "999", dataset: "giftcardsales", SessionID: SessionID},

	reader: new Ext.data.JsonReader({root: 'giftcardsales',	totalProperty: 'totalCount'}, [
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

giftcardActivityMenu = new Ext.menu.Menu({
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
				var ds = giftcardActivity.getStore();
				var record = ds.getAt(SelectedRow);
				SalesDetailWindow(record.get('uid'));
			}
		}),'-',
		new Ext.menu.Item({
			cls			: 'x-btn-text-icon bmenu', // icon and text class
			pressed		: false,
			enableToggle: false,
			text		: 'Sales List Help',
			tooltip		: 'View Help about using the Product Sales List.',
			icon		: '/images/help_balloon.png',
			scope		: this,
			handler		: function () {
				DrawMarrWikiWindow(landingtabs, "iDavi: Product Details Sales List");
			}
		})
	]
									
});	
	

giftcardActivityListGridView = new Ext.grid.GridView({
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


var giftcardActivity = new Ext.grid.GridPanel({
	store: giftcardActivitystore,
	view: giftcardActivityListGridView,
	columns: [
	          {header: "Date", width: 120, sortable: true, dataIndex: 'DateTime'},
	          {id: 'ProdutNameGiftCard', header: "Product Name", width: 100, sortable: true, dataIndex: 'ProductName'},
	          {header: "Sale Amount", width: 100, sortable: true, dataIndex: 'PurchaseAmount'},
	          {header: "Gift Amount", width: 100, sortable: true, dataIndex: 'GiftAmount'},
	          {header: "Status", width: 100, sortable: true, dataIndex: 'StatusName'}
	          ],
	autoExpandColumn: 'ProdutNameGiftCard',
	title:'Gift Card Sales Details'
});

giftcardActivity.on('rowcontextmenu', function(grid, rowIndex, e){
	
	e.stopEvent(); // Stops the browser context menu from showing.
	
	SelectedRow = rowIndex;
	giftcardActivityMenu.showAt(e.getXY());
});


giftcardActivity.on('rowdblclick', function(grid, rowIndex, e){
	
	e.stopEvent(); // Stops the browser context menu from showing.
	
	var ds = giftcardActivity.getStore();
	var record = ds.getAt(rowIndex);
	giftcardSalesDetailWindow(record.get('uid'));
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

function GiftCardDetailWindow(cardid){
		
	gGiftID = cardid;
	giftcardActivitystore.reload({params: {cardid : cardid}});
	
	if (!giftcardDetailWin) {
		giftcardDetailWin = new Ext.Window({
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
			title: 'Gift Card Details',
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
				giftcardDetailWin.hide();
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
                        items:[editgiftcard,
                               giftcardActivity
								]		//end of items in column layout				//end item2,

		})]
		})
		
		editgiftcard.getForm().load({url:'/rap_admin/addons/GIS/paymentpro/data/getjson.php?uid=' + cardid + '&dataset=giftcard&SessionID=' + SessionID, waitMsg:'Loading',
			success: function(form, action) {
				
			}
			});	

		giftcardDetailWin.show();

		//end of !EditIncidentWin
	} else {
		
		editgiftcard.getForm().load({url:'/rap_admin/addons/GIS/paymentpro/data/getjson.php?uid=' + cardid + '&dataset=giftcard&SessionID=' + SessionID, waitMsg:'Loading',
				success: function(form, action) {
				
				}
		});
		
		
		
		giftcardDetailWin.show();
	}
}