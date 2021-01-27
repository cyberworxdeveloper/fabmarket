<?php
namespace Magenticians\Ajaxmodule\Block;
class Ajaxmodule extends \Magento\Framework\View\Element\Template
{
public function __construct(
\Magento\Backend\Block\Template\Context $context,
array $data = []
)
{
parent::__construct($context, $data);
}
public function getAjaxmodule()
{
	
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$customerSession = $objectManager->get('Magento\Customer\Model\Session');
if($customerSession->isLoggedIn()) {
	
	echo "login";
   // customer login action
}else
{
	echo "not login";
}
	
	
	
return 'Module Created Successfully';
}
}
?>