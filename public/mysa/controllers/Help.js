// JavaScript Document
define(["dojo/_base/declare", "dojo/dom", "dojo/dom-construct", "dojo/on",
		"dijit/layout/BorderContainer", "dijit/layout/ContentPane",
		"dijit/MenuBar", "dijit/MenuBarItem", "dijit/PopupMenuBarItem", "dijit/PopupMenuItem", "dijit/Menu", "dijit/MenuItem", "dijit/DropDownMenu",
		"dijit/form/ComboButton",
		"dojo/domReady!"],
function(declare, dom, domConstruct, on,
			BorderContainer, ContentPane,
			MenuBar, MenuBarItem, PopupMenuBarItem, PopupMenuItem, Menu, MenuItem, DropDownMenu,
			ComboButton){
////
return declare(null, {
	
	constructor: function(){
	},
	
	makeSideMenu: function(){
		domConstruct.create("h3", {	innerHTML: "Help Menu:" }, "vw-sidemenu-container");
		var div = domConstruct.create("div", {	id: "vw-sidemenu" }, "vw-sidemenu-container");
		var pMenu;
		pMenu = new Menu({
			//targetNodeIds: ["vw-sidemenu"],//
		}, "vw-sidemenu");
		
		pMenuItem = new MenuItem({	label: "Overview" });
		pMenu.addChild(pMenuItem);
		on(pMenuItem, "click", function(){
          window.location.href = "/help/index";
		});
		
		pMenuItem = new MenuItem({	label: "Terms of Use" });
		pMenu.addChild(pMenuItem);
		on(pMenuItem, "click", function(){
          window.location.href = "/help/tou";
		});

		pMenuItem = new MenuItem({	label: "Privacy" });
		pMenu.addChild(pMenuItem);
		on(pMenuItem, "click", function(){
          window.location.href = "/help/privacy";
		});
		
		pMenuItem = new MenuItem({	label: "FAQ" });
		pMenu.addChild(pMenuItem);
		on(pMenuItem, "click", function(){
          //window.location.href = "/help/privacy";
		});

		pMenuItem = new MenuItem({	label: "What this Website is" });
		pMenu.addChild(pMenuItem);
		on(pMenuItem, "click", function(){
          //window.location.href = "/help/privacy";
		});
		
		pMenuItem = new MenuItem({	label: "What this Website isn&apos;t" });
		pMenu.addChild(pMenuItem);
		on(pMenuItem, "click", function(){
          //window.location.href = "/help/privacy";
		});
		pMenu.startup();
	},
	
});
////
});