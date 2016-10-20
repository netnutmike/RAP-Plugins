var barsearchField = new Ext.form.TextField({
	fieldLabel: 'Search', 
	blankText: 'Search...',
	id: 'barsearchFieldid',
	selectOnFocus: true,
	width: 200,
	name: 'Search'
	});
	
var SearchwikiField = new Ext.form.TextField({
	fieldLabel: 'Search',
	blankText: 'Search...',
	selectOnFocus: true,
	width: 200,
	id: 'SearchwikiFieldid',
	name: 'Searchwiki'
	});

var landinftbadmin = new Ext.Toolbar();
landinftbadmin.add({
		text: '<img src="/images/idavi-logo-small.png">'
	}, {
		xtype: 'tbfill'
	},{
		text: '<b>Logged In</b>: ' + CUNAME
	},{
		xtype: 'tbbutton',
		text: 'logout',
		icon: '/images/shut_down.png', 
		cls: 'x-btn-text-icon bmenu',
		handler: function() {
			window.location.href='/affiliates/login.php?authenticity_token=logout';
			}
	},'','-','',{
		text: 'Multi Search:'
	},barsearchField,
	new Ext.Toolbar.SplitButton({
	    text: 'Search',
	    id: 'Search',
//	    tooltip: {text:'Click This to Search Using Multi Search or Select on Right The Search You Want', title:'Search'},
	    icon: '/images/search_home.png',
	    cls: 'x-btn-text-icon bmenu',
	    handler: DoMultiSearch,
	    // Menus can be built/referenced by using nested menu config objects
	    menu : {
	        items: [{
	            text: '<b>Search Products</b>', 
	            icon: '/images/search_home.png',
	            handler: MultiSearch
	        }, {
	            text: 'Search Affiliates', 
	            icon: '/images/search_business_user.png',
	            handler: MultiSearch
	        }, {
	            text: 'Search Sites', 
	            icon: '/images/search_computer.png',
	            handler: MultiSearch
	        },
	        '-',
	        {
	        	cls			: 'x-btn-text-icon bmenu', // icon and text class
				pressed		: false,
				enableToggle: false,
				text		: 'Command Help',
				tooltip		: 'How to Use Commands in The MultiSearch.',
				icon		: '/images/windows_terminal.png',
				scope		: this
	        },
	        {
	        	cls			: 'x-btn-text-icon bmenu', // icon and text class
				pressed		: false,
				enableToggle: false,
				text		: 'How To Use Search',
				tooltip		: 'View Help about using the search features.',
				icon		: '/images/help.png',
				scope		: this
	        }]
	    }
	}),
	'','-','',{
		text: 'Search wiki:'
	},SearchwikiField,{
		xtype: 'tbbutton',
		text: 'Search',
		id: 'Searchwikibtn', 
		icon: '/images/search.png', 
		cls: 'x-btn-text-icon bmenu'
	}
	);

//global variables
var SearchWin;

var searchvar;
var searchstore = new Ext.data.Store({			

	url: '/data/searchjson.php',
	baseParams:{SessionID: SessionID, UserID:Login, IsAdmin:IsAdmin},
			
	reader: new Ext.data.JsonReader({root: 'searchresults',	totalProperty: 'totalCount'}, [
		{name: 'uid', mapping: 'uid'},
		{name: 'Name', mapping: 'Name'},
		{name: 'Description', mapping: 'Description'},
		{name: 'FindType', mapping: 'FindType'},
		{name: 'FindTypeName', mapping: 'FindTypeName'}])

	 });	
	 	
var SearchButton = Ext.getCmp('Search');

function SearchType(whattheytypedin) {

	
	return 'Search';
	
}


function DoMultiSearch() {
	
	
	//next try to determine what they are searching for
	switch (SearchType(barsearchField.getValue())) {
		default:
			MultiSearch();
			break;
	}
	
}
	
function openItem(id, type) {
	
	//do what is needed based on the type of the record being opened
	switch (type) {
		case '1':		//product
			ProductDetailWindow(id);
			break;
		case '2':		//site
			SiteDetailWindow(id);
			break;
		case '3':		//affiliate
			AffiliateDetailWindow(id);
			break;
		case '4':		//customer
			CustomerDetailWindow(id);
			break;
		case '5':		//sale
			SalesDetailWindow(id);
			break;
		
	}
}

function MultiSearch() {	

	var lastClickedLine;
	
	searchvar = barsearchField.getValue();
	if (!SearchWin) {
		SearchWin = new Ext.Window({
			//applyTo: 'search-win',
			autoCreate: true,
			title: 'Multi Search',
			animateTarget: 'toolbar',
			shadow: true,
			modal: true,
			constrain: true,
			resizable: true,
			animCollapse: true,
			layout: 'fit',
			width: 700,
			height: 500,
			icon: '/images/search_home.png',
			closeAction: 'hide',
			plain: true,
			items: TheSearchGrid = new Ext.grid.GridPanel({
				store: searchstore,
    			columns: [
        			//{header: "Name", width: 50, sortable: true, dataIndex: 'Name'},
        			{id: 'SearchWindowDescription',header: "Description", width: 175, sortable: true, dataIndex: 'Description'},						
        			{header: "Found In", width: 75, sortable: true, dataIndex: 'FindTypeName'}
    			],
    			autoExpandColumn: 'SearchWindowDescription',				
    			height:350,
    			title:'Search Results for "' + barsearchField.getValue() + '"',
				id: 'searchgrid'
			}),
			buttons: [{
				text: 'Go',
				disabled: true,
				id: 'gobutton',
				cls: 'x-btn-text-icon bmenu',
				icon: '/images/next.png',
				handler: function() {
					openItem(record.get('uid'), record.get('FindType'));
					SearchWin.hide();
					}
				},
				{ 
					text: 'Close',
					cls: 'x-btn-text-icon bmenu',
					icon: '/images/delete.png',
				handler: function() { SearchWin.hide(); } } ]
		})

		var GoButton = Ext.getCmp('gobutton');
//		var TheSearchGrid = Ext.getCmp('searchgrid');

		TheSearchGrid.on('rowdblclick', function(grid, rowIndex, e) {
//			e.stopEvent();
			var ds = grid.getStore();
			var record = ds.getAt(rowIndex);
			openItem(record.get('uid'), record.get('FindType'));
			SearchWin.hide();
			//End of function on dblclick
			}  );
			
		TheSearchGrid.on('rowclick', function(grid, rowIndex, e) {
			//console.log(GoButton);
			var ds = grid.getStore();
			var record = ds.getAt(rowIndex);
			lastClickedLine = record.get('uid');
			GoButton.enable();
			//End of function on rowclick
			}  );
			

		TheSearchGrid.on('rowcontextmenu', function(grid, rowIndex, e) {
			e.stopEvent();
			var ds = grid.getStore();
			var record = ds.getAt(rowIndex);
			openItem(record.get('uid'), record.get('FindType'));
			SearchWin.hide();
			//End of function on rowcontextmenu
			}  );

		//end of !SearchWin
		}

	SearchWin.show(SearchButton);
	searchstore.load({ params: {SEARCHFOR : Ext.getCmp('barsearchFieldid').getValue()} });
	Ext.getCmp('searchgrid').setTitle('Search Results for "' + Ext.getCmp('barsearchFieldid').getValue() + '"');
	//end of searchbutton.on(click)
}
	
	barsearchField.on('specialkey', function(field, e) {
		if (e.getKey() == 13) {
			DoMultiSearch();
			}
		//End of function on specialkey
		}  );

var SearchwikiButton = Ext.getCmp('Searchwikibtn');