define(["dojo/_base/declare", "dojo/dom", "dojo/dom-construct", "dojo/string", "dojo/on",
		"dijit/layout/BorderContainer", "dijit/layout/ContentPane",
		"dijit/MenuBar", "dijit/MenuBarItem", "dijit/PopupMenuBarItem", "dijit/PopupMenuItem", "dijit/Menu", "dijit/MenuItem", "dijit/DropDownMenu", "dijit/form/ComboButton",
		"mysa/utility/Format1", "mysa/utility/myError",
		"dojo/i18n!mysa/nls/ModConPage",
		"dojo/domReady!"],
function(declare, dom, domConstruct, string, on,
			BorderContainer, ContentPane,
			MenuBar, MenuBarItem, PopupMenuBarItem, PopupMenuItem, Menu, MenuItem, DropDownMenu, ComboButton,
			Format1, myError,
			MCP
			){
////
return declare(null, {
	
	errorInfo: {
				class: "layout/Admin",
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
		}, "l-template-container");
		//MAKE CENTER PANE
		cp = new ContentPane({
			id: "l-center",
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
									id: "l-center-content",
									style: "float: left; width: 700px;"
									 }, "l-center", "last");
		var sideContent = domConstruct.create("div", {
									id: "l-center-side",
									style: "float: left; width: 300px;"
									 }, "l-center", "last");
		this.makeMenuPlaceholder(centerContent);
		}
	catch(e){
		console.error(this.eHandle.output(e, "setupContentDiv"))
	}

    },
	
	NotSignedIn: function(){
	try{
		var combobutton = domConstruct.create("div", {	id: "l-combobutton", }, "l-subheader-1");
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

		var button = new ComboButton({
			label: "Enter MySocialArea.com",
			style: "font-size: 10px;",
			dropDown: menu,
		}, combobutton);
	}
	catch(e){
		console.error(this.eHandle.output(e, "NotSignedIn"))
	}
	},

	SignedIn: function(){
	try{
		var p = new domConstruct.create("p", { id: "l-auth-status", innerHTML: "Hi, " + this.layoutPayload.identity.name,
												class: "personal-data1" }, "l-subheader-1");
		var br =  new domConstruct.create("br", { }, "l-auth-status");				
		var a1 = new domConstruct.create("a", { href: "/user/logout", innerHTML: "Log out",
												class: "personal-data1" }, "l-auth-status");
	}
	catch(e){
		console.error(this.eHandle.output(e, "SignedIn"))
	}
	},

	SignInError: function(error){
	try{
		//var screenID = this.user.formattedScreenID();
		var p = new domConstruct.create("p", { id: "l-auth-status", innerHTML: error,
												class: "personal-data1" }, "l-subheader-1");
	}
	catch(e){
		console.error(this.eHandle.output(e, "SignedIn"))
	}
	},

	makeHeader: function(){
	try{
		var header = domConstruct.create("div", {	id: "l-header" }, "l-center");
		var subheader2 = domConstruct.create("div", {	id: "l-subheader-1", }, header);
		switch (this.layoutPayload.identity){
			case null:
				//this.NotSignedIn();
				break;
			case this.layoutPayload.globals.constants.errors.identity:
				this.SignInError(this.layoutPayload.globals.constants.errors.identity);
				break;
			default:
				this.SignedIn();
				break;
		}
		
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
													id: "l-title",
													innerHTML: pagetitle,
												}, "l-center");										
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