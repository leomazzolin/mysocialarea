// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "dojo/dom-class", "dojox/string/Builder", "mysa/utility/myError",
		"dojo/domReady!"],
function(declare, domConstruct, domClass, string, myError){
////
return declare(null, {
	
	errorInfo: {
				class: "mysa/widgets/h/style1",
				},
	size: 1,
	content: "",

	constructor: function(content, size){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.size = size;
			this.content = this.content.concat(content, ": ");
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	get: function(){
	try{
		var h = "h"
		var header = domConstruct.create(h.concat(this.size));
		header.innerHTML = this.content;
 		domClass.add(header, "standard");
 		return header;
	}
	catch(e){
		console.error(this.eHandle.output(e, "get"))
	}
	},	
});
////
});