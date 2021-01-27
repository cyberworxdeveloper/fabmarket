<?php
namespace Magecheckout\Customminicart\Controller\Index;

class Minisidebar extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->_pageFactory = $pageFactory;
		return parent::__construct($context);
	}

	public function execute()
	{
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 
		 $subTotal = $cart->getQuote()->getSubtotal();
		$totalQuantity = $cart->getQuote()->getItemsQty();
		
		$items = $cart->getQuote()->getAllItems();
		foreach($items as $item) {
			//print_r($item->getImage());
			echo 'ID: '.$item->getProductId().'<br />';
			echo 'Name: '.$item->getName().'<br />';
			echo 'Sku: '.$item->getSku().'<br />';
			echo 'Quantity: '.$item->getQty().'<br />';
			echo 'Price: '.$item->getPrice().'<br />';
			echo "<br />";         
		}
		die("present sir!");
	}
}