// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "dojo/on", "dojo/dom", "dojo/dom-construct", "dojo/dom-attr", "dojo/string", "dojo/json", "mysa/utility/myError",
		"mysa/form/FormTemplate",
		"mysa/widgets/html/Table",
		"dijit/Editor", "dijit/_editor/plugins/AlwaysShowToolbar", "dijit/_editor/plugins/LinkDialog",
		"dojo/domReady!"],
function(declare, domConstruct, on, dom, domConstruct, domAttr, string, JSON, myError,
			FormTemplate,
			Table,
			Editor, AlwaysShowToolbar, LinkDialog){
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
		var rows = new Array();
		var editButtons = new Array();
		rows[0] = new Array("Id", "Email", "Created", "Options");

		for(i=0; i<this.viewPayload.users.length; i++){
			var row = new Array(
						this.viewPayload.users[i].id,
						this.viewPayload.users[i].email,
						this.viewPayload.users[i].created,
						'<a href="/admin/sheldonsays/view/val/' + this.viewPayload.users[i].id + '" >View</a>&nbsp;&nbsp;<a href="/admin/sheldonsays/edit/val/' + this.viewPayload.users[i].id + '" >Edit</a>'

						);
			rows[i+1] = row;
		}
		var table = new Table({orient: "horizontal"});
		table.setRows(rows);
		var div =  domConstruct.create("div", {class: "page-content1"});
		domConstruct.create("p", {innerHTML: "User Count:  " + this.viewPayload.user_count}, div);
		domConstruct.place(table.get(), div);
		return div;
		}
		catch(e){
			console.error(this.eHandle.output(e, "make"))
		}
	},	
});
////
});