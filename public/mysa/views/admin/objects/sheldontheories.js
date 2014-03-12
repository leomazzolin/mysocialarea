// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "dojo/on", "dojo/dom", "dojo/dom-construct", "dojo/dom-attr", "dojo/string", "dojo/json", "mysa/utility/myError",
		"dijit/registry", "dijit/form/Button", "dijit/Editor", "dijit/_editor/plugins/AlwaysShowToolbar", "dijit/_editor/plugins/LinkDialog", "dijit/_editor/plugins/FontChoice",
		"mysa/form/FormTemplate",
		"dojo/domReady!"],
function(declare, domConstruct,  on, dom, domConstruct, domAttr, string, JSON, myError,
			registry, Button, Editor, AlwaysShowToolbar, LinkDialog, FontChoice,
			FormTemplate
		){
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
			var returnDiv = domConstruct.create("div");
			var div = domConstruct.create( "div", {
													id: "claim-editor",
													class: "page-content1",
													}, returnDiv);
			var dijit = new Editor({
									id: "dijit-claim-editor",
									extraPlugins: [AlwaysShowToolbar, 'createLink', 'unlink', 'insertImage', {name: 'formatBlock', plainText: true}],
								}, div);
			dijit.startup();
			var claimButton = domConstruct.create("button", {}, returnDiv);
			var dijitClaimButton = new Button(
						{
							innerHTML: "Fill Claim",
						}, claimButton);
			var div = domConstruct.create( "div", {
													id: "content-editor",
													class: "page-content1",
													}, returnDiv);
			var dijit = new Editor({
									id: "dijit-content-editor",
									extraPlugins: [AlwaysShowToolbar, 'createLink', 'unlink', 'insertImage', {name: 'formatBlock', plainText: true}],
								}, div);
			dijit.startup();
			var contentButton = domConstruct.create("button", {}, returnDiv);
			var dijitContentButton = new Button(
						{
							innerHTML: "Fill Content",
						}, contentButton);
			var Form = new FormTemplate(this.viewPayload.formData, this.viewPayload.formItems);
			domConstruct.place(Form.makeForm(), returnDiv);;
			var claimButtonSignal = on(dijitClaimButton, "click", function(){
				// remove listener after first event
				domAttr.set("claim", "value", registry.byId("dijit-claim-editor").get("value"));
				//alert(registry.byId("dijit-editor").get("value"));
				// do something else...
			});
			var contentButtonSignal = on(dijitContentButton, "click", function(){
				// remove listener after first event
				domAttr.set("content", "value", registry.byId("dijit-content-editor").get("value"));
				//alert(registry.byId("dijit-editor").get("value"));
				// do something else...
			});
			return returnDiv;
		}
		catch(e){
			console.error(this.eHandle.output(e, "make"))
		}
	},	
});
////
});