// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "mysa/utility/myError",
		"mysa/form/FormTemplate",
		"dojo/domReady!"],
function(declare, domConstruct, myError,
			FormTemplate){
////
return declare(null, {
	
	errorInfo: {
				class: "mysa/views/error",
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
		var div = domConstruct.create( "div", {
												class: "page-content1",
												});
		for (i = 0; i < this.viewPayload.errors.length; ++i) {
			var number = i+1;						
			var errorNumber = domConstruct.create("p", {
										innerHTML: "ERROR #" + number + ":",
										style: "border: 2px solid black; background-color: yellow; width: 20%; font-size: 120%;",
									}, div);

			var message = domConstruct.create("p", {
										innerHTML: "MESSAGE:<br />" + this.viewPayload.errors[i].message + "<br />",
									}, errorNumber, "after");
			var _class = domConstruct.create("p", {
										innerHTML: "CLASS:<br />" + this.viewPayload.errors[i].class + "<br />",
									}, message);
			var method = domConstruct.create("p", {
										innerHTML: "METHOD:<br />" + this.viewPayload.errors[i].method + "<br />",
									}, _class);
			var exceptionDiv = domConstruct.create("p", {
										innerHTML: "STACKTRACE:",
									}, method);
			var exceptions = this.viewPayload.errors[i].exception.split("#");
			exceptions.shift();
			for(j =0; j<exceptions.length; ++j){
				var exception = domConstruct.create("p", {
											innerHTML: exceptions[j],
											style: "font-size: 80%;",
										}, exceptionDiv);
			}
			var request = domConstruct.create("p", {
										innerHTML: "REQUEST:<br />" +  this.viewPayload.errors[i].request,
									}, exceptionDiv);
		}
		return div
	}
	catch(e){
		console.error(this.eHandle.output(e, "make"))
	}
	},	
});
////
});