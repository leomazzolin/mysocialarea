// JavaScript Document
define(["dojo/_base/declare", "dojo/_base/lang", "dojo/on", "dojo/dom", "dojo/dom-construct", "dojo/dom-attr", "dojo/string", "dojo/json",
		"dijit/registry", "dojox/validate",
		"dijit/form/ValidationTextBox", "dijit/form/CurrencyTextBox", "dijit/form/DateTextBox", "dijit/form/NumberSpinner", "dijit/form/NumberTextBox",
		"dijit/form/TextBox", "dijit/form/TimeTextBox", "dijit/Editor", "dijit/_editor/plugins/AlwaysShowToolbar", "dijit/_editor/plugins/LinkDialog",
		"dijit/form/RadioButton", "dijit/form/CheckBox", "dijit/form/Button",
		"mysa/utility/myError",
		"dojo/i18n!mysa/nls/Form",
		"dojox/validate/web", "dojox/validate/check", /*WEB AND CHECK BOTH EXTEND VALIDATE */ "dojo/domReady!" /*THESE DON'T NEED TO BE DECLARED BELOW */],
function(declare, lang, on, dom, domConstruct, domAttr, string, JSON,
		 registry, validate, 
		 ValidationTextBox, CurrencyTextBox, DateTextBox, NumberSpinner, NumberTextBox,
		  TextBox, TimeTextBox, Editor, AlwaysShowToolbar, LinkDialog,
		  RadioButton, CheckBox, Button,
		  myError,
		  frm){
////
return declare(null, {
	
		fontsize: "14px",
		type: "text",
		dijitInfo: new Object(),

	errorInfo: {
				class: "form/Dijit",
				},

	constructor: function(jArg){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.dijitInfo = jArg;
			if(this.dijitInfo.field.type != null){
				this.type = this.dijitInfo.field.type;
			}
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	make: function(td){
	try{
		switch(this.dijitInfo.general.dijitType)
		{
		case "validation":
			var input = domConstruct.create( "input", {
														id: this.dijitInfo.general.id,
													}, td);
			var dijit = new ValidationTextBox({
												id: this.dijitInfo.general.id,
												name: this.dijitInfo.general.id,
												type: this.type,
												style:"font-size: " + this.fontsize + "; width: 300px;",
												promptMessage: frm.dijits[this.dijitInfo.general.label].prompt,
												missingMessage: frm.msgs.missing + frm.msgs.postfix,
												invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
												scrollOnFocus:false
											}, input);
			this.setAttr(dijit, this.dijitInfo.field);
			break;
		case "currency":
			var input = domConstruct.create( "input", {
														id: this.dijitInfo.general.id,
														}, td);
			var dijit = new CurrencyTextBox({
												id: this.dijitInfo.general.id,
												name: this.dijitInfo.general.id,
												type: this.type,
												style:"font-size: " + this.fontsize + ";",
												promptMessage: frm.dijits[this.dijitInfo.general.label].prompt,
												missingMessage: frm.msgs.missing + frm.msgs.postfix,
												invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
												scrollOnFocus:false
											}, input);
			this.setAttr(dijit, this.dijitInfo.field);
		  break;
		case "date":
			var input = domConstruct.create( "input", {
														id: this.dijitInfo.general.id,
													}, td);
			var dijit = new DateTextBox({
											id: this.dijitInfo.general.id,
											name: this.dijitInfo.general.id,
											type: this.type,
											constraints: { datePattern : 'yyyy-MMM-dd' },
											style:"font-size: " + this.fontsize + ";",
											promptMessage: frm.dijits[this.dijitInfo.general.label].prompt,
											missingMessage: frm.msgs.missing + frm.msgs.postfix,
											invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
											scrollOnFocus:false
										}, input);
			this.setAttr(dijit, this.dijitInfo.field);
		  break;
		case "spinner":
			var input = domConstruct.create( "input", {
														id: this.dijitInfo.general.id,
													}, td);
			var dijit = new NumberSpinner({
											id: this.dijitInfo.general.id,
											name: this.dijitInfo.general.id,
											type: this.type,
											style:"font-size: " + this.fontsize + ";width: 100px;",
											promptMessage: frm.dijits[this.dijitInfo.general.label].prompt,
											missingMessage: frm.msgs.missing + frm.msgs.postfix,
											invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
											scrollOnFocus:false
										}, input);
			this.setAttr(dijit, this.dijitInfo.field);
		  break;
		case "number":
			var input = domConstruct.create( "input", {
														id: this.dijitInfo.general.id,
														}, td);
			var dijit = new NumberTextBox({
											id: this.dijitInfo.general.id,
											name: this.dijitInfo.general.id,
											type: this.type,
											style:"font-size: " + this.fontsize + ";width: 100px;",
											promptMessage: frm.dijits[this.dijitInfo.general.label].prompt,
											missingMessage: frm.msgs.missing + frm.msgs.postfix,
											invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
											scrollOnFocus:false
										}, input);
			this.setAttr(dijit, this.dijitInfo.field);
		  break;
		case "text":
			var input = domConstruct.create( "input", {
														id: this.dijitInfo.general.id,
														}, td);
			var dijit = new TextBox({
										id: this.dijitInfo.general.id,
										name: this.dijitInfo.general.id,
										type: this.type,
										style:"font-size: " + this.fontsize + ";width: 400px;",
										promptMessage: frm.dijits[this.dijitInfo.general.label].prompt,
										missingMessage: frm.msgs.missing + frm.msgs.postfix,
										invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
										scrollOnFocus:false
										}, input);
			this.setAttr(dijit, this.dijitInfo.field);
		  break;
		case "time":
			var input = domConstruct.create( "input", {
														id: this.dijitInfo.general.id,
														}, td);
			var dijit = new TimeTextBox({
											id: this.dijitInfo.general.id,
											name: this.dijitInfo.general.id,
											type: this.type,
											style:"font-size: " + this.fontsize + ";",
											promptMessage: frm.dijits[this.dijitInfo.general.label].prompt,
											missingMessage: frm.msgs.missing + frm.msgs.postfix,
											invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
											scrollOnFocus:false
										}, input);
			this.setAttr(dijit, this.dijitInfo.field);
		  break;
		case "editor":
			var dijitId = this.dijitInfo.general.id;
			var div = domConstruct.create( "div", {
													id: this.dijitInfo.general.id,
													}, td);
			var dijit = new Editor({
									id: this.dijitInfo.general.id,
									name: this.dijitInfo.general.id,
									height: "200px",
									style: "width: 500px; margin-bottom: 0; padding-bottom: 0;",
									extraPlugins: [AlwaysShowToolbar],
									//extraPlugins: [AlwaysShowToolbar, 'createLink', 'unlink', 'insertImage'],
									value: this.dijitInfo.field.value,
									promptMessage: frm.dijits[this.dijitInfo.general.label].prompt,
									missingMessage: frm.msgs.missing + frm.msgs.postfix,
									invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
									scrollOnFocus:false
								}, div);
			 var input = domConstruct.create( "input", {
														id: this.dijitInfo.general.id + "-input",
														name: this.dijitInfo.general.id + "-input",
														style: "visibility: collapse;",
														promptMessage: frm.dijits[this.dijitInfo.general.label].prompt,
														missingMessage: frm.msgs.missing + frm.msgs.postfix,
														invalidMessage: frm.msgs.geninvalid + frm.msgs.postfix,
														}, td, "first");
			/* DON'T KNOW WHY THIS TRIGGERS AN ERROR											
			for(var key in this.dijitInfo.field){
				if(key != "type"){
					//domAttr.set(dijitId + "-input", key, this.dijitInfo.field[key]);
				}
			}
			*/
			dijit.startup();
			/*
			var button = domConstruct.create( "div", {}, td);
			var dijitButton = new Button({
											inputId: input.id,
											dijitId: dijit.id,
											innerHTML: "Reset",
											scrollOnFocus:false
											}, button);
			*/
			on(dijit, "change", function(){
				if(registry.byId(this.id).get("value") == '<br _moz_editor_bogus_node="TRUE" />' || string.trim(registry.byId(this.id).get("value")) == ""){
					dom.byId(this.id + "-input").value = null;
				}
				else{
					dom.byId(this.id + "-input").value = string.trim(registry.byId(this.id).get("value"));
				}
			});
			/*
			on(dijitButton, "click", function(){
				registry.byId(this.dijitId).set("value", "");
				dom.byId(this.inputId).value = "";
			});
			*/
		  break;
		case "radio":
			for(var i = 0; i < this.dijitInfo.field.radio.length; i++){
				input = domConstruct.create( "input", 
													{
														id: this.dijitInfo.general.id + "-" + this.dijitInfo.field.radio[i].option.value,
													}, td);
				dijit = new RadioButton({
							name: this.dijitInfo.general.id,
							value: this.dijitInfo.field.radio[i].option.value,
							checked: this.dijitInfo.field.radio[i].option.checked,
							scrollOnFocus:false
						}, input);
				domConstruct.create( "label", 
									{
										"for": this.dijitInfo.general.id + "-" + this.dijitInfo.field.radio[i].option.value,
										style: "padding-left: 10px;",
										innerHTML: this.dijitInfo.field.radio[i].option.label,
									}, td);
				domConstruct.create( "br", null, td);		
			}
		  break;
		case "checkbox":
			var input = domConstruct.create( "input", {	id: this.dijitInfo.general.id }, td);
			var dijit = new CheckBox({	
										id: this.dijitInfo.general.id,
										name: this.dijitInfo.general.id,
										checked: this.dijitInfo.field.checked,
										value: this.dijitInfo.field.value,
										scrollOnFocus:false
										}, input);
				domConstruct.create( "label", 
									{
										"for": this.dijitInfo.general.id,
										style: "padding-left: 10px;",
										innerHTML: this.dijitInfo.field.label,
									}, td);
				if(this.dijitInfo.field.required != null){
					dijit.set("required", this.dijitInfo.field.required);
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