<?php
namespace Cyberworx\CustomerAccount\Controller\Checkwishlist;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\App\Action\Action
{
protected $resultPageFactory;

protected $session;

public function __construct(
    \Magento\Framework\App\Action\Context $context,
    \Magento\Customer\Model\Session $customerSession,
    PageFactory $resultPageFactory
    )
{
    $this->session = $customerSession;
    parent::__construct($context);
    $this->resultPageFactory = $resultPageFactory;
}
public function execute()
{
    if (!$this->session->isLoggedIn())
    {
       
echo $idsss =  $session->getCustomerID();
    }
    
    
    
}

}

