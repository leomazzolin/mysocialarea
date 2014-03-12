// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "dojo/string",
		"dijit/Fieldset",
		 "mysa/utility/myError",
		"dojo/domReady!"],
function(declare, domConstruct, string,
			Fieldset,
		 	myError){
////
return declare(null, {
	
	errorInfo: {
				class: "mysa/widgets/Note",
				},
	div: null,
	title: null,
	content: null,
	fieldset: null,

	constructor: function(title, content){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.title = title;
			this.content = content;
			this.makeNote(title, content);
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	makeNote: function(t, c){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.div = domConstruct.create("div", {style: "background-color: red; width: 302px; ",});		  
			var fContent = "";
			for(var i = 0; i < c.length; i++){
				fContent = fContent.concat('<p style="font-size: 12px;">' + c[i] + '</p>');
			}
			this.fieldset = new Fieldset({
										title: t,
										content: fContent,
										style: "width: 300px;",
										});
			this.fieldset.placeAt(this.div);
			this.fieldset.startup();
		}
		catch(e){
			console.error(this.eHandle.output(e, "makeNote"))
		}
	},
	
	getNote: function(){
		try{
			return this.div;
		}
		catch(e){
			console.error(this.eHandle.output(e, "getScreenId"))
		}
	},	

	startup: function(){
		try{
			this.fieldset.startup();;
		}
		catch(e){
			console.error(this.eHandle.output(e, "getScreenId"))
		}
	},	

});
////
});