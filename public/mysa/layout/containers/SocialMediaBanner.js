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
				class: "layout/containers/SocialMediaBanner",
				},
	element: null,
	logo: {long: "MySocialArea.com", short: "MySA"},
	
	constructor: function(){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.element = domConstruct.create("div", {
				id: "l-social-media-banner",
				class: "pos-absolute",
				//style: "margin-left: 100px;",
			}, "l-page-layout");
			
			var div = domConstruct.create("div", {	class:"fb-like",
													style: "margin-right: 10px;",
													"data-href":"http://www.mysocialarea.com",
													"data-send":"true",
													"data-layout":"button_count",
													"data-width":"150",
													"data-show-faces":"true",
													"data-font":"arial" }, this.element);
			var a = domConstruct.create("a", {	href: "https://twitter.com/mysocialarea",
												class:"twitter-follow-button",
												//style: "background-color: yellow;",
												"data-show-count":"false",
												"data-lang":"en",
												innerHTML:"Follow @MySA" }, this.element);
			var divSpacer = domConstruct.create("div", {
															style:"width: 10px; height: 10px; display: inline;",
															innerHTML: "&nbsp;&nbsp;&nbsp;",
														}, this.element);
			var div1 = domConstruct.create("div", {	class:"g-plusone",
													"data-size": "medium",
													//"data-annotation": "inline",
													//"data-width": "300"
													//innerHTML: "G-PlusOne",
													}, this.element);
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

	setLocation: function(obj){
		try{
			domStyle.set(this.element, {top: 5 + "px", left: obj.l + obj.w + 10 + "px"});
		}
		catch(e){
			console.error(this.eHandle.output(e, "setLocation"))
		}
	},
	
});
////
});