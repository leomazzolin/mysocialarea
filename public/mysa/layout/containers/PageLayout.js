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
				class: "layout/containers/PageLayout",
				},
	element: null,
	screenData: new Object(),
	
	constructor: function(data){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.screenData = data;
			this.element = domConstruct.create("div", {
													id: "l-page-layout",
													class: "pos-absolute",
													}, "l-body" );
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

	setDim: function(obj){
		try{
			var height = 0;
			var width = 0;
			for(key in obj){
			  var objHeight = obj[key].t + obj[key].h;
				if(objHeight > height){
					height = objHeight;
				}
			}
			domStyle.set( this.element, {height: height + "px"});

			if(this.screenData.width > domStyle.get(this.element, "width")){
				var left = (this.screenData.width - domStyle.get(this.element, "width")) / 2 + "px";
				domStyle.set(this.element, "left", left);
			}
		}
		catch(e){
			console.error(this.eHandle.output(e, "getDim"))
		}
	},
	
});
////
});