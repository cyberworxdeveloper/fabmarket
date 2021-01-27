<?php
 namespace Magenticians\Ajaxmodule\Observer;
 
use Magento\Framework\ObjectManager\ObjectManager;
 
class OrderBefore implements \Magento\Framework\Event\ObserverInterface {
 
    /** @var \Magento\Framework\Logger\Monolog */
    protected $_logger;
    
    /**
     * @var \Magento\Framework\ObjectManager\ObjectManager
     */
    protected $_objectManager;
    
    protected $_orderFactory;    
    protected $_checkoutSession;
    
    public function __construct(        
        \Psr\Log\LoggerInterface $loggerInterface,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Framework\ObjectManager\ObjectManager $objectManager,
		\Magento\Framework\Message\ManagerInterface $messageManager

    ) {
        $this->_logger = $loggerInterface;
        $this->_objectManager = $objectManager;        
        $this->_orderFactory = $orderFactory;
        $this->_checkoutSession = $checkoutSession; 
	    $this->messageManager = $messageManager;

    }
 
    /**
     * This is the method that fires when the event runs.
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer ) { 
		
		
		
    }
}