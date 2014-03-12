// JavaScript Document
define(["dojo/_base/declare", "dojo/dom-construct", "dojo/dom-attr", "dojo/dom-style", "dojo/dom-class", "dojo/on", "dojo/json", "mysa/utility/myError",
		"dijit/registry", "dijit/form/Button", "dijit/form/RadioButton",
		"mysa/form/FormTemplate",
		"mysa/widgets/sheldonsays/Conclusion",
		"dojo/domReady!"],
function(declare, domConstruct, domAttr, domStyle, domClass, on, JSON, myError,
			registry, Button, RadioButton,
			FormTemplate,
			widgSSConclusion){
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
		var divContent =  domConstruct.create("div");
		if(this.layoutPayload.params.val == null){
			domClass.add(divContent, "page-content1");
			var radioInputs = new Array();
			for(var i = 0; i < 3; i++){
				radioInputs[i] = domConstruct.create("input", {}, divContent);
			}
			domConstruct.create("label", {for: "sort-chr-asc", innerHTML: "Sort Chronological ASC", style: "margin-right: 10px;" }, radioInputs[0], "after");
			domConstruct.create("label", {for: "sort-chr-desc", innerHTML: "Sort Chronological DESC", style: "margin-right: 10px;" }, radioInputs[1], "after");
			domConstruct.create("label", {for: "sort-views-asc", innerHTML: "Sort By Number of Views DESC", style: "margin-right: 10px;" }, radioInputs[2], "after");
			var dijitRadioInputs = new Array();
			for(var i = 0; i < 3; i++){
				dijitRadioInputs[i] = new RadioButton({}, radioInputs[i]);
			}
			switch(this.layoutPayload.params.sort){
				case "chr-desc":
					dijitRadioInputs[1].set({ checked: true });
					break;
				case "views-desc":
					dijitRadioInputs[2].set({ checked: true });
					break;
				default:
					dijitRadioInputs[0].set({ checked: true });
					break;			
			}
			on(dijitRadioInputs[0], "click", function(){
				window.location.href = "/sheldonsays/theories/sort/chr-asc";
			});
			on(dijitRadioInputs[1], "click", function(){
				window.location.href = "/sheldonsays/theories/sort/chr-desc";
			});
			on(dijitRadioInputs[2], "click", function(){
				window.location.href = "/sheldonsays/theories/sort/views-desc";
			});
			for(i = 0; i < this.viewPayload.factoids.length; i++){
				domConstruct.place(this.makeClaimsOverviewDiv(this.viewPayload.factoids[i]), divContent);			
			}
		}
		else{
			domConstruct.place(this.makeClaimsViewDiv(this.viewPayload.factoid), divContent);
		}
		return divContent;

		}
		catch(e){
			console.error(this.eHandle.output(e, "make"))
		}
	},	

	makeClaimsOverviewDiv: function(arrClaim){
		try{
			var divOutput =  domConstruct.create("div", {style: "margin: 10px 0 10px 0; background-color: yellow;"});
			var divYouTube = domConstruct.create("div", {style: "float: left; width: 230px; height: 130px;"});
			if(arrClaim.youtube == 0 || arrClaim.youtube == null ){
				domConstruct.create("p", {innerHTML: "No video available"}, divYouTube);
			}
			else{
				domConstruct.create("iframe", {
												width: 224,
												height: 126,
												src: "//www.youtube.com/embed/" + arrClaim.youtube,
												frameborder: 0,
												allowfullscreen: true,
												 }, divYouTube);
			}
			var divClaim = domConstruct.create("div", {style: "float: left; width: 490px; height: 150px;"});
			domConstruct.create("p", {
										innerHTML: arrClaim.claim,
									  }, divClaim);
			var divFooter = domConstruct.create("div", {
														//style: "margin-left: 150px;",
														});
			var button = domConstruct.create("button", {}, divFooter);
			var dijitButton = new Button(
						{
							innerHTML: "View Theory Page",
						}, button);
			domConstruct.create("p", {
										style: "display: inline-block;",
										innerHTML: "Season: " + arrClaim.season,
									}, divFooter);
			domConstruct.create("p", {
										style: "display: inline-block;",
										innerHTML: "Episode: " + arrClaim.episode,
									}, divFooter);
			domConstruct.create("p", {
										style: "display: inline-block;",
										innerHTML: "Theory ID:  #" + arrClaim.id,
									}, divFooter);
			domConstruct.create("p", {
										style: "display: inline-block;",
										innerHTML: "Views: " + arrClaim.views,
									}, divFooter);
			dijitButton.set("data-mysa-info", JSON.stringify(arrClaim));
			on(dijitButton, "click", function(){
				var info = JSON.parse(this.get("data-mysa-info"));
				window.location.href = "/sheldonsays/theories/val/" + info.id;
			});
			domConstruct.place(divYouTube, divOutput);
			domConstruct.place(divClaim, divOutput);
			domConstruct.place(divFooter, divOutput);
			return divOutput;
		}
		catch(e){
			console.error(this.eHandle.output(e, "make"))
		}
	},	

	makeClaimsViewDiv: function(arrClaim){
		try{
			var divOutput =  domConstruct.create("div", {
														class: "page-factoid c-w-720"});
			var button = domConstruct.create("button", {}, divOutput);
			var dijitButton = new Button(
						{
							innerHTML: "Go Back to List of Theories",
							scrollOnFocus:false
						}, button);
			on(dijitButton, "click", function(){
				window.location.href = "/sheldonsays/theories";
			});
			var hClaim = domConstruct.create("h1", {
													innerHTML: "CLAIM:",
												}, divOutput);
			var pClaim = domConstruct.create("p", {
													innerHTML: "&quot;" + arrClaim.claim + "&quot;",
													class: "claim",
												}, divOutput);
			var divYouTube = domConstruct.create("div", {style: "margin: auto"}, divOutput);
			if(arrClaim.youtube <= 0 || arrClaim.youtube == null ){
				var innerH = "Do you know of a YouTube video for this claim? Help me out by providing the id for the video.<br /> For example:";
				domConstruct.create("p", {
										innerHTML: innerH,
									  }, divYouTube);
				domConstruct.create("img", {
						src: "/sheldonsays/youtubeexample1.JPG",
					  }, divYouTube);
				var innerH = "Please enter this portion of the link to the video:";
				domConstruct.create("p", {
										innerHTML: innerH,
									  }, divYouTube);
				domConstruct.create("img", {
						src: "/sheldonsays/youtubeexample2.JPG",
					  }, divYouTube);
				var innerH = "And Thanxs!!!";
				domConstruct.create("p", {
										innerHTML: innerH,
									  }, divYouTube);
				domStyle.set(divYouTube, {width: "600px", height: "500px", backgroundColor: "#FF9", padding: "20px"});
				var Form = new FormTemplate(this.viewPayload.formData, this.viewPayload.formItems);
				domConstruct.place(Form.makeForm(), divYouTube);
				registry.byId("youtube-cancel").destroy();
			}
			else{
				domStyle.set(divYouTube, {width: "460px", height: "260px"});
				domConstruct.create("iframe", {
												width: 448,
												height: 252,
												src: "//www.youtube.com/embed/" + arrClaim.youtube,
												frameborder: 0,
												allowfullscreen: true,
												 }, divYouTube);
			}

			var pContent = domConstruct.create("p", {
										innerHTML: arrClaim.content,
									  }, divOutput);

			if(pContent.innerHTML.search("<p>!#!TRUE!#!</p>") > -1){
				var result = new widgSSConclusion("true");
				pContent.innerHTML = pContent.innerHTML.replace("<p>!#!TRUE!#!</p>", "");
				domConstruct.place(result.make(), pContent, "after");
			}
			if(pContent.innerHTML.search("<p>!#!FALSE!#!</p>") > -1){
				var result = new widgSSConclusion("false");
				pContent.innerHTML = pContent.innerHTML.replace("<p>!#!FALSE!#!</p>", "");
				domConstruct.place(result.make(), pContent, "after");
			}
			if(pContent.innerHTML.search("<p>!#!PLAUSIBLE!#!</p>") > -1){
				var result = new widgSSConclusion("plausible");
				pContent.innerHTML = pContent.innerHTML.replace("<p>!#!PLAUSIBLE!#!</p>", "");
				domConstruct.place(result.make(), pContent, "after");
			}
			domConstruct.place("vw-disqus", divOutput);
			return divOutput;
		}
		catch(e){
			console.error(this.eHandle.output(e, "make"))
		}
	},	
});
////
});