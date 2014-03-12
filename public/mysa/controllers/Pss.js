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
		domConstruct.create("h3", {	innerHTML: "PSS Menu:" }, "vw-sidemenu-container");
		var div = domConstruct.create("div", {	id: "vw-sidemenu-options" }, "vw-sidemenu-container");
		var pMenu;
		pMenu = new Menu({
			//targetNodeIds: ["vw-sidemenu"],//
		}, "vw-sidemenu-options");
		
		pMenuItem = new MenuItem({	label: "Overview" });
		pMenu.addChild(pMenuItem);
		on(pMenuItem, "click", function(){
          window.location.href = "/pss/index";
		});
		
		pMenuItem = new MenuItem({	label: "Photo Gallery" });
		pMenu.addChild(pMenuItem);
		on(pMenuItem, "click", function(){
          window.location.href = "/pss/collage";
		});

		pMenuItem = new MenuItem({	label: "Your Pet Pages" });
		pMenu.addChild(pMenuItem);
		on(pMenuItem, "click", function(){
          window.location.href = "/pss/pages";
		});
		
		pMenuItem = new MenuItem({	label: "Pet Page Search" });
		pMenu.addChild(pMenuItem);
		on(pMenuItem, "click", function(){
          window.location.href = "/pss/search";
		});
		
		pMenuItem = new MenuItem({	label: "Feedback" });
		pMenu.addChild(pMenuItem);
		on(pMenuItem, "click", function(){
          window.location.href = "/pss/feedback";
		});
		pMenu.startup();
		domConstruct.create("br", { }, "vw-sidemenu-container");
	},
	
});
////
});