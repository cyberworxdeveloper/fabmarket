<?php
namespace Magecheckout\Customminicart\Observer;

class Checkorderstatus implements \Magento\Framework\Event\ObserverInterface
{
	public function execute(\Magento\Framework\Event\Observer $observer)
	{
		 $order = $observer->getEvent()->getOrder();
		
		if ($order instanceof \Magento\Framework\Model\AbstractModel) {
		   if($order->getState() == 'complete') {
			   $objectManager = \Magento\Framework\App\ObjectManager::getInstance();			   
					$items = $order->getAllItems();
					$order_list="";
					$count=0;
					foreach($items as $mailitem)
					{	
						$count++;
						$product = $objectManager->create('Magento\Catalog\Model\Product')->load($mailitem->getProductId());
						
						$imageUrl = $product->getMediaConfig()->getMediaUrl($product->getImage());
					
						/*if($product->getSpecialPrice()>0)
						{
							$prodcut_price=$product->getSpecialPrice();
							
						}else
						{
							$prodcut_price=$product->getPrice();
							
						}*/
						$prodcut_price=$mailitem->getPrice();	
						$qtyordered=round($mailitem->getQtyOrdered());
						$pprice=$qtyordered*$prodcut_price;
						
						$order_list.='<div class="inside-detail" style="display: flex;flex-wrap: wrap;padding: 10px 0;"><div class="col-md-6" style="width: 50%;display: flex;flex-wrap: wrap;"><div class="img_box" style="width: 40px;height: 40px;margin-right: 15px;"><img src="'.$imageUrl.'" style="width: 40px;height: 40px;object-fit: cover;border-radius: 4px;"></div><div class="detail_block"><p style="margin: 0 0 2px 0;font-size: 14px;font-weight: bold;color: #172832;">'.$product->getName().'</p><p style="margin: 0;font-size: 12px;color: #8f8f8f;">Product #561162</p></div></div><div class="col-md-6" style="width: 24%;">'.$qtyordered.'</div><div class="col-md-6" style="text-align: right;width: 24%;">$'.number_format($pprice,2).'</div></div>';
					}
					if($count==1)
					{
						$dwntxt="Download";
					}else
					{
						$dwntxt="Download All";
					}
					$discount='';
					$coupn='';
					$IncrementId=$order->getIncrementId();
					$customer_email=$order->getCustomerEmail();
					$created_at=$order->getCreatedAt();
					$newDate = date("d-M-Y", strtotime($created_at));  
					$tax_amount=$order->getTaxAmount();
					//$tax_amount=$objectManager->create('Magento\Framework\Pricing\Helper\Data')->currency(number_format($tax_amount,2));
					$discount =$order->getDiscountAmount();
					//$discount=$objectManager->create('Magento\Framework\Pricing\Helper\Data')->currency(number_format($discount,2));
					$coupn=$order->getCouponCode();
					//echo "order status".$order->getStatus();
					//$order->getStoreId();
					$getGrandTotal=$order->getGrandTotal();
					//echo "grandtotal".$getGrandTotal=$objectManager->create('Magento\Framework\Pricing\Helper\Data')->currency(number_format($getGrandTotal,2));
					$getSubtotal=$order->getSubtotal();
					//$getSubtotal=$objectManager->create('Magento\Framework\Pricing\Helper\Data')->currency(number_format($getSubtotal,2));
					//$order->getTotalQtyOrdered();
					//$order->getOrderCurrencyCode();
					
					//echo "cname".$order->getCustomerName();
					$html='<html><head><title>Order Purchased</title><link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&amp;display=swap" rel="stylesheet"></head><body style="font-family: Nunito Sans, sans-serif;margin: 0;background: #ececec;"><div class="mailer_body" style="width: 800px;margin: 0 auto;background: #fff;padding:30px;box-sizing:border-box;"><div class="header"><img src="https://www.fabmarket.in/pub/media/logo/default/FAB-Logo3.jpg" style="width: 210px;position: relative;z-index: 99;"></div><div class="banner"><img src="https://www.fabmarket.in/pub/media/mailer-image/banner.jpg" style="width: 100%;position: relative;bottom: 70px;margin-bottom: -80px;"></div><div class="article" style="position: relative;z-index: 999;"><div class="top_block" style="text-align: center;"><h3 style="font-size: 30px;margin: 0;font-weight: bold;">Order Purchased</h3><h4 style="margin: 10px 0 0 0px;font-size: 20px;">Order '.$IncrementId.'</h4></div><div class="middle_block" style="margin-top: 70px;margin-bottom: 50px;"><p style="font-size: 25px;font-weight: bold;margin: 0 0 10px 0;">'.$order->getCustomerName().', please find link to download your items</p><div class="top_detail" style="display: flex;flex-wrap: wrap;margin-top: 40px;border-bottom: 1px solid #ececec;margin-bottom: 15px;"><div class="col-md-6" style="width: 48%;"><p style="font-weight: 700;margin: 0 0 10px 0;">Your Order</p></div><div class="col-md-6" style="width: 38%;"><p style="font-weight: 700;margin: 0 0 10px 0;">QTY</p></div><div class="col-md-6" style="width: 14%;text-align: right;"><p style="margin: 0;"><a href="http://lykanmedia.com/sales/order/history/?p=1" download="download" style="text-decoration: none;color: #cf4347;font-weight: 600;"><img src="down-arrow-red.svg" width="13px"> '.$dwntxt.'</a></p></div></div>';
					$html.=$order_list;
					$html.='<a href="http://lykanmedia.com/invoice/index.php/?order_id='.$IncrementId.'" download="download" style="border-radius: 19.5px;border: solid 1px #cf4347;text-decoration: none;font-size: 12px;font-weight: bold;text-align: center;color: #cf4347;padding: 7px 20px;margin: 20px auto 20px auto;display: block;width: max-content;">Download PDF Recipt</a></div><footer style="background-image:url(http://lykanmedia.com/pub/media/mailer-image/footer1.png);background-size: cover;padding: 90px 0 30px 0;margin: 0 -30px -30px -30px;text-align: center;box-sizing: border-box;"><p style="margin: 0;font-size: 14px;color: rgb(255, 255, 255);padding-top: 0;box-sizing: border-box;">Copyright &copy; HT Media. All Rights Reserved</p></footer></div></body></html>';					
					$sendmail=['support@fabmarket.in',$customer_email];
					require("class.phpmailer.php");					

					$mail = new \PHPMailer();
					
					$mail->IsSMTP();
					//$mail->SMTPDebug  = 1;
					$mail->Host = "email-smtp.ap-south-1.amazonaws.com";
					$mail->SMTPAuth = true;
					$mail->SMTPSecure = "tls";
					$mail->Port = 587;
					$mail->Username = "AKIAYR726V2PKXQ2F2RG";
					$mail->Password = "BA24yFRPPSkLBSDxAGh0ZO8vOfffLsvG0cXmOTrYw2lh";
					$mail->From = "support@fabmarket.in";
					$mail->FromName = "Fabmarket";
					foreach($sendmail as $row)
					{
					$mail->AddAddress($row);
					$mail->AddReplyTo($row);
					$mail->IsHTML(true);
					$mail->Subject = "New Order Confirmation";
					$mail->Body = $html;
					
					$mail->Send();
					;
					}
				/*send mail*/
		   }
		}
		return $this;
	}
}
?>