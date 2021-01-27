<?php
namespace Cyberworx\CustommailOrder\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->_pageFactory = $pageFactory;
		return parent::__construct($context);
	}

	public function execute()
	{			
			//$dataval=$this->getRequest()->getParams('a');
			//print_r($dataval);
			
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			
			$customerSession = $objectManager->get('Magento\Customer\Model\Session');		
			$customerData = $customerSession->getCustomer()->getData();		
			$cid="";		
			if(count($customerData)>0)
			{
				//echo "==>".$billingAddressId=$customerData['default_shipping'];
				$billingAddressId=$customerData['default_billing'];
				$customerId = $customerSession->getCustomer()->getId();
				// $customer = $this->customerRepository->getById($customerId);
				// echo "===>".$billingAddressId = $customer->getDefaultBilling();
				 //$shippingAddressId = $customer->getDefaultShipping();
				 //$addressRepository=$om->get('\Magento\Customer\Api\AddressRepositoryInterface');
				 $address = $objectManager->create('Magento\Customer\Model\Address')->load($billingAddressId);
				 $cid=$address->getData('country_id');
				//echo "<pre>";print_r($address->getData());
			}
			
			$cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 						 
			$subTotal = $cart->getQuote()->getSubtotal();
			$grandTotal = $cart->getQuote()->getGrandTotal();
			//die("hi");
			$getBillingAddress = $cart->getQuote()->getBillingAddress();
			$country_id=$getBillingAddress->getCountryId();
			if($country_id=="")
			{
				$country_id=$cid;
			}
			//echo '<pre>'; print_r($getBillingAddress->getData()); echo '</pre>';
			//$taxamount=$shippingAddress->getShippingAddress()->getBaseTaxAmount();
			//$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$taxClassObj = $objectManager->create('\Magento\Tax\Model\Calculation\Rate');
			$taxRates = $taxClassObj->getCollection()->getData();
			$taxArray = array();
			foreach ($taxRates as $tax) {
				//echo $taxRateId = $tax['tax_calculation_rate_id'];
				if($tax["code"]=="S-*-*Rate3")
				{
					$taxrate=$tax["rate"];
				}
			}
			$layout = $this->_view->getLayout();
			$block = $layout->createBlock('Magento\Checkout\Block\Cart\Totals');
			$quote = $block->getQuote();
			$discount=0;
			foreach($quote->getAllVisibleItems() as $_item) {
			 $discount +=$_item->getDiscountAmount();
			}
			if(strtolower($country_id)=="sg")
			{
				if($discount!=0)
				{
					$taxsubtotalcl=$subTotal-$discount;
					$tax_amount=($taxsubtotalcl*$taxrate)/100;
				}
				else
				{
					$tax_amount=($subTotal*$taxrate)/100;
				}
			}
			else
			{
				$tax_amount=0.0;
				//$grandTotal=$subTotal;
			}
			$tax_amount=number_format($tax_amount,2);
			$discount=number_format($discount,2);
			$subTotal=number_format($subTotal,2);
			$grandTotal=number_format($grandTotal,2);
		//echo "Discount: ".$discount."<p>Sub Total: ".$subTotal."</p>"."<p>Tax Amount: ".$tax_amount."</p>"."<p>Grand Total: ".$grandTotal."</p>";//return $this->_pageFactory->create();
		echo '<div><table class="product_checkout_total_detail">
	<tr>
		<th>Subtotal</th>
		<td>$'.$subTotal.'</td>
	</tr>
	<tr>
		<th>Promocode</th>
		<td>-$'.$discount.'</td>
	</tr>
	<tr>
		<th>Tax</th>
		<td class="red show_tax_detail">$'.$tax_amount.'</td>
	</tr>
	<tr>
		<th>Order Total Incl. Tax</th>
		<td>$'.$grandTotal.'</td>
	</tr>
</table></div>';//return $this->_pageFactory->create();
		
	}
}
?>
