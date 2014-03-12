// JavaScript Document
define(["dojo/_base/declare", "dojo/on", "dojo/dom", "dojo/dom-construct", "dojo/dom-style", "dojo/query", "dojo/string", "dojo/request/xhr", "dojo/dom-form", "dojo/request", "dojo/json",
		"dijit/registry", "dijit/form/Form", "dijit/form/Button", "dijit/form/ValidationTextBox", "dojox/validate",
		"mysa/form/Dijit", "mysa/form/Label", "mysa/form/ReCaptcha", "mysa/utility/Globals", "mysa/utility/myError",
		"dojo/i18n!mysa/nls/Form",		
		"dojox/validate/web", "dojox/validate/check", /*WEB AND CHECK BOTH EXTEND VALIDATE */ "dojo/domReady!" /*THESE DON'T NEED TO BE DECLARED BELOW */],
function(declare, on, dom, domConstruct, domStyle, query, string, xhr, domForm, request, JSON,
		 registry, Form, Button, ValidationTextBox, validate,
		 Dijit, Label, ReCaptcha, Globals, myError,
		 frm){
////
return declare(null, {

	errorInfo: {
				class: "form/FormTemplate",
				},
	td: new Array(),
				
	constructor: function(form, items){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.postfix = ": ";
			this.form = form;
			this.items = items;
			this.globals = new Globals();
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	makeForm: function(){
	try{
		var form = domConstruct.create( "form",
										{	id: this.form.id,
											"data-dojo-type": "dijit/form/Form",
											style: "margin: auto; width: 98%;",
											encType: this.form.encType,
											action: this.form.action,
											method: this.form.method 
										});
		var table = domConstruct.create( "table",
											{	
											id: this.form.id + "-table",
											class: "style1",
											cellspacing: "10"
											}, form);
		for(var i = 0; i < this.items.length; i++){
			this.makeTableRow(table);
		}
		if(this.form.recaptcha == true){
			this.makeTableRow(table);		
		}
		this.makeSubmit(form);
		//this.makeReset(form);
		this.makeCancel(form);
		for(var i = 0; i < this.items.length; i++){
			var label = new Label(this.items[i]);
			label.make(this.td[2*i]);
			var dijit = new Dijit(this.items[i]);
			dijit.make(this.td[2*i+1]);
		}
		if(this.form.recaptcha == true)
		{
			domConstruct.place("recap-label", this.td[this.td.length-2]);
			domConstruct.place("recap", this.td[this.td.length-1]);
		}
		return form;
	}
	catch(e){
		console.error(this.eHandle.output(e, "makeForm"))
	}		
	},
	
	makeTableRow: function(tbl){
	try{
		var tr = domConstruct.create( "tr", null, tbl  );
		for(var j = 0; j < 2; j++){
			this.td[this.td.length]  = domConstruct.create( "td", null, tr );
		}
	}
	catch(e){
		console.error(this.eHandle.output(e, "makeTableRow"))
	}		
	},

	makeSubmit: function(form){
	try{
		var globals = new Globals();
		var dataAttr = this.globals.formDataAttr();
		var dataAttrContent = JSON.stringify(this.form);
		var b = domConstruct.create( "button",
									{
										id: this.makeformIdPrefix("submit")
									}, form );
		var button = new Button(
						{
							id: this.makeformIdPrefix("submit"),
							name: "submit",
							type: "submit",
							value: "Submit",
							innerHTML: "Submit",
							style: "font-size: 24px;",
							scrollOnFocus:false
						}, b);
		button.set(dataAttr, dataAttrContent);
		on(button, "click", function(evt){
			this.set("disabled", true);
			if(dom.byId("error-div") != null){
				domConstruct.destroy(dom.byId("error-div").id);
				registry.byId("error-button").destroy();
			}
			// prevent the page from navigating after submit
			evt.stopPropagation();
			evt.preventDefault();
			// Post the data to the server
			var globals = new Globals();
			var formAttrContent = JSON.parse(this.get(globals.formDataAttr()));
			var promise = request.post(formAttrContent.validate, {
				// Send the username and password
				data: domForm.toObject(formAttrContent.id),
				// Wait 2 seconds for a response
				timeout: 10000
			});
			// Use promise.response.then, NOT promise.then
			promise.response.then(function(response){
				var result = response.getHeader('result');
				if(result == "PASS"){
					registry.byId(formAttrContent.id + "-submit").set("disabled", true);
					if(formAttrContent.uri != ""){
						window.location.href = formAttrContent.uri;
					}
					else{
						if(window.history.length > 1){						
							window.history.back();
						}
						else{
							window.location.href = "/";
						}						
					}

				}
				else if(result == "FAIL"){
					if(formAttrContent.recaptcha == true){
						Recaptcha.reload();
					}
					registry.byId(formAttrContent.id + "-submit").set("disabled", false);
					var div = domConstruct.create( "div", {
											id: "error-div",
											class: "error pos-absolute",
											style: "z-index: 1;"
											}, formAttrContent.id, "first");
					var errors = JSON.parse(response.data);
					for(var i =0; i < errors.length; i++){
						var html = frm.dijits[errors[i].label].label + ":<br />" + frm.msgs.invalid[errors[i].errors] + frm.msgs.postfix;
						var p =  domConstruct.create("p", {
															innerHTML: html,
															}, div);
					}
					var p =  domConstruct.create("p", { style: "margin-left: 200px;"}, div);
					var b = domConstruct.create("button", {
															id: "error-button",
															name: "error-button",
															value: "error-button",
															innerHTML: "Close",
															}, p);
					var button = new Button({
						id: "error-button",
						name: "error-button",
						value: "error-button",
						innerHTML: "Close",
						scrollOnFocus:false
					}, b);
					on(button, "click", function(){
					   domConstruct.destroy(dom.byId("error-div").id);
						registry.byId("error-button").destroy();
					});
				}
				else{
					registry.byId(formAttrContent.id + "-submit").set("disabled", false);
				}
			});
		});
	}
	catch(e){
		console.error(this.eHandle.output(e, "makeSubmit"))
	}		
	},
	
	makeReset: function(form){
	try{
		var b = domConstruct.create( "button", {
												id: this.makeformIdPrefix("reset")
												}, form );
		var button = new Button(
					{
						id: this.makeformIdPrefix("reset"),
						name: "reset",
						type: "reset",
						value: "Reset",
						innerHTML: "Reset",
						formId: form.id,
						style: "font-size: 24px;",
						scrollOnFocus:false
					}, b);
		on(button, "click", function(){
		});
	}
	catch(e){
		console.error(this.eHandle.output(e, "makeReset"))
	}		
	},

	makeCancel: function(form){
	try{
		var dataAttr = this.globals.formDataAttr();
		var dataAttrContent = JSON.stringify(this.form);
		var b = domConstruct.create( "button", {
												id: this.makeformIdPrefix("cancel")
												}, form );
		var button = new Button(
					{
						id: this.makeformIdPrefix("cancel"),
						name: "cancel",
						type: "cancel",
						value: "Cancel",
						innerHTML: "Cancel / Previous (&larr;)",
						style: "font-size: 24px;",
						scrollOnFocus:false
					}, b);
		button.set(dataAttr, dataAttrContent);
		on(button, "click", function(){
			var globals = new Globals();
			var formAttrContent = JSON.parse(this.get(globals.formDataAttr()));
			if(window.history.length > 1){
				window.history.back();
			}
			else{
				window.location.href = formAttrContent.uri;
			}
		});
	}
	catch(e){
		console.error(this.eHandle.output(e, "makeCancel"))
	}		
	},
	
	makeformIdPrefix: function(s){
	try{
		return this.form.id + "-" + s;
	}
	catch(e){
		console.error(this.eHandle.output(e, "makeformIdPrefix"))
	}		

	}
});
////
});