<?php
class Zend_View_Helper_Prompt1 extends Zend_View_Helper_Abstract
{
    public function Prompt1 ($uri)
    {		
		?><p style="font-weight: bolder; margin-bottom: 10px;">PLEASE <a href="/default/user/login/uri<?php echo $uri ?>">LOGIN</a> TO ACCESS THIS RESOURCE<br />OR<br /><a href="/default/user/signup">SIGN UP</a> NOW!!!</p><?php
    }
}
?>