<?php
namespace Cyberworx\Popularshow\Block;
class Index extends \Magento\Framework\View\Element\Template
{    
	protected $_resourceFactory;
	protected $_imageHelper;
	protected $_cartHelper;
	protected $product;	
	protected $customer;	
	protected $wishlist;
	protected $_sampleCollectionFactory;
	protected $_registry;
	public function __construct(
    	\Magento\Catalog\Block\Product\Context $context,
    	\Magento\Reports\Model\ResourceModel\Report\Collection\Factory $resourceFactory,
		\Magento\Customer\Model\Session $customer,
    	\Magento\Catalog\Model\Product $product,
		\Magento\Wishlist\Model\Wishlist $wishlist,
		\Magento\Downloadable\Model\ResourceModel\Sample\CollectionFactory $sampleCollectionFactory,
		\Magento\Framework\Registry $registry,
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
	 
	/*public function getProductPriceHtml(
    	\Magento\Catalog\Model\Product $product,
    	$priceType = null,
    	$renderZone = \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST,
    	array $arguments = []
	) {
    	if (!isset($arguments['zone'])) {
        	$arguments['zone'] = $renderZone;
    	}
    	$arguments['zone'] = isset($arguments['zone'])
        	? $arguments['zone']
        	: $renderZone;
    	$arguments['price_id'] = isset($arguments['price_id'])
        	? $arguments['price_id']
        	: 'old-price-' . $product->getId() . '-' . $priceType;
    	$arguments['include_container'] = isset($arguments['include_container'])
        	? $arguments['include_container']
        	: true;
    	$arguments['display_minimal_price'] = isset($arguments['display_minimal_price'])
        	? $arguments['display_minimal_price']
        	: true;
 
    	$priceRender = $this->getLayout()->getBlock('product.price.render.default');
 
    	$price = '';
    	if ($priceRender) {
        	$price = $priceRender->render(
            	\Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE,
            	$product,
            	$arguments
        	);
    	}
    	return $price;
	}*/
   /* protected $_bestSellersCollectionFactory;
    protected $_productCollectionFactory;
   
    public function __construct(
         \Magento\Backend\Block\Template\Context $context,        
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
		\Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory $bestSellersCollectionFactory,	
        array $data = []
    ) {
        $this->_bestSellersCollectionFactory = $bestSellersCollectionFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }
   
    public function getProductCollection()
    {
		
        $productIds = [];
        $bestSellers = $this->_bestSellersCollectionFactory->create()->setPeriod('year');
        foreach ($bestSellers as $product) {
            $productIds[] = $product->getProductId();
        }
		print_r($productIds);
        $collection = $this->_productCollectionFactory->create()->addIdFilter($productIds);
        $collection->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addAttributeToSelect('*')			
            ->addStoreFilter($this->getStoreId())->setPageSize(6);
			echo "<pre>";
		foreach ($collection as $_product) {
		print_r($_product->getData());
		
		}
		die("working");
       // return $collection;
    }*/
}