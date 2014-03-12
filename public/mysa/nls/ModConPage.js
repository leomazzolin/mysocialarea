define({
root: {
	module: [
		{
			name: "default",
			title: null,
			controller: [
						 {
							name: "index",
							title: "HOME",
							action: [
									{
										name: "index",
										title: "Welcome to MySocialArea.com",
									}
							],
						},
						/*
						{
							name: "pss",
							title: "PET SOCIAL SPACE",
							action: [
									{
										name: "index",
										title: "Overview",
									},
									{
										name: "collage",
										title: "Photo Gallery",
									},
									{
										name: "pages",
										title: "Your Pet Pages",
									},
									{
										name: "search",
										title: "Pet Page Search",
									},
									{
										name: "feedback",
										title: "Feedback",
									},
							],
						},
						*/
						{
							name: "sheldonsays",
							title: "SHELDON SAYS",
							action: [
									{
										name: "index",
										title: "Overview",
									},
									{
										name: "theories",
										title: "Theories",
									}
							],
						},
						{
							name: "contact",
							title: "CONTACT US",
							action: [
									{
										name: "index",
										title: "Overview",
									}
							],
						},
						{
							name: "help",
							title: "HELP",
							action: [
									{
										name: "index",
										title: "Overview",
									},
									{
										name: "tou",
										title: "Terms of Use",
									},
									{
										name: "privacy",
										title: "Privacy",
									},
							],
						},
						{
							name: "user",
							title: "MY PROFILE",
							action: [
									{
										name: "index",
										title: "Overview",
									},
									{
										name: "email",
										title: "Edit Email Address",
									},
									{
										name: "personal",
										title: "Edit Personal Details",
									},
									{
										name: "password",
										title: "Change Password",
									},
									{
										name: "login",
										title: "login",
										show: false,
									},
									{
										name: "register",
										title: "register",
										show: false,
									},
									{
										name: "forgotpassword",
										title: "forgot password",
										show: false,
									},
									{
										name: "activate",
										title: "account activation",
										show: false,
										msg1: "Please check the inbox of the email address you used to register with us for a token password and enter it in the form below along with your email address and password to complete the registration process.",
									},
									{
										name: "confirmemail",
										title: "confirm emaill address",
										show: false,
										msg1: "Please check the inbox of the new email address you supplied for a token password and enter it in the form below to complete the change of email address process.",
									},
									{
										name: "resetpassword",
										title: "reset password",
										show: false,
										msg1: "Please check the inbox of the email address you supplied to us for a token password and enter it below to complete the password reset process.",
									},
							],
						},
			],
		//END CONTROLLERS
		},
		{
			name: "admin",
			title: null,
			controller: [
						 {
							name: "index",
							title: "ADMIN HOME",
							action: [
									{
										name: "index",
										title: "Overview",
									}
							],
						},
						{
							name: "pages",
							title: "PAGES",
							action: [
									{
										name: "index",
										title: "Overview",
									},
									{
										name: "create",
										title: "Create",
									},
									{
										name: "edit",
										title: "Edit",
									},
							],
						},
						{
							name: "sheldonsays",
							title: "OBJECTS -- SHELDON SAYS",
							action: [
									{
										name: "index",
										title: "Overview",
									},
									{
										name: "view",
										title: "View Theory Details",
									},
									{
										name: "create",
										title: "Create",
									},
									{
										name: "edit",
										title: "Edit",
									},
							],
						},
						{
							name: "users",
							title: "OBJECTS -- USERS",
							action: [
									{
										name: "index",
										title: "Overview",
									},
							],
						},
						{
							name: "objects",
							title: "OBJECTS",
							action: [
									{
										name: "index",
										title: "Overview",
									},
									{
										name: "sheldontheoryoverview",
										title: "Sheldon Theory Overview",
									},
									{
										name: "sheldontheoryedit",
										title: "Sheldon Theory Edit",
									},
									{
										name: "sheldontheories",
										title: "Sheldon Theories",
									},
									{
										name: "sheldontheorytemplate",
										title: "Sheldon Theory Template",
									},
							],
						},
						{
							name: "pss",
							title: "PET SOCIAL SPACE",
							action: [
									{
										name: "index",
										title: "Overview",
									},
									{
										name: "collage",
										title: "Photo Gallery",
									},
									{
										name: "pages",
										title: "Your Pet Pages",
									},
									{
										name: "search",
										title: "Pet Page Search",
									},
									{
										name: "feedback",
										title: "Feedback",
									},
							],
						},
						{
							name: "contact",
							title: "CONTACT US",
							action: [
									{
										name: "index",
										title: "Overview",
									}
							],
						},
						{
							name: "help",
							title: "HELP",
							action: [
									{
										name: "index",
										title: "General",
									},
									{
										name: "tou",
										title: "Terms of Use",
									},
									{
										name: "privacy",
										title: "Privacy",
									},
							],
						},
						{
							name: "user",
							title: "MY PROFILE",
							action: [
									{
										name: "index",
										title: "Overview",
									},
									{
										name: "email",
										title: "Edit Email Address",
									},
									{
										name: "personal",
										title: "Edit Personal Details",
									},
									{
										name: "password",
										title: "Change Password",
									},
									{
										name: "login",
										title: "login",
										show: false,
									},
									{
										name: "register",
										title: "register",
										show: false,
									},
									{
										name: "forgotpassword",
										title: "forgot password",
										show: false,
									},
									{
										name: "activate",
										title: "account activation",
										show: false,
										msg1: "Please check the inbox of the email address you used to register with us for a token password and enter it in the form below along with your email address and password to complete the registration process.",
									},
									{
										name: "confirmemail",
										title: "confirm emaill address",
										show: false,
										msg1: "Please check the inbox of the new email address you supplied for a token password and enter it in the form below to complete the change of email address process.",
									},
									{
										name: "resetpassword",
										title: "reset password",
										show: false,
										msg1: "Please check the inbox of the email address you supplied to us for a token password and enter it below to complete the password reset process.",
									},
							],
						},
			],
		//END CONTROLLERS
		},
	//END MODULES
	],
//END ROOT
},
	"fr-fr": true,
});

