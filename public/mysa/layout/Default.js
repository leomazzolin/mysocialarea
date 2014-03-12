define(["dojo/_base/declare", "dojo/dom", "dojo/dom-construct", "dojo/string", "dojo/on",
		"dijit/layout/BorderContainer", "dijit/layout/ContentPane",
		"dijit/MenuBar", "dijit/MenuBarItem", "dijit/PopupMenuBarItem", "dijit/PopupMenuItem", "dijit/Menu", "dijit/MenuItem", "dijit/DropDownMenu", "dijit/form/DropDownButton",
		"mysa/utility/Format1", "mysa/utility/myError",
		"dojo/i18n!mysa/nls/ModConPage",
		"dojo/domReady!"],
function(declare, dom, domConstruct, string, on,
			BorderContainer, ContentPane,
			MenuBar, MenuBarItem, PopupMenuBarItem, PopupMenuItem, Menu, MenuItem, DropDownMenu, DropDownButton,
			Format1, myError,
			MCP
			){
////
return declare(null, {
	
	errorInfo: {
				class: "layout/Metrics",
				},
	layoutPayload: null,
	
	constructor: function(lp){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.layoutPayload = lp;
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	make: function(){
	try{
				this.makeWireFrame();
				this.makeHeader();
				this.makeTitle();
				this.setupContentDiv();
	}
	catch(e){
		console.error(this.eHandle.output(e, "makeLayout"))
	}
	},

    makeWireFrame: function(){
	try{
		var bc;
		var cp;
		//MAKE BORDER
		bc = new BorderContainer({
			style: "width: 100%; height: 100%;",
			gutters: false,
			//liveSplitters: false,
		}, this.layoutPayload.globals.attch_pts.default.layout.container);
		//MAKE CENTER PANE
		cp = new ContentPane({
			id: this.layoutPayload.globals.attch_pts.default.layout.panes.center,
			style: "margin:0; padding:0;",
			region: "center",
		});
		bc.addChild(cp);
		bc.startup();
		}
	catch(e){
		console.error(this.eHandle.output(e, "makeWireFrame"))
	}

    },

    setupContentDiv: function(){
	try{
		var centerContent = domConstruct.create("div", {
									id: this.layoutPayload.globals.attch_pts.default.layout.content.center,
									style: "float: left; width: 700px;"
									 }, this.layoutPayload.globals.attch_pts.default.layout.panes.center, "last");
		var sideContent = domConstruct.create("div", {
									id: this.layoutPayload.globals.attch_pts.default.layout.content.side,
									style: "float: left; width: 300px;"
									 }, this.layoutPayload.globals.attch_pts.default.layout.panes.center, "last");
		this.makeMenuPlaceholder(centerContent);
		}
	catch(e){
		console.error(this.eHandle.output(e, "setupContentDiv"))
	}

    },
	
	NotSignedIn: function(){
	try{
		var combobutton = domConstruct.create("div", {
				id: "default-l-combobutton",
			}, this.layoutPayload.globals.attch_pts.default.layout.header.sub1);
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
		}, combobutton);
	}
	catch(e){
		console.error(this.eHandle.output(e, "NotSignedIn"))
	}
	},

	SignedIn: function(){
	try{
		var format = new Format1();
		var screenID = format.screenID(this.layoutPayload.identity.username, this.layoutPayload.identity.id);
		//var screenID = this.user.formattedScreenID();
		var authStatus = new domConstruct.create("p", { id: "default-l-auth-status", innerHTML: "Hi,<br />" + screenID,
												class: "personal-data1" }, this.layoutPayload.globals.attch_pts.default.layout.header.sub1);
		var br =  new domConstruct.create("br", { }, authStatus);				
		var a =  new domConstruct.create("a", { href: "/user/index", innerHTML: "My Profile", style: "margin-right: 10px;",
												class: "personal-data1" }, authStatus);
		var a1 = new domConstruct.create("a", { href: "/user/logout", innerHTML: "Log out",
												class: "personal-data1" }, authStatus);
	}
	catch(e){
		console.error(this.eHandle.output(e, "SignedIn"))
	}
	},

	SignInError: function(error){
	try{
		//var screenID = this.user.formattedScreenID();
		var p = new domConstruct.create("p", { id: "default-l-auth-status", innerHTML: error,
												class: "personal-data1" }, this.layoutPayload.globals.attch_pts.default.layout.header.sub1);
	}
	catch(e){
		console.error(this.eHandle.output(e, "SignedIn"))
	}
	},

	makeHeader: function(){
	try{
		var header = domConstruct.create("div", {
			id: this.layoutPayload.globals.attch_pts.default.layout.header.holder,
		}, this.layoutPayload.globals.attch_pts.default.layout.panes.center);
		//MAKE LOGO -- SUBHEADER 1
		var subheader1 = domConstruct.create("div", {
			id: this.layoutPayload.globals.attch_pts.default.layout.header.sub1,
		}, header);
		var a = domConstruct.create("a", {	href: "/", style: "text-decoration:none;" }, subheader1);
		var h2 = domConstruct.create("h2", { id:"default-l-logo-1", innerHTML: "MySocialArea" }, a);
		//MAKE AUTH SUBHEADER-2
		var subheader2 = domConstruct.create("div", {
			id: this.layoutPayload.globals.attch_pts.default.layout.header.sub2,
			//style: "background-color: #00CC66;"
		}, header);
		switch (this.layoutPayload.identity){
			case null:
				this.NotSignedIn();
				break;
			case this.layoutPayload.globals.constants.errors.identity:
				this.SignInError(this.layoutPayload.globals.constants.errors.identity);
				break;
			default:
				this.SignedIn();
				break;
		}
//		if(this.layoutPayload.identity == null){
//			this.NotSignedIn();
//		}else{
//			this.SignedIn();
//		}
		var div = domConstruct.create("div", {	class:"fb-like",
												style: "margin-right: 10px;",
												"data-href":"http://www.mysocialarea.com",
												"data-send":"true",
												"data-layout":"button_count",
												"data-width":"150",
												"data-show-faces":"true",
												"data-font":"arial" }, subheader2);
		var a = domConstruct.create("a", {	href: "https://twitter.com/mysocialarea",
											class:"twitter-follow-button",
											"data-show-count":"false",
											"data-lang":"en",
											innerHTML:"Follow @MySA" }, subheader2);
		var divSpacer = domConstruct.create("div", {
														style:"width: 10px; height: 10px; display: inline;",
														innerHTML: "&nbsp;&nbsp;&nbsp;",
													}, subheader2);
		var div1 = domConstruct.create("div", {	class:"g-plusone",
												"data-size": "medium",
												//"data-annotation": "inline",
												//"data-width": "300"
												}, subheader2);
		var br = domConstruct.create("br", { }, subheader2);												

		//WILL NOT RENDER GOOGLE AD
		/*
		var subheader3 = domConstruct.create("div", {	id: this.layoutPayload.globals.attch_pts.default.layout.header.sub3, }, header);
		var script = domConstruct.create("script", {type: "text/javascript",
													src: "/scripts/google/banner.js" }, subheader3);			
		var script = domConstruct.create("script", {type: "text/javascript",
													src: "http://pagead2.googlesyndication.com/pagead/show_ads.js" }, subheader3);
		*/
		
	}
	catch(e){
		console.error(this.eHandle.output(e, "makeHeader"))
	}
	},
	
	makeTitle: function(){
	try{
		var pagetitle = "";
		var separator1 = ": ";
		var separator2 = "...";
		var iModule = 0;
		for(var  i = 0; i < MCP.module.length; i++){
			if(MCP.module[i].name == this.layoutPayload.params.module){
				if(MCP.module[i].title != null){
					pagetitle = MCP.module[i].title;
				}
				iModule = i;
			}
		}
		var iController = 0;
		for(var  i = 0; i < MCP.module[iModule].controller.length; i++){
			if(MCP.module[iModule].controller[i].name == this.layoutPayload.params.controller){
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
			if(MCP.module[iModule].controller[iController].action[i].name == this.layoutPayload.params.action){
				if(MCP.module[iModule].controller[iController].action[i].title != null){
					if(pagetitle != ""){
						pagetitle = pagetitle + separator2;
					}
					pagetitle = pagetitle + MCP.module[iModule].controller[iController].action[i].title;
				}
				iAction = i;
			}
		}
		var divTitle = domConstruct.create("div",{
													id: "default-l-title",
													innerHTML: pagetitle,
												}, this.layoutPayload.globals.attch_pts.default.layout.panes.center);										
	}
	catch(e){
		console.error(this.eHandle.output(e, "makeTitle"))
	}
	},

	formattedScreenID: function(){
	try{
		return this.layoutPayload.jsonIdentity.username + "_" + string.pad(this.layoutPayload.jsonIdentity.id, 4);
	}
	catch(e){
		console.error(this.eHandle.output(e, "formattedScreenID"))
	}
	},

	makeMenuPlaceholder: function(node){
	try{
		var div = domConstruct.create("div", {
											class:"menu-placeholder",
												}, node);
		
	}
	catch(e){
		console.error(this.eHandle.output(e, "makeTitle"))
	}
	},

	formattedScreenID: function(){
	try{
		return this.layoutPayload.jsonIdentity.username + "_" + string.pad(this.layoutPayload.jsonIdentity.id, 4);
	}
	catch(e){
		console.error(this.eHandle.output(e, "formattedScreenID"))
	}
	}

	
});
////
});