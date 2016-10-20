/**
 * @author Mike Myers
 */

var newgiftcardWin;

	newgiftcard = new Ext.FormPanel({
		layout: 'form',
		border: false,
		title: "New Gift Card",
		style: 'margin-left:20px; margin-top:20px; margin-bottom:20px',
		items: [{
				    xtype:'fieldset',
				    title: 'Gift Card Amount',
				    autoHeight:true,
				    width: 300,
					defaultType: 'textfield',
					items :[{
						xtype:'textfield',
						fieldLabel: 'Balance',
						name: 'Balance',
						anchor:'95%'
					}]
				},{
				    xtype:'fieldset',
				    title: 'Issued Information (optional)',
				    autoHeight:true,
				    //height: 125,
				    width: 300,
				  
					items :[{
							xtype:'textfield',
							fieldLabel: 'Issued To',
							name: 'IssuedToName',
							anchor:'95%'
						},{
							xtype:'hidden',
							name: 'SessionID',
							id: 'newsinglegiftcardSessionID'
						}]
				}]
			});
	

function newgiftcarddoSave()
{

	newgiftcard.getForm().items.get('newsinglegiftcardSessionID').setValue(SessionID);
	newgiftcard.getForm().submit({url:'/rap_admin/addons/GIS/paymentpro/data/newGiftCard.php', waitMsg:'Saving Data...',
		success: function(form, action) {
			giftcardstore.reload();
			newgiftcardWin.hide();
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

function NewGiftCardWindow(){
	
	if (!newgiftcardWin) {
		newgiftcardWin = new Ext.Window({
			autoCreate: true,
			animateTarget: 'toolbar',
			shadow: true,
			modal: true,
			constrain: true,
			resizable: false,
			animCollapse: true,
			layout: 'fit',
			width: 360,
			height: 250,
			closeAction: 'hide',
			//plain: true,
			title: 'New Gift Card',
			tbar: [{
				
				xtype: 'tbbutton',
				text: 'Save',
				name: 'Save',
				cls: 'x-btn-text-icon bmenu',
				icon: '/rap_admin/addons/GIS/paymentpro/images/save.png',
				listeners: {
	    			click: function() { 
							newgiftcarddoSave();
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
				newgiftcardWin.hide();
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
                        items:[ newgiftcard ]
		})]
		})
		
		newgiftcard.getForm().reset();
		newgiftcardWin.show();

		//end of !EditIncidentWin
	} else {
		
		newgiftcard.getForm().reset();
		newgiftcardWin.show();
	}
}