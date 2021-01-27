<?php
namespace Cyberworx\Rshow\Block;
class Index extends \Magento\Framework\View\Element\Template
{
	protected $_resourceFactory;
	protected $_imageHelper;
	protected $_cartHelper;
	protected $product;	
	protected $customer;	
	protected $wishlist;
	protected $_recentlyViewed;
	protected $_sampleCollectionFactory; 
	protected $_registry;
	public function __construct(
    	\Magento\Catalog\Block\Product\Context $context,
    	\Magento\Reports\Model\ResourceModel\Report\Collection\Factory $resourceFactory,
		\Magento\Customer\Model\Session $customer,
    	\Magento\Catalog\Model\Product $product,
		\Magento\Wishlist\Model\Wishlist $wishlist,	
		\Magento\Downloadable\Model\ResourceModel\Sample\CollectionFactory $sampleCollectionFactory,	\Magento\Framework\Registry $registry,
    	array $data = []
	) {
    	$this->_resourceFactory = $resourceFactory;
    	$this->product = $product;
    	$this->_imageHelper = $context->getImageHelper();
    	$this->_cartHelper = $context->getCartHelper();
		$this->customer = $customer;	
		$this->wishlist = $wishlist;	
		$this->_sampleCollectionFactory = $sampleCollectionFactory;		
		$this->_registry = $registry;
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
	public function checkWishlistitem($customer_id)
	{
		$wishlist_collection = $this->wishlist->loadByCustomerId($customer_id, true)->getItemCollection();		
		$pid=[];		
		foreach ($wishlist_collection as $item) {
			 $pid[]=$item->getProduct()->getId();			
		}
		return $pid;
	}
	public function imageHelperObj(){
    	return $this->_imageHelper;
	}
	public function getProduct($id){
     	return $this->product->load($id);
	}
	/**
 	To get featured product collection
 	*/
	public function getBestsellerProduct(){
		$resourceCollection = $this->_resourceFactory->create('Magento\Sales\Model\ResourceModel\Report\Bestsellers\Collection');
		$resourceCollection->setPageSize(10);
		return $resourceCollection;
	}
   
	public function getAddToCartUrl($product, $additional = [])
	{
		return $this->_cartHelper->getAddUrl($product, $additional);
	}
}