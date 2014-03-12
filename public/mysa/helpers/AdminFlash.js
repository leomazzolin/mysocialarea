// JavaScript Document
define(["dojo/_base/declare",
		"dojo/on", "dojo/dom", "dojo/dom-construct", "dojo/dom-class", "dojo/string",
		"dijit/form/Button",
		"mysa/utility/myError",
		"dojo/domReady!"],
function(declare,
		 on, dom, domConstruct, domClass, string,
		 Button,
		 myError){
////
return declare(null, {
	
	errorInfo: {
				class: "helpers/Flash",
				},

	constructor: function(json){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.flash = json;
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	setFlashMsgs: function(json){
	try{
		this.flash = json;
		}
		catch(e){
			console.error(this.eHandle.output(e, "setFlashMsgs"))
		}
	},
	
	display: function(){
	try{
		var bgc;
		domStyle.set("l-message-holder", "height", "200px");
		var div = domConstruct.create("div", {	
												id: "flash",
											 }, "l-message-holder");
		domConstruct.create("br", null, div, "after");
		switch(this.flash.namespace){
			case "success":
				domClass.add(div, "success");
				break;
			case "error":
				domClass.add(div, "error");
				break;
			case "notice":
				domClass.add(div, "notice");
				break;
			default:
				break;
		}
		for(var i = 0; i < this.flash.msgs.length; i++){
			domConstruct.create("p", { innerHTML: this.flash.msgs[i]}, "flash");
		}
		var p =  domConstruct.create("p", { style: "margin-left: 200px;"}, "flash");
		var b = domConstruct.create("button", {	id: "flash-button" }, p);
		
		var button = new Button({
			id: "flash-button",
			name: "flash-button",
			value: "flash-button",
			innerHTML: "Close",
			scrollOnFocus:false
		}, b);
		on(button, "click", function(){
           domConstruct.destroy(dom.byId("flash").id);
		   domStyle.set("l-message-holder", "height", "0px");

		});
		}
		catch(e){
			console.error(this.eHandle.output(e, "display"))
		}
	}
	
});
////
});