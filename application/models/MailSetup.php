<?php
class Model_MailSetup{
	
	protected 	$_configInfo = array(	'auth' => 'login',
										'username' => '',
										'password' => '',
										'port' => ''
									);
	protected	$_host = '';
	protected $_domain = '';
	
	protected $_from = array( 	'contact' 	=>	'admin');
	
	function __construct()
	{
   		$config = Zend_Registry::get("appOptions");
		$this->_configInfo['username'] = $config['my']['mailsetup']['username'];
		$this->_configInfo['password'] = $config['my']['mailsetup']['password'];
		$this->_configInfo['port'] = $config['my']['mailsetup']['port'];
		$this->_host = $config['my']['mailsetup']['host'];
		$this->_domain = $config['my']['mailsetup']['domain'];

	}

	public function  getConfigInfo()
	{
		return $this->_configInfo;
	}
	
	public function getHost()
	{
		return $this->_host;
	}
	
	public function getFrom($f)
	{
		return $this->_from[$f] . $this->_domain;
	}
	
	public function get_header()
	{?>
        <svg xmlns="http://www.w3.org/2000/svg"
             xmlns:xlink="http://www.w3.org/1999/xlink">
             <defs>
                <linearGradient id="myLinearGradient1"
                                x1="0%" y1="0%"
                                x2="0%" y2="100%"
                                spreadMethod="pad">
                  <stop offset="0%"   stop-color="#00cc00" stop-opacity="1"/>
                  <stop offset="100%" stop-color="#006600" stop-opacity="1"/>
                </linearGradient>
                <filter id="f1" x="0" y="0" width="200%" height="200%">
              <feOffset result="offOut" in="SourceGraphic" dx="20" dy="20" />
              <feGaussianBlur result="blurOut" in="offOut" stdDeviation="10" />
              <feBlend in="SourceGraphic" in2="blurOut" mode="normal" />
            </filter>
              </defs>
              <!--<rect x="0" y="0" width="88%" height="98px" rx="0" ry="0"
                 style="fill:url(#myLinearGradient1);
                        stroke: #005000;
                        stroke-width: 3;" />-->
            <text x="10"  y="30" class="svg1">My
                <tspan x="10" y="60" class="svg1">SocialArea</tspan>
                <tspan x="100" y="90" class="svg1">.com</tspan>
            </text>
            
        </svg>
	<?php
	}
/*
	public function header()
	{?>
    	<div style="width:70em; height: 8em; background-color: #f0f8ff; margin:0;">
        
            <div style="width:15%; height: inherit; float:left;">
                    <img style="height:100%; float:left" src="http://www.topdog-uofficepools.com/skins/blues/images/leftside.jpg" />
            </div>
            
            <div style="height:inherit; width:60%; float:left;">
                <div style="width:100%; height: 40%;" align="center">
                <h1>TopDog-U OfficePools.com</h1>
                </div>
            </div>
            
            <div style="width: 25%;  height: inherit; float:right; padding:0; margin:0;">
            	<img style="height:100%; float:right;" src="http://www.topdog-uofficepools.com/skins/blues/images/benny.jpg" />
            </div>
        </div>
	<?php
	}
*/
}
?>