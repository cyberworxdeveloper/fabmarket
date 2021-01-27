<?php
namespace Cyberworx\Newshows\Block;
class Index extends \Magento\Framework\View\Element\Template
{   
	protected $_productCollectionFactory;
     protected $_sampleCollectionFactory;   
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,        
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory, 
		\Magento\Downloadable\Model\ResourceModel\Sample\CollectionFactory $sampleCollectionFactory,	
        array $data = []
    )
    {    
        $this->_productCollectionFactory = $productCollectionFactory;    
		$this->_sampleCollectionFactory = $sampleCollectionFactory;
        parent::__construct($context, $data);
    }
    
    public function getProductCollection()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
		$collection->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH);
		$collection->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED); 
		$collection->setOrder('entity_id','DESC');
		$collection->setPageSize(10)->load();		
        return $collection;
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

}