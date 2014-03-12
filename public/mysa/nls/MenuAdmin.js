define({
root:{
    menu: [
			{
				label: "HOME",
				module: "admin",
				controller: "index",
				action: "index",
			},
			{
				label: "PAGES",
				submenu: [
								{
									label: "Overview",
									module: "admin",
									controller: "pages",
									action: "index",
								},
								{
									label: "Create",
									module: "admin",
									controller: "pages",
									action: "create",
								},
							 ]
			},
			{
				label: "OBJECTS",
				submenu: [
								{
									label: "Overview",
									module: "admin",
									controller: "objects",
									action: "index",
								},
								{
									label: "Users",
									submenu: [
													{
														label: "Overview",
														module: "admin",
														controller: "users",
														action: "index",
													},
												 ]
								},
								{
									label: "Sheldon Says",
									submenu: [
													{
														label: "Overview",
														module: "admin",
														controller: "sheldonsays",
														action: "index",
													},
													{
														label: "Create",
														module: "admin",
														controller: "sheldonsays",
														action: "create",
													},
												 ]
								},
							 ]
			},
    ],
},
	"fr-fr": true
});