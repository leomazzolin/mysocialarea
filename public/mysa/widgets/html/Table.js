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
	thead: null,
	tbody: null,
	tfoot: null,

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
						var cssClass = "v-" + this.cssClass;
						this.table = domConstruct.create("table", {class: cssClass,});
						var colgroup = domConstruct.create("colgroup", {}, this.table);
						domConstruct.create("col", {span: "1", class: "th" }, colgroup);
						domConstruct.create("col", {class: "td"}, colgroup);
						this.tbody = domConstruct.create("tbody", {}, this.table);
						break;
					case "horizontal":
						var cssClass = "h-" + this.cssClass;
						this.table = domConstruct.create("table", {class: cssClass,});
						this.thead = domConstruct.create("thead", {}, this.table);
						this.tbody = domConstruct.create("tbody", {}, this.table);
						if(objInit['tfoot'] == true){
							this.tfoot = domConstruct.create("tfoot", {}, this.table);
						}
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
				domConstruct.create("caption", {class: cssClass, innerHTML: objInit["caption"]}, this.table, "first");
			}
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	setRows: function(data){
		try{
			if("orient" in this.objInit){
				switch(this.objInit['orient']){
					case "vertical":
						var cssClass = "v-" + this.cssClass;
						for(var i = 0; i < data.length; i++){
							var tr = domConstruct.create("tr", {}, this.tbody);
							for(var j = 0; j < data[i].length; j++){
								if(j == 0){
									domConstruct.create("th", {innerHTML: data[i][j]}, tr);
								}
								else{
									domConstruct.create("td", {innerHTML: data[i][j]}, tr);
								}
							}
						}
						break;
					case "horizontal":
						var cssClass = "h-" + this.cssClass;
						for(var i = 0; i < data.length; i++){
							if(i == 0){
								var tr = domConstruct.create("tr", {class: cssClass,}, this.thead);
								for(var j = 0; j < data[i].length; j++){
									domConstruct.create("th", {class: cssClass, innerHTML: data[i][j]}, tr);
								}
							}
							else if(i == (data.length - 1) && this.objInit['tfoot'] == true){
								var tr = domConstruct.create("tr", {class: cssClass,}, this.tfoot);
								for(var j = 0; j < data[i].length; j++){
									domConstruct.create("td", {class: cssClass, innerHTML: data[i][j]}, tr);
								}
							}
							else{
								var tr = domConstruct.create("tr", {class: cssClass,}, this.tbody);
								for(var j = 0; j < data[i].length; j++){
									domConstruct.create("td", {class: cssClass, innerHTML: data[i][j]}, tr);
								}
							}
						}
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