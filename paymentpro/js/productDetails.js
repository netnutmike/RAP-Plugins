/**
 * @author Mike Myers
 */

var productDetailWin;
var gProductID;

	var ProcessorList = [
                     ['Paypal','0'],
                     ['Alert Pay','1'],
                     ['Authorize.net','2'],
                     ['Clickbank','3']
                 ];		
             	
	// create the data store
	var ProcessorStore = new Ext.data.SimpleStore({
                     fields: [
                        {name: 'Description'},
                        {name: 'Index'}
                     ]
                 });
	ProcessorStore.loadData(ProcessorList);
	
	var CommissionMethodList = [
                     ['Instant','0'],
                     ['Mass Pay','1'],
                     ['Merchant','2']
                 ];		
             	
	// create the data store
	var CommissionMethodStore = new Ext.data.SimpleStore({
                     fields: [
                        {name: 'Description'},
                        {name: 'Index'}
                     ]
                 });
	CommissionMethodStore.loadData(CommissionMethodList);
	
	var MethodList = [
                     ['Alternate (Traditional)','1'],
                     ['Split Payments','2'],
                     ['Chained Payments','3']
                 ];		
             	
	// create the data store
	var MethodStore = new Ext.data.SimpleStore({
                     fields: [
                        {name: 'Description'},
                        {name: 'Index'}
                     ]
                 });
	MethodStore.loadData(MethodList);
	
	var EntryTypeList = [
	                     ['One-Time','1'],
	                     ['Recurring','2']
	                 ];		
	             	
	// create the data store
	var EntryTypestore = new Ext.data.SimpleStore({
	                     fields: [
	                        {name: 'Description'},
	                        {name: 'Index'}
	                     ]
	                 });
	EntryTypestore.loadData(EntryTypeList);
	
	var ClickbankList = [
	                     ['Yes','1'],
	                     ['No','2']
	                 ];		
	             	
	// create the data store
	var Clickbankstore = new Ext.data.SimpleStore({
	                     fields: [
	                        {name: 'Description'},
	                        {name: 'Index'}
	                     ]
	                 });
	Clickbankstore.loadData(ClickbankList);
	
	var BillLengthList = [
	                     ['Days','D'],
	                     ['Weeks','W'],
	                     ['Months','M'],
	                     ['Years','Y']
	                 ];		
	             	
	// create the data store
	var BillLengthstore = new Ext.data.SimpleStore({
	                     fields: [
	                        {name: 'Description'},
	                        {name: 'Index'}
	                     ]
	                 });
	BillLengthstore.loadData(BillLengthList);
 
	var productUpsalesstore = new Ext.data.Store({			

		url: '/rap_admin/addons/GIS/paymentpro/data/getjson.php',
		baseParams:{ProductID: "999", dataset: "productupsells", SessionID: SessionID},
	
		reader: new Ext.data.JsonReader({root: 'upsells',	totalProperty: 'totalCount'}, [
		      {name: 'uid', mapping: 'uid'},
		      {name: 'productID', mapping: 'productID'},
		      {name: 'Name', mapping: 'Name'},
		      {name: 'Status', mapping: 'Status'},
		      {name: 'StatusName', mapping: 'StatusName'},
		      {name: 'Price', mapping: 'Price'},
		      {name: 'AttachedProduct', mapping: 'AttachedProduct'},
		      {name: 'AttachedProductName', mapping: 'AttachedProductName'},
		      {name: 'AttachedAction', mapping: 'AttachedAction'},
		      {name: 'Amount', mapping: 'Amount'}
		      ])
	
	});			 		

	productUpsellsMenu = new Ext.menu.Menu({
		items : [
			new Ext.menu.Item({
				cls			: 'x-btn-text-icon bmenu', // icon and text class
				pressed		: false,
				enableToggle: false,
				text		: 'Edit Upsell Detail',
				tooltip		: 'Edit The Upsell Detail',
				icon		: '/images/edit.png',
				scope		: this,
				handler		: function () {
					var ds = productSalesGrid.getStore();
					var record = ds.getAt(SelectedRow);
					editupsellWindow(record.get('uid'));
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
	

	productUpsellsGridView = new Ext.grid.GridView({
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


	var productUpsellsGrid = new Ext.grid.GridPanel({
		store: productUpsalesstore,
		view: productUpsellsGridView,
		columns: [
		          {id: 'Produtupsellname', header: "Name", width: 100, sortable: true, dataIndex: 'Name'},
		          {header: "Action", width: 150, sortable: true, dataIndex: 'AttachedAction'},
		          {header: "Product", width: 150, sortable: true, dataIndex: 'AttachedProductName'},
		          {header: "Price", width: 100, sortable: true, dataIndex: 'Price'},
		          {header: "Amount", width: 70, sortable: true, dataIndex: 'Amount'},
		          {header: "Status", width: 70, sortable: true, dataIndex: 'StatusName'}
		          ],
		autoExpandColumn: 'Produtupsellname',
		title:'Upsales List',
		autoHeight: true,
        tbar:[{
				xtype:'tbbutton',
				text: 'Add Upsell',
				cls: 'x-btn-text-icon bmenu',
				icon: '/rap_admin/addons/GIS/paymentpro/images/add.png',
				listeners: {
					click: function() { 
	        			newupsellWindow();
					}
				}
			},{
				xtype:'tbseparator'
			},{
				xtype: 'tbfill'
			}]
		});
	
	productUpsellsGrid.on('rowcontextmenu', function(grid, rowIndex, e){
		
		e.stopEvent(); // Stops the browser context menu from showing.
		
		SelectedRow = rowIndex;
		productUpsellsMenu.showAt(e.getXY());
	});
	
	
	productUpsellsGrid.on('rowdblclick', function(grid, rowIndex, e){
		
		e.stopEvent(); // Stops the browser context menu from showing.
		
		var ds = productUpsellsGrid.getStore();
		var record = ds.getAt(rowIndex);
		editupsellWindow(record.get('uid'));
	});


	editproduct = new Ext.FormPanel({
		layout: 'form',
		border: false,
		title: "Product Payment/Commission Setup",
		//style: 'margin-left:20px; margin-top:20px; margin-bottom:20px',
		reader: new Ext.data.JsonReader({root: 'product',	totalProperty: 'totalCount'}, [
		        {name: 'id', mapping: 'id'},
		        {name: 'EntryType', mapping: 'EntryType'},
		        {name: 'IsOTO', mapping: 'IsOTO'},
				{name: 'ProductName', mapping: 'ProductName'},
				{name: 'Price', mapping: 'Price'},
				{name: 'PaymentProcessor', mapping: 'PaymentProcessor'},
				{name: 'PaymentType', mapping: 'PaymentType'},
				{name: 'PaymentMethod', mapping: 'PaymentMethod'},
				{name: 'CommissionType', mapping: 'CommissionType'},
				{name: 'AutoClickbank', mapping: 'AutoClickbank'},
				{name: 'Status', mapping: 'Status'},
				{name: 'item_name', mapping: 'item_name'},
				{name: 'item_price', mapping: 'item_price'},
				{name: 'two_tier', mapping: 'two_tier'},
				{name: 'item_pct', mapping: 'item_pct'},
				{name: 'item_pct2', mapping: 'item_pct2'},
				{name: 'oto_name', mapping: 'oto_name'},
				{name: 'oto_price', mapping: 'oto_price'},
				{name: 'oto_pct', mapping: 'oto_pct'},
				{name: 'oto_pct2', mapping: 'oto_pct2'},
				{name: 'jvcode', mapping: 'jvcode'},
				{name: 'jv_item_pct', mapping: 'jv_item_pct'},
				{name: 'jv_item_pct2', mapping: 'jv_item_pct2'},
				{name: 'jv_oto_pct', mapping: 'jv_oto_pct'},
				{name: 'jv_oto_pct2', mapping: 'jv_oto_pct2'},
				{name: 'a1', mapping: 'a1'},
				{name: 'p1', mapping: 'p1'},
				{name: 't1', mapping: 't1'},
				{name: 'a2', mapping: 'a2'},
				{name: 'p2', mapping: 'p2'},
				{name: 't2', mapping: 't2'},
				{name: 'a3', mapping: 'a3'},
				{name: 'p3', mapping: 'p3'},
				{name: 't3', mapping: 't3'},
				{name: 'src', mapping: 'src'},
				{name: 'sra', mapping: 'sra'},
				{name: 'srt', mapping: 'srt'},
				{name: 'signpmt_subscr_url', mapping: 'signpmt_subscr_url'},
				{name: 'cancel_subscr_url', mapping: 'cancel_subscr_url'},
				{name: 'a1o', mapping: 'a1o'},
				{name: 'p1o', mapping: 'p1o'},
				{name: 't1o', mapping: 't1o'},
				{name: 'a2o', mapping: 'a2o'},
				{name: 'p2o', mapping: 'p2o'},
				{name: 't2o', mapping: 't2o'},
				{name: 'a3o', mapping: 'a3o'},
				{name: 'p3o', mapping: 'p3o'},
				{name: 't3o', mapping: 't3o'},
				{name: 'srco', mapping: 'srco'},
				{name: 'srao', mapping: 'srao'},
				{name: 'srto', mapping: 'srto'},
				{name: 'signpmt_subscr_urlo', mapping: 'signpmt_subscr_urlo'},
				{name: 'cancel_subscr_urlo', mapping: 'cancel_subscr_urlo'},
				{name: 'SignupNotifty', mapping: 'SignupNotifty'},
				{name: 'SignupParameters', mapping: 'SignupParameters'},
				{name: 'CancellationNotifty', mapping: 'CancellationNotifty'},
				{name: 'CancellationParameters', mapping: 'CancellationParameters'}
				]),
		items: [new Ext.TabPanel({
		            border:false,
		            autoHeight: true,
		            activeTab:0,
		            tabPosition:'top',
		            items:[{
		            	style: 'margin-left:20px; margin-top:20px; margin-bottom:20px',
		            	autoHeight: true,
		            	title: 'Product',
						items: [{
						    xtype:'fieldset',
						    title: 'Billing Setup',
						    autoHeight:true,
						    width: 650,
							defaultType: 'textfield',
							items :[{
									xtype:'textfield',
									fieldLabel: 'Product Name',
									name: 'item_name',
									readOnly: true,
									anchor:'95%'
								},{
									xtype:'hidden',
									name: 'id'
								},{
									xtype: 'panel',
									layout:'column',
									border: false,
									style:'border-style: none;',
									items:[{
											columnWidth: 0.50,
											border:false,
											layout: 'form',
											items:[{
												xtype: 'combo',
												name: 'PaymentProcessor',
												id: 'mainproductpaymentprocessor',
												mode: 'local',
												fieldLabel: 'Processor',
												width: 180,
												//value: '0',
												hiddenName: 'PaymentProcessor',
												valueField: 'Index',
												displayField:'Description',
												store: ProcessorStore,					
												selectOnFocus: true,
												editable: false,
												forceSelection: true,
												triggerAction: 'all',
												listeners: {
									    			select: function() { 
														//alert(Ext.getCmp('mainproductpaymenttype').getValue());
														switch (Ext.getCmp('mainproductpaymentprocessor').getValue()) {
															case '1':		//AlertPay
																//Ext.getCmp('mainproductpaymentprocessor').setValue('1');
																//alert('1');
																Ext.getCmp('mainproductpaymentmethod').disable();
																Ext.getCmp('mainproductpaymentmethod').setValue('1');
																Ext.getCmp('mainproductcommissiontype').enable();
																//Ext.getCmp('productrecurringoptions').show();
																//Ext.getCmp('productfreetrialoptions').show();
																Ext.getCmp('mainproductpaymenttype').enable();
																//Ext.getCmp('productnotificationoptions').show();
																Ext.getCmp('freetrial2line').hide();
																
																
																
																break;
																
															case '2':		//authorize.net
																//Ext.getCmp('mainproductpaymentprocessor').setValue('1');
																//alert('1');
																Ext.getCmp('mainproductpaymentmethod').disable();
																Ext.getCmp('mainproductcommissiontype').disable();
																Ext.getCmp('mainproductcommissiontype').setValue('1');
																Ext.getCmp('productrecurringoptions').hide();
																Ext.getCmp('productfreetrialoptions').hide();
																Ext.getCmp('mainproductpaymenttype').disable();
																Ext.getCmp('mainproductpaymenttype').setValue('1');
																Ext.getCmp('productnotificationoptions').hide();
																break;
																
															case '3':		//clickbank
																//Ext.getCmp('mainproductpaymentprocessor').setValue('1');
																//alert('1');
																Ext.getCmp('mainproductpaymentmethod').disable();
																Ext.getCmp('mainproductcommissiontype').disable();
																Ext.getCmp('mainproductcommissiontype').setValue('2');
																Ext.getCmp('productrecurringoptions').hide();
																Ext.getCmp('productfreetrialoptions').hide();
																Ext.getCmp('mainproductpaymenttype').disable();
																Ext.getCmp('mainproductpaymenttype').setValue('1');
																Ext.getCmp('productnotificationoptions').hide();
																break;
																
															default:		//paypal
																//('2');
																Ext.getCmp('mainproductpaymentmethod').enable();
																Ext.getCmp('mainproductcommissiontype').enable();
																//Ext.getCmp('productrecurringoptions').hide();
																//Ext.getCmp('productfreetrialoptions').hide();
																Ext.getCmp('mainproductpaymenttype').enable();
																//Ext.getCmp('productnotificationoptions').hide();
																Ext.getCmp('freetrial2line').show();
																break;
															}
														
														}
									  				}
											}]
										
									},{
											columnWidth: 0.50,
											border:false,
											layout: 'form',
											items:[{
												xtype: 'combo',
												name: 'CommissionType',
												id: 'mainproductcommissiontype',
												mode: 'local',
												fieldLabel: 'Commission Type',
												width: 180,
												//value: '0',
												hiddenName: 'CommissionType',
												valueField: 'Index',
												displayField:'Description',
												store: CommissionMethodStore,					
												selectOnFocus: true,
												editable: false,
												forceSelection: true,
												triggerAction: 'all'
											}]
										}]
									},{
									xtype: 'panel',
									layout:'column',
									border: false,
									style:'border-style: none;',
									items:[{
											columnWidth: 0.50,
											border:false,
											layout: 'form',
											items:[{
												xtype: 'combo',
												name: 'PaymentType',
												id: 'mainproductpaymenttype',
												mode: 'local',
												fieldLabel: 'Payment Type',
												width: 180,
												//value: '0',
												hiddenName: 'PaymentType',
												valueField: 'Index',
												displayField:'Description',
												store: EntryTypestore,					
												selectOnFocus: true,
												editable: false,
												forceSelection: true,
												triggerAction: 'all',
												listeners: {
									    			select: function() { 
														//alert(Ext.getCmp('mainproductpaymenttype').getValue());
														switch (Ext.getCmp('mainproductpaymenttype').getValue()) {
															case '2':		//Recurring
																//Ext.getCmp('mainproductpaymentprocessor').setValue('1');
																//alert('1');
																Ext.getCmp('mainproductpaymentmethod').disable();
																Ext.getCmp('productrecurringoptions').show();
																Ext.getCmp('productfreetrialoptions').show();
																Ext.getCmp('productnotificationoptions').show();
																break;
																
															default:		//one-time
																//('2');
																Ext.getCmp('mainproductpaymentmethod').enable();
																Ext.getCmp('productrecurringoptions').hide();
																Ext.getCmp('productfreetrialoptions').hide();
																Ext.getCmp('productnotificationoptions').hide();
																break;
															}
														
														}
									  				}
											}]
										},{
												columnWidth: 0.50,
												border:false,
												layout: 'form',
												items:[{
													xtype:'textfield',
													name: 'item_price',
													fieldLabel: 'Price',
													anchor:'95%'
											}]
										}]
									},{
										xtype: 'panel',
										layout:'column',
										border: false,
										style:'border-style: none;',
										items:[{
												columnWidth: 0.50,
												border:false,
												layout: 'form',
												items:[{
													xtype: 'combo',
													name: 'PaymentMethod',
													id: 'mainproductpaymentmethod',
													mode: 'local',
													fieldLabel: 'Pay Method',
													width: 180,
													//value: '0',
													hiddenName: 'PaymentMethod',
													valueField: 'Index',
													displayField:'Description',
													store: MethodStore,					
													selectOnFocus: true,
													editable: false,
													forceSelection: true,
													triggerAction: 'all',
													listeners: {
										    			select: function() { 
															switch (Ext.getCmp('mainproductpaymentmethod').getValue()) {
																case '1':		//traditional method
																	//alert('3');
																	Ext.getCmp('mainproductpaymenttype').enable();
																	break;
																	
																default:		//adapative payments
																	//alert('adaptive' + Ext.getCmp('mainproductpaymentmethod').getValue());
																	Ext.getCmp('mainproductpaymenttype').setValue('1');
																	Ext.getCmp('mainproductpaymenttype').disable();
																	break;
																}
															
															}
										  				}
												}]
											},{
												columnWidth: 0.50,
												border:false,
												layout: 'form',
												items:[{
													xtype: 'combo',
													name: 'AutoClickbank',
													mode: 'local',
													fieldLabel: 'Allow Clickbank?',
													width: 180,
													//value: '0',
													hiddenName: 'AutoClickbank',
													valueField: 'Index',
													displayField:'Description',
													store: Clickbankstore,					
													selectOnFocus: true,
													editable: false,
													forceSelection: true,
													triggerAction: 'all'
												}]
											}]
									},{
										xtype: 'panel',
										layout:'column',
										border: false,
										style:'border-style: none;',
										items:[{
												columnWidth: 0.30,
												border:false,
												layout: 'form',
												items:[{
													xtype:'textfield',
													name: 'item_pct',
													fieldLabel: 'Affiliate %',
													anchor:'95%'
												}]
											},{
												columnWidth: 0.30,
												border:false,
												layout: 'form',
												items:[{
													xtype: 'combo',
													name: 'two_tier',
													mode: 'local',
													fieldLabel: '2 Tier?',
													width: 60,
													//value: '0',
													hiddenName: 'two_tier',
													valueField: 'Index',
													displayField:'Description',
													store: YesNostore,					
													selectOnFocus: true,
													editable: false,
													forceSelection: true,
													triggerAction: 'all'
												}]
											},{
												columnWidth: 0.30,
												border:false,
												layout: 'form',
												items:[{
													xtype:'textfield',
													name: 'item_pct2',
													fieldLabel: 'Tier2 %',
													anchor:'95%'
												}]
											}]
									},{
										xtype: 'panel',
										layout:'column',
										border: false,
										style:'border-style: none;',
										items:[{
												columnWidth: 0.30,
												border:false,
												layout: 'form',
												items:[{
													xtype:'textfield',
													name: 'jv_item_pct',
													fieldLabel: 'JV %',
													anchor:'95%'
												}]
											},{
												columnWidth: 0.30,
												border:false,
												layout: 'form',
												items:[{
													xtype:'textfield',
													name: 'jv_item_pct2',
													fieldLabel: 'JV Tier 2 %',
													anchor:'95%'
												}]
											},{
												columnWidth: 0.30,
												border:false,
												layout: 'form',
												items:[{
													xtype:'textfield',
													name: 'jvcode',
													fieldLabel: 'JV Code',
													anchor:'95%'
												}]
											}]
										}]
								},{
								    xtype:'fieldset',
								    title: 'Recurring Options',
								    id: 'productrecurringoptions',
								    autoHeight:true,
								    width: 650,
									items :[{
										xtype: 'panel',
										layout:'column',
										border: false,
										style:'border-style: none;',
										items:[{
												columnWidth: 0.05,
												border:false,
												layout: 'form',
												items:[{
													xtype: 'label', 
													html: '<div class="x-form-item  x-form-item-label">Bill:</div>'
												}]
											},{
												columnWidth: 0.10,
												border:false,
												layout: 'form',
												items:[{
													xtype:'textfield',
													hideLabel: true,
													fieldLabel: 'Bill',
													name: 'a3',
													anchor:'95%'
												}]
											},{
												columnWidth: 0.05,
												border:false,
												layout: 'form',
												items:[{
													xtype: 'label', 
													html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
												}]
											},{
												columnWidth: 0.05,
												border:false,
												layout: 'form',
												items:[{
													xtype: 'label', 
													html: ' <div class="x-form-item  x-form-item-label">Every:</div>   '
												}]
											},{
												columnWidth: 0.10,
												border:false,
												layout: 'form',
												items:[{
													xtype:'textfield',
													fieldLabel: 'Every',
													hideLabel: true,
													name: 'p3',
													anchor:'95%'
												}]
											},{
												columnWidth: 0.15,
												border:false,
												layout: 'form',
												items:[{
													xtype: 'combo',
													name: 't3',
													mode: 'remote',
													hideLabel: true,
													width: 80,
													hiddenName: 't3',
													valueField: 'Index',
													displayField:'Description',
													store: BillLengthstore,					
													selectOnFocus: true,
													editable: false,
													forceSelection: true,
													triggerAction: 'all'
												}]
											},{
												columnWidth: 0.06,
												border:false,
												layout: 'form',
												items:[{
													xtype: 'label', 
													html: '<div class="x-form-item  x-form-item-label">Limit:</div>   '
												}]
											},{
												columnWidth: 0.10,
												border:false,
												layout: 'form',
												items:[{
													xtype:'textfield',
													fieldLabel: 'Every',
													hideLabel: true,
													name: 'srt',
													anchor:'95%'
												}]
											},{
												columnWidth: 0.30,
												border:false,
												layout: 'form',
												items:[{
													xtype: 'label', 
													html: '<div class="x-form-item  x-form-item-label">Payments (0 or blank is infinite)</div>   '
												}]
											}]
										}]
									},{
									    xtype:'fieldset',
									    id: 'productfreetrialoptions',
									    title: 'Free Trial Options (optional)',
									    autoHeight:true,
									    width: 650,
										items :[{
											xtype: 'panel',
											layout:'column',
											border: false,
											style:'border-style: none;',
											items:[{
													columnWidth: 0.15,
													border:false,
													layout: 'form',
													items:[{
														xtype: 'label', 
														html: '<div class="x-form-item  x-form-item-label"><B>Free Trial 1:</b></div>&nbsp;&nbsp;&nbsp;'
													}]
												},{
													columnWidth: 0.10,
													border:false,
													layout: 'form',
													items:[{
														xtype: 'label', 
														html: '<div class="x-form-item  x-form-item-label">Amount: $</div>'
													}]
												},{
													columnWidth: 0.10,
													border:false,
													layout: 'form',
													items:[{
														xtype:'textfield',
														hideLabel: true,
														fieldLabel: 'Bill',
														name: 'a1',
														anchor:'95%'
													}]
												},{
													columnWidth: 0.05,
													border:false,
													layout: 'form',
													items:[{
														xtype: 'label', 
														html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
													}]
												},{
													columnWidth: 0.05,
													border:false,
													layout: 'form',
													items:[{
														xtype: 'label', 
														html: ' <div class="x-form-item  x-form-item-label">For:</div>   '
													}]
												},{
													columnWidth: 0.10,
													border:false,
													layout: 'form',
													items:[{
														xtype:'textfield',
														fieldLabel: 'Every',
														hideLabel: true,
														name: 'p1',
														anchor:'95%'
													}]
												},{
													columnWidth: 0.15,
													border:false,
													layout: 'form',
													items:[{
														xtype: 'combo',
														name: 't1',
														mode: 'local',
														hideLabel: true,
														width: 80,
														hiddenName: 't1',
														valueField: 'Index',
														displayField:'Description',
														store: BillLengthstore,					
														selectOnFocus: true,
														editable: false,
														forceSelection: true,
														triggerAction: 'all'
													}]
												}]
											},{
												xtype: 'panel',
												layout:'column',
												border: false,
												id: 'freetrial2line',
												style:'border-style: none;',
												items:[{
														columnWidth: 0.15,
														border:false,
														layout: 'form',
														items:[{
															xtype: 'label', 
															html: '<div class="x-form-item  x-form-item-label"><B>Free Trial 2:</b></div>&nbsp;&nbsp;&nbsp;'
														}]
													},{
														columnWidth: 0.10,
														border:false,
														layout: 'form',
														items:[{
															xtype: 'label', 
															html: '<div class="x-form-item  x-form-item-label">Amount: $</div>'
														}]
													},{
														columnWidth: 0.10,
														border:false,
														layout: 'form',
														items:[{
															xtype:'textfield',
															hideLabel: true,
															fieldLabel: 'Bill',
															name: 'a2',
															anchor:'95%'
														}]
													},{
														columnWidth: 0.05,
														border:false,
														layout: 'form',
														items:[{
															xtype: 'label', 
															html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
														}]
													},{
														columnWidth: 0.05,
														border:false,
														layout: 'form',
														items:[{
															xtype: 'label', 
															html: ' <div class="x-form-item  x-form-item-label">For:</div>   '
														}]
													},{
														columnWidth: 0.10,
														border:false,
														layout: 'form',
														items:[{
															xtype:'textfield',
															fieldLabel: 'Every',
															hideLabel: true,
															name: 'p2',
															anchor:'95%'
														}]
													},{
														columnWidth: 0.15,
														border:false,
														layout: 'form',
														items:[{
															xtype: 'combo',
															name: 't2',
															mode: 'local',
															hideLabel: true,
															width: 80,
															hiddenName: 't2',
															valueField: 'Index',
															displayField:'Description',
															store: BillLengthstore,					
															selectOnFocus: true,
															editable: false,
															forceSelection: true,
															triggerAction: 'all'
														}]
													}]
												}]
											},{
											    xtype:'fieldset',
											    title: 'Sign-up / Cancellation Notification Options',
											    id: 'productnotificationoptions',
											    width: 650,
												defaultType: 'textfield',
												items :[{
														xtype: 'label', 
														html: ' <div class="x-form-item  x-form-item-label"><b>When a New Subscription Signs up: </b></div>   '
													},{
														xtype: 'panel',
														layout:'column',
														border: false,
														style:'border-style: none;',
														items:[{
																columnWidth: 0.49,
																border:false,
																layout: 'form',
																items:[{
																	xtype:'textfield',
																	fieldLabel: 'Notify URL',
																	readOnly: true,
																	name: 'signpmt_subscr_url',
																	anchor:'98%'
																}]
															},{
																columnWidth: 0.50,
																border:false,
																layout: 'form',
																items:[{
																	xtype:'textfield',
																	fieldLabel: 'Adtl Parameters',
																	readOnly: true,
																	name: 'SignupParameters',
																	anchor:'98%'
																}]
															}]
													},{
														xtype: 'label', 
														html: ' <div class="x-form-item  x-form-item-label"><b>When a Subscription Cancels: </b></div>   '
													},{
														xtype: 'panel',
														layout:'column',
														border: false,
														style:'border-style: none;',
														items:[{
																columnWidth: 0.49,
																border:false,
																layout: 'form',
																items:[{
																	xtype:'textfield',
																	fieldLabel: 'Notify URL',
																	readOnly: true,
																	name: 'cancel_subscr_url',
																	anchor:'98%'
																}]
															},{
																columnWidth: 0.50,
																border:false,
																layout: 'form',
																items:[{
																	xtype:'textfield',
																	fieldLabel: 'Adtl Parameters',
																	readOnly: true,
																	name: 'CancellationParameters',
																	anchor:'98%'
																}]
															}]
														}]
											},{
											    xtype:'fieldset',
											    title: 'Clickbank Options',
											    width: 650,
												defaultType: 'textfield',
												items :[{
													xtype: 'panel',
													layout:'column',
													border: false,
													style:'border-style: none;',
													items:[{
														columnWidth: 0.49,
														border:false,
														layout: 'form',
														items:[{
															xtype:'textfield',
															fieldLabel: 'Order URL',
															readOnly: true,
															name: 'DCDescription',
															anchor:'98%'
														}]
													},{
														columnWidth: 0.50,
														border:false,
														layout: 'form',
														items:[{
															xtype:'textfield',
															fieldLabel: 'Hoplink URL',
															readOnly: true,
															name: 'DCDescription',
															anchor:'98%'
														}]
													}]
												}]
											}]	//end of product tab
		            },{
		            	//style: 'margin-left:20px; margin-top:20px; margin-bottom:20px',
		            	autoHeight: true,
		            	title: 'Upsells',
						items: [productUpsellsGrid]
		            },{
		            	style: 'margin-left:20px; margin-top:20px; margin-bottom:20px',
		            	autoHeight: true,
		            	title: 'Terms',
						items: [{
						 	xtype:'fieldset',
						    title: 'Terms Setup',
						    autoHeight:true,
						    width: 650,
							defaultType: 'textfield',
							items :[{
										xtype:'checkbox',
										name: 'requireterms',
										boxLabel: 'Require Terms',
										anchor:'95%'
								},{
										xtype:'textarea',
										name: 'TermsText',
										fieldLabel: 'Terms',
										height: 500,
										anchor:'95%'
								}]
						}]
		            }]	//end of tabpanel items
			})	//end of tabpanel
		]	//end of items for window
	});	//end of window
	
	

var categorydelete = new Ext.FormPanel({
	layout: 'form',
	border: false,
	items: [
		{
			xtype:'hidden',
			name: 'uid',
			id: 'UIDh1'
		},{
			xtype:'hidden',
			name: 'UserID',
			id: 'categorydeleteUserID'
		},{
			xtype:'hidden',
			name: 'SessionID',
			id: 'categorydeleteSessionID'
		},{
			xtype:'hidden',
			name: 'IsAdmin',
			id: 'categorydeleteIsAdmin'
		}
		]
	});


salesgraphstore = new Ext.data.Store({			

	url: '/rap_admin/addons/GIS/paymentpro/data/getjson.php',
	baseParams:{Size: "Month", Back: "8", dataset: "productsalesgraph", SessionID: SessionID},

	reader: new Ext.data.JsonReader({root: 'graphdata',	totalProperty: 'totalCount'}, [
	      {name: 'Name', mapping: 'Name'},
	      {name: 'Value1', mapping: 'Value1'},
	      {name: 'Value2', mapping: 'Value2'}
	      ])
});			 		

	
var productSalesGraph = new Ext.Panel({
    //iconCls:'chart',
    title: 'Sales Trends',
    frame:true,
    width:500,
    height:300,
    layout:'fit',

    items: {
        xtype: 'linechart',
        store: salesgraphstore,
        url: '/rap_admin/addons/GIS/paymentpro/ext/resources/charts.swf',
        xField: 'Name',
        yField: 'Value1',
        yAxis: new Ext.chart.NumericAxis({
            displayName: 'Sales',
            labelRenderer : Ext.util.Format.numberRenderer('0,0')
        }),
        tipRenderer : function(chart, record){
            return Ext.util.Format.number(record.data.visits, '0,0') + ' sales in ' + record.data.name;
        }
    }
});


membershipgraphstore = new Ext.data.Store({			

	url: '/rap_admin/addons/GIS/paymentpro/data/getjson.php',
	baseParams:{Size: "Month", Back: "8", dataset: "productmembergraph", SessionID: SessionID},

	reader: new Ext.data.JsonReader({root: 'graphdata',	totalProperty: 'totalCount'}, [
	      {name: 'Name', mapping: 'Name'},
	      {name: 'Value1', mapping: 'Value1'},
	      {name: 'Value2', mapping: 'Value2'}
	      ])
});			 		

	
var productMembershipGraph = new Ext.Panel({
    //iconCls:'chart',
    title: 'Membership Trending',
    frame:true,
    width:500,
    height:300,
    layout:'fit',

    items: {
        xtype: 'linechart',
        store: membershipgraphstore,
        url: '/rap_admin/addons/GIS/paymentpro/ext/resources/charts.swf',
        xField: 'Name',
        yField: 'Value1',
        yAxis: new Ext.chart.NumericAxis({
            displayName: 'Sales',
            labelRenderer : Ext.util.Format.numberRenderer('0,0')
        }),
        tipRenderer : function(chart, record){
            return Ext.util.Format.number(record.data.visits, '0,0') + ' sales in ' + record.data.name;
        }
    }
});


var productSalesstore = new Ext.data.Store({			

	url: '/rap_admin/addons/GIS/paymentpro/data/getjson.php',
	baseParams:{Refunded: "999", dataset: "productsales", SessionID: SessionID},

	reader: new Ext.data.JsonReader({root: 'productsales',	totalProperty: 'totalCount'}, [
	      {name: 'uid', mapping: 'uid'},
	      {name: 'TransactionID', mapping: 'TransactionID'},
	      {name: 'Refunded', mapping: 'Refunded'},
	      {name: 'RefundedName', mapping: 'RefundedName'},
	      {name: 'ReceiverEmail', mapping: 'ReceiverEmail'},
	      {name: 'PayerEmail', mapping: 'PayerEmail'},
	      {name: 'PaidToDescription', mapping: 'PaidToDescription'},
	      {name: 'Firstname', mapping: 'Firstname'},
	      {name: 'Lastname', mapping: 'Lastname'},
	      {name: 'Fullname', mapping: 'Fullname'},
	      {name: 'Business', mapping: 'Business'},
	      {name: 'Purchased', mapping: 'Purchased'},
	      {name: 'PaymentAmount', mapping: 'PaymentAmount'},
	      {name: 'DiscountCode', mapping: 'DiscountCode'},
	      {name: 'Expires', mapping: 'Expires'},
	      {name: 'AffiliateID', mapping: 'AffiliateID'},
	      {name: 'AffiliateName', mapping: 'AffiliateName'}
	      ])

});			 		

productSalesMenu = new Ext.menu.Menu({
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
				var ds = productSalesGrid.getStore();
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
	

productDetailsSalesListGridView = new Ext.grid.GridView({
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


var productSalesGrid = new Ext.grid.GridPanel({
	store: productSalesstore,
	view: productDetailsSalesListGridView,
	columns: [
	          {header: "Date", width: 120, sortable: true, dataIndex: 'Purchased'},
	          {id: 'ProdutDetailSalesSoldTo', header: "Sold To", width: 100, sortable: true, dataIndex: 'Fullname'},
	          {header: "Amount", width: 50, sortable: true, dataIndex: 'PaymentAmount'},
	          {header: "Type", width: 50, sortable: true, dataIndex: 'DiscountCode'},
	          {header: "Affiliate Name", width: 100, sortable: true, dataIndex: 'AffiliateName'},
	          {header: "Paid To", width: 70, sortable: true, dataIndex: 'PaidToDescription'},
	          {header: "Status", width: 70, sortable: true, dataIndex: 'RefundedName'}
	          ],
	autoExpandColumn: 'ProdutDetailSalesSoldTo',
	title:'Sales Details'
});

productSalesGrid.on('rowcontextmenu', function(grid, rowIndex, e){
	
	e.stopEvent(); // Stops the browser context menu from showing.
	
	SelectedRow = rowIndex;
	productSalesMenu.showAt(e.getXY());
});


productSalesGrid.on('rowdblclick', function(grid, rowIndex, e){
	
	e.stopEvent(); // Stops the browser context menu from showing.
	
	var ds = productSalesGrid.getStore();
	var record = ds.getAt(rowIndex);
	SalesDetailWindow(record.get('uid'));
});




function doproddetSave()
{
	//editproduct.getForm().items.get('prddetfrmSessionID').setValue(SessionID);
	editproduct.getForm().submit({url:'/rap_admin/addons/GIS/paymentpro/data/updateproduct.php', waitMsg:'Saving Data...',
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

function ProductDetailWindow(productid){
		
	gProductID = productid;
	productSalesstore.reload({params: {ProductID : productid}});
	membershipgraphstore.reload({params: {ProductID : productid}});
	salesgraphstore.reload({params: {ProductID : productid}});
	productUpsalesstore.reload({params: {ProductID : productid}});
	
	if (!productDetailWin) {
		productDetailWin = new Ext.Window({
			autoCreate: true,
			animateTarget: 'toolbar',
			shadow: true,
			modal: true,
			constrain: true,
			resizable: false,
			animCollapse: true,
			layout: 'fit',
			width: 700,
			height: 720,
			closeAction: 'hide',
			//plain: true,
			title: 'Product Pricing, Payment and Commission Details',
			tbar: [{
				
				xtype: 'tbbutton',
				id: 'editproductdetailsave',
				text: 'Save',
				name: 'Save',
				cls: 'x-btn-text-icon bmenu',
				icon: '/rap_admin/addons/GIS/paymentpro/images/save.png',
				listeners: {
	    			click: function() { 
						
							doproddetSave();
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
				productDetailWin.hide();
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
                        items:[editproduct,
                               productMembershipGraph,
                               productSalesGraph,
                               productSalesGrid
								]		//end of items in column layout				//end item2,

		})]
		})
		
		editproduct.getForm().load({url:'/rap_admin/addons/GIS/paymentpro/data/getjson.php?uid=' + productid + '&dataset=product&SessionID=' + SessionID, waitMsg:'Loading',
			success: function(form, action) {
				
			}
			});	
		
		

		
		productDetailWin.show();

		//end of !EditIncidentWin
	} else {
		
		editproduct.getForm().load({url:'/rap_admin/addons/GIS/paymentpro/data/getjson.php?uid=' + productid + '&dataset=product&SessionID=' + SessionID, waitMsg:'Loading',
				success: function(form, action) {
				
				}
		});
		
		
		
		productDetailWin.show();
	}
}