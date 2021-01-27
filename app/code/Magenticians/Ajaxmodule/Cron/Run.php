<?php
namespace Magenticians\Ajaxmodule\Cron;

use \Psr\Log\LoggerInterface;
use Magento\Sales\Model\Order;



class Run {

  private $logger;

  public function __construct(LoggerInterface $logger) {

    $this->logger = $logger;

  }

  /**

    * Write to system.log

    *

    * @return void

  */

  public function execute() {

	$this->logger->debug('TEST1 CRON ID');  
	
	 // $file = 'var/tmp/data.csv';

	
	  
	  
	  
 /*  
	try{

	   foreach($orderIds as $ids) {
		 
		   $thi$orderId = 1;
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$order = $objectManager->create('\Magento\Sales\Model\Order') ->load($orderId);
$orderState = Order::STATE_PROCESSING;
$order->setState($orderState)->setStatus(Order::STATE_PROCESSING);
$order->save();


s->logger->debug('TEST1 CRON ID'.$ids);  
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$order = $objectManager->create('\Magento\Sales\Model\Order') ->load($ids);
		   
		   
    		$order->setState(\Magento\Sales\Model\Order::STATE_PROCESSING, true)->save();
    		$order->setStatus(\Magento\Sales\Model\Order::STATE_PROCESSING, true)->save();
    		$order->addStatusToHistory($order->getStatus(), 'Order processed successfully with reference again and again');
			
		   
		    $this->logger->debug('TEST1 CRON ID'.$ids);  
    	   
	   } 
		  $this->logger->debug('TEST2 CRON ID');  
	} catch (NoSuchEntityException $ex) {
            echo "error";
		  $this->logger->debug('ERROR TEST CRON ID');  
        }
	   exit;
	   
	   */
	
  }

}