define(["dojo/_base/declare", "dojo/dom", "dojo/dom-construct", "dojo/dom-attr", "dojo/dom-class", "dojo/dom-style", "dojo/dom-geometry", "dojo/query", "dojo/string", "dojo/on", "dojo/json",
		"dijit/layout/BorderContainer", "dijit/layout/ContentPane",
		"dijit/MenuBar", "dijit/MenuBarItem", "dijit/PopupMenuBarItem", "dijit/PopupMenuItem", "dijit/Menu", "dijit/MenuItem", "dijit/DropDownMenu", "dijit/form/DropDownButton",
		"mysa/utility/Format1", "mysa/utility/myError",
		"dojo/i18n!mysa/nls/ModConPage", "dojo/i18n!mysa/nls/Menu", "dojo/i18n!mysa/nls/MenuAdmin",

		"dojo/domReady!"],
function(	// DOJO FILES
			declare, dom, domConstruct, domAttr, domClass, domStyle, domGeom, query, string, on, JSON,
			// DIJIT FILES
			BorderContainer, ContentPane,
			MenuBar, MenuBarItem, PopupMenuBarItem, PopupMenuItem, Menu, MenuItem, DropDownMenu, DropDownButton, 
			// MYSA FILES
			Format1, myError,
			MCP, nlsMenu, nlsMenuAdmin
			){
////
return declare(null, {
	
	errorInfo: {
				class: "layout/containers/Navigation",
				},
	element: null,
	dim: new Object(),
	module: null,
	
	constructor: function(strModule){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.module = strModule;
			//CREATE DIV TO PLACE MENU DIJIT IN
			var div = domConstruct.create("div", {
					id: "l-main-menu",
					class: "pos-absolute c-w-180 c-margin c-padding c-h-50",
				}, "l-page-layout");
			////////////////////////////////////////
			
			//CREATE TOP LEVEL MENU ITEM
			var menu = new Menu({ style: "display: none;"});
			///////////////////////////////////////////////////
			var menuType = null;
			switch(this.module){
				case "default":
					menuType = nlsMenu;
					break;
				case "admin":
					menuType = nlsMenuAdmin;
					break;
				default:
					break;
			}
			//START CREATING MENU OPTIONS
			for(var i = 0; i < menuType.menu.length; i++){
				//IF NO SUBMENU OPTIONS...
				if(menuType.menu[i].submenu == null){
					var href = this.makeHref(menuType.menu[i]);
					var menuItem = new MenuItem({
						label: menuType.menu[i].label,
						"data-mysa-prop": { href: href, }, 
					});
					on(menuItem, "click", function(){
						window.location.href = this["data-mysa-prop"].href;
					});
					menu.addChild(menuItem);
				}
				//IF HAS A SUBMENU....
				else{
					//CREATE A NEW SUBMENU ITEM
					var subMenu = new Menu({ style: "display: none;"});
					//START CREATING SUBMENU ITEMS TO ATTACH TO SUBMENU 
					for(var j = 0; j < menuType.menu[i].submenu.length; j++){
						//IF NO SUBMENU OPTIONS...
						if(menuType.menu[i].submenu[j].submenu == null){
							var href = this.makeHref(menuType.menu[i].submenu[j]);
							var menuItem = new MenuItem({
								label: menuType.menu[i].submenu[j].label,
								"data-mysa-prop": { href: href, },
							});
							on(menuItem, "click", function(){
								window.location.href = this["data-mysa-prop"].href;
							});
							subMenu.addChild(menuItem);
						}
						//HAS A SUBMENU...
						else{
							//var subSubMenu = new Menu({ style: "display: none;"});
						}
					}
					menu.addChild(new PopupMenuItem({	label: menuType.menu[i].label,
														popup: subMenu
													}));
				}
			}
			var button = new DropDownButton({
				label: "Main Menu",
				style: "font-size: 18px;",
				dropDown: menu,
			});
			dom.byId("l-main-menu").appendChild(button.domNode);
			this.element = div;
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	get: function(){
		try{
			return this.element;
		}
		catch(e){
			console.error(this.eHandle.output(e, "get"))
		}
	},

	getDim: function(){
		try{
			var computedStyle = domStyle.getComputedStyle(this.element);
			var box = domGeom.getMarginBox(this.element, computedStyle);
			box.r = box.l + box.w;
			box.b = box.t + box.h;
			return box; 
		}
		catch(e){
			console.error(this.eHandle.output(e, "getDim"))
		}
	},

	makeHref: function(obj){
		try{
			var href = "/";
			if(obj.module == "default"){
			}
			else{
				href += obj.module + "/";
			}
			return href + obj.controller + "/" + obj.action;
		}
		catch(e){
			console.error(this.eHandle.output(e, "makeHref"))
		}
	},
	
	ShowSectionMenu: function(objParams){
		try{
			var showSectionMenu = false;
			for (var i = 0; i < nlsMenu.menu.length; i++){
				if(nlsMenu.menu[i].submenu == null){
					if(nlsMenu.menu[i].module == objParams.module && nlsMenu.menu[i].controller == objParams.controller	&& nlsMenu.menu[i].action == objParams.action){
						break;
					}
				}
				else{
					for(var j = 0; j < nlsMenu.menu[i].submenu.length; j++){
					  if(nlsMenu.menu[i].submenu[j].module == objParams.module && nlsMenu.menu[i].submenu[j].controller == objParams.controller	&& nlsMenu.menu[i].submenu[j].action == objParams.action){
							showSectionMenu = i;
							break;
						}
					}
				}
			}
			return showSectionMenu;
		}
		catch(e){
			console.error(this.eHandle.output(e, "ShowSectionMenu"))
		}
	},

});
////
});