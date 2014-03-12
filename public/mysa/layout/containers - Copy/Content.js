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
				class: "layout/containers/Content",
				},
	element: null,
	data: new Object(),
	
	constructor: function(data){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.data = data;
			this.element = domConstruct.create("div", {
													id: "l-content",
													}, "l-body" );
			switch(true){
				case (this.data.width <= 320):
					alert('less than 320');
					break;
				case (this.data.width > 320 && this.data.width <= 540):
					alert('less than 320');
					break;
				case (this.data.width > 540 && this.data.width <= 1200):
					alert('less than 320');
					break;
				default:
					domStyle.set("l-content", {
												margin: "auto",
												width: "1045px",
												});
					break;
			}

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

	setHeight: function(obj){
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
			/*
			for(key in obj){
			  var objWidth = obj[key].l + obj[key].w;
				if(objWidth > width){
					width = objWidth;
				}
			}
			domStyle.set( this.element, {width: width + "px"});
			*/
		}
		catch(e){
			console.error(this.eHandle.output(e, "getDim"))
		}
	},
	
});
////
});