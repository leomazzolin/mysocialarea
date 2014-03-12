<?php
class Zend_View_Helper_Comments_Twitter extends Zend_View_Helper_Abstract
{
    public function Comments_Twitter ( $poll )
    { ?>
        <a class="twitter-timeline"  href="https://twitter.com/search?q=%23MySAPolls" data-widget-id="294095858209787905">Tweets about "#MySAPolls"</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<?php
	}
}
?>