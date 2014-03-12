// JavaScript Document
define(["dojo/_base/declare", "dojo/dom", "dojo/dom-construct", "dojo/on", "dojo/string",
		"dijit/registry", "dijit/layout/BorderContainer", "dijit/layout/ContentPane",
		"dijit/MenuBar", "dijit/MenuBarItem", "dijit/PopupMenuBarItem", "dijit/PopupMenuItem", "dijit/Menu", "dijit/MenuItem", "dijit/DropDownMenu",
		"dijit/form/ComboButton", "mysa/utility/Format1",
		"dojo/domReady!"],
function(declare, dom, domConstruct, on, string,
			registry, BorderContainer, ContentPane,
			MenuBar, MenuBarItem, PopupMenuBarItem, PopupMenuItem, Menu, MenuItem, DropDownMenu,
			ComboButton, Format1){
////
return declare(null, {
	
	constructor: function(){
	},
	makeMsgBox: function(jArg){
		domConstruct.create("div", {
								class: "msgbox",
								innerHTML: jArg.innerHTML,
							}, jArg.place, "first");
	},
	
	makeSectionMenu: function(jArray){
		var place = "view-content";
		var combobutton = domConstruct.create("div", {	id: "vw-sectionmenu", }, place);
		var menu = new Menu({
							style: "display: none;"
							});
		for(var i = 0; i < jArray.length; i++){
			var menuItem = new MenuItem({
											label: jArray[i].label,
											"data-mysa-href": jArray[i].href,
										});
			on(menuItem, "click", function(){
			 	window.location.href = this.get("data-mysa-href");
			});
			menu.addChild(menuItem);
		}

		var button = new ComboButton({
										label: "Section Menu:",
										style: "font-size: 14px;",
										dropDown: menu,
									}, combobutton);
	},

	makePageMenu: function(jArray){
		var place = "view-content";
		var combobutton = domConstruct.create("div", {	id: "vw-pagemenu", }, place);
		var menu = new Menu({
							style: "display: none;"
							});
		for(var i = 0; i < jArray.length; i++){
			var menuItem = new MenuItem({
											label: jArray[i].label,
											"data-mysa-href": jArray[i].href,
										});
			on(menuItem, "click", function(){
			 	window.location.href = this.get("data-mysa-href");
			});
			menu.addChild(menuItem);
		}

		var button = new ComboButton({
										label: "Page Menu:",
										style: "font-size: 14px;",
										dropDown: menu,
									}, combobutton);
	},

});
//END DECLARE
});
//END DEFINE AND FUNCTION