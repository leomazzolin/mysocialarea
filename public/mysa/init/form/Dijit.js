// JavaScript Document
define(["dojo/_base/declare",
		"mysa/utility/myError",
		"dojo/domReady!"],
function(
			declare,
			myError
		){
////
return declare(null, {
	
	errorInfo: {
				class: "mysa/init/form/Dijit",
				},

	objAttr: {
				scrollOnFocus: false,
				},

	constructor: function(){
		this.eHandle = new myError(this.errorInfo);
		try{
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	getAttr: function(objAttr){
		try{
			return this.objAttr;
		}
		catch(e){
			console.error(this.eHandle.output(e, "getAttr"))
		}
	},

});
////
});