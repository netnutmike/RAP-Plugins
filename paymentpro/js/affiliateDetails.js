/**
 * @author Mike Myers
 */

var affiliateDetailWin;
var gAffiliateID;

editaffiliate = new Ext.FormPanel({
	layout: 'form',
	border: false,
	title: "Affiliate Information",
	style: 'margin-left:20px; margin-top:20px; margin-bottom:20px',
	reader: new Ext.data.JsonReader({root: 'affiliate',	totalProperty: 'totalCount'}, [
	        {name: 'uid', mapping: 'uid'},
			{name: 'Name', mapping: 'Name'},
			{name: 'EmailAddress', mapping: 'EmailAddress'},
			{name: 'Nickname', mapping: 'Nickname'},
			{name: 'PaypalEmailAddress', mapping: 'PaypalEmailAddress'},
			{name: 'Type', mapping: 'Type'},
			{name: 'TypeName', mapping: 'TypeName'},
			{name: 'DateAdded', mapping: 'DateAdded'},
			{name: 'LastLogin', mapping: 'LastLogin'},
			{name: 'Notifications', mapping: 'Notifications'},
			{name: 'Status', mapping: 'Status'},
			{name: 'StatusName', mapping: 'StatusName'},
			{name: 'TOSVersion', mapping: 'TOSVersion'},
			{name: 'SubLoginOf', mapping: 'SubLoginOf'},
			{name: 'SubLoginOfDesc', mapping: 'SubLoginOfDesc'} ]),
	items: [{
	    xtype:'fieldset',
	    title: 'Details',
	    autoHeight:true,
	    width: 500,
		defaultType: 'textfield',
		items :[{
			xtype:'textfield',
			fieldLabel: 'Affiliate Name',
			name: 'Name',
			readOnly: true,
			anchor:'95%'
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
					xtype:'textfield',
					fieldLabel: 'Nickname',
					readOnly: true,
					name: 'Nickname',
					anchor:'95%'
				}]}]
		},{
			xtype:'textfield',
			fieldLabel: 'Contact Email',
			name: 'EmailAddress',
			readOnly: true,
			anchor:'95%'
		},{
			xtype:'textfield',
			fieldLabel: 'Paypal Email',
			name: 'PaypalEmailAddress',
			readOnly: true,
			anchor:'95%'
		},{
		xtype:'hidden',
		name: 'uid'
		//value: incidentid
	},{
		xtype:'hidden',
		name: 'UserID',
		id: 'affdetfrmUserID'
	},{
		xtype:'hidden',
		name: 'SessionID',
		id: 'affdetfrmSessionID'
	},{
		xtype:'hidden',
		name: 'IsAdmin',
		id: 'affdetfrmIsAdmin'
	},{
		xtype: 'combo',
		name: 'Status',
		mode: 'remote',
		fieldLabel: 'Status',
		width: 180,
		//value: '0',
		hiddenName: 'Status',
		valueField: 'Value',
		displayField:'Description',
		store: AffiliateStatusstore,					
		selectOnFocus: true,
		editable: false,
		forceSelection: true,
		triggerAction: 'all'
	}]},
	{
	    xtype:'fieldset',
	    title: 'Account',
	    width: 500,
		defaultType: 'textfield',
		items :[{
			xtype: 'panel',
			layout:'column',
			border: false,
			style:'border-style: none;',
			items:[{
				columnWidth: 0.50,
				border:false,
				layout: 'form',
				items:[{
					xtype:'textfield',
					readOnly: true,
					fieldLabel: 'Last Login',
					name: 'LastLogin',
					anchor:'95%'
				}]},
				{
					columnWidth: 0.50,
					border:false,
					layout: 'form',
					items:[{
						xtype:'textfield',
						readOnly: true,
						fieldLabel: 'Date Added',
						name: 'DateAdded',
						anchor:'95%'
					}
					]
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
					xtype: 'textfield',
					fieldLabel: 'Type',
					readOnly: true,
					name: 'TypeName',
					//disabled: true,
					anchor:'95%'
				}]},
				{
					columnWidth: 0.50,
					border:false,
					layout: 'form',
					items:[{
						xtype: 'textfield',
						fieldLabel: 'TOS Version',
						readOnly: true,
						//disabled: true,
						name: 'TOSVersion',
						anchor:'95%'
					}
					]
				}]
		},{
			xtype:'textfield',
			//hideLabel: true,
			fieldLabel: 'Sub-account of',
			readOnly: true,
			name: 'SubLoginOfDesc',
			anchor:'100%'
		}]
	}
	
	]
})



affiliatesalesgraphstore = new Ext.data.Store({			

	url: '/data/getjson.php',
	baseParams:{Size: "Month", Back: "8", dataset: "affiliatesalesgraph", SessionID: SessionID, UserID:Login, IsAdmin:IsAdmin},

	reader: new Ext.data.JsonReader({root: 'graphdata',	totalProperty: 'totalCount'}, [
	      {name: 'Name', mapping: 'Name'},
	      {name: 'Value1', mapping: 'Value1'},
	      {name: 'Value2', mapping: 'Value2'}
	      ])
});			 		

	
var affiliateSalesGraph = new Ext.Panel({
    //iconCls:'chart',
    title: 'Sales Stats',
    frame:true,
    width:500,
    height:300,
    layout:'fit',

    items: {
        xtype: 'linechart',
        store: affiliatesalesgraphstore,
        url: '/ext/resources/charts.swf',
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


var affiliateSalesstore = new Ext.data.Store({			

	url: '/data/getjson.php',
	baseParams:{Refunded: "999", dataset: "affiliatesales", SessionID: SessionID, UserID:Login, IsAdmin:IsAdmin},

	reader: new Ext.data.JsonReader({root: 'affiliatesales',	totalProperty: 'totalCount'}, [
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

affiliateSalesMenu = new Ext.menu.Menu({
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
				var ds = affiliateSalesGrid.getStore();
				var record = ds.getAt(SelectedRow);
				SalesDetailWindow(record.get('uid'));
			}
		}),'-',
		new Ext.menu.Item({
			cls			: 'x-btn-text-icon bmenu', // icon and text class
			pressed		: false,
			enableToggle: false,
			text		: 'Affiliate Sales List Help',
			tooltip		: 'View Help about using the Affiliate Sales List.',
			icon		: '/images/help_balloon.png',
			scope		: this,
			handler		: function () {
				DrawMarrWikiWindow(landingtabs, "iDavi: Affiliate Details Sales List");
			}
		})
	]
									
});	
	

AffiliateDetailsSalesListGridView = new Ext.grid.GridView({
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


var affiliateSalesGrid = new Ext.grid.GridPanel({
	store: affiliateSalesstore,
	view: AffiliateDetailsSalesListGridView,
	columns: [
	          {header: "Date", width: 120, sortable: true, dataIndex: 'Purchased'},
	          {id: 'AffiliateDetailSalesSoldTo', header: "Sold To", width: 100, sortable: true, dataIndex: 'Fullname'},
	          {header: "Amount", width: 50, sortable: true, dataIndex: 'PaymentAmount'},
	          {header: "Paid To", width: 70, sortable: true, dataIndex: 'PaidToDescription'},
	          {header: "Status", width: 70, sortable: true, dataIndex: 'RefundedName'}
	          ],
	autoExpandColumn: 'AffiliateDetailSalesSoldTo',
	title:'Sales Details'
});

affiliateSalesGrid.on('rowcontextmenu', function(grid, rowIndex, e){
	
	e.stopEvent(); // Stops the browser context menu from showing.
	
	SelectedRow = rowIndex;
	affiliateSalesMenu.showAt(e.getXY());
});


affiliateSalesGrid.on('rowdblclick', function(grid, rowIndex, e){
	
	e.stopEvent(); // Stops the browser context menu from showing.
	
	var ds = affiliateSalesGrid.getStore();
	var record = ds.getAt(rowIndex);
	SalesDetailWindow(record.get('uid'));
});


var affiliateSitesstore = new Ext.data.Store({			

	url: '/data/getjson.php',
	baseParams:{Status: "999", dataset: "affiliatesitelist", SessionID: SessionID, UserID:Login, IsAdmin:IsAdmin},

	reader: new Ext.data.JsonReader({root: 'sites',	totalProperty: 'totalCount'}, [
			{name: 'SiteID', mapping: 'SiteID'},
			{name: 'SiteName', mapping: 'SiteName'},
			{name: 'DateSignedUp', mapping: 'DateSignedUp'},
			{name: 'Sponsor', mapping: 'Sponsor'},
			{name: 'SponsorName', mapping: 'SponsorName'},
			{name: 'Count', mapping: 'Count'}
	    ])
});			 		

affiliateSitesMenu = new Ext.menu.Menu({
	items : [
		new Ext.menu.Item({
			cls			: 'x-btn-text-icon bmenu', // icon and text class
			pressed		: false,
			enableToggle: false,
			text		: 'View Site Details',
			tooltip		: 'View Details about this site.',
			icon		: '/images/world_info.png',
			scope		: this,
			handler		: function () {
				var ds = affiliateSites.getStore();
				var record = ds.getAt(SelectedRow);
				SiteDetailWindow(record.get('SiteID'));
			}
		}),'-',
		
		
		new Ext.menu.Item({
			cls			: 'x-btn-text-icon bmenu', // icon and text class
			pressed		: false,
			enableToggle: false,
			text		: 'Affiliate Details Site List Help',
			tooltip		: 'View help on how to use the sites list in the affiliate details window.',
			icon		: '/images/help_balloon.png',
			scope		: this,
			handler		: function () {
				DrawMarrWikiWindow(landingtabs, "iDavi: Affiliate Details Site List");
			}
		})
	]
									
});	

AffiliateDetailsSiteListGridView = new Ext.grid.GridView({
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

var affiliateSites = new Ext.grid.GridPanel({
	store: affiliateSitesstore,
	view: AffiliateDetailsSiteListGridView,
	columns: [
	          {id: 'affiliatedetailsitelistname', header: "Site Name", width: 120, sortable: true, dataIndex: 'SiteName'},
	          {header: "Signed Up", width: 180, sortable: true, dataIndex: 'DateSignedUp'},
	          {header: "Sponsor", width: 120, sortable: true, dataIndex: 'SponsorName'},
	          {header: "Sales", width: 100, sortable: true, dataIndex: 'Count'}
	          ],
	autoExpandColumn: 'affiliatedetailsitelistname',
	title:'Sites'
});

affiliateSites.on('rowcontextmenu', function(grid, rowIndex, e){
	
	e.stopEvent(); // Stops the browser context menu from showing.
	
	SelectedRow = rowIndex;
	affiliateSitesMenu.showAt(e.getXY());
});

function doaffSave()
{
	editaffiliate.getForm().items.get('affdetfrmUserID').setValue(Login);
	editaffiliate.getForm().items.get('affdetfrmSessionID').setValue(SessionID);
	editaffiliate.getForm().items.get('affdetfrmIsAdmin').setValue(IsAdmin);
	editaffiliate.getForm().submit({url:'/data/updateAffiliate.php', waitMsg:'Saving Data...',
		success: function(form, action) {
			affiliatestore.reload({
				params: {
					Status: Ext.getCmp('AffiliateType').getValue(),
					Site: Ext.getCmp('AffiliateListSiteSelection').getValue(),
					Category: Ext.getCmp('AffiliateListCategorySelection').getValue(),
					Keywords: Ext.getCmp('AffiliateListKeywords').getValue()
				}
			});
			affiliateDetailWin.hide();
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

function AffiliateDetailWindow(affiliateid){
//	var EditIncidentWin;
		
	gAffiliateID = affiliateid;
	affiliateSalesstore.reload({params: {AffiliateID : affiliateid}});
	affiliatesalesgraphstore.reload({params: {AffiliateID : affiliateid}});
	affiliateSitesstore.reload({params: {AffiliateID : affiliateid}});
	
	
	if (!affiliateDetailWin) {
		affiliateDetailWin = new Ext.Window({
			autoCreate: true,
			animateTarget: 'toolbar',
			shadow: true,
			modal: true,
			constrain: true,
			resizable: false,
			animCollapse: true,
			layout: 'fit',
			width: 550,
			height: 460,
			closeAction: 'hide',
			//plain: true,
			title: 'Affiliate Details',
			tbar: [{
				
				xtype: 'tbbutton',
				id: 'editaffiliatedetailsave',
				text: 'Save',
				name: 'Save',
				cls: 'x-btn-text-icon bmenu',
				icon: '/images/save.png',
				listeners: {
	    			click: function() { 
						
							doaffSave();
						}							
					}
									
				
	},{
		xtype:'tbseparator',
		id: 'editaffiliatetbsep1'
	},{
		xtype:'tbbutton',
		text: 'Cancel',
		cls: 'x-btn-text-icon bmenu',
		icon: '/images/delete.png',
		listeners: {
			click: function() { 
				affiliateDetailWin.hide();
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
		icon: '/images/help.png',
		listeners: {
			click: function() { 
				DrawMarrWikiWindow(landingtabs, "iDavi: Affiliate Detail Window");
				}
			}
	}
],
		items: new Ext.TabPanel({
                        border:false,
                        activeTab:0,
                        tabPosition:'top',
                        items:[editaffiliate,
                               affiliateSalesGraph,
								affiliateSalesGrid,
								affiliateSites
								]		//end of items in column layout				//end item2,

		})
		})
		
		editaffiliate.getForm().load({url:'/data/getjson.php?uid=' + affiliateid + '&dataset=affiliate&SessionID=' + SessionID + '&UserID=' + Login +'&IsAdmin=1' , waitMsg:'Loading...'
			
			});	
		
		

		
		affiliateDetailWin.show();

		//end of !EditIncidentWin
	} else {
		
		editaffiliate.getForm().load({url:'/data/getjson.php?uid=' + affiliateid + '&dataset=affiliate&SessionID=' + SessionID + '&UserID=' + Login + '&IsAdmin=1' , waitMsg:'Loading...',
				success: function(form, action) {
				
				}
		});
		
		
		
		affiliateDetailWin.show();
	}
}