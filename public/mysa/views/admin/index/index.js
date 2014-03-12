// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "dojo/on", "dojo/dom", "dojo/dom-construct", "dojo/dom-attr", "dojo/string", "dojo/json", "mysa/utility/myError",
		"mysa/form/FormTemplate",
		"dijit/Editor", "dijit/_editor/plugins/AlwaysShowToolbar", "dijit/_editor/plugins/LinkDialog",
		"dojo/domReady!"],
function(declare, domConstruct, on, dom, domConstruct, domAttr, string, JSON, myError,
			FormTemplate,
			Editor, AlwaysShowToolbar, LinkDialog){
////
return declare(null, {
	
	errorInfo: {
				class: "mysa/views/",
				},

	layoutPayload: null,
	viewPayload: null,

	constructor: function(lp, vp){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.layoutPayload = lp;
			this.viewPayload = vp;
			this.errorInfo.class = this.errorInfo.class 
				+ this.layoutPayload.params.module
				+ "/"
				+ this.layoutPayload.params.controller
				+ "/"
				+ this.layoutPayload.params.action;
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	make: function(){
	try{
			var div = domConstruct.create( "div", {
													class: "page-content1",
													});
			domConstruct.create( "h1", {
										innerHTML: "OBJECTS:",
										}, div);
			var divSheldonTheory = domConstruct.create( "div", {
										style: "margin-left: 30px;",
										}, div);
										
			domConstruct.create( "h2", {
										innerHTML: "SHELDON THEORIES:",
										}, divSheldonTheory);
			domConstruct.create( "p", {
										innerHTML: "Theory Count:  " + this.viewPayload.theory_count,
										}, divSheldonTheory);
			var divUsers = domConstruct.create( "div", {
										style: "margin-left: 30px;",
										}, div);
										
			domConstruct.create( "h2", {
										innerHTML: "USERS:",
										}, divUsers);
			domConstruct.create( "p", {
										innerHTML: "User Count:  " + this.viewPayload.user_count,
										}, divUsers);
			/////////////////////////////////////////////////////////////////////////////////////////////////
			domConstruct.create( "h1", {
										innerHTML: "PAGE OVERVIEW:",
										}, div);
			domConstruct.create( "p", {
										innerHTML: "Page Count:  " + this.viewPayload.page_count,
										}, div);
			var pages = "";
			for(var i = 0; i < this.viewPayload.pages.length; i++){
				if(i != 0){
				pages = pages.concat( "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;");
				}
				pages = pages.concat( this.viewPayload.pages[i].module, "/", this.viewPayload.pages[i].controller, "/", this.viewPayload.pages[i].action  );
			}
			domConstruct.create( "p", {
										innerHTML: "Pages:",
										}, div);
			domConstruct.create( "p", {
										innerHTML: pages,
										}, div);
						
			return div;
		}
		catch(e){
			console.error(this.eHandle.output(e, "make"))
		}
	},	
});
////
});