define(["dojo/_base/declare", "dojo/dom", "dojo/dom-construct", "dojo/dom-attr", "dojo/dom-class", "dojo/dom-style", "dojo/dom-geometry", "dojo/query", "dojo/string", "dojo/on",
		"dijit/layout/BorderContainer", "dijit/layout/ContentPane",
		"dijit/MenuBar", "dijit/MenuBarItem", "dijit/PopupMenuBarItem", "dijit/PopupMenuItem", "dijit/Menu", "dijit/MenuItem", "dijit/DropDownMenu", "dijit/form/DropDownButton",
		"mysa/utility/Format1", "mysa/utility/myError",
		"dojo/i18n!mysa/nls/ModConPage", "dojo/i18n!mysa/nls/Menu",
		"dojo/domReady!"],
function(	// DOJO FILES
			declare, dom, domConstruct, domAttr, domClass, domStyle, domGeom, query, string, on,
			// DIJIT FILES
			BorderContainer, ContentPane,
			MenuBar, MenuBarItem, PopupMenuBarItem, PopupMenuItem, Menu, MenuItem, DropDownMenu, DropDownButton, 
			// MYSA FILES
			Format1, myError,
			MCP, nlsMenu
			){
////
return declare(null, {
	
	errorInfo: {
				class: "layout/containers/SectionMenu",
				},
	element: null,
	dim: new Object(),
	
	constructor: function(intMenu){
		this.eHandle = new myError(this.errorInfo);
		try{
			var div = domConstruct.create("div", {
					id: "l-section-menu",
					class: "pos-absolute c-w-180 c-margin c-padding c-h-50",
				}, "l-page-layout");

			var menu = new Menu({ style: "display: none;"});
			///////////////////////////////////////////////////
			
			//IF NO SUBMENU OPTIONS...
			if(nlsMenu.menu[intMenu].submenu == null){
				var href = this.makeHref(nlsMenu.menu[intMenu]);
				var menuItem = new MenuItem({
					label: nlsMenu.menu[intMenu].label,
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
				for(var j = 0; j < nlsMenu.menu[intMenu].submenu.length; j++){
					//IF NO SUBMENU OPTIONS...
					if(nlsMenu.menu[intMenu].submenu[j].submenu == null){
						var href = this.makeHref(nlsMenu.menu[intMenu].submenu[j]);
						var menuItem = new MenuItem({
							label: nlsMenu.menu[intMenu].submenu[j].label,
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
				menu.addChild(new PopupMenuItem({	label: nlsMenu.menu[intMenu].label,
													popup: subMenu
												}));
			}
	
			var button = new DropDownButton({
				label: "Section Menu",
				style: "font-size: 18px;",
				dropDown: menu,
				scrollOnFocus:false
			});
			dom.byId("l-section-menu").appendChild(button.domNode);
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
				href += obj.module;
			}
			return href + obj.controller + "/" + obj.action;
		}
		catch(e){
			console.error(this.eHandle.output(e, "makeHref"))
		}
	},
	
});
////
});