/**
 * @author Mike Myers
 */

var editupsellWin;

	editupsell = new Ext.FormPanel({
		layout: 'form',
		border: false,
		title: "Edit Upsell Details",
		style: 'margin-left:20px; margin-top:20px; margin-bottom:20px',
		reader: new Ext.data.JsonReader({root: 'upsell',	totalProperty: 'totalCount'}, [
		        {name: 'uid', mapping: 'uid'},
		        {name: 'Name', mapping: 'Name'},
		        {name: 'Price', mapping: 'Price'},
				{name: 'Description', mapping: 'Description'},
				{name: 'AttachedAction', mapping: 'AttachedAction'},
				{name: 'AttachedProduct', mapping: 'AttachedProduct'},
				{name: 'Amount', mapping: 'Amount'},
				{name: 'DateCompleted', mapping: 'DateCompleted'},
				{name: 'Status', mapping: 'Status'}
				]),
		items: [{
			    xtype:'fieldset',
			    title: 'Upsell Details',
			    autoHeight:true,
			    width: 450,
				defaultType: 'textfield',
				items :[{
					xtype:'textfield',
					fieldLabel: 'Name',
					name: 'Name',
					anchor:'95%'
				},{
					xtype:'textfield',
					fieldLabel: 'Price',
					name: 'Price',
					anchor:'95%'
				},{
					xtype:'textarea',
					fieldLabel: 'Description',
					name: 'Description',
					anchor:'95%'
				},{
					xtype: 'combo',
					name: 'Status',
					mode: 'local',
					fieldLabel: 'Status',
					hiddenName: 'Status',
					valueField: 'Index',
					displayField:'Description',
					store: upsellStatusstore,					
					selectOnFocus: true,
					editable: false,
					forceSelection: true,
					triggerAction: 'all',
					anchor:'95%'
				}]
			},{
			    xtype:'fieldset',
			    title: 'Action',
			    autoHeight:true,
			    //height: 125,
			    width: 450,
			  
				items :[{
							xtype: 'combo',
							name: 'AttachedAction',
							mode: 'local',
							fieldLabel: 'Action',
							hiddenName: 'AttachedAction',
							valueField: 'Index',
							displayField:'Description',
							store: upsellActionStore,					
							selectOnFocus: true,
							editable: false,
							forceSelection: true,
							triggerAction: 'all',
							anchor:'95%'
						},{
							xtype: 'combo',
							name: 'AttachedProduct',
							mode: 'local',
							fieldLabel: 'Product',
							hiddenName: 'AttachedProduct',
							valueField: 'id',
							displayField:'ProductName',
							store: ProductListstore,					
							selectOnFocus: true,
							editable: false,
							forceSelection: true,
							triggerAction: 'all',
							anchor:'95%'
						},{
							xtype:'textfield',
							fieldLabel: 'Amount',
							name: 'Amount',
							anchor:'95%'
						},{
							xtype:'hidden',
							name: 'SessionID',
							id: 'editupsellSessionID'
						},{
							xtype:'hidden',
							name: 'uid',
							id: 'editupselluid'
						}]
			}]});
	

function editupselldoSave()
{

	editupsell.getForm().items.get('editupsellSessionID').setValue(SessionID);
	editupsell.getForm().submit({url:'/rap_admin/addons/GIS/paymentpro/data/updateupsell.php', waitMsg:'Saving Data...',
		success: function(form, action) {
			productUpsalesstore.reload({params: {ProductID : gProductID}});
			editupsellWin.hide();
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

function editupsellWindow(upsellid){
	
	if (!editupsellWin) {
		editupsellWin = new Ext.Window({
			autoCreate: true,
			animateTarget: 'toolbar',
			shadow: true,
			modal: true,
			constrain: true,
			resizable: false,
			animCollapse: true,
			layout: 'fit',
			width: 500,
			height: 410,
			closeAction: 'hide',
			//plain: true,
			title: 'Edit Upsell',
			tbar: [{
				
				xtype: 'tbbutton',
				text: 'Save',
				name: 'Save',
				cls: 'x-btn-text-icon bmenu',
				icon: '/rap_admin/addons/GIS/paymentpro/images/save.png',
				listeners: {
	    			click: function() { 
						
							editupselldoSave();
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
				editupsellWin.hide();
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
				DrawMarrWikiWindow(landingtabs, "Edit Upsell Window");
				}
			}
	}
],
		items: [new Ext.TabPanel({
                        border:false,
                        activeTab:0,
                        tabPosition:'top',
                        items:[ editupsell ]
		})]
		})
		
		editupsell.getForm().load({url:'/rap_admin/addons/GIS/paymentpro/data/getjson.php?uid=' + upsellid + '&dataset=upsell&SessionID=' + SessionID, waitMsg:'Loading',
			success: function(form, action) {
			}
			});	
			
		editupsellWin.show();

		//end of !EditIncidentWin
	} else {
		
		editupsell.getForm().load({url:'/rap_admin/addons/GIS/paymentpro/data/getjson.php?uid=' + upsellid + '&dataset=upsell&SessionID=' + SessionID, waitMsg:'Loading',
			success: function(form, action) {
			}
			});	
		editupsellWin.show();
	}
}