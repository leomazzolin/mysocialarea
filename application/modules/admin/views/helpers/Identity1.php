<?php
class Zend_View_Helper_Identity1 extends Zend_View_Helper_Abstract
{
    public function Identity1 ( $flag, $email )
    {
		if($flag == true)
		{ ?>
            <p id="auth-status">
			<?php echo $email; ?>
            <br />
            <a href="/default/user/profile">My Profile</a>&nbsp;&nbsp;&bull;&nbsp;
            <a href="/default/user/logout">Log out</a>
            </p>
<?php   }
		else
		{?>
            <p id="auth-status">
            <a href="/default/user/login">Log in</a>&nbsp;&nbsp;&bull;&nbsp;
            <a href="/default/user/signup">Sign up</a><br />
            <a href="/default/user/forgotpassword">Forgot My Password</a> 
         	</p>
	<?php
        }
	}
}
?>