<?php
/**
 *
 * Copyright © 2015 Fabmarketcommerce. All rights reserved.
 */
namespace Fabmarket\Subscribedetails\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{

	/**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected $_cacheTypeList;

    /**
     * @var \Magento\Framework\App\Cache\StateInterface
     */
    protected $_cacheState;

    /**
     * @var \Magento\Framework\App\Cache\Frontend\Pool
     */
    protected $_cacheFrontendPool;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\App\Cache\StateInterface $cacheState
     * @param \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\StateInterface $cacheState,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheState = $cacheState;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->resultPageFactory = $resultPageFactory;
    }
	
    /**
     * Flush cache storage
     *
     */
    public function execute()
    {


                      $quoteid="";
		$produt_id=$_POST['product_id'];
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$tableName = $resource->getTableName('mg_subscribedetails_index'); 

		$cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 
		 
		// retrieve quote items collection
		$quoteid = $cart->getQuote()->getEntityId();
		if($quoteid!="")
		{
			$sql = "SELECT * FROM " . $tableName ." where quoteid=".$quoteid." and produtid=".$produt_id;
			
			$result = $connection->fetchAll($sql); 			
			if(count($result)>0)
			{

				echo "yes";
			}
			else
			{
			   echo "no";
			}
			
		}
		else
		{
		   echo "no";
		}
		exit;
        
    }
}
