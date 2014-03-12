<?php
class Zend_View_Helper_Content_Home_Welcome1 extends Zend_View_Helper_Abstract
{
    public function Content_Home_Welcome1($key)
    {
		$output = array();
		
		$output['welcome'] =
			'
			<h3>
			This website is in its infancy with new modules to be constantly added to in the near future.</h3>
			</h3>
			<br />
			<h3>
			MySocialArea.com content is designed to be fun and light hearted with the ability to share and discuss with your social media friends 
			such as Facebook and Twitter although you do not need an account for either.
			</h3>
			<br />
			<h3>
			MySocialArea.com content also evolves to individual user preferences by accepting user suggestions. 
			</h3>
			<br />
			<h3>
			To find out more about what we mean please read about the 1st module that we made (Opinion Polls) on the next panel below or go right to 
			the module now.
			</h3>
			<br />
        	<a class="menu-item" href="/op/index/index">Go to Opinion Polls</a>
			';
		$output['op'] =
			'
			<p>
			This is MySocialArea.com&acute;s 1st module to be created.
			</p>
			<p>
			The opinion polls available can be from any subject. 
			However, if you believe that we left out a choice from a certain poll or if you would like us to create 
			a new opinion poll on a certain subject that you and your friends may like to vote on then you may tell us about it. 
			</p>
			<p>
			Once you have selected an opinion poll you can do the following:
			<ul>
				<li>select your choice and save it</li>
				<li>view the current statistics for the selected poll</li>
				<li>discuss the poll results with your social media friends if you wish to (Facebook functionality is only available right now).</li>
			</ul>
			</p>
			<br />
        	<a class="menu-item" href="/op/index/index">Go to Opinion Polls</a>
			';
		$output['mlse'] =
			'
			<p>
			By now it should be painfully obvious to everyone that anything Maple Leaf Sports Entertainment (MLSE) touches turns to s**t.
			</p>
			<p>
			So if for some reason you are still a fan of any of the teams that MLSE owns and you believe to be a victim of MLAS&apos;s  
			mismanaging of it&apos;s sports teams (which should be considered a criminal act) then  
			this is the spot to make a victim impact statement.
			</p>
			<br />
        	<a class="menu-item" href="/default/mlse/index">Go to MLSE Sucks</a>
			';
		$output['pss'] =
			'
			<p>
			Family pets have become beloved and equal members of many families. 
			Now you have the opportunity to celebrate your pet with their very own presence on the web. 			
			</p>
        	<p>Go to <a class="menu-item" href="/default/pss/index">PET SOCIAL SPACE</a> now to find out more.</p>
			';
		return $output[$key];
    }
}

?>