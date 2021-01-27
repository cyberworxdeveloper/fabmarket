<?php
namespace Fabmarket\Sidebarremoveitem\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
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
		$itemid=$_GET['itemid'];
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$checkoutSession = $objectManager->get('Magento\Checkout\Model\Session');
		$allItems = $checkoutSession->getQuote()->getAllVisibleItems();
		$cart =  $objectManager->get('Magento\Checkout\Model\Cart');

		if(count($allItems) > 0){
			foreach ($allItems as $item) {			
				$cart->removeItem($itemid)->save();
			}
		}
		
		$cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 
		$subTotal = $cart->getQuote()->getSubtotal();
		$totalQuantity = $cart->getQuote()->getItemsQty();
		$qtyprice= round($subTotal,2)."-".round($totalQuantity);
		$items = $cart->getQuote()->getAllItems();
		$sidebaritem=array();
		foreach($items as $item) {			
			$_imagehelper = $objectManager->get('\Magento\Catalog\Helper\Image');
			$product = $item->getProduct();
			$img = $_imagehelper->init($product,'category_page_list',array('height' => '100' , 'width'=> '100'))->getUrl();
			$pid=$item->getProductId();
			$itemname=$item->getName();
			$sku=$item->getSku();
			$qty=$item->getQty();
			$price=$item->getPrice();					
			$sidebaritem[]=[
				'img' => $img, 
				'pid' => $pid, 
				'itemid' =>$item->getItemId(),
				'itemname' => $itemname, 
				'sku' => $sku, 
				'qty' => $qty, 
				'price' => number_format($price,2)
			];
		}
		$arr=array(
			'sidebaritem' => $sidebaritem,
			'minicartUpdate' => array('updatedData' => $qtyprice),
			'subtotal'	=> array('subtotal' => number_format($subTotal,2))
 		);		
		$data = json_encode($arr);
		echo $data;
		exit;
		//return $this->_pageFactory->create();
	}
}