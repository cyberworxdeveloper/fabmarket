<?php
namespace Fabmarket\Downloadepisode\Controller\Index;

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
		//print_r(base64_decode($_GET['id']));
		$url=base64_decode($_GET['id']);
		$arr=explode("/",$url);	
		$len=count($arr);
		$file_name = $arr[$len-1];
		$file_url = $url;
		//die("hi");
		//$file_name = 'ACP+002.mp3';
		//$file_url = 'https://international-radio.s3.ap-south-1.amazonaws.com/Drama/ACP+Kernal+Singh/' . $file_name;
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary"); 
		header("Content-disposition: attachment; filename=\"".$file_name."\""); 
		readfile($file_url);
		die("present sir!");
		//return $this->_pageFactory->create();
	}
}