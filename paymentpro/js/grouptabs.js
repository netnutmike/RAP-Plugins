/*!
 * Ext JS Library 3.2.1
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
Ext.onReady(function() {
  Ext.QuickTips.init();
    
    // create some portlet tools using built in Ext tool ids
    var tools = [{
        id:'gear',
        handler: function(){
    		irfacurrentpropertiesWindow();
        }
    },{
        id:'help',
        handler: function(e, target, panel){
            panel.ownerCt.remove(panel, true);
        }
    }];
    
    // create some portlet tools using built in Ext tool ids
    var ralerts = [{
        id:'refresh',
        handler: function(e, target, panel){
    		irfacurrentrstore.reload();
        }
    },{
        id:'pin',
        handler: function(){
    		//AlertType, TableID, Status, Class, TrackingNumber, Severity
    		newAlertWindow('0','','1','1','');
        }
    },{
        id:'help',
        handler: function(e, target, panel){
    		DrawMarrWikiWindow('', "iDavi: Field View - Re-Active Alarms Summary");
        }
    }
    ];
    
    // create some portlet tools using built in Ext tool ids
    var palerts = [{
        id:'refresh',
        handler: function(e, target, panel){
    		irfacurrentstore.reload();
        }
    },{
        id:'pin',
        handler: function(){
    		//AlertType, TableID, Status, Class, TrackingNumber, Severity
			newAlertWindow('0','','1','2','');
        }
    },{
        id:'help',
        handler: function(e, target, panel){
    		DrawMarrWikiWindow('', "iDavi: Field View - Proactive Alarms Summary");
        }
    }
    ];
    
    // create some portlet tools using built in Ext tool ids
    var salerts = [{
        id:'refresh',
        handler: function(e, target, panel){
    		irfasecuritystore.reload();
        }
    },{
        id:'pin',
        handler: function(){
    		//AlertType, TableID, Status, Class, TrackingNumber, Severity
			newAlertWindow('1','','1','','');
        }
    },{
        id:'help',
        handler: function(e, target, panel){
    		DrawMarrWikiWindow('', "iDavi: Field View - Security Issues Summary");
        }
    }
    ];
    
    var quickLinks="<br><br><b></b> <br><br>&nbsp;";
    var contactText="<br><br>&nbsp;";

    var viewport = new Ext.Panel({
        layout:'anchor',
        renderTo: 'container',
        items:[//landinftbadmin,
               {
        	xtype: 'grouptabpanel',
        	tabWidth: 150,
        	anchor: '100% -50',
        	activeGroup: 0,
        	items: [{
            	mainItem: 0,
            	items: [{
                    xtype: 'portal',
                    title: 'Dashboard',
                    tabTip: 'iDavi Dashboard',
                    icon: '/images/chart_pie.png',
                    items:[{
                        columnWidth:.49,
                        style:'padding:10px 20px 10px 10px',
                        monitorResize: true,
                        autoScroll: true,
                        items:[{
                            title: 'Affiliate Sales',
                            layout:'fit',
                            monitorResize: true,
                            autoScroll: true,
                            autoHeight: true,
                            tools: ralerts
                            //items: dashboardaffliateSalesGraph
                        },{
                            title: 'Site Sales',
                            layout:'fit',
                            monitorResize: true,
                            autoScroll: true,
                            tools: palerts
                            //items: dashboardsiteSalesGraph
                        }]
                    },{
                        columnWidth:.49,
                        style:'padding:10px 0 10px 10px',
                        items:[{
                            title: 'New Products List',
                            tools: salerts
                            //items: newproductgridmini
                        },{
                            title: 'Top Products'
                            //tools: tools,
                           // items: topproductgridmini
                        }]
                    }]                    
                }, {
                	title: 'Active Subscriptions',
                    iconCls: 'x-icon-new-products',
                    tabTip: 'New Products List',
                    style: 'padding: 10px;'
                    //items: newproductgrid     
                }, {
                	title: 'Sales',
                    iconCls: 'x-icon-new-affiliates',
                    tabTip: 'New Affiliates List',
                    style: 'padding: 10px;'
                    //items: newaffiliatesgrid     
                }]
            },{
            	mainItem: 0,
            	items: [{
            		title: 'Products',
                    layout: 'fit',
                    iconCls: 'x-icon-tickets',
                    tabTip: 'View the entire category list and Statistics',
                    style: 'padding: 10px;',
                    items: productgrid
            	}]
            },{
            	mainItem: 0,
            	items: [{
            		title: 'Gift Cards',
                    layout: 'fit',
                    iconCls: 'x-icon-tickets',
                    tabTip: 'View and Manage Your Customers',
                    style: 'padding: 10px;',
                    items: giftcardlist
            	}]
            },{
            	mainItem: 0,
            	items: [{
            		title: 'Offline Promotion',
                    layout: 'fit',
                    iconCls: 'x-icon-tickets',
                    tabTip: 'View and Manage Your Customers',
                    style: 'padding: 10px;',
                    items: offlinepromolist
            	}]
            },{
            	mainItem: 0,
            	items: [{
            		title: 'Commissions',
                    layout: 'fit',
                    iconCls: 'x-icon-tickets',
                    tabTip: 'View and Manage Your Customers',
                    style: 'padding: 10px;'
                    //items: customergrid
            	}]
            }, {
            	mainItem: 0,
            	items: [{
            		title: 'Reports',
                    layout: 'fit',
                    iconCls: 'x-icon-tickets',
                    tabTip: 'Run Reports on your sales',
                    style: 'padding: 10px;'
                   // items: affiliategrid
            	},{
            		title: 'Product Stats',
                    layout: 'fit',
                    iconCls: 'x-icon-tickets',
                    tabTip: 'Place and mnager your ads on iDavi',
                    style: 'padding: 10px;'
                    //items: affiliategrid
            	},{
            		title: 'Product Revenue',
                    layout: 'fit',
                    iconCls: 'x-icon-tickets',
                    tabTip: 'Use our JV Services',
                    style: 'padding: 10px;'
                   // items: affiliategrid
            	},{
            		title: 'Sales',
                    layout: 'fit',
                    iconCls: 'x-icon-tickets',
                    tabTip: 'Use our JV Services',
                    style: 'padding: 10px;'
                   // items: affiliategrid
            	}]
            },{
            	mainItem: 0,
            	items: [{
            		title: 'Options',
                    layout: 'fit',
                    iconCls: 'x-icon-tickets',
                    tabTip: 'Setup Payment Pro Options',
                    style: 'padding: 10px;'
                    //items: customergrid
            	}]
            }
            ]
    }//,
    //mainstatusbar
               ]
    });
});
