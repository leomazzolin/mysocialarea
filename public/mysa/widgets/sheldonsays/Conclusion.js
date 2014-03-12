// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "dojo/dom-class", "dojo/dom-attr", "dojo/dom-style", "dojo/string",
		"dijit/Fieldset",
		 "mysa/utility/myError",
		"dojo/domReady!"],
function(declare, domConstruct, domClass, domAttr, domStyle, string,
			Fieldset,
		 	myError){
////
return declare(null, {
	
	errorInfo: {
				class: "mysa/widgets/sheldonsays",
				},
	h1: null,
	result: null,

	constructor: function(result){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.h1 = domConstruct.create("h1", {
													style: "padding: 10px; font-size: 30px; width: 200px; text-align: center;"
												});
			this.result = result;
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	make: function(){
		this.eHandle = new myError(this.errorInfo);
		try{
			switch(this.result){
				case "true":
					domAttr.set(this.h1, "innerHTML", "TRUE");
					domStyle.set(this.h1, {
											backgroundColor: "green",
											color: "white"
					});
					break;
				case "false":
					domAttr.set(this.h1, "innerHTML", "FALSE");
					domStyle.set(this.h1, {
											backgroundColor: "red",
											color: "white"
					});
					break;
				case "plausible":
					domAttr.set(this.h1, "innerHTML", "PLAUSIBLE");
					domStyle.set(this.h1, {
											backgroundColor: "yellow",
											color: "black"
					});
					break;
				default:
					break;
			}
			return this.h1;
		}
		catch(e){
			console.error(this.eHandle.output(e, "make"))
		}
	},
	
});
////
});