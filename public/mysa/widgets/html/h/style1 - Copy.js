// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "mysa/utility/myError",
		"dojo/domReady!"],
function(declare, domConstruct, myError){
////
return declare(null, {
	
	errorInfo: {
				class: "mysa/widgets/h/style1",
				},
	size: 1,
	content: "",
	attachPt: null,

	constructor: function(content, attachPt, size){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.size = size;
			this.content = this.content.concat(content, ": ");
			this.attachPt = attachPt;
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	make: function(){
	try{
		switch (this.size){
			case 6:
				var header = domConstruct.create("h6", {}, this.attachPt);
				break;
			case 5:
				var header = domConstruct.create("h5", {}, this.attachPt);
				break;
			case 4:
				var header = domConstruct.create("h4", {}, this.attachPt);
				break;
			case 3:
				var header = domConstruct.create("h3", {}, this.attachPt);
				break;
			case 2:
				var header = domConstruct.create("h2", {}, this.attachPt);
				break;
			case 1:
			default:			
				var header = domConstruct.create("h1", {}, this.attachPt);
				break;		
		}
		header.innerHTML = this.content;
		var style = "background-color: lightgrey; ";
		style = style.concat(style, "border: 1px solid black; "); 
		style = style.concat(style, "display: inline; "); 
		style = style.concat(style, "padding: 0px 5px 0px 5px; "); 
		//style = style.concat(style, ""); 
		header.style = style;
		var br = domConstruct.create("br", {}, header, "after");
	}
	catch(e){
		console.error(this.eHandle.output(e, "make"))
	}
	},	
});
////
});