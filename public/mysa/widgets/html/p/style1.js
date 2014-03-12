// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "mysa/utility/myError",
		"dojo/domReady!"],
function(declare, domConstruct, myError){
////
return declare(null, {
	
	errorInfo: {
				class: "mysa/widgets/p/style1",
				},
	content: null,
	attachPt: null,

	constructor: function(content, attachPt){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.content = content;
			this.attachPt = attachPt;
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	make: function(){
	try{
		var p = domConstruct.create("p", {}, this.attachPt);
		p.innerHTML = this.content;
		var style = "size: 12px; ";
		style = style.concat(style, "padding:  5px 5px 5px 20px; ");
		//style = style.concat(style, "background-color:  #6F9; ");
		p.style = style;
		var br = domConstruct.create("br", {}, p, "after");
	}
	catch(e){
		console.error(this.eHandle.output(e, "make"))
	}
	},	
});
////
});