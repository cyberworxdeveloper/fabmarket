<?php
namespace Fabmarket\Episode\Controller\Index;
class Index extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $session;
	public function __construct(		
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{		
		$this->_pageFactory = $pageFactory;
		return parent::__construct($context);
	}

	public function execute()
	{
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();		
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$tableName = $resource->getTableName('mg_subscribedetails_index');
		
		//$sql = "SELECT * FROM " . $tableName." where customerid=". $customerId . " AND flag='2'";
		$sql = "SELECT * FROM " . $tableName." where flag='2'";
		$result = $connection->fetchAll($sql); 

		$sendmail=array();
		require("class.phpmailer.php");	
		$mail = new \PHPMailer();
		$mail->IsSMTP();
		//$mail->SMTPDebug  = 0;
		$mail->Host = "email-smtp.ap-south-1.amazonaws.com";
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "tls";
		$mail->Port = 587;
		//$mail->Username = "AKIAZY5TDMSGTPV6N6F7";
		$mail->Username = "AKIAYR726V2PKXQ2F2RG";
		//$mail->Password = "BDW0aGpcUlRknJBHOi7f/YUaUgF1WtcBsRjwI2GcNYfl";
		$mail->Password = "BA24yFRPPSkLBSDxAGh0ZO8vOfffLsvG0cXmOTrYw2lh";
		$mail->From = "support@fabmarket.in";
		$mail->FromName = "Cyberworx";	
		//echo "<pre>";
		//print_r($result);
		//die("hi");
		foreach($result as $row)
		{
			//echo "<pre>";
			
			$produtid=$row['produtid'];
			$noofepisode=$row['noofepisode'];
			$customerid=$row['customerid'];
			$todaydate = date('Y-m-d');
			
			$currentday= date("l");
			$nextepisodedate="";
			$frequency=$row['frequency'];
			if($frequency=="daily")
			{
				$nextepisodedate=$row['nextepisodedate'];
			}			
			if($frequency=="monthly")
			{
				$nextepisodedate=$row['frequency_date'];
			}
			$newDatearr=explode(" ",$nextepisodedate);
			$newDate = $newDatearr[0]; 
			$subscription_end_date=$row['subscription_end_date'];
			if($todaydate<=$subscription_end_date)
			{			
			//echo $todaydate;
			//echo "==".$subscription_end_date;
			//echo "==".$newDate;
			//echo $frequency;
			if($frequency=="weekly")
			{
				//echo strtolower($currentday);
				//echo "==>".strtolower($row['frequency_day'])."<br/>";
				
				if(strtolower($currentday)==strtolower($row['frequency_day']))	
				{
					//echo $currentday;
					//die("hii");
					$customerFactory = $objectManager->get('\Magento\Customer\Model\CustomerFactory')->create();
					$customer = $customerFactory->load($customerid); 
					$cusotmeremail=$customer->getEmail();		
					
					$product = $objectManager->get('\Magento\Catalog\Model\Product')->load($produtid);
					$customOptions = $objectManager->get('Magento\Catalog\Model\Product\Option')->getProductOptionCollection($product);
					$total_bite=0;
					$nextdate="";
					$i=1;
					$skuarray=array();
					foreach($customOptions as $opt)
					{
						$total_bite=count($opt->getValues());				
						foreach($opt->getValues() as $value) {
							$val=$value->getData('sku');
							$skuarray[$i]=$val;	
							$i++;
						}
						//$skuarray[$i]=$val;
						//$i++;
						//echo "<pre>";
						//print_r($opt->getData());
						//print_r("SKU:=>".$opt->getSku());
						
					}
					if($total_bite>$noofepisode)
					{
						date_default_timezone_set('Asia/Kolkata');
						$date = $row['nextepisodedate'];
						$nextdate = strtotime(date("Y-m-d", strtotime($date)) . " +1 week");
						if($nextdate!="")
						{
							$newshowdate=date("Y-m-d",$nextdate);
							
						}						
						else
						{
							$newshowdate=$row['nextepisodedate'];							
						}
						
						//$sendmail[]=$cusotmeremail;
						$nextsku=$skuarray[$noofepisode+1];
						$upepisode=$noofepisode+1;
						
							$sqlupdate = "UPDATE mg_subscribedetails_index SET noofepisode = '".$upepisode."',nextepisodedate='".$newshowdate."' WHERE quoteid = " . $row['quoteid']." AND flag='2' AND itemid=".$row['itemid'];						
							
						$connection->query($sqlupdate);
						$productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
						$productObj = $productRepository->get($nextsku);
						//echo $productObj->getId();
						//echo $productObj->getName();
						//print_r($productObj->getProductUrl());
						$ProductUrl=$productObj->getProductUrl();
						$pname=$productObj->getName();
						$pid=$productObj->getId();
			$html="<p>Product Id:".$pid."</p><p>Product Url:".$ProductUrl."</p><p>Product Name:".$pname."</p>";
						//$sendmail=[$cusotmeremail];
						//$this->sendepisodemail($sendmail,$html);
						$mail->AddAddress($cusotmeremail);
						$mail->AddReplyTo($cusotmeremail);
						$mail->IsHTML(true);
						$mail->Subject = "New Episode";
						$mail->Body = $html;
						$mail->Send();
					}
					else
					{
						date_default_timezone_set('Asia/Kolkata');
						$date = $row['nextepisodedate'];
						$nextdate = strtotime(date("Y-m-d", strtotime($date)) . " +1 week");
						if($nextdate!="")
						{
							$newshowdate=date("Y-m-d",$nextdate);
							
						}
						
							$sqlupdate = "UPDATE mg_subscribedetails_index SET nextepisodedate='".$newshowdate."' WHERE quoteid = " . $row['quoteid']." AND flag='2' AND itemid=".$row['itemid'];
												
						$connection->query($sqlupdate);
					
					}
				}
				//$nextepisodedate=$row['nextepisodedate'];
			}
			
		else{
			if($todaydate==$newDate && $row['frequency']!=1)
			{			//die("hi");
				$customerFactory = $objectManager->get('\Magento\Customer\Model\CustomerFactory')->create();
				$customer = $customerFactory->load($customerid); 
				$cusotmeremail=$customer->getEmail();		
				
				$product = $objectManager->get('\Magento\Catalog\Model\Product')->load($produtid);
				$customOptions = $objectManager->get('Magento\Catalog\Model\Product\Option')->getProductOptionCollection($product);
				$total_bite=0;
				$nextdate="";
				$i=1;
				$skuarray=array();
				
				foreach($customOptions as $opt)
				{
					$total_bite=count($opt->getValues());				
					foreach($opt->getValues() as $value) {
						$val=$value->getData('sku');
						$skuarray[$i]=$val;	
						$i++;
					}
					//$skuarray[$i]=$val;
					//$i++;
					//echo "<pre>";
					//print_r($opt->getData());
					//print_r("SKU:=>".$opt->getSku());
					
				}
								
				if($total_bite>$noofepisode)
				{					
					/*if($todaydate>$newDate)
					{*/
						date_default_timezone_set('Asia/Kolkata');
						if($row['frequency']=="daily")
						{
							$date = $row['nextepisodedate'];
							$nextdate = strtotime(date("Y-m-d", strtotime($date)) . " +1 day");
						}
						/*else if($row['frequency']=="weekly")
						{
							$date = $row['nextepisodedate'];
							$nextdate = strtotime(date("Y-m-d", strtotime($date)) . " +1 week");
						}*/
						else if($row['frequency']=="monthly")
						{
							$date = $row['frequency_date'];
							$nextdate = strtotime(date("Y-m-d", strtotime($date)) . " +1 month");			
						}
						// current date
						
						if($nextdate!="")
						{
							$newshowdate=date("Y-m-d",$nextdate);
							
						}
					//}
					else
					{
						if($row['frequency']=="daily")
						{
							$newshowdate=$row['nextepisodedate'];
						}
						else if($row['frequency']=="monthly")
						{
							$newshowdate=$row['frequency_date'];
						}
					}
					
					//$sendmail[]=$cusotmeremail;
					$nextsku=$skuarray[$noofepisode+1];
					$upepisode=$noofepisode+1;
					if($row['frequency']=="daily")
					{
						$sqlupdate = "UPDATE mg_subscribedetails_index SET noofepisode = '".$upepisode."',nextepisodedate='".$newshowdate."' WHERE quoteid = " . $row['quoteid']." AND flag='2' AND itemid=".$row['itemid'];
					}
					else if($row['frequency']=="monthly")
					{
						$sqlupdate = "UPDATE mg_subscribedetails_index SET noofepisode = '".$upepisode."',frequency_date='".$newshowdate."' WHERE quoteid = " . $row['quoteid']." AND flag='2' AND itemid=".$row['itemid'];
					}
						
					$connection->query($sqlupdate);
				
					//echo "nextsku==>".$nextsku;
					
					$productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
					$productObj = $productRepository->get($nextsku);
					//echo $productObj->getId();
					//echo $productObj->getName();
					//print_r($productObj->getProductUrl());
					$ProductUrl=$productObj->getProductUrl();
					$pname=$productObj->getName();
					$pid=$productObj->getId();
		$html="<p>Product Id:".$pid."</p><p>Product Url:".$ProductUrl."</p><p>Product Name:".$pname."</p>";
					//$sendmail=[$cusotmeremail];
					//$this->sendepisodemail($sendmail,$html);
					$mail->AddAddress($cusotmeremail);
					$mail->AddReplyTo($cusotmeremail);
					$mail->IsHTML(true);
					$mail->Subject = "New Episode";
					$mail->Body = $html;
					$mail->Send();
				}
				else
				{
					date_default_timezone_set('Asia/Kolkata');
						if($row['frequency']=="daily")
						{
							$date = $row['nextepisodedate'];
							$nextdate = strtotime(date("Y-m-d", strtotime($date)) . " +1 day");
						}
						/*else if($row['frequency']=="weekly")
						{
							$date = $row['nextepisodedate'];
							$nextdate = strtotime(date("Y-m-d", strtotime($date)) . " +1 week");
						}*/
						else if($row['frequency']=="monthly")
						{
							$date = $row['frequency_date'];
							$nextdate = strtotime(date("Y-m-d", strtotime($date)) . " +1 month");			
						}
						// current date
						
						if($nextdate!="")
						{
							$newshowdate=date("Y-m-d",$nextdate);
							
						}
						if($row['frequency']=="daily")
						{
							$sqlupdate = "UPDATE mg_subscribedetails_index SET nextepisodedate='".$newshowdate."' WHERE quoteid = " . $row['quoteid']." AND flag='2' AND itemid=".$row['itemid'];
						}
						else if($row['frequency']=="monthly")
						{
							$sqlupdate = "UPDATE mg_subscribedetails_index SET frequency_date='".$newshowdate."' WHERE quoteid = " . $row['quoteid']." AND flag='2' AND itemid=".$row['itemid'];
						}							
						$connection->query($sqlupdate);
				
				}
			}
			}
			}
			//die("bye");
			
		}
		
		//echo '<pre>'; print_r($result); echo '</pre>';
		die("working");
		//return $this->_pageFactory->create();
	}
	/*public function sendepisodemail($sendmail,$html)
	{
			
		foreach($sendmail as $row)
		{
		$mail->AddAddress($row);
		$mail->AddReplyTo($row);
		$mail->IsHTML(true);
		$mail->Subject = "New Episode";
		$mail->Body = $html;
		$mail->Send();
		}
	}*/
}