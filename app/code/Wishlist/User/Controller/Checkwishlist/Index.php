<?php
namespace Wishlist\User\Controller\Checkwishlist;
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
    if ($this->session->isLoggedIn())
    {
       
 $idsss = $this->session->getCustomerID();

 $in_wishlist = 0;
 $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $wishlist            = $objectManager->get('\Magento\Wishlist\Model\Wishlist');
    $wishlistCollection = $wishlist->loadByCustomerId($idsss, true)->getItemCollection(); 
    $wishlistvalue=array();
foreach ($wishlistCollection as $_wishlist_item) {
  
  echo $wishlistvalue=$_wishlist_item->getProduct()->getId();
  echo',';

}




    }
    
    
}

}

