/**
 * @author Mike Myers
 */

var newupsellWin;

	newupsell = new Ext.FormPanel({
		layout: 'form',
		border: false,
		title: "New Upsell Details",
		style: 'margin-left:20px; margin-top:20px; margin-bottom:20px',
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
							id: 'newupsellSessionID'
						},{
							xtype:'hidden',
							name: 'ProductID',
							id: 'newupsellProductID'
						}]
			}]});
	

function newUpselldoSave()
{

	newupsell.getForm().items.get('newupsellSessionID').setValue(SessionID);
	newupsell.getForm().items.get('newupsellProductID').setValue(gProductID);
	newupsell.getForm().submit({url:'/rap_admin/addons/GIS/paymentpro/data/newUpsell.php', waitMsg:'Saving Data...',
		success: function(form, action) {
			productUpsalesstore.reload({params: {ProductID : gProductID}});
			newupsellWin.hide();
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

function newupsellWindow(){
	
	if (!newupsellWin) {
		newupsellWin = new Ext.Window({
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
			title: 'New Upsell',
			tbar: [{
				
				xtype: 'tbbutton',
				text: 'Save',
				name: 'Save',
				cls: 'x-btn-text-icon bmenu',
				icon: '/rap_admin/addons/GIS/paymentpro/images/save.png',
				listeners: {
	    			click: function() { 
						
							newUpselldoSave();
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
				newupsellWin.hide();
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
				DrawMarrWikiWindow(landingtabs, "New Upsell Window");
				}
			}
	}
],
		items: [new Ext.TabPanel({
                        border:false,
                        activeTab:0,
                        tabPosition:'top',
                        items:[ newupsell ]
		})]
		})
		
		newupsell.getForm().reset();
		newupsellWin.show();

		//end of !EditIncidentWin
	} else {
		
		newupsell.getForm().reset();
		newupsellWin.show();
	}
}