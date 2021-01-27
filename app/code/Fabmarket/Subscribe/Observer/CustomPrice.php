<?php	
	namespace Fabmarket\Subscribe\Observer;

	use Magento\Framework\Event\ObserverInterface;
	use Magento\Framework\App\RequestInterface;

	class CustomPrice implements ObserverInterface
	{
		public function execute(\Magento\Framework\Event\Observer $observer) {
			//print_r($this->getRequest()->getPost());		
			/*$item = $observer->getQuoteItem();
			$quote = $item->getQuote();

			echo $item->getQuoteId();
			die("hi");*/
			$item = $observer->getEvent()->getData('quote_item');		
			$item = ( $item->getParentItem() ? $item->getParentItem() : $item );
			//print_r($item->getProductId());
			$product_id=$item->getProductId();
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$produt=$objectManager->get('Magento\Catalog\Model\Product')->load($product_id);
			if(isset($_POST["subscribe"]) && $_POST["subscribe"]=="one_month")
			{
				$price=$produt->getData('one_month');
				$item->setCustomPrice($price);
				$item->setOriginalCustomPrice($price);
				$item->getProduct()->setIsSuperMode(true);
			}
			else if(isset($_POST["subscribe"]) && $_POST["subscribe"]=="three_month")
			{
				$price=$produt->getData('three_month');
				$item->setCustomPrice($price);
				$item->setOriginalCustomPrice($price);
				$item->getProduct()->setIsSuperMode(true);
			}
			else if(isset($_POST["subscribe"]) && $_POST["subscribe"]=="five_month")
			{
				$price=$produt->getData('five_month');
				$item->setCustomPrice($price);
				$item->setOriginalCustomPrice($price);
				$item->getProduct()->setIsSuperMode(true);
			}
			else
			{
				/*$price=$produt->getData('price');
				$item->setCustomPrice($price);
				$item->setOriginalCustomPrice($price);
				$item->getProduct()->setIsSuperMode(true);*/
			}
			//print_r($_POST["subscribe"]);
			
			//die("hi");
			//print_r($produt->getData('one_month'));
			/*if($produt->getData('one_month')!="")
			{
				$price = 150; //set your price here
				
			}*/
						
		}

	}