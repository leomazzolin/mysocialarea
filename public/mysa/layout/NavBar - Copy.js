define(["dojo/_base/declare", "dojo/dom", "dojo/dom-construct", "dojo/string", "dojo/on", "dojo/dom-geometry", "dojo/dom-style", "dojo/json",
		"dijit/layout/BorderContainer", "dijit/layout/ContentPane",
		"dijit/MenuBar", "dijit/MenuBarItem", "dijit/PopupMenuBarItem", "dijit/PopupMenuItem", "dijit/Menu", "dijit/MenuItem", "dijit/DropDownMenu",
		"dijit/form/DropDownButton", "mysa/utility/Format1", "mysa/utility/myError",
		"dojo/i18n!mysa/nls/ModConPage",
		"dojo/domReady!"],
function(declare, dom, domConstruct, string, on, domGeom, domStyle, JSON,
			BorderContainer, ContentPane,
			MenuBar, MenuBarItem, PopupMenuBarItem, PopupMenuItem, Menu, MenuItem, DropDownMenu,
			DropDownButton, Format1, myError,
			MCP
		){
////
return declare(null, {

	errorInfo: {
				class: "layout/NavBar",
				},
	controllerPayload: null,
	nodeList: null,
	
	combobuttonStyle: "font-size: 16px; padding: 0 25px 0 25px;",
		
	constructor: function(cp, nl){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.controllerPayload = cp;
			this.nodeList = nl;
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	makeNavBar: function(){
		try{
			for (var i = 0; i < this.nodeList.length; i++) {
				var Bar = this.makeBar(this.nodeList[i]);
				var mainMenu = this.makeMainMenu(Bar);
				var sectionMenu = this.makeSectionMenu(Bar);
				//var pageMenu = this.makePageMenu(Bar);
			}
		}
		catch(e){
			console.error(this.eHandle.output(e, "makeNavBar"))
		}
	},

    makeBar: function(s){
		try{
		var divBar = domConstruct.create("div", {
													class: "navbar",
												}, s, "first");
		return divBar;
		}
		catch(e){
			console.error(this.eHandle.output(e, "makeBar"))
		}
										
    },
	
	makePageMenu: function(dij){
		try{
		var divMainMenu = domConstruct.create("div", {
													}, dij);
		var button = new DropDownButton({
			label: "Page Nav:",
			style: this.combobuttonStyle,
			//dropDown: menu,
		}, divMainMenu);
		}
		catch(e){
			console.error(this.eHandle.output(e, "makePageMenu"))
		}

	},	

	makeSectionMenu: function(dij){
		try{
		var MenuItems = MCP.module[0];
		var iController = 0;
		for(var  i = 0; i < MenuItems.controller.length; i++){
			if(MenuItems.controller[i].name == this.controllerPayload.params.controller){
				iController = i;
			}
		}
		var boolShowSection = false;
		for(var  i = 0; i < MenuItems.controller[iController].action.length; i++){
			if(MenuItems.controller[iController].action[i].name == this.controllerPayload.params.action){
				if(MenuItems.controller[iController].action[i].show != false){
					boolShowSection = true;
				}
			}
		}
		if(boolShowSection == true){
			if(MenuItems.controller[iController].action.length > 1 && boolShowSection == true){					
				var divMainMenu = domConstruct.create("div", {
															}, dij);
				var menu = new Menu();
				for(var  j = 0; j < MenuItems.controller[iController].action.length; j++){
					if(MenuItems.controller[iController].action[j].show != false){
						var href = "/" + MenuItems.controller[iController].name + "/" +  MenuItems.controller[iController].action[j].name;
						var mItem = new MenuItem({
										label:   MenuItems.controller[iController].action[j].title,
										hreflink: href,
									});
						on(mItem, "click", function(){
							window.location.href = this.hreflink;
						});
						menu.addChild(mItem);
					}
				}
				menu.startup();
				var button = new DropDownButton({
					label: "Section Options:",
					style: this.combobuttonStyle,
					dropDown: menu,
				}, divMainMenu);
			}
		}
		}
		catch(e){
			console.error(this.eHandle.output(e, "makeSectionMenu"))
		}
	},	

	makeMainMenu: function(dij){
		try{
		var divMainMenu = domConstruct.create("div", { style: "width: 40px; 40px;"
													}, dij);
		var MenuItems = MCP.module[0];
		var menu = new Menu({ style: "display: none;"});
		for(var i = 0; i < MenuItems.controller.length; i++){
			if(MenuItems.controller[i].name != "user"){
				if(MenuItems.controller[i].action.length > 1){					
					var submenu = new Menu();
					for(var  j = 0; j < MenuItems.controller[i].action.length; j++){
						var shref = "/" + MenuItems.controller[i].name + "/" +  MenuItems.controller[i].action[j].name;
						var submItem = new MenuItem({
										label:   MenuItems.controller[i].action[j].title,
										hreflink: shref,
									});
						on(submItem, "click", function(){
							window.location.href = this.hreflink;
						});
						submenu.addChild(submItem);
					}
					var mhref = "/" + MenuItems.controller[i].name + "/index";
					var mItem = new PopupMenuItem({
									label: MenuItems.controller[i].title,
									hreflink: mhref,
									popup: submenu,
								});
					on(mItem, "click", function(){
						window.location.href = this.hreflink;
					});
				}
				else{
					var mhref = "/" + MenuItems.controller[i].name + "/index";
					var mItem = new MenuItem({
									label: MenuItems.controller[i].title,
									hreflink: mhref,
								});
					on(mItem, "click", function(){
						window.location.href = this.hreflink;
					});
				}
			}
			menu.addChild(mItem);
		}		
		menu.startup();
		var button = new DropDownButton({
			label: "Main Menu:",
			style: this.combobuttonStyle,
			dropDown: menu,
		}, divMainMenu);
		}
		catch(e){
			console.error(this.eHandle.output(e, "makeMainMenu"))
		}
	},	

});
////
});