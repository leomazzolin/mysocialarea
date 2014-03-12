<?php
class Zend_View_Helper_Recaptcha extends Zend_View_Helper_Abstract
{
    public function Recaptcha ()
    {?>
        <div id="recap">
        <label id="recap-label" class="required" for="mycaptcha">reCaptcha: </label>
        <script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6LcIPNISAAAAAJAp2oXxFBcVkrvoGeH_lmLhl_4V"></script>
        <noscript>
           <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LcIPNISAAAAAJAp2oXxFBcVkrvoGeH_lmLhl_4V"
               height="300" width="500" frameborder="0"></iframe><br>
           <textarea id="mycaptcha" name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
           <input id="recaptcha_response_field" required="required" type="hidden" name="recaptcha_response_field" value="manual_challenge">
        </noscript>
        <!--<p id="recap-refresh-msg" style="font-size: 80%; font-weight:bold; background-color:#FF0; padding: 5px;"></p>-->
        </div>
<?php
    }
}
?>