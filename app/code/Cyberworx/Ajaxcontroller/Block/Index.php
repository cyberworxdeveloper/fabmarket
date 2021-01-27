<?php
namespace Cyberworx\Ajaxcontroller\Block;
class Index extends \Magento\Framework\View\Element\Template
{
protected $_resourceFactory;
	protected $_imageHelper;
	protected $_cartHelper;
	protected $product;	
	protected $customer;	
	protected $wishlist;
	protected $_recentlyViewed;
	protected $_registry;
	public function __construct(
    	\Magento\Catalog\Block\Product\Context $context,
    	\Magento\Reports\Model\ResourceModel\Report\Collection\Factory $resourceFactory,
		\Magento\Customer\Model\Session $customer,
    	\Magento\Catalog\Model\Product $product,
		\Magento\Wishlist\Model\Wishlist $wishlist,		
		\Magento\Framework\Registry $registry,
    	array $data = []
	) {
    	$this->_resourceFactory = $resourceFactory;
    	$this->product = $product;
    	$this->_imageHelper = $context->getImageHelper();
    	$this->_cartHelper = $context->getCartHelper();
		$this->customer = $customer;	
		$this->wishlist = $wishlist;		
		$this->_registry = $registry;
    	parent::__construct($context, $data);
	}
	public function checkLoginuser(){			
		return $customerId = $this->customer->getId();
	}	
	/*public function getWishliturl($product)
	{
		return '<a href="'.$block->getUrl("wishlist", ["_secure" => true]).'" img src="'.$block->getViewFileUrl("images/wish_icon.jpg").'" data-post="'.$this->helper("Magento\Wishlist\Helper\Data")->getAddParams($product).'" class="action towishlist" data-action="add-to-wishlist"><span>Add to Wish List</span></a>';
	}*/
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