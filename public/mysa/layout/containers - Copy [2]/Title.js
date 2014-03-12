define(["dojo/_base/declare", "dojo/dom", "dojo/dom-construct", "dojo/dom-attr", "dojo/dom-class", "dojo/dom-style", "dojo/dom-geometry", "dojo/query", "dojo/string", "dojo/on",
		"dijit/layout/BorderContainer", "dijit/layout/ContentPane",
		"dijit/MenuBar", "dijit/MenuBarItem", "dijit/PopupMenuBarItem", "dijit/PopupMenuItem", "dijit/Menu", "dijit/MenuItem", "dijit/DropDownMenu", "dijit/form/ComboButton",
		"mysa/utility/Format1", "mysa/utility/myError",
		"dojo/i18n!mysa/nls/ModConPage",
		"dojo/domReady!"],
function(	// DOJO FILES
			declare, dom, domConstruct, domAttr, domClass, domStyle, domGeom, query, string, on,
			// DIJIT FILES
			BorderContainer, ContentPane,
			MenuBar, MenuBarItem, PopupMenuBarItem, PopupMenuItem, Menu, MenuItem, DropDownMenu, ComboButton, 
			// MYSA FILES
			Format1, myError,
			MCP
			){
////
return declare(null, {
	
	errorInfo: {
				class: "layout/containers/Title",
				},
	element: null,
	dim: new Object(),
	
	constructor: function(){
		this.eHandle = new myError(this.errorInfo);
		try{
			//this.data = data;
			this.element = domConstruct.create("div", {	
												id: "l-title",
												innerHTML: "TITLE BAR",
												class: "pos-absolute",
												}, "l-page-layout");
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

	setLocation: function(main, section){
		try{
			domStyle.set(this.element, {
										top: section.t + "px",
										left: section.l + section.w + "px",
										width: 1035 - main.w - section.w + "px"});
		}
		catch(e){
			console.error(this.eHandle.output(e, "setLocation"))
		}
	},
	
});
////
});