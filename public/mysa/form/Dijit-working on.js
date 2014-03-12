// JavaScript Document
define(["dojo/_base/declare", "dojo/_base/lang", "dojo/on", "dojo/dom", "dojo/dom-construct", "dojo/dom-attr", "dojo/string", "dojo/json",
		"dijit/registry", "dojox/validate",
		"dijit/form/ValidationTextBox", "dijit/form/CurrencyTextBox", "dijit/form/DateTextBox", "dijit/form/NumberSpinner", "dijit/form/NumberTextBox",
		"dijit/form/TextBox", "dijit/form/TimeTextBox", "dijit/Editor", "dijit/_editor/plugins/AlwaysShowToolbar", "dijit/_editor/plugins/LinkDialog",
		"dijit/form/RadioButton", "dijit/form/CheckBox", "dijit/form/Button",
		"mysa/init/form/Dijit",
		"mysa/utility/myError",
		"dojo/i18n!mysa/nls/Form",
		"dojox/validate/web", "dojox/validate/check", /*WEB AND CHECK BOTH EXTEND VALIDATE */ "dojo/domReady!" /*THESE DON'T NEED TO BE DECLARED BELOW */],
function(
		declare, lang, on, dom, domConstruct, domAttr, string, JSON,
		registry, validate, 
		ValidationTextBox, CurrencyTextBox, DateTextBox, NumberSpinner, NumberTextBox,
		TextBox, TimeTextBox, Editor, AlwaysShowToolbar, LinkDialog,
		RadioButton, CheckBox, Button,
		initFormDijit,
		myError,
		frm){
////
return declare(null, {

	fontsize: "14px",
	type: "text",

	errorInfo: {
				class: "form/Dijit",
				},

	constructor: function(jArg){
		this.eHandle = new myError(this.errorInfo);
		try{
			lang.mixin(this, jArg);
			if(this.field.type != null){
				this.type = this.field.type;
			}
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	make: function(td){
	try{
		var initDij = new initDijit();
		switch(this.general.dijitType)
		{
		case "validation":
			var input = domConstruct.create( "input", {
														id: this.general.id,
													}, td);
			var dijitAttr = lang.mixin({
											id: this.general.id,
											name: this.general.id,
											type: this.type,
											style:"font-size: " + this.fontsize + "; width: 300px;",
											promptMessage: frm.dijits[this.general.label].prompt,
											missingMessage: frm.msgs.missing + frm.msgs.postfix,
											invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
										}, initDij.getAttr());
			var dijit = new ValidationTextBox(dijitAttr, input);
			this.setAttr(dijit, this.field);
			break;
		case "currency":
			var input = domConstruct.create( "input", {
														id: this.general.id,
														}, td);
			var dijitAttr = lang.mixin({
											id: this.general.id,
											name: this.general.id,
											type: this.type,
											style:"font-size: " + this.fontsize + "; width: 300px;",
											promptMessage: frm.dijits[this.general.label].prompt,
											missingMessage: frm.msgs.missing + frm.msgs.postfix,
											invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
										}, initDij.getAttr());
			var dijit = new CurrencyTextBox(dijitAttr, input);
			this.setAttr(dijit, this.field);
		  break;
		case "date":
			var input = domConstruct.create( "input", {
														id: this.general.id,
													}, td);
			var dijit = new DateTextBox({
											id: this.general.id,
											name: this.general.id,
											type: this.type,
											constraints: { datePattern : 'yyyy-MMM-dd' },
											style:"font-size: " + this.fontsize + ";",
											promptMessage: frm.dijits[this.general.label].prompt,
											missingMessage: frm.msgs.missing + frm.msgs.postfix,
											invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
											scrollOnFocus:false
										}, input);
			this.setAttr(dijit, this.field);
		  break;
		case "spinner":
			var input = domConstruct.create( "input", {
														id: this.general.id,
													}, td);
			var dijit = new NumberSpinner({
											id: this.general.id,
											name: this.general.id,
											type: this.type,
											style:"font-size: " + this.fontsize + ";width: 100px;",
											promptMessage: frm.dijits[this.general.label].prompt,
											missingMessage: frm.msgs.missing + frm.msgs.postfix,
											invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
											scrollOnFocus:false
										}, input);
			this.setAttr(dijit, this.field);
		  break;
		case "number":
			var input = domConstruct.create( "input", {
														id: this.general.id,
														}, td);
			var dijit = new NumberTextBox({
											id: this.general.id,
											name: this.general.id,
											type: this.type,
											style:"font-size: " + this.fontsize + ";width: 100px;",
											promptMessage: frm.dijits[this.general.label].prompt,
											missingMessage: frm.msgs.missing + frm.msgs.postfix,
											invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
											scrollOnFocus:false
										}, input);
			this.setAttr(dijit, this.field);
		  break;
		case "text":
			var input = domConstruct.create( "input", {
														id: this.general.id,
														}, td);
			var dijit = new TextBox({
										id: this.general.id,
										name: this.general.id,
										type: this.type,
										style:"font-size: " + this.fontsize + ";width: 400px;",
										promptMessage: frm.dijits[this.general.label].prompt,
										missingMessage: frm.msgs.missing + frm.msgs.postfix,
										invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
										scrollOnFocus:false
										}, input);
			this.setAttr(dijit, this.field);
		  break;
		case "time":
			var input = domConstruct.create( "input", {
														id: this.general.id,
														}, td);
			var dijit = new TimeTextBox({
											id: this.general.id,
											name: this.general.id,
											type: this.type,
											style:"font-size: " + this.fontsize + ";",
											promptMessage: frm.dijits[this.general.label].prompt,
											missingMessage: frm.msgs.missing + frm.msgs.postfix,
											invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
											scrollOnFocus:false
										}, input);
			this.setAttr(dijit, this.field);
		  break;
		case "editor":
			var dijitId = this.general.id;
			var div = domConstruct.create( "div", {
													id: this.general.id,
													}, td);
			var dijit = new Editor({
									id: this.general.id,
									name: this.general.id,
									height: "200px",
									style: "width: 500px; margin-bottom: 0; padding-bottom: 0;",
									extraPlugins: [AlwaysShowToolbar],
									value: this.field.value,
									promptMessage: frm.dijits[this.general.label].prompt,
									missingMessage: frm.msgs.missing + frm.msgs.postfix,
									invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
									scrollOnFocus:false
								}, div);
			 var input = domConstruct.create( "input", {
														id: this.general.id + "-input",
														name: this.general.id + "-input",
														style: "visibility: collapse;",
														promptMessage: frm.dijits[this.general.label].prompt,
														missingMessage: frm.msgs.missing + frm.msgs.postfix,
														invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
														}, td, "first");
			dijit.startup();
			on(dijit, "change", function(){
				if(registry.byId(this.id).get("value") == '<br _moz_editor_bogus_node="TRUE" />' || string.trim(registry.byId(this.id).get("value")) == ""){
					dom.byId(this.id + "-input").value = null;
				}
				else{
					dom.byId(this.id + "-input").value = string.trim(registry.byId(this.id).get("value"));
				}
			});
		  break;
		case "radio":
			for(var i = 0; i < this.field.radio.length; i++){
				input = domConstruct.create( "input", 
													{
														id: this.general.id + "-" + this.field.radio[i].option.value,
													}, td);
				dijit = new RadioButton({
							name: this.general.id,
							value: this.field.radio[i].option.value,
							checked: this.field.radio[i].option.checked,
							scrollOnFocus:false
						}, input);
				domConstruct.create( "label", 
									{
										"for": this.general.id + "-" + this.field.radio[i].option.value,
										style: "padding-left: 10px;",
										innerHTML: this.field.radio[i].option.label,
									}, td);
				domConstruct.create( "br", null, td);		
			}
		  break;
		case "checkbox":
			var input = domConstruct.create( "input", {	id: this.general.id }, td);
			var dijit = new CheckBox({	
										id: this.general.id,
										name: this.general.id,
										checked: this.field.checked,
										value: this.field.value,
										scrollOnFocus:false
										}, input);
				domConstruct.create( "label", 
									{
										"for": this.general.id,
										style: "padding-left: 10px;",
										innerHTML: this.field.label,
									}, td);
				if(this.field.required != null){
					dijit.set("required", this.field.required);
				}
		  break;
		default:
			return null;
			break;
		}
	}
	catch(e){
		console.error(this.eHandle.output(e, "make"))
	}		
	},
	
	setAttr: function(dijitD, jsonJ){
	try{
		for(var key in jsonJ){
			if(key != "type"){
				if(key == "validator"){
					switch(jsonJ[key]){
						case "email":
							dijitD.set(key, dojox.validate.isEmailAddress);
							break;
						default:
						break;
					}
				}
				else{
					dijitD.set(key, jsonJ[key]);
				}
			}
		}
	}
	catch(e){
		console.error(this.eHandle.output(e, "setAttr"))
	}		
	},
	
	on: function(){
	try{
		on(button, "click", function(){
			
		});
	}
	catch(e){
		console.error(this.eHandle.output(e, "on"))
	}		
	}

});
////
});