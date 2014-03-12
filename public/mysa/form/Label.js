// JavaScript Document
define(["dojo/_base/declare", "dojo/_base/lang", "dojo/on", "dojo/dom", "dojo/dom-construct", "dojo/string",
		"dijit/registry", "dijit/form/ValidationTextBox",
		"dojo/i18n!mysa/nls/Form",
		"mysa/utility/myError",
		"dojox/validate", "dojox/validate/web", "dojox/validate/check", /*WEB AND CHECK BOTH EXTEND VALIDATE */
		"dojo/domReady!" /*THESE DON'T NEED TO BE DECLARED BELOW */],
function(declare, lang, on, dom, domConstruct, string,
		 registry, ValidationTextBox,
		 frm,
		 myError,
		 validate){
////
return declare(null, {
	errorInfo: {
				class: "form/Label",
				},
	postfix: ": ",
	class: "",
	for: "",
	constructor: function(jArg){
		this.eHandle = new myError(this.errorInfo);
		try{
			lang.mixin(this, jArg);
			//this.general.label = this.general.label + this.postfix;
			this.for = this.general.id;
			if(this.field.required == "required"){
				this.class = "required";
			}
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	make: function(td){
		try{
			var lbl = frm.dijits[this.general.label].label;
			lbl = lbl + this.postfix;
			var label = domConstruct.create( "label", {	
														innerHTML: lbl,
														class: this.class,
													}, td);
			return label;
		}
		catch(e){
			console.error(this.eHandle.output(e, "make"))
		}

	}

});
////
});