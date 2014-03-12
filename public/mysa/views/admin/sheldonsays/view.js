// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "dojo/on", "dojo/dom", "dojo/dom-construct", "dojo/dom-attr", "dojo/string", "dojo/json", "mysa/utility/myError",
		"mysa/form/FormTemplate",
		"mysa/widgets/html/Table",
		"dijit/Editor", "dijit/_editor/plugins/AlwaysShowToolbar", "dijit/_editor/plugins/LinkDialog",
		"dojo/domReady!"],
function(declare, domConstruct, on, dom, domConstruct, domAttr, string, JSON, myError,
			FormTemplate,
			Table,
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
		var div =  domConstruct.create("div", {style: "margin: 30px;", class: "page-content1"});
		domConstruct.create("a", {
							href: '/admin/sheldonsays/index',
							innerHTML: "GO BACK TO OVERVIEW...",}, div);

		domConstruct.create("h1", {innerHTML: "DETAILS:"}, div);
		domConstruct.create("p", {innerHTML: "Season:" + this.viewPayload.gen.season}, div);
		domConstruct.create("p", {innerHTML: "Episode:" + this.viewPayload.gen.episode}, div);
		domConstruct.create("p", {innerHTML: "Views:" + this.viewPayload.gen.views}, div);
		domConstruct.create("p", {innerHTML: "YouTube Id:" + this.viewPayload.gen.youtube}, div);
		domConstruct.create("h1", {innerHTML: "CLAIM:"}, div);
		domConstruct.create("p",{
									innerHTML: this.viewPayload.gen.claim,
									}, div);
		domConstruct.create("h1", {innerHTML: "CONTENT:"}, div);
		domConstruct.create("p",{
									innerHTML: this.viewPayload.gen.content,
									style: "margin-left: 100px; background-color: yellow;"
									}, div);
		domConstruct.create("h1", {innerHTML: "YouTube Ids:"}, div);
		var p = domConstruct.create("p", {}, div);
		for(var i=0; i < this.viewPayload.youtubeIds.length; i++){
			domConstruct.create("a", {
										href: 'http://www.youtube.com/watch?v=' + this.viewPayload.youtubeIds[i],
										innerHTML: this.viewPayload.youtubeIds[i],
										target: "_new"}, p);
		}
		
		return div;
		}
		catch(e){
			console.error(this.eHandle.output(e, "make"))
		}
	},	
});
////
});