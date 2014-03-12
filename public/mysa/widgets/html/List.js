// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "dojo/dom-class",
		"mysa/utility/myError",
		"dojo/domReady!"],
function(declare, domConstruct, domClass,
			myError){
////
return declare(null, {
	
	errorInfo: {
				class: "mysa/widgets/html/List",
				},
	objInit: null,
	cssClass: "standard",
	node: null,
	list: null,
	caption: null,

	constructor: function(objInit){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.objInit = objInit;
			this.node = domConstruct.create("div", {class: this.cssClass,});
			if("type" in objInit){
				switch(objInit['type']){
					case "ol":
						this.list = domConstruct.create(objInit['type'], {}, this.node);
						break;
					case "ul":
						this.list = domConstruct.create(objInit['type'], {}, this.node);
						break;
					default:
						throw new Error("Orient value is not a valid option.");
						break;
				}
			}
			else{
				throw new Error("Orient key does not exist in objInit arg");
			}
			if("caption" in objInit){
				this.caption = domConstruct.create("h3", {innerHTML: objInit["caption"]}, this.node, "first");
			}
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	setList: function(data){
		try{
			for(i =0; i < data.length; i++){
				domConstruct.create("li", {innerHTML: data[i]}, this.list);
			}
		}
		catch(e){
			console.error(this.eHandle.output(e, "setList"))
		}
	},	

	get: function(){
		try{
			return this.node;
		}
		catch(e){
			console.error(this.eHandle.output(e, "get"))
		}
	},	
});
////
});