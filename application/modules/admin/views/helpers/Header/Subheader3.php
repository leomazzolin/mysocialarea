<?php
class Zend_View_Helper_Header_Subheader3 extends Zend_View_Helper_Abstract
{
    public function Header_Subheader3 ( )
    {?>
    	<h3>LIKE OUR WEBSITE:</h3>
        <div class="fb-like" data-href="http://www.mysocialarea.com" data-send="true" data-layout="button_count" data-width="150" data-show-faces="true" data-font="arial"></div>
        <br /><br />
        <h3><a>FOLLOW US:</a></h3>
        <a href="https://twitter.com/mysocialarea" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @MySocialArea</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	<?php
    }
}

?>