// JavaScript Document
define(["dojo/_base/declare", "dojo/_base/lang", "dojo/on", "dojo/dom", "dojo/dom-construct", "dojo/string",
		"mysa/utility/myError",
		"dijit/registry", "dijit/form/ValidationTextBox", "dojox/validate",
		"dojox/validate/web", "dojox/validate/check", /*WEB AND CHECK BOTH EXTEND VALIDATE */ "dojo/domReady!" /*THESE DON'T NEED TO BE DECLARED BELOW */],
function(declare, lang, on, dom, domConstruct, string,
			myError,
		 	registry, ValidationTextBox, validate){
////
return declare(null, {
	errorInfo: {
				class: "form/ReCaptcha",
				},
	challenge: "6LcIPNISAAAAAJAp2oXxFBcVkrvoGeH_lmLhl_4V",
	
	constructor: function(place){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.place = place;
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	makeReCaptcha: function(place){
	try{
		var script = domConstruct.create( "script", {	type:"text/javascript" ,
															src: "http://www.google.com/recaptcha/api/challenge?k=" + this.challenge }, place);
		var noscript = domConstruct.create( "noscript", null, script, "after");
		var iframe = domConstruct.create( "iframe", {		src: "http://www.google.com/recaptcha/api/noscript?k=" + this.challenge,
															height: "300",
															width: "500",
															frameborder: "0"}, noscript);
		var br = domConstruct.create( "br", null, iframe);
		var textarea = domConstruct.create( "textarea", {id: "mycaptcha",
															 name: "recaptcha_challenge_field",
															 rows: "3",
															 cols: "40"}, iframe);
		var input = domConstruct.create( "input", {type: "hidden",
													 name: "recaptcha_response_field",
													 value: "manual_challenge"}, iframe);
	}
	catch(e){
		console.error(this.eHandle.output(e, "makeReCaptcha"))
	}
	},
	
	makeNoScript: function(s){
	try{
		var noscript = domConstruct.create( "noscript", null, s, "after");
	}
	catch(e){
		console.error(this.eHandle.output(e, "makeNoScript"))
	}
	},
	
	makeIframe: function(ns){
	try{
		var iframe = domConstruct.create( "iframe", {	type:"text/javascript" ,
															src: "http://www.google.com/recaptcha/api/noscript?k=" + this.challenge,
															height: 300,
															width: 500,
															frameborder: 0}, ns);
		var br = domConstruct.create( "br", null, iframe);
		var textarea = domConstruct.create( "textarea", {id: "mycaptcha",
															 name: "recaptcha_challenge_field",
															 rows: "3",
															 cols: "40"}, iframe);
		var input = domConstruct.create( "input", {type: "hidden",
													 name: "recaptcha_response_field",
													 value: "manual_challenge"}, iframe);
		
	}
	catch(e){
		console.error(this.eHandle.output(e, "makeIframe"))
	}
	}
});
////
});