<?php

class TwitterController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function authenticateAction()
    {
		 $config = array(
        'callbackUrl' => 'http://qotd/default/twitter/callback',
        'siteUrl' => 'http://twitter.com/oauth',
        'consumerKey' => 'OpVwSRiUnV8VTtdOzY9CA',
        'consumerSecret' => 'YsJbwG4O5QR64wYkVEY4PASVab21XE8PJImNiu5wXdU'
		);
		$consumer = new Zend_Oauth_Consumer($config);
		 
		// fetch a request token
		$token = $consumer->getRequestToken();
		 
		// persist the token to storage
		$_SESSION['TWITTER_REQUEST_TOKEN'] = serialize($token);
		 
		// redirect the user
		$consumer->redirect();
	}

    public function callbackAction()
    {
		 $config = array(
        'callbackUrl' => 'http://qotd/default/twitter/callback',
        'siteUrl' => 'http://twitter.com/oauth',
        'consumerKey' => 'OpVwSRiUnV8VTtdOzY9CA',
        'consumerSecret' => 'YsJbwG4O5QR64wYkVEY4PASVab21XE8PJImNiu5wXdU'
		);
		$consumer = new Zend_Oauth_Consumer($config);
	 
		if (!empty($_GET) && isset($_SESSION['TWITTER_REQUEST_TOKEN'])) {
			$token = $consumer->getAccessToken(
						 $_GET,
						 unserialize($_SESSION['TWITTER_REQUEST_TOKEN'])
					 );
			$_SESSION['TWITTER_ACCESS_TOKEN'] = serialize($token);
		 
			// Now that we have an Access Token, we can discard the Request Token
			$_SESSION['TWITTER_REQUEST_TOKEN'] = null;
			$this->_redirect('/default/index/index');
		} else {
			// Mistaken request? Some malfeasant trying something?
			exit('Invalid callback request. Oops. Sorry.');		
			}
	}

}





