
	
	var giftvaluestore = new Ext.data.Store({			

		url: '/rap_admin/addons/GIS/paymentpro/data/getjson.php',
		baseParams:{dataset: "giftvalues", SessionID: SessionID},
				
		reader: new Ext.data.JsonReader({root: 'giftvalues',	totalProperty: 'totalCount'}, [
			{name: 'Value', mapping: 'Value'},
			{name: 'Display', mapping: 'Display'}
		 	])
		 });
	
	giftvaluestore.load();
	
	var ProductListstore = new Ext.data.Store({			

		url: '/rap_admin/addons/GIS/paymentpro/data/getjson.php',
		baseParams:{dataset: "products", SessionID: SessionID},
				
		reader: new Ext.data.JsonReader({root: 'products',	totalProperty: 'totalCount'}, [
			{name: 'id', mapping: 'id'},
			{name: 'ProductName', mapping: 'ProductName'}
		 	])
		 });
	
	ProductListstore.load();
	

	
	var GiftCardStatusList = [
	           ['All','999'],
	           ['Disabled','0'],
	           ['Not Issued','1'],
	           ['Issued','2'],
	           ['Emptied','3']
	           ];		
	                  	
	// create the data store
	var GiftCardStatusstore = new Ext.data.SimpleStore({
	   fields: [
	            {name: 'Description'},
	            {name: 'Index'}
	           ]
	           });
	GiftCardStatusstore.loadData(GiftCardStatusList);
	
	var PromoStatusList = [
	           	           ['All','999'],
	           	           ['Disabled','0'],
	           	           ['Active','1'],
	           	           ['Completed','2']
	           	           ];		
	           	                  	
   	// create the data store
   	var PromoStatusstore = new Ext.data.SimpleStore({
   	   fields: [
   	            {name: 'Description'},
   	            {name: 'Index'}
   	           ]
	});
   	PromoStatusstore.loadData(PromoStatusList);
   	
   	var YesNoList = [
	           	           ['Yes','1'],
	           	           ['No','0']
	           	           ];		
	           	                  	
   	// create the data store
   	var YesNostore = new Ext.data.SimpleStore({
   	   fields: [
   	            {name: 'Description'},
   	            {name: 'Index'}
   	           ]
	});
   	YesNostore.loadData(YesNoList);
   	

	var upsellStatusList = [
	           ['Enabled','1'],
	           ['Disabled','0']
	           ];		
	                  	
	// create the data store
	var upsellStatusstore = new Ext.data.SimpleStore({
	   fields: [
	            {name: 'Description'},
	            {name: 'Index'}
	           ]
	           });
	upsellStatusstore.loadData(upsellStatusList);
	
	var upsellActionList = [
	           ['Provide Product Access','1'],
	           ['Extend Download','2'],
	           ['Give Membership','3']
	           ];		
	                  	
	// create the data store
	var upsellActionStore = new Ext.data.SimpleStore({
	   fields: [
	            {name: 'Description'},
	            {name: 'Index'}
	           ]
	           });
	upsellActionStore.loadData(upsellActionList);
	