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
	
	constructor: function(identity){
		this.identity = identity
	},
	
	viewOverview: function(){
		var format = new Format1();
		var place = "view-content";
		var html = null;
		var inputs = {"innerHTML":"UserID", "place": place};
		this.header(inputs);
		domConstruct.create("p", {	innerHTML: format.userID(this.identity.id),
									class: "personal-data2" }, place );
		var inputs = {"innerHTML":"Screen ID", "place": place};
		this.header(inputs);
		domConstruct.create("p", {	innerHTML: format.screenID(this.identity.username, this.identity.id),
									class: "personal-data2",
									style: "padding: 10px;" }, place );
		domConstruct.create("p", {	innerHTML: "Your screen name is your username combined with your UserID to help keep your personal info private.",
									class: "p1 personal-data2" }, place );
		var inputs = {"innerHTML":"Email", "place": place};
		this.header(inputs);
		domConstruct.create("p", {	innerHTML: this.identity.email,
									class: "personal-data2" }, place );
		var inputs = {"innerHTML":"Personal Info", "place": place};
		this.header(inputs);
		domConstruct.create("p", {	innerHTML: "Name:  " + this.identity.name,
									class: "personal-data2" }, place );
		domConstruct.create("p", {	innerHTML: "Username:  " + this.identity.username,
									class: "personal-data2" }, place );
		domConstruct.create("p", {	innerHTML: "Birthday:  " + this.identity.birthday,
									class: "personal-data2" }, place );
		domConstruct.create("p", {	innerHTML:"Member Since:  " +  this.identity.created,
									class: "personal-data2" }, place );
		var inputs = {"innerHTML":"Facebook Status", "place": place};
		this.header(inputs);
		if(this.identity.fb_id == false){
			html = "Not linked to your Facebook profile";
		}else{
			html = "Connected";
		}
		domConstruct.create("p", {	innerHTML: html,
									class: "personal-data2" }, place );
	},
	
	header: function(inputs){
		domConstruct.create("h3", {	innerHTML: inputs.innerHTML,
									class: "header1" }, inputs.place);
	},
});
////
});