// JavaScript Document
define(["dojo/_base/declare", "dojo/string", "dojo/request", "dojo/request/xhr", "dojo/dom", "dojo/dom-construct", "dojo/json", "dojo/on",
		"mysa/utility/myError",
		"dojo/domReady!"],
function(declare, string, request, xhr, dom, domConst, JSON, on,
			myError){
////
/////////
return declare(null, {
	errorInfo: {
				class: "utility/Globals",
				},
	globals:	{
					"domain":	{
									"full":	"http://www.mysocialarea.com",
									"short": "mysocialarea.com",
									"name": "mysocialarea",
									"acronym": "mysa",
								},
					"form":		{
									"dataAttr": "form"
								},
				},
	constructor: function(){
		this.eHandle = new myError(this.errorInfo);
		try{
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	domain: function(s){
	try{
		return this.globals.domain[s];
	}
	catch(e){
		console.error(this.eHandle.output(e, "domain"))
	}
	},
	
	form: function(s){
	try{
		return this.globals.form[s];
	}
	catch(e){
		console.error(this.eHandle.output(e, "form"))
	}
	},
	
	formDataAttr: function(){
	try{
		return "data-" + this.globals.domain.acronym + "-" + this.globals.form.dataAttr;
	}
	catch(e){
		console.error(this.eHandle.output(e, "formDataAttr"))
	}
	}
//END OF DECLARE		
});
//END OF DEFINE
});