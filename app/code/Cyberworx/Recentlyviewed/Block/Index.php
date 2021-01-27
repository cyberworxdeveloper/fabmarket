<?php
namespace Cyberworx\Recentlyviewed\Block;
class Index extends \Magento\Framework\View\Element\Template
{
	protected $_productRepositoryFactory;
	protected $_imageHelper;
	protected $customer;	
	protected $_sampleCollectionFactory;
	public function __construct(
    	\Magento\Catalog\Block\Product\Context $context,
    	\Magento\Catalog\Api\ProductRepositoryInterfaceFactory $productRepositoryFactory,
		\Magento\Customer\Model\Session $customer,
		\Magento\Downloadable\Model\ResourceModel\Sample\CollectionFactory $sampleCollectionFactory,
    	array $data = []
	) {
    	$this->_productRepositoryFactory = $productRepositoryFactory;
		$this->_imageHelper = $context->getImageHelper();
		$this->customer = $customer;
		$this->_sampleCollectionFactory = $sampleCollectionFactory;
    	parent::__construct($context, $data);
	}
	public function checkLoginuser(){			
		return $customerId = $this->customer->getId();
	}
	public function getSampleCollection($productId){
		//echo $productId;
		 $i=0;
		 $collection = $this->_sampleCollectionFactory->create();
		 $collection->addProductToFilter($productId);
		 $mediaUrl="";
		 foreach($collection as $row)
		 {	
				$mediaUrl=$row->getData('sample_url');
				
		 }
			return	 $mediaUrl;
		
    }
	public function getImage($pid){			
		$pimage = $this->_productRepositoryFactory->create()->getById($pid);
		return $image_url=$pimage->getData('image');		
	}
	public function imageHelperObj(){
    	return $this->_imageHelper;
	}
}