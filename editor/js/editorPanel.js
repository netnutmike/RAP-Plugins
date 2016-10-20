var productID;
var fileName;

var tokenstore = new Ext.data.Store({			

	url: '/rap_admin/addons/GIS/editor/data/getjson.php',
	baseParams:{dataset: "tokenlist"},
			
	reader: new Ext.data.JsonReader({root: 'tokenlist',	totalProperty: 'totalCount'}, [
		{name: 'tag', mapping: 'tag'},
		{name: 'description', mapping: 'description'}
	 	])
		
	 });

	tokenstore.load();
	
var tokengrid = new Ext.grid.GridPanel({
    store: tokenstore,
    columns: [
        {id: 'tokenname', header: "Token", width: 200, sortable: true, dataIndex: 'tag'},
        {header: "Description", width: 300, sortable: true, dataIndex: 'description'}
        ],
	//autoExpandColumn: 'tokenname',
    //layout: 'fit',
    title: 'Insert Token',
    monitorResize: true,
    autoScroll: true,
    height: 400
    });


tokenMenu = new Ext.menu.Menu({ 
		items : [tokengrid]
	});

function saveFile() {
	Ext.Ajax.request({
		   url: '/rap_admin/addons/GIS/editor/data/savedata.php',
		   success: function(response, opts) {
				alert('success');
			},
		   failure: function(response, opts) {
				alert('fail');
			},
		   params: { productid: productID, filename: fileName, EditText: Ext.getCmp('htmledit').getValue() }
		});
}

var editorPanel = new Ext.Panel({
		id: 'editor-panel',
		title: 'Editor',
		layout: 'anchor',
		anchor: '100% 100%',
		//height: '100%',
		tbar:[{
			xtype:'tbbutton',
			text: 'Save',
			cls: 'x-btn-text-icon bmenu',
			icon: '/rap_admin/addons/GIS/editor/images/save.png',
			listeners: {
    			click: function() { 
    				saveFile();
				}
			}
		},{
			xtype:'tbbutton',
			text: 'Save As',
			cls: 'x-btn-text-icon bmenu',
			icon: '/rap_admin/addons/GIS/editor/images/saveas.png',
			listeners: {
    			click: function() { 
    				saveFileAsWindow();
				}
			}
		},{
			xtype:'tbseparator'
		}],
		items: [{
			layout: 'fit',
	    	xtype: 'htmleditor',
	    	name: 'EditText',
	    	hideLabel: true,
	    	fieldLabel: 'Edit Here',
	    	anchor: '100% 100%',
	    	//width: '100%',
	    	id: 'htmledit',
	    	listeners: {
	    	    render: function(editor) {
	    	        editor.getToolbar().add({
	    	            //iconCls: 'x-icon-addimage',
	    	        	icon: '/rap_admin/addons/GIS/editor/images/add_image.png',
	    	            handler: function(b,e) {
	    	        		Ext.Msg.prompt('Insert Image', 'Image URL', function(btn, txt) {
	    	        			if (btn == 'ok') {
	    	        				editor.relayCmd('insertimage', txt); 
	    	        			}
	    	            });
	    	        }
	    	        });
	    	        
	    	        editor.getToolbar().add({
	    	        	icon: '/rap_admin/addons/GIS/editor/images/tools.png',
	    	            handler: function(b,e) {
	    	        		tokenMenu.showAt(e.getXY());                                           
	    	            }
	    	        });
	    	    }
	    	}
	    }]
		
	});

function loadTemplate(productid, filename) {
	productID = productid;
	fileName = filename;
	
	Ext.Ajax.request({
		   url: '/rap_admin/addons/GIS/editor/data/getjson.php',
		   success: function(response, opts) {
				//$rtnobj = Ext.decode(response.responseText)
				Ext.getCmp('htmledit').setValue(response.responseText);


			},
		   failure: function(response, opts) {
				//alert('fail');
			},
		   params: { productid: productid, filename: filename, dataset: "file" }
		});
}

