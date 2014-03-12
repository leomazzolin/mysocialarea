// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "dojo/dom-class",
		"mysa/utility/myError",
		"dojo/domReady!"],
function(declare, domConstruct, domClass,
			myError){
////
return declare(null, {
	
	errorInfo: {
				class: "mysa/widgets/html/Table",
				},
	objInit: null,
	cssClass: "standard",
	table: null,
	caption: null,
	tbody: null,

	constructor: function(objInit){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.objInit = objInit;
			if("cssClass" in objInit){
				this.cssClass = objInit["cssClass"];
			}
			if("orient" in objInit){
				switch(objInit['orient']){
					case "vertical":
						this.table = domConstruct.create("table", {class: this.cssClass,});
						this.tbody = domConstruct.create("tbody", {}, this.table);
						break;
					case "horizontal":
						break;
					case "2axis":
					default:
						throw new Error("Orient value is not a valid option.");
						break;
				}
			}
			else{
				throw new Error("Orient key does not exist in objInit arg");
			}
			if("caption" in objInit){
				domConstruct.create("caption", {class: this.cssClass, innerHTML: objInit["caption"]}, this.table, "first");
			}
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	setRows: function(data){
		try{
			for(var i = 0; i < data.length; i++){
				var tr = domConstruct.create("tr", {class: this.cssClass,}, this.tbody);
				for(var j = 0; j < data[i].length; j++){
					if(j == 0){
						domConstruct.create("th", {class: this.cssClass, innerHTML: data[i][j]}, tr);
					}
					else{
						domConstruct.create("td", {class: this.cssClass, innerHTML: data[i][j]}, tr);
					}
				}
			}
		}
		catch(e){
			console.error(this.eHandle.output(e, "setRows"))
		}
	},	

	get: function(){
		try{
			return this.table;
		}
		catch(e){
			console.error(this.eHandle.output(e, "get"))
		}
	},	
});
////
});