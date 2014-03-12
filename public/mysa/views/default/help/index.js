// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "mysa/utility/myError",
		"dojo/domReady!"],
function(declare, domConstruct, myError){
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
			var div =  domConstruct.create("div", {class: "page-content1"});
			var content = new Array();
			content[0] = "This Help section will expand to suit the needs of this site as it grows but this site is pretty straight forward right now."
			content[1] = 'For now <a href="/contact/index">Contact Us</a> if you have any questions.'
			for (var i=0; i<content.length; i++){
				domConstruct.create("p", {innerHTML: content[i]}, div);
			}
			return div;
		}
		catch(e){
			console.error(this.eHandle.output(e, "make"))
		}
	},	
});
////
});