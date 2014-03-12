// JavaScript Document
define(["dojo/_base/declare", "dojo/string",
		"dojo/domReady!"],
function(declare, string){
////
return declare(null, {
	
	constructor: function(jInfo){
		this.info = jInfo;
		try{
			if(typeof this.info != "object")
			throw "!! MYSA GENERAL ERROR\nYou forgot to initialize myError object somewhere dummy !!\nERROR INFO:  " + this.info.test;
		}catch(e){
			console.error(e);
		}
	},
	
	output: function(error, func){
		var line = new Error(error).lineNumber;
		var txt = "MYSA ERROR:\n";
		txt = txt + "Class: " + this.info.class + "\n";
		txt = txt + "Function: " + func + "\n";
		txt = txt + "Name: " + error.name + "\n";
		txt = txt + "Description: " + error.description + "\n";
		txt = txt + "Message: " + error.message + "\n";
		txt = txt + "Line#: " + line;
		return txt;
	},
});
////
});