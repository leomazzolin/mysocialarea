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
				class: "layout/containers/Navigation",
				},
	element: null,
	dim: new Object(),
	
	constructor: function(){
		this.eHandle = new myError(this.errorInfo);
		try{
			var div = domConstruct.create("div", {
					id: "l-main-menu",
					class: "pos-absolute",
				}, "l-page-layout");

			var menu = new Menu({ style: "display: none;"});
			var menuItem1 = new MenuItem({
				label: "HOME",
				onClick: function(){ window.location.href = "/"; }
			});
			menu.addChild(menuItem1);
		
			var menuItem2 = new MenuItem({
				label: "Contact Us",
				onClick: function(){ window.location.href = "/contactus/index"; }
	
			});
			menu.addChild(menuItem2);
		
			var menuItem3 = new MenuItem({
				label: "Help",
				onClick: function(){ window.location.href = "/help/index"; }
			});
			menu.addChild(menuItem3);
	
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

	setLocation: function(dim){
		try{
			domStyle.set(this.element, {top: dim.t + dim.h + "px"});
		}
		catch(e){
			console.error(this.eHandle.output(e, "setLocation"))
		}
	},
	
});
////
});