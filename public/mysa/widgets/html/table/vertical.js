// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "mysa/utility/myError",
		"dojo/domReady!"],
function(declare, domConstruct, myError){
////
return declare(null, {
	
	errorInfo: {
				class: "mysa/widgets/table/vertical",
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
	
	get: function(data){
	try{
		var table = domConstruct.create("table", {
												class: "standard",
												});
		var tbody = domConstruct.create("tbody", {}, table);
		for(var i = 0; i < data.length; i++){
			var tr = domConstruct.create("tr", {class: "standard",}, tbody);
			for(var j = 0; j < data[i].length; j++){
				if(j == 0){
					domConstruct.create("th", {class: "standard", innerHTML: data[i][j]}, tr);
				}
				else{
					domConstruct.create("td", {class: "standard", innerHTML: data[i][j]}, tr);
				}
			}
		}
		return table;
	}
	catch(e){
		console.error(this.eHandle.output(e, "get"))
	}
	},	
});
////
});