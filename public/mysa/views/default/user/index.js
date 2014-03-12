// JavaScript Document
define(["dojo/_base/declare",  "dojo/_base/lang", "dojo/dom-construct", "dojo/dom-geometry", "dojo/dom-style", "dojo/json",
		"dojox/html/entities", "dojox/string/Builder",
		"mysa/utility/myError","mysa/form/FormTemplate",
		"mysa/widgets/ScreenId", "mysa/widgets/Note",
		"mysa/widgets/html/h/style1", "mysa/widgets/html/p/style1", "mysa/widgets/html/table/vertical", "mysa/widgets/html/Table", "mysa/widgets/html/List",
		"dojo/domReady!"],
function(declare, lang, domConstruct, domGeom, domStyle, JSON,
			Entities, builder,
			myError, FormTemplate,
			wScreenId, Note,
			wHtmlH, wHtmlP, wHtmlTableV, wHtmlTable, wHtmlList){
////
return declare(null, {
	
	errorInfo: {
				class: "mysa/views/",
				},

	layoutPayload: null,
	viewPayload: null,

	constructor: function(lp, vp){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.layoutPayload = lp;
			this.viewPayload = vp;
			this.errorInfo.class = this.errorInfo.class 
				+ this.layoutPayload.params.module
				+ "/"
				+ this.layoutPayload.params.controller
				+ "/"
				+ this.layoutPayload.params.action;
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},
	
	make: function(){
	try{
		var wSId = new wScreenId({"id": this.viewPayload.id, "username": this.viewPayload.personal.username});
		var screenId = wSId.getScreenId(); 
		var categories = {
					"MySocialArea.com Credentials": this.viewPayload.id,
					"Email": this.viewPayload.general.email,
					"Personal": "personal info goes here...as in name, username, birthday, ...",
				};
		for (key in categories){
			var attach = "l-content";
			var returnDiv = domConstruct.create("div");
			domConstruct.place(returnDiv, attach);
			switch (key){
				case "MySocialArea.com Credentials":
					var div = domConstruct.create("div");
					div.style = "margin: 10px; width: 200px; padding: 10px 10px 10px 10px; background-color: yellow;";
					var objInit = {orient: "vertical", caption: "Basic Credentials:",};
					var t = new wHtmlTable(objInit);
					var data = new Array(
							new Array("Id: ", wSId.getId()),
							new Array("ScreenId: ", screenId)
						);
					t.setRows(data);
					domConstruct.place(t.get(), div);
					var ttl = "Notes:";
					var content = new Array(
										"Your ScreenId is simply your UserId combined with your Username.",
										"You cannot change your UserId and your ScreenId will change if you cahnge your Username."
										);
					var dijit = new Note(ttl, content);
					var note = dijit.getNote();
					domConstruct.place(note, div);
					domConstruct.place(div, returnDiv );
					break;
				case "Email":
					var div = domConstruct.create("div");
					div.style = "margin: 10px; width: 200px; padding: 10px 10px 10px 10px; background-color: yellow;";
					var objInit = {type: "ul", caption: "Email Address:"};
					var l = new wHtmlList(objInit);
					var email = categories[key].replace('@', '[at]');
					var data = new Array(email);
					l.setList(data);
					domConstruct.place(l.get(), div);
					domConstruct.place(div, returnDiv );
					break;
				case "Personal":
					var div = domConstruct.create("div");
					div.style = "margin: 10px; width: 200px; padding: 10px 10px 10px 10px; background-color: yellow;";
					var objInit = {orient: "vertical", caption: "MySocialArea.com Credentials:",};
					var t = new wHtmlTable(objInit);
					var data = new Array(
							new Array("Name: ", this.viewPayload.personal.name),
							new Array("Userame: ", this.viewPayload.personal.username),
							new Array("Birthday: ", this.viewPayload.personal.birthday)
							);
					t.setRows(data);
					domConstruct.place(t.get(), div);
 					domConstruct.place(div, returnDiv );
					break;
				case "Misc":
					var div = domConstruct.create("div");
					div.style = "margin: 10px; width: 200px; padding: 10px 10px 10px 10px; background-color: yellow;";
					var objInit = {orient: "horizontal", caption: "MySocialArea.com Credentials:",};
					var t = new wHtmlTable(objInit);
					var data = categories['Misc'];
					t.setRows(data);
					domConstruct.place(t.get(), div);
					domConstruct.place(div, returnDiv );
					break;
				default:
				break;
			}
		}
		return returnDiv;
	}
	catch(e){
		console.error(this.eHandle.output(e, "make"))
	}
	},	
});
////
});