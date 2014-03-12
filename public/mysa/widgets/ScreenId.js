// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "dojo/string",
		 "mysa/utility/myError",
		"dojo/domReady!"],
function(declare, domConstruct, string,
		 myError){
////
return declare(null, {
	
	errorInfo: {
				class: "mysa/widgets/ScreenId",
				},
	id: null,
	screenId: null,

	constructor: function(content){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.id = string.pad(content["id"], 4);
			var str = "";
			str = str.concat(content["username"], "_",  string.pad(content["id"], 4));
			//str = str.concat(str, content["username"]);
			this.screenId = str;
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	getScreenId: function(){
		try{
			return this.screenId;
		}
		catch(e){
			console.error(this.eHandle.output(e, "getScreenId"))
		}
	},	

	getId: function(){
		try{
			return this.id;
		}
		catch(e){
			console.error(this.eHandle.output(e, "getId"))
		}
	},	

});
////
});