// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "mysa/utility/myError", "mysa/form/FormTemplate",
		"dojo/domReady!"],
function(declare, domConstruct, myError, FormTemplate){
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
			var Form = new FormTemplate(this.viewPayload.formData, this.viewPayload.formItems);
			return Form.makeForm();
		}
		catch(e){
			console.error(this.eHandle.output(e, "make"))
		}
	},	
});
////
});