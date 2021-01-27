<?php
namespace Magenticians\Ajaxmodule\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
 
class Customproduct implements ObserverInterface
{
	public function execute(\Magento\Framework\Event\Observer $observer) {
		
    	$item = $observer->getEvent()->getData('quote_item');
    	$item = ( $item->getParentItem() ? $item->getParentItem() : $item );
		
		
		$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
		$logger = new \Zend\Log\Logger();
		$logger->addWriter($writer);
		$logger->info('function called');
		
		
		/*
		$options = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());

    	$price = 100; //set your price here
    	$item->setCustomPrice($price);
        $item->setOriginalCustomPrice($price);
        $item->getProduct()->setIsSuperMode(true);
		*/
		
		$om =   \Magento\Framework\App\ObjectManager::getInstance();
		$cartData = $om->create('Magento\Checkout\Model\Cart')->getQuote()->getAllVisibleItems();

		
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$customOptions = $objectManager->get('Magento\Catalog\Model\Product\Option')->getProductOptionCollection($item->getProduct());
		
		
		$cart = $objectManager->get(
										'Magento\Checkout\Model\Cart'
									);
									$productRepo = $objectManager->get(
										'Magento\Catalog\Model\ProductRepository'
									);
		
		$sku=$item->getSku();
		$exp_sku=explode("-",$sku);
		if(count($exp_sku)>0 && count($customOptions)>0)
		{
			foreach($exp_sku as $val)
			{
				if(strstr($val,'TSBP'))
				{
					$main_sku=$val;
					$productId = $objectManager->get('Magento\Catalog\Model\Product')->getIdBySku($main_sku);
					
						$isProductInCart=true;
							$logger->info('function called true');
							foreach($cartData as $_item) {
							if($_item->getProductId() == $productId){
								$isProductInCart = false;
								$logger->info('function called false');
							}
						}
					
					
					if($isProductInCart)
					{
						
									$productData = [];
									$productData['qty'] = 1; // input  here for quantity of product, for. e.g : 5
									$productData['product'] = $productId; // input product id here, for e.g : 1

									$_product = $productRepo->getById($productId);
									if ($_product) {
										$cart->addProduct($_product, $productData); // adds product in cart using cart model
									}
									$cart->save();
									$cart->getQuote()->setTotalsCollectedFlag(false)->collectTotals();
									$cart->getQuote()->save();
						$logger->info('add cart');

			
					}else
					{
						$productAdded = $productRepo->getById($productId);
						$item= $cart->getQuote()->getItemByProduct($productAdded);
									$item_id= $item->getItemId();
						            if($item_id)
									{
									$qty = $item->getQty();

									$params[$item_id]['qty'] = $qty+1;
									$params = array(
										'product' => $productId,
										'qty'     =>  $qty+1,
									);
									$cart->getQuote()->updateItem($item_id,$params);
										
										$logger->info('edit cart');
									}
						
						
						
						
					}
					
				}
			}
		
		}
		
		
		
               

        
	}
 
}