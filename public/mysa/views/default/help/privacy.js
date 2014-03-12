// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "dojo/dom-class", "dojo/dom-attr", "dojo/dom-style", "mysa/utility/myError",
		"dojo/domReady!"],
function(declare, domConstruct, domClass, domAttr, domStyle, myError){
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
			var div =  domConstruct.create("div");
			domClass.add(div, "page-content1");
			domAttr.set(div, {
								innerHTML: this.viewPayload.gen.content,
							 });
			return div;
		}
		catch(e){
			console.error(this.eHandle.output(e, "make"))
		}
	},	
});
////
});