<?php
namespace Cyberworx\Ajaxcontroller\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $_productRepositoryFactory;
	protected $_sampleCollectionFactory; 
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Catalog\Api\ProductRepositoryInterfaceFactory $productRepositoryFactory,
		\Magento\Downloadable\Model\ResourceModel\Sample\CollectionFactory $sampleCollectionFactory,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->_pageFactory = $pageFactory;
		$this->_productRepositoryFactory = $productRepositoryFactory;
		$this->_sampleCollectionFactory = $sampleCollectionFactory;	
		return parent::__construct($context);
	}

	public function execute()
	{
		$val=$this->getRequest()->getParam('customdata1');
		$val=rtrim($val, ",");
		$exparr=explode(",",$val);		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();		
		$html="";
		$fullhtml="";
		foreach($exparr as $pid)
		{		
			$product = $objectManager->create('Magento\Catalog\Model\Product')->load($pid);	
			//print_r("===".$product->getTags());
			$pvisibility=$product->getVisibility();
			$pname=$product->getName();	
			if($product->getName()!="" && $pvisibility==4)
			{
				 $collection = $this->_sampleCollectionFactory->create();
				 $collection->addProductToFilter($pid);
				 $audiourl="";
				 foreach($collection as $row)
				 {	
						$audiourl=$row->getData('sample_url');
						
				 }			
				
				if($product->getSpecialPrice()>0)
				{
					$pprice= number_format($product->getSpecialPrice(),2);
				}else
				{
					$pprice= number_format($product->getPrice(),2);
				}
				/*$getBlock = $this->getLayout()->createBlock("Cyberworx\Ajaxcontroller\Block\Index");
				echo $getBlock->getWishliturl($product);
				die("hi");*/
				//$pprice=$product->getPrice();
				$pimage = $this->_productRepositoryFactory->create()->getById($pid);
				$image_url=$pimage->getData('image');
				
				$path=$objectManager->get('Magento\Store\Model\StoreManagerInterface')
						->getStore()
						->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
				
					//$html.='<div class="item"><h4><a href="/'.$product->getUrlKey().'"><img src="'.$path.'catalog/product/'.$image_url.'"/><p>'.$pname.'</p></a><p>'.$pprice.'</p></h4></div>';
					$html.='<div class="item"><h4><a href="/'.$product->getUrlKey().'"><img src="'.$path.'catalog/product/'.$image_url.'"/><p>'.$pname.'</p></a>';				
					$html.='<p>'.$audiourl.'</p>';					
					$html.='<p>$'.$pprice.'</p></h4></div>';
			?>			
			<?php
			}
		}
		$fullhtml="<div class='owl-carousel owl-theme'>".$html."</div><script>
require(['jquery','owlcarousel'], function($){
$('.owl-carousel').owlCarousel({ loop:true, margin:10, nav:true, responsive:{ 0:{ items:1 }, 600:{ items:3 }, 1000:{ items:5 } } }) ;  
}); 
</script>";
   
		echo $fullhtml;
		
		//return $this->_pageFactory->create();
	}
}