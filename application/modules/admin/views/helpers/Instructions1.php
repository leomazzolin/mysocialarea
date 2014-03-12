<?php
class Zend_View_Helper_Instructions1 extends Zend_View_Helper_Abstract
{
    public function Instructions1 ($data)
    { 
		switch ($data)
		{
		case 'default_user_login':
			$msg = "Please enter your email address and password...";
			break;
		case 'default_user_activate':
			$msg = "Please enter the email address you used to sign up with us as well as all the other necessary information 
					to complete the sign up process.<br />
					The token password was provided to you in the sign up confirmation email sent to you.";
			break;
		case 'default_user_confirmemail':
			$msg = "Please enter the your new email address to complete the change of email address process.<br />
					The token password was provided to you in the change of email confirmation email sent to you.";
			break;
		case 'default_user_email':
			$msg = "Please enter a new email address and confirm the new email address
					<br />
					A confirmation email will be sent to this address to complete the process.";
			break;
		case 'default_user_signup':
			$msg = "Please enter your email address.
					<br />
					A confirmation email will be sent to this address to complete your account activation process.";
			break;
		case 'default_user_password':
			$msg = "Please enter your current password and enter your new passsword and confirm.";
			break;
		case 'default_user_forgotpassword':
			$msg = "Please enter the email address you used to sign up with us.
					<br />
					An email will be sent to this address with further instructions for resetting your password.";
			break;
		case 'default_user_resetpassword':
			$msg = "Please enter your email address, token password that was provided to you in the password reset email sent to you 
					and your new password.";
			break;
		case 'default_user_personal':
			$msg = "Edit your personal details.";
			break;
		default:
			break;
		}
	?>
		<h3>INSTRUCTIONS:</h3>
        <p style="width: 60%;"><?php echo $msg ?></p>
        <br />
<?php
	}
}
?>