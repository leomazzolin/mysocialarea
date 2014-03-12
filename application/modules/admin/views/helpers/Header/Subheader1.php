<?php
class Zend_View_Helper_Header_Subheader1 extends Zend_View_Helper_Abstract
{
    public function Header_Subheader1 ( )
    {?>
        <a href="/">
        <img src="/images/website_logo.jpg" height="100%" width="100%" />
        <!--
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
                        stroke-width: 3;" /> ///ADD AN END HTML COMMENT HERE
            <text x="10"  y="30" class="svg1">My
                <tspan x="10" y="60" class="svg1">SocialArea</tspan>
                <tspan x="100" y="90" class="svg1">.com</tspan>
            </text>
        </svg>
        -->
        </a>
        <!--<h1>MySocialArea<br />.com</h1>-->
	<?php
    }
}

?>