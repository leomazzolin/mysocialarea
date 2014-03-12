define(["dojo/_base/declare", 
		"dojo/dom", "dojo/dom-construct", "dojo/string", "dojo/on",
		"mysa/utility/myError", "mysa/form/FormTemplate",
		"mysa/layout/Default", "mysa/layout/Admin",
		"mysa/views/default/test/index",
		"mysa/views/default/index/index",
		"mysa/views/default/sheldonsays/index", "mysa/views/default/sheldonsays/theories",
		"mysa/views/default/contact/index",
		"mysa/views/default/help/index", "mysa/views/default/help/privacy", "mysa/views/default/help/tou",
		"mysa/views/default/user/index", "mysa/views/default/user/login", "mysa/views/default/user/register", "mysa/views/default/user/activate", "mysa/views/default/user/password", "mysa/views/default/user/resetpassword", "mysa/views/default/user/forgotpassword", "mysa/views/default/user/email","mysa/views/default/user/confirmemail", "mysa/views/default/user/personal",
		"mysa/views/admin/index/index", "mysa/views/admin/index/login",
		"mysa/views/admin/pages/index", "mysa/views/admin/pages/create", "mysa/views/admin/pages/edit",
		"mysa/views/admin/objects/index", "mysa/views/admin/objects/sheldontheoryoverview", "mysa/views/admin/objects/sheldontheoryedit", "mysa/views/admin/objects/sheldontheories", "mysa/views/admin/objects/sheldontheorytemplate",
		"mysa/views/admin/sheldonsays/index", "mysa/views/admin/sheldonsays/create", "mysa/views/admin/sheldonsays/edit", "mysa/views/admin/sheldonsays/view",
		"mysa/views/admin/users/index",
		"mysa/views/error",
		"dojo/i18n!mysa/nls/ModConPage",
		"dojo/domReady!"],
function(declare, 
			dom, domConstruct, string, on,
			myError, Formtemplate,
			layoutDefault, layoutAdmin,
			dTestIndex,
			dIndexIndex,
			dSheldonSaysIndex, dSheldonSaysTheories,
			dContactIndex,
			dHelpIndex, dHelpPrivacy, dHelpTou,
			dUserIndex, dUserLogin, dUserRegister, dUserActivate, dUserPassword, dUserResetPassword, dUserForgotPassword, dUserEmail, dUserConfirmEmail, dUserPersonal,
			aIndexIndex, aIndexLogin,
			aPagesIndex, aPagesCreate, aPagesEdit,
			aObjectsIndex, aObjectsSheldonTheoryOverview, aObjectsSheldonTheoryEdit, aObjectsSheldonTheories, aObjectsSheldonTheoryTemplate,
			aSheldonSaysIndex, aSheldonSaysCreate, aSheldonSaysEdit, aSheldonSaysView,
			aUsersIndex,
			errorView,
			MCP
			){
////
return declare(null, {
	
	errorInfo: {
				class: "Director",
				},
	layoutPayload: null,
	viewPayload: null,
	
	constructor: function(lp, vp){
		this.eHandle = new myError(this.errorInfo);
		try{
			this.layoutPayload = lp;
			this.viewPayload = vp;
		}
		catch(e){
			console.error(this.eHandle.output(e, "constructor"))
		}
	},

	get: function(){
		this.eHandle = new myError(this.errorInfo);
		try{
			if(this.viewPayload.errors){
				var view = new errorView(this.layoutPayload, this.viewPayload);
			}
			else{
				switch(this.layoutPayload.params.module){
					case "default":
						switch (this.layoutPayload.params.controller){
							case "test":
								var view = new dTestIndex(this.layoutPayload, this.viewPayload);
								break;
							case "index":
								switch (this.layoutPayload.params.action){
									case "index":
										var view = new dIndexIndex(this.layoutPayload, this.viewPayload);
										break;
									default:
										break;
								}		
								break;
							case "sheldonsays":
								switch (this.layoutPayload.params.action){
									case "index":
										var view = new dSheldonSaysIndex(this.layoutPayload, this.viewPayload);
										break;
									case "theories":
										var view = new dSheldonSaysTheories(this.layoutPayload, this.viewPayload);
										break;
									default:
										break;
								}
								break;	
							case "contact":
								switch (this.layoutPayload.params.action){
									case "index":
										var view = new dContactIndex(this.layoutPayload, this.viewPayload);
										break;
									default:
										break;
								}		
								break;
							case "help":
								switch (this.layoutPayload.params.action){
									case "index":
										var view = new dHelpIndex(this.layoutPayload, this.viewPayload);
										break;
									case "privacy":
										var view = new dHelpPrivacy(this.layoutPayload, this.viewPayload);
										break;
									case "tou":
										var view = new dHelpTou(this.layoutPayload, this.viewPayload);
										break;
									default:
										break;
								}		
								break;
							case "user":
								switch (this.layoutPayload.params.action){
									case "index":
										var view = new dUserIndex(this.layoutPayload, this.viewPayload);
										break;
									case "login":
										var view = new dUserLogin(this.layoutPayload, this.viewPayload);
										break;
									case "register":
										var view = new dUserRegister(this.layoutPayload, this.viewPayload);
										break;
									case "activate":
										var view = new dUserActivate(this.layoutPayload, this.viewPayload);
										break;
									case "forgotpassword":
										var view = new dUserForgotPassword(this.layoutPayload, this.viewPayload);
										break;
									case "resetpassword":
										var view = new dUserResetPassword(this.layoutPayload, this.viewPayload);
										break;
									case "password":
										var view = new dUserPassword(this.layoutPayload, this.viewPayload);
										break;
									case "email":
										var view = new dUserEmail(this.layoutPayload, this.viewPayload);
										break;
									case "confirmemail":
										var view = new dUserConfirmEmail(this.layoutPayload, this.viewPayload);
										break;
									case "personal":
										var view = new dUserPersonal(this.layoutPayload, this.viewPayload);
										break;
									case "password":
										var view = new dUserPassword(this.layoutPayload, this.viewPayload);
										break;
									default:
										break;
								}		
								break;
							default:
								break;
							}
							break;
					case "admin":
						switch (this.layoutPayload.params.controller){
							case "index":
								switch (this.layoutPayload.params.action){
									case "index":
										var view = new aIndexIndex(this.layoutPayload, this.viewPayload);
										break;
									case "login":
										var view = new aIndexLogin(this.layoutPayload, this.viewPayload);
										break;
									default:
										break;
								}		
								break;
							case "pages":
								switch (this.layoutPayload.params.action){
									case "index":
										var view = new aPagesIndex(this.layoutPayload, this.viewPayload);
										break;
									case "create":
										var view = new aPagesCreate(this.layoutPayload, this.viewPayload);
										break;
									case "edit":
										var view = new aPagesEdit(this.layoutPayload, this.viewPayload);
										break;
									default:
										break;
								}		
								break;
							case "objects":
								switch (this.layoutPayload.params.action){
									case "index":
										var view = new aObjectsIndex(this.layoutPayload, this.viewPayload);
										break;
									case "sheldontheoryoverview":
										var view = new aObjectsSheldonTheoryOverview(this.layoutPayload, this.viewPayload);
										break;
									case "sheldontheoryedit":
										var view = new aObjectsSheldonTheoryEdit(this.layoutPayload, this.viewPayload);
										break;
									case "sheldontheories":
										var view = new aObjectsSheldonTheories(this.layoutPayload, this.viewPayload);
										break;
									case "sheldontheorytemplate":
										var view = new aObjectsSheldonTheoryTemplate(this.layoutPayload, this.viewPayload);
										break;
									default:
										break;
								}		
								break;
							case "sheldonsays":
								switch (this.layoutPayload.params.action){
									case "index":
										var view = new aSheldonSaysIndex(this.layoutPayload, this.viewPayload);
										break;
									case "create":
										var view = new aSheldonSaysCreate(this.layoutPayload, this.viewPayload);
										break;
									case "edit":
										var view = new aSheldonSaysEdit(this.layoutPayload, this.viewPayload);
										break;
									case "view":
										var view = new aSheldonSaysView(this.layoutPayload, this.viewPayload);
										break;
									default:
										break;
								}		
								break;
							case "users":
								switch (this.layoutPayload.params.action){
									case "index":
										var view = new aUsersIndex(this.layoutPayload, this.viewPayload);
										break;
									default:
										break;
								}		
								break;
							default:
								break;
						}
						break;
					default:
						break;
				}
			}
			return view.make();
		}
		catch(e){
			console.error(this.eHandle.output(e, "view"))
		}
	},

});
////
});