<?php
class Zend_View_Helper_Content_Socialmedia1 extends Zend_View_Helper_Abstract
{
    public function Content_Socialmedia1 ()
    {?>
    	<div style="background-color:#FFC; padding: 10px; margin: 10px; border:1px solid #999;">
            <h3>FOLLOW US ON FACEBOOK AND TWITTER:</h3>
            <br />
            <div style="float:left; width:45%">
                <div class="fb-like-box" data-href="http://www.facebook.com/mysocialarea" data-width="400" data-show-faces="false" data-stream="true" data-header="true"></div>
            </div>
            <div style="float:left;">
                <a class="twitter-timeline"  href="https://twitter.com/MySocialArea" data-widget-id="298511822699503616" width="400">Tweets by @MySocialArea</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </div>
            <br clear="all" /><br />
            <div style="width:60%; margin-left: 100px;">
                <p>By following us on Facebook and Twitter you will be able to stay current with everything that is happening on this website by getting instant notifications for the following:</p>
                <br />
                <ul>
                    <li>new content such as new modules</li>
                    <li>updates on new opinion polls</li>
                    <li>updates on new choices available to existing opinion polls</li>
                    <li>and much more</li>
                </ul>
            </div>
        </div>
        <br /><br />
	<?php
    }
}

?>