define(["dojo/_base/declare", "dojo/dom", "dojo/dom-construct", "dojo/dom-attr", "dojo/dom-class", "dojo/dom-style", "dojo/dom-geometry", "dojo/query", "dojo/string", "dojo/on",
		"dijit/layout/BorderContainer", "dijit/layout/ContentPane",
		"dijit/MenuBar", "dijit/MenuBarItem", "dijit/PopupMenuBarItem", "dijit/PopupMenuItem", "dijit/Menu", "dijit/MenuItem", "dijit/DropDownMenu", "dijit/form/DropDownButton",
		"mysa/utility/Format1", "mysa/utility/myError",
		"dojo/i18n!mysa/nls/ModConPage",
		"dojo/domReady!"],
function(	// DOJO FILES
			declare, dom, domConstruct, domAttr, domClass, domStyle, domGeom, query, string, on,
			// DIJIT FILES
			BorderContainer, ContentPane,
			MenuBar, MenuBarItem, PopupMenuBarItem, PopupMenuItem, Menu, MenuItem, DropDownMenu, DropDownButton, 
			// MYSA FILES
			Format1, myError,
			MCP
			){
////
return declare(null, {
	
	errorInfo: {
				class: "layout/containers/Auth",
				},
	element: null,
	dim: new Object(),
	logo: {long: "MySocialArea.com", short: "MySA"},
	
	constructor: function(){
		this.eHandle = new myError(this.errorInfo);
		try{
			var combobutton = domConstruct.create("div", {
					id: "l-auth",
					class: "pos-absolute",
				}, "l-page-layout");

			var menu = new Menu({ style: "display: none;"});
			var menuItem1 = new MenuItem({
				label: "Login",
				onClick: function(){ window.location.href = "/user/login"; }
			});
			menu.addChild(menuItem1);
		
			var menuItem2 = new MenuItem({
				label: "Register",
				onClick: function(){ window.location.href = "/user/register"; }
	
			});
			menu.addChild(menuItem2);
		
			var menuItem3 = new MenuItem({
				label: "Forgot Password",
				onClick: function(){ window.location.href = "/user/forgotpassword"; }
			});
			menu.addChild(menuItem3);
	
			var button = new DropDownButton({
				label: "Enter MySocialArea.com",
				style: "font-size: 14px;",
				dropDown: menu,
			});
			dom.byId("l-auth").appendChild(button.domNode);
			this.element = combobutton;
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	getDim: function(){
		try{
			var computedStyle = domStyle.getComputedStyle(this.element);
			return domGeom.getMarginBox(this.element, computedStyle);
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