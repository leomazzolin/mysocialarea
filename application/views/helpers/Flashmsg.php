<?php
class Zend_View_Helper_Flashmsg extends Zend_View_Helper_Abstract
{
    public function Flashmsg ()
    {
		$flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
		$output = array();
		 if ($flashMessenger->setNamespace('notice')->hasMessages() ||
		 		$flashMessenger->setNamespace('success')->hasMessages()||
				$flashMessenger->setNamespace('error')->hasMessages() ||
				$flashMessenger->setNamespace('instructions')->hasMessages())
		{
			$output['namespace'] = $flashMessenger->getNamespace();
			foreach ($flashMessenger->getMessages() as $msg)
			{
				$output['msgs'][] = $msg;
			}
			return Zend_Json::encode($output);
		}
		else
		{
			return NULL;
		}
    }
}
?>