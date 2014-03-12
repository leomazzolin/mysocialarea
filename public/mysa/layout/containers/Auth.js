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
	
	constructor: function(identity){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.element = domConstruct.create("div", {
					id: "l-auth",
					class: "pos-absolute c-w-180 c-h-90 c-margin c-padding",
				}, "l-page-layout");
			if(identity == null){	
				var menu = new Menu({ 
										style: "display: none;",
									});
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
					style: "font-size: 12px;",
					dropDown: menu,
					scrollOnFocus:false
				});
				dom.byId("l-auth").appendChild(button.domNode);
			}
			else{
				var format = new Format1();
				var screenID = format.screenID(identity.username, identity.id);
				//var screenID = this.user.formattedScreenID();
				var authStatus = new domConstruct.create("p", { id: "default-l-auth-status", innerHTML: "Hi,<br />" + screenID,
														class: "personal-data1" }, this.element);
				var br =  new domConstruct.create("br", { }, authStatus);				
				var a =  new domConstruct.create("a", { href: "/user/index", innerHTML: "My Profile", style: "margin-right: 10px;",
														class: "personal-data1" }, authStatus);
				var a1 = new domConstruct.create("a", { href: "/user/logout", innerHTML: "Log out",
														class: "personal-data1" }, authStatus);				
			}
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