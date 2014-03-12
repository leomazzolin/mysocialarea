<?php
class Zend_View_Helper_Comments_Facebook extends Zend_View_Helper_Abstract
{
    public function Comments_Facebook ( $uri )
    {
		?>
        <script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=188317251310377";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>
        <div class="fb-comments" data-href="http://mysocialarea.com<?php echo $uri; ?>" data-width="470" data-num-posts="5"></div>
<?php
	}
}
?>