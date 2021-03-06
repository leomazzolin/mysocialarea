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
													id: "editor",
													class: "page-content1",
													}, returnDiv);
			var dijit = new Editor({
									id: "dijit-editor",
									extraPlugins: [AlwaysShowToolbar, 'createLink', 'unlink', 'insertImage', {name: 'formatBlock', plainText: true}],
									value: this.viewPayload.page.general.content
								}, div);
			dijit.startup();
			var button = domConstruct.create("button", {}, returnDiv);
			var dijitButton = new Button(
						{
							innerHTML: "Fill Form",
						}, button);
			this.viewPayload.formData.validate = this.viewPayload.formData.validate + '/id/' + this.viewPayload.page.id
			this.viewPayload.formItems[0].field.value = this.viewPayload.page.general.module;
			this.viewPayload.formItems[1].field.value = this.viewPayload.page.general.controller;
			this.viewPayload.formItems[2].field.value = this.viewPayload.page.general.action;
			this.viewPayload.formItems[3].field.value = this.viewPayload.page.general.content;
			var Form = new FormTemplate(this.viewPayload.formData, this.viewPayload.formItems);
			domConstruct.place(Form.makeForm(), returnDiv);
			var signal = on(dijitButton, "click", function(){
				// remove listener after first event
				domAttr.set("page-content", "value", registry.byId("dijit-editor").get("value"));
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