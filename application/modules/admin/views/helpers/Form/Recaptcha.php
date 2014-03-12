<?php
class Zend_View_Helper_Form_Recaptcha extends Zend_View_Helper_Abstract
{
    public function Form_Recaptcha ()
    {
		$config = Zend_Registry::get("appOptions");
		$publicKey =  $config['my']['captcha']['publickey'];
		?>
        <input type="hidden" name="recaptcha_challenge_field" value="" id="captcha-challenge">
        <input type="hidden" name="recaptcha_response_field" value="" id="captcha-response">
        <script type="text/javascript">
            var RecaptchaOptions = {"theme":"white","lang":"en"};
        </script>
        <script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=<?php echo $publicKey; ?>"></script>
        <!--<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6LcIPNISAAAAAJAp2oXxFBcVkrvoGeH_lmLhl_4V"></script>-->
        <noscript>
        	<iframe src="http://www.google.com/recaptcha/api/noscript?k=<?php echo $publicKey; ?>" height="300" width="500" frameborder="0"></iframe>
          <!--<iframe src="http://www.google.com/recaptcha/api/noscript?k=6LcIPNISAAAAAJAp2oXxFBcVkrvoGeH_lmLhl_4V" height="300" width="500" frameborder="0"></iframe>-->
           <br>
           <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
           <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
        </noscript>
        <script type="text/javascript" language="JavaScript">
            function windowOnLoad(fn) {
                var old = window.onload;
                window.onload = function() {
                    if (old) {
                        old();
                    }
                    fn();
                };
            }
            function zendBindEvent(el, eventName, eventHandler) {
                if (el.addEventListener){
                    el.addEventListener(eventName, eventHandler, false); 
                } else if (el.attachEvent){
                    el.attachEvent('on'+eventName, eventHandler);
                }
            }
            windowOnLoad(function(){
                zendBindEvent(
                    document.getElementById("captcha-challenge").form,
                    'submit',
                    function(e) {
                        document.getElementById("captcha-challenge").value = document.getElementById("recaptcha_challenge_field").value;
                        document.getElementById("captcha-response").value = document.getElementById("recaptcha_response_field").value;
                    }    
                );
            });
        </script>
<?php
    }
}
?>