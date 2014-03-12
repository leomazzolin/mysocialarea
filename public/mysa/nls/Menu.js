define({
root:{
    menu: [
			//DEFAULT MODULE
			{
				label: "HOME",
				module: "default",
				controller: "index",
				action: "index",
			},
			{
				label: "Sheldon Says",
				submenu: [
								{
									label: "Overview",
									module: "default",
									controller: "sheldonsays",
									action: "index",
								},
								{
									label: "Theories",
									module: "default",
									controller: "sheldonsays",
									action: "theories",
								},
							 ]
			},
			{
				label: "Contact Us",
				module: "default",
				controller: "contact",
				action: "index",
			},
			{
				label: "HELP",
				submenu: [
								{
									label: "Overview",
									module: "default",
									controller: "help",
									action: "index",
								},
								{
									label: "Terms of Use",
									module: "default",
									controller: "help",
									action: "tou",
								},
								{
									label: "Privacy",
									module: "default",
									controller: "help",
									action: "privacy",
								},
							 ]
			},
			{
				label: "My Profile",
				submenu: [
								{
									label: "Overview",
									module: "default",
									controller: "user",
									action: "index",
								},
								{
									label: "Edit Email Address",
									module: "default",
									controller: "user",
									action: "email",
								},
								{
									label: "Edit Personal Details",
									module: "default",
									controller: "user",
									action: "personal",
								},
								{
									label: "Edit Password",
									module: "default",
									controller: "user",
									action: "password",
								},
							 ]
			},
    ],
},
	"fr-fr": true
});