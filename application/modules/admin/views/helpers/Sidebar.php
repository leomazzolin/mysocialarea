<?php
class Zend_View_Helper_Sidebar extends Zend_View_Helper_Abstract
{
    public function Sidebar ()
    {?>
        <div id="l-side" style="height: auto; width: 100%; margin-left: 10px; padding: 0 10px 0 10px; background-color: #F0F0F0; border-left: 1px solid black;">
        <div style="padding: 10px 25px 0 25px;">
        <script type="text/javascript" src="/scripts/google/square250.js"></script>
        <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
        </div>
        <br />
        <h3 style="border: 1px solid black; padding: 5px; margin-bottom: 5px;">FACEBOOK:</h3>
        <div class="fb-like-box" data-href="https://www.facebook.com/mysocialarea" data-width="300" data-show-faces="true" data-header="true" data-stream="true" data-show-border="true"></div>
        <br /><br />
        <h3 style="border: 1px solid black; padding: 5px; margin-bottom: 5px;">TWITTER:</h3>
        <div style="width: 300px;"><a class="twitter-timeline"  href="https://twitter.com/MySocialArea"  data-widget-id="381497177127649280" data-chrome="transparent">Tweets by @MySocialArea</a></div>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </div>
        <div id="l-subheader-3">
        <script type="text/javascript" src="/scripts/google/banner.js"></script>
        <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
        </div>
<?php
    }
}
?>