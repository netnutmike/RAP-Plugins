/**
 * @author Mike Myers
 */

var newgiftcardsWin;

	newgiftcards = new Ext.FormPanel({
		layout: 'form',
		border: false,
		title: "New Gift Cards",
		style: 'margin-left:20px; margin-top:20px; margin-bottom:20px',
		items: [{
			    xtype:'fieldset',
			    title: 'Bulk Card Creation Information',
			    autoHeight:true,
			    width: 300,
				defaultType: 'textfield',
				items :[{
						xtype:'textfield',
						fieldLabel: 'Balance',
						name: 'Balance',
						anchor:'95%'
					},{
						xtype:'textfield',
						fieldLabel: 'Count',
						name: 'Count',
						anchor:'95%'
					},{
						xtype:'hidden',
						name: 'SessionID',
						id: 'newsgiftcardsSessionID'
					}]
				}]
		});
	

function newgiftcardsdoSave()
{

	newgiftcards.getForm().items.get('newsgiftcardsSessionID').setValue(SessionID);
	newgiftcards.getForm().submit({url:'/rap_admin/addons/GIS/paymentpro/data/newGiftCards.php', waitMsg:'Saving Data...',
		success: function(form, action) {
			giftcardstore.reload();
			newgiftcardsWin.hide();
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

function NewGiftCardsWindow(){
	
	if (!newgiftcardsWin) {
		newgiftcardsWin = new Ext.Window({
			autoCreate: true,
			animateTarget: 'toolbar',
			shadow: true,
			modal: true,
			constrain: true,
			resizable: false,
			animCollapse: true,
			layout: 'fit',
			width: 360,
			height: 210,
			closeAction: 'hide',
			//plain: true,
			title: 'New Bulk Gift Cards',
			tbar: [{
				
				xtype: 'tbbutton',
				text: 'Save',
				name: 'Save',
				cls: 'x-btn-text-icon bmenu',
				icon: '/rap_admin/addons/GIS/paymentpro/images/save.png',
				listeners: {
	    			click: function() { 
						
							newgiftcardsdoSave();
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
				newgiftcardsWin.hide();
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
                        items:[ newgiftcards ]
		})]
		})
		
		newgiftcards.getForm().reset();
		newgiftcardsWin.show();

		//end of !EditIncidentWin
	} else {
		
		newgiftcards.getForm().reset();
		newgiftcardsWin.show();
	}
}