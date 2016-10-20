/**
 * @author Mike Myers
 */

var newofflinepromoWin;

	newofflinepromo = new Ext.FormPanel({
		layout: 'form',
		border: false,
		title: "New Offline Promotion",
		style: 'margin-left:20px; margin-top:20px; margin-bottom:20px',
		items: [{
			    xtype:'fieldset',
			    title: 'Promotion Information',
			    autoHeight:true,
			    width: 400,
				defaultType: 'textfield',
				items :[{
							xtype:'textfield',
							fieldLabel: 'Promo Code',
							name: 'promoCode',
							anchor:'95%'
						},{
							xtype:'textarea',
							fieldLabel: 'Promo Description',
							name: 'promoDescription',
							anchor:'95%'
						}]
				},{
				    xtype:'fieldset',
				    title: 'Product Details',
				    autoHeight:true,
				    //height: 125,
				    width: 400,
				  
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
					},{
						xtype:'hidden',
						name: 'SessionID',
						id: 'newpromotionSessionID'
					}]
			}]
		});
	

function newpromotiondoSave()
{

	newofflinepromo.getForm().items.get('newpromotionSessionID').setValue(SessionID);
	newofflinepromo.getForm().submit({url:'/rap_admin/addons/GIS/paymentpro/data/newPromotion.php', waitMsg:'Saving Data...',
		success: function(form, action) {
			offlinepromostore.reload();
			newofflinepromoWin.hide();
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

function NewOfflinePromoWindow(){
	
	if (!newofflinepromoWin) {
		newofflinepromoWin = new Ext.Window({
			autoCreate: true,
			animateTarget: 'toolbar',
			shadow: true,
			modal: true,
			constrain: true,
			resizable: false,
			animCollapse: true,
			layout: 'fit',
			width: 460,
			height: 365,
			closeAction: 'hide',
			//plain: true,
			title: 'New offline Promotion',
			tbar: [{
				
				xtype: 'tbbutton',
				text: 'Save',
				name: 'Save',
				cls: 'x-btn-text-icon bmenu',
				icon: '/rap_admin/addons/GIS/paymentpro/images/save.png',
				listeners: {
	    			click: function() { 
							newpromotiondoSave();
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
				newofflinepromoWin.hide();
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
                        items:[ newofflinepromo ]
		})]
		})
		
		newofflinepromo.getForm().reset();
		newofflinepromoWin.show();

		//end of !EditIncidentWin
	} else {
		
		newofflinepromo.getForm().reset();
		newofflinepromoWin.show();
	}
}