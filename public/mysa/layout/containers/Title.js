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
												//style: "width: 400px;",
												class: "pos-absolute c-margin c-padding c-h-50",
												}, "l-page-layout");
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

	makeTitle: function(params){
		try{
			var pagetitle = "";
			var separator1 = ": ";
			var separator2 = "...";
			var iModule = 0;
			for(var  i = 0; i < MCP.module.length; i++){
				if(MCP.module[i].name == params.module){
					if(MCP.module[i].title != null){
						pagetitle = MCP.module[i].title;
					}
					iModule = i;
				}
			}
			var iController = 0;
			for(var  i = 0; i < MCP.module[iModule].controller.length; i++){
				if(MCP.module[iModule].controller[i].name == params.controller){
					if(MCP.module[iModule].controller[i].title != null){
						if(pagetitle != ""){
							pagetitle = pagetitle + separator1;
						}
						pagetitle = pagetitle + MCP.module[iModule].controller[i].title;
					}
					iController = i;
				}
			}
			var iAction = 0;
			for(var  i = 0; i < MCP.module[iModule].controller[iController].action.length; i++){
				if(MCP.module[iModule].controller[iController].action[i].name == params.action){
					if(MCP.module[iModule].controller[iController].action[i].title != null){
						if(pagetitle != ""){
							pagetitle = pagetitle + separator2;
						}
						pagetitle = pagetitle + MCP.module[iModule].controller[iController].action[i].title;
					}
					iAction = i;
				}
			}
			return pagetitle;
		}
		catch(e){
			console.error(this.eHandle.output(e, "makeTitle"))
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