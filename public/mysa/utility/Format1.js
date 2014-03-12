// JavaScript Document
define(["dojo/_base/declare", "dojo/string",
		"mysa/utility/myError",
		"dojo/domReady!"],
function(declare, string,
		 myError
		 ){
////
return declare(null, {
	
	errorInfo: {
				class: "utilty/Format1",
				},

	constructor: function(){
		this.eHandle = new myError(this.errorInfo);
		try{
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	screenID: function(username, id){
	try{
		return username + "_" + string.pad(id, 4);
	}
	catch(e){
		console.error(this.eHandle.output(e, "screenID"))
	}
	},

	userID: function(id){
	try{
		return string.pad(id, 4);
	}
	catch(e){
		console.error(this.eHandle.output(e, "userID"))
	}
	}
	
});
////
});