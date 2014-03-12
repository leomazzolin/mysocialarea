// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "dojo/json", "dojo/dom-geometry", "dojo/dom-style",
		"mysa/widgets/sheldonsays/Conclusion",
		"mysa/utility/myError",
		"mysa/form/FormTemplate",
		"dojo/domReady!"],
function(declare, domConstruct, JSON, domGeom, domStyle,
			widgSSConclusion,
			myError,
			FormTemplate){
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
			this.viewPayload = JSON.stringify(vp);
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
			var div =  domConstruct.create("div", {
													class: "page-content1"
													});
			var para = "";
			para = para.concat("Welcome to MySocialArea.com. ");
			para = para.concat("More sections will be added to this site soon but for now take a look at the first section to this site...");
			domConstruct.create("p", {
										innerHTML: para,
										class: "c-w-360",
										style: "font-size: 24px; margin: auto;",
										}, div);
			var p = domConstruct.create("p", {
												class: "c-w-360",
												style: "font-size: 24px; margin: auto;",
											}, div);
			domConstruct.create("a", {
										innerHTML: "SHELDON SAYS",
										href: "/sheldonsays/index",
										style: "font-size: 24px;",
									}, p);
									
			domConstruct.create("h1", {
										innerHTML: "SECTIONS:",
										//class: "standard",
										style: "margin: 60px 10px 30px 10px",
									}, div);
			var anchorSS = domConstruct.create("a", {
										href: "/sheldonsays/index",
									}, div);
			var divSSSection = domConstruct.create("div", {
										class: "c-w-720 c-h-270",
										style: "background-color: blue;"
									}, anchorSS);
			domConstruct.create("img", {
										src: "/sheldonsays/sheldoncooper1.jpg",
										width: "350px",
										style: "float: right; margin: 20px 10px 20px 10px;",
									}, divSSSection);
			domConstruct.create("h1", {
										innerHTML: "SHELDON SAYS",
										style: "float: left; margin: 10px; width: 270px; color: white;",
									}, divSSSection);
			domConstruct.create("p", {
										innerHTML: "This section takes a look at all the theories that the character Sheldon Cooper of the sitcom The Big Bang Theory has stated over the seasons of the show.",
										style: "float: left; margin: 10px; width: 270px; color: white;",
									}, divSSSection);
			return div;
		}

		catch(e){
			console.error(this.eHandle.output(e, "make"))
		}
	},	
});
////
});