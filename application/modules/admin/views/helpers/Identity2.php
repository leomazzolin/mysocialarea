<?php
class Zend_View_Helper_Identity2 extends Zend_View_Helper_Abstract
{
    public function Identity2 ( $flag, $email )
    {?>
		<script>
		var hasFacebook = false;
          // Additional JS functions here
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '188317251310377', // App ID
              channelUrl : 'http://www.mysocialrea.com/default/facebook/xdreceiver', // Channel File
              status     : true, // check login status
              cookie     : true, // enable cookies to allow the server to access the session
              xfbml      : true  // parse XFBML
            });
            
            // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
          // for any authentication related change, such as login, logout or session refresh. This means that
          // whenever someone who was previously logged out tries to log in again, the correct case below 
          // will be handled. 
          FB.Event.subscribe('auth.authResponseChange', function(response) {
			  alert("hello");
            // Here we specify what we do with the response anytime this event occurs. 
            if (response.status === 'connected') {
              // The response object is returned with a status field that lets the app know the current
              // login status of the person. In this case, we're handling the situation where they 
              // have logged in to the app.
              //testAPI();
			  hasFacebook = true;
            } else if (response.status === 'not_authorized') {
              // In this case, the person is logged into Facebook, but not into the app, so we call
              // FB.login() to prompt them to do so. 
              // In real-life usage, you wouldn't want to immediately prompt someone to login 
              // like this, for two reasons:
              // (1) JavaScript created popup windows are blocked by most browsers unless they 
              // result from direct interaction from people using the app (such as a mouse click)
              // (2) it is a bad experience to be continually prompted to login upon page load.
              FB.login();
            } else {
              // In this case, the person is not logged into Facebook, so we call the login() 
              // function to prompt them to do so. Note that at this stage there is no indication
              // of whether they are logged into the app. If they aren't then they'll see the Login
              // dialog right after they log in to Facebook. 
              // The same caveats as above apply to the FB.login() call here.
              FB.login();
            }
          });
          
          };
        
          // Load the SDK asynchronously
          (function(d){
             var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement('script'); js.id = id; js.async = true;
             js.src = "//connect.facebook.net/en_US/all.js";
             ref.parentNode.insertBefore(js, ref);
           }(document));
           // Here we run a very simple test of the Graph API after login is successful. 
          // This testAPI() function is only called in those cases. 
          function testAPI() {
            console.log('Welcome!  Fetching your information.... ');
            FB.api('/me', function(response) {
                alert(response.name);
              //console.log('Good to see you, ' + response.name + '.');
            });
          }
        </script>
        <script src="https://connect.facebook.net/en_US/all.js"></script>
        <?php
		if($flag == true)
		{ ?>
			<script>
            require(["dijit/Menu", "dijit/MenuItem", "dijit/form/ComboButton", "dojo/dom-construct", "dojo/domReady!"],
                    function(Menu, MenuItem, ComboButton, domConstruct){
				var a = new domConstruct.create("p", { id: "auth-status", innerHTML: "<?php echo $email; ?>" }, "combobutton");
				var br =  new domConstruct.create("br", { }, "auth-status");				
				var a =  new domConstruct.create("a", { href: "/default/user/profile", innerHTML: "My Profile" }, "auth-status");
				var br =  new domConstruct.create("br", { }, "auth-status");				
				if(hasFacebook == true){
					var fb = new domConstruct.create("fb:login-button", { size: "small", 
																			autologoutlink: "true" }, "auth-status");
				}
				else{
					var a = new domConstruct.create("a", { href: "/default/user/logout", innerHTML: "Log out" }, "auth-status");
				}
				
               // button.placeAt(dojo.body());
			   function fb_logout(){
				   FB.logout(function(response) {
					});
			   }
            });		
            </script>
<?php   }
		else
		{?>
			<script>
            require(["dijit/Menu", "dijit/MenuItem", "dijit/form/ComboButton", "dojo/domReady!"],
                    function(Menu, MenuItem, ComboButton){
                var menu = new Menu({ style: "display: none;"});
                var menuItem1 = new MenuItem({
                    label: "Login",
                    onClick: function(){ window.location.href = "/default/user/login"; }
                });
                menu.addChild(menuItem1);
            
                var menuItem2 = new MenuItem({
                    label: "Register",
                    onClick: function(){ window.location.href = "/default/user/register"; }

                });
                menu.addChild(menuItem2);
            
                var menuItem3 = new MenuItem({
                    label: "Forgot Password",
                    onClick: function(){ window.location.href = "/default/user/forgotpassword"; }
                });
                menu.addChild(menuItem3);

                var button = new ComboButton({
                    label: "Enter MySocialArea.com",
                    dropDown: menu,
                }, "combobutton");
               // button.placeAt(dojo.body());
            });
            </script>
	<?php
        }
	}
}
?>