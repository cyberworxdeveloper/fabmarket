<?php
ini_set('display_errors', 1);
//X4YEN

use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');
require('../vendor/autoload.php');
$orderid=$_GET['order_id'];
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$order = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($orderid);
foreach ($order->getInvoiceCollection() as $invoice)
{
	$invoice_id = $invoice->getIncrementId();
	$createdAt = $invoice->getCreatedAt();
	$invoiceDate = date("d-M-Y", strtotime($createdAt));

}
 $orderItems = $order->getAllItems();
 $billingaddress = $order->getBillingAddress();
 $billingcity = $billingaddress->getCity();
 $billingstreet = $billingaddress->getStreet();
$streetval = '';
foreach ($billingstreet as $result) {
    $streetval .= $result .',';
}
 $billingpostcode = $billingaddress->getPostcode();
 $billingtelephone = $billingaddress->getTelephone();
 $billingstate_code = $billingaddress->getRegionCode();
 $region = $billingaddress->getRegion();
 $order_list='';
$i=1;
foreach ($orderItems as $item) {
	  $item->getSku();
  $productname= $item->getName();
  /*echo "<pre>";
  print_r($item->getData());
  die("working");*/
 $qtyordered=round($item->getQtyOrdered());
 $prodcut_price=$item->getPrice();
 $prodcut_price=$objectManager->create('Magento\Framework\Pricing\Helper\Data')->currency(number_format($prodcut_price,2));

$order_list.='<tr style="vertical-align: baseline;font-weight: 600;"><td style="border-bottom: 1px solid #d8d8d8;padding: 0 0 15px 0;"><p style="margin: 0 0 3px 0;color: #000;">'.$i.'</p></td><td style="border-bottom: 1px solid #d8d8d8;padding: 0 0 15px 0;text-align: left;"><p style="margin: 0;">'.$productname.'</p></td><td style="border-bottom: 1px solid #d8d8d8;padding: 0 0 15px 0;text-align: left;font-weight: 600;"><p style="margin: 0;">Audio</p></td><td style="border-bottom: 1px solid #d8d8d8;padding: 0 0 15px 0;text-align: right;"><p style="margin: 0;">'.$prodcut_price.'</p></td><td style="border-bottom: 1px solid #d8d8d8;padding: 0 0 15px 0;text-align: right;"><p style="margin: 0;">'.$qtyordered.'</p></td><td style="border-bottom: 1px solid #d8d8d8;padding: 0 0 15px 0;text-align: right;"><p style="margin: 0;">'.$prodcut_price.'</p></td></tr>';
$i++;
}
$discount='';
$coupn='';
$IncrementId=$order->getIncrementId();
$customer_email=$order->getCustomerEmail();
$customer_Name=$order->getCustomerName();
$created_at=$order->getCreatedAt();
 $newDate = date("d-M-Y", strtotime($created_at));  
$tax_amount=$order->getTaxAmount();
$tax_amount=$objectManager->create('Magento\Framework\Pricing\Helper\Data')->currency(number_format($tax_amount,2));
$discount =$order->getDiscountAmount();
$discount=$objectManager->create('Magento\Framework\Pricing\Helper\Data')->currency(number_format($discount,2));
$coupn=$order->getCouponCode();
$order->getStatus();
$order->getStoreId();
$getGrandTotal=$order->getGrandTotal();
$getGrandTotal=$objectManager->create('Magento\Framework\Pricing\Helper\Data')->currency(number_format($getGrandTotal,2));
$getSubtotal=$order->getSubtotal();
$getSubtotal=$objectManager->create('Magento\Framework\Pricing\Helper\Data')->currency(number_format($getSubtotal,2));
$order->getTotalQtyOrdered();
$order->getOrderCurrencyCode();
//echo "<pre>"; print_r($order->debug());
 //die;

$order->getCustomerName(); 
?>
<?php
// Include autoloader 
require_once 'dompdf/autoload.inc.php'; 
 
// Reference the Dompdf namespace 
use Dompdf\Dompdf; 
 
// Instantiate and use the dompdf class 
$dompdf = new Dompdf();
// Load content from html file 
$dompdf->set_option('isRemoteEnabled', TRUE);
$html='<html><head><title>Fab Invoice</title><link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&amp;display=swap" rel="stylesheet"></head><body style="font-family: sans-serif;margin: 0;background: #ececec;><div class="mailer_body" style="width: 100%;margin: 0 auto;background: #fff;box-sizing:border-box;color: #8f8f8f;"><div class="toppart" style="background: #f7f7f7;padding: 0 70px 50px 70px;"><header><div class="row" style="display: block;"><div class="col-md-3" style="width: 35%;display: inline-block;"><div class="invoic_box" style="text-align: left;color: #ff4248;padding: 30px 10px 10px 0px;"><h2 style="margin: 0;font-size: 30px;">Tax Invoice</h2><p style="margin: 0;font-size: 13px;color: #8f8f8f;">GST Reg No 201017570W</p></div></div><div class="col-md-3 offset-md-6" style="width: 25%;display: inline-block;margin-left: 39%;text-align: right;"><img src="https://www.fabmarket.in/pub/media/logo/default/FAB-Logo3.jpg" style="width: 89%;position: relative;top: 0;right: 0;"></div></div></header><div class="detail_part" style="margin:0px 0 0 0;"><div class="col-md-12"><p style="margin: 0;color: #172832;font-size: 13px;"><b>Invoice To</b></p><p style="font-size: 13px;margin: 5px 0 0 0;">'.$customer_Name.' '.$streetval.' '.$billingcity.' ('.$billingstate_code.') - '.$billingpostcode.'</p></div><div class="col-md-4" style="display: inline-block;width: 33.33%;"><p style="margin: 5px 0 0 0;font-size: 13px;"><b style="color: #cf4347;">Email: </b>'.$customer_email.'</p></div><div class="col-md-4" style="display: inline-block;width: 33.33%;margin: 0 0 25px 0px;"><p style="margin: 5px 0 0 0;font-size: 13px;"><b style="color: #cf4347;">Mob: </b> '.$billingtelephone.'</p></div><div class="row" style="margin-top:30px"><div class="col-md-3" style="display: inline-block;width: 24%;"><b style="margin: 0;color: #172832;font-size: 13px;">Order no.</b><p style="margin: 3px 0 0 0;font-size: 13px;">#'.$IncrementId.'</p></div><div class="col-md-3" style="display: inline-block;width: 24%;"><b style="margin: 0;color: #172832;font-size: 13px;">Order Date</b><p style="margin: 3px 0 0 0;font-size: 13px;">'.$newDate.'</p></div><div class="col-md-3" style="display: inline-block;width: 24%;"><b style="margin: 0;color: #172832;font-size: 13px;">Invoice no.</b><p style="margin: 3px 0 0 0;font-size: 13px;">'.$invoice_id.'</p></div><div class="col-md-3" style="display: inline-block;width: 24%;"><b style="margin: 0;color:#172832;font-size: 13px;">Invoice Date</b><p style="margin: 3px 0 0 0;font-size: 13px;">'.$invoiceDate.'</p></div></div></div></div><div class="article" style="padding: 40px 70px 0 70px;"><table width="100%" align="center" cellpadding="0px" cellspacing="0" style="font-size: 14px;color: #172832;"><tbody><tr style="color: #8f8f8f;"><th style="text-align: left;font-weight: 200;color: #8f8f8f;padding: 0px 0 20px 0;">Sr. No.</th><th style="text-align: left;font-weight: 200;color: #8f8f8f;padding: 0 0 20px 0;">Product Name</th><th style="text-align: left;font-weight: 200;color: #8f8f8f;padding: 0 0 20px 0;">Product Type</th><th style="text-align: right;font-weight: 200;color: #8f8f8f;padding: 0 0 20px 0;">Price (US$) </th><th style="text-align: right;font-weight: 200;color: #8f8f8f;padding: 0 0 20px 0;">Quantity</th><th style="text-align: right;font-weight: 200;color: #8f8f8f;padding: 0 0 20px 0;">Amount (US$)</th></tr>'.$order_list.'<tr style="vertical-align: baseline;font-weight: 600;"><td></td><td></td><td style="border-bottom: 1px solid #d8d8d8;padding: 10px 0 10px 0;"><p style="margin: 0;font-size: 12px;color: #8f8f8f;">Total Amount</p></td><td style="border-bottom: 1px solid #d8d8d8;padding: 10px 0 10px 0;"></td><td style="border-bottom: 1px solid #d8d8d8;padding: 10px 0 10px 0;"></td><td style="border-bottom: 1px solid #d8d8d8;padding: 10px 0 10px 0;text-align: right;"><p style="margin: 0;">'.$getSubtotal.'</p></td></tr>';
if($coupn!=0)
{
$html.='<tr style="vertical-align: baseline;font-weight: 600;"><td></td><td></td><td style="border-bottom: 1px solid #d8d8d8;padding: 10px 0 10px 0;"><p style="margin: 0;font-size: 12px;color: #8f8f8f;">Promocode<b style="color: #cf4347;"> ('.$coupn.')</b></p></td><td style="border-bottom: 1px solid #d8d8d8;padding: 0 0 15px 0;"></td><td style="border-bottom: 1px solid #d8d8d8;padding: 0 0 15px 0;"></td><td style="border-bottom: 1px solid #d8d8d8;padding: 10px 0 10px 0;text-align: right;"><p style="margin: 0;">'.$discount.'</p></td></tr>';	
}
$html.='<tr style="vertical-align: baseline;font-weight: 600;"><td></td><td></td><td style="border-bottom: 1px solid #d8d8d8;padding: 10px 0 10px 0;"><p style="margin: 0;font-size: 12px;color: #8f8f8f;">GST @ 7%</p></td><td style="border-bottom: 1px solid #d8d8d8;padding: 0 0 15px 0;"></td><td style="border-bottom: 1px solid #d8d8d8;padding: 0 0 15px 0;"></td><td style="border-bottom: 1px solid #d8d8d8;padding: 10px 0 10px 0;text-align: right;"><p style="margin: 0;">'.$tax_amount.'</p></td></tr><tr style="vertical-align: baseline;font-size: 15px;"><td></td><td></td><td><p><b style="font-size: 16px;">Total Payable</b></p></td><td></td><td></td><td style="text-align: right;padding: 10px 0 10px 0;"><p style="margin: 0;"><b style="color: #cf4347;">'.$getGrandTotal.'</b></p></td></tr></tbody></table><hr style="margin: 20px 0 30px 0;opacity: 0.5;"><div class="info_block" style="font-size: 13px;"><p style="margin: 0px 0 20px 0;font-size: 16px;color: #ff4248;">For payment via transfer, please send remittance to:</p><p style="font-size: 14px;margin: 0px 0 10px 0;">Bank Name: <b style="color: #172832;">Citibank N.A. Singapore Branch</b></p><p style="font-size: 14px;margin: 0 0 10px 0;">Swift &amp; Bank Code: <b style="color: #172832;">Swift Code CITISGSG, Bank Code 7214, Branch Code 001</b> </p><p style="font-size: 14px;margin: 0 0 0 0;">Account Name: <b style="color: #172832;">HT Overseas Pte Ltd</b><i style="display: inline-block;width: 3px;height: 3px;background: #cf4347;border-radius: 1.5px;vertical-align: middle;margin: 0 10px;"></i> Bank Account No: <b style="color: #172832;">0-853936-014 (USD Account)</b> </p></div><hr style="margin: 40px 0 30px 0;opacity: 0.5;"><div class="info_block" style="font-size: 13px;"><div class="row"><div class="col-md-12" style="display: inline-block;width: 100%;vertical-align: top;"><b style="margin: 0;color: #172832;">Address</b><p style="margin: 10px 0 30px 0;font-size: 15px;">30 Cecil Street, #23-03/04, Prudential Tower, Singapore 049712</p><p style="margin: 30px 0 0 0;color: #000;">*Kindly ignore if  already paid</p><p style="margin: 30px 0 20px 0;text-align: center;background: whitesmoke;padding: 10px;color: #8f8f8f;">Copyright © HT Media. All Rights Reserved</p></div></div></div></div></div></body></html>';

$dompdf->loadHtml($html); 
 
// (Optional) Setup the paper size and orientation 
//$dompdf->setPaper('A4', 'portrait'); 
$dompdf->setPaper('A4', 'portrait');
 
// Render the HTML as PDF 
$dompdf->render(); 
 
// Output the generated PDF (1 = download and 0 = preview) 
$dompdf->stream("Invoice", array("Attachment" => 1));

?>