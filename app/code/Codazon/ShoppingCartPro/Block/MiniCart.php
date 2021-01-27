<?php
/**
 * Copyright © 2016 Codazon. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Codazon\ShoppingCartPro\Block;

class MiniCart extends \Magento\Framework\View\Element\Template
{
    
    /* @var \Codazon\ShoppingCartPro\Helper\Data */
    protected $helper;
    protected $_checkoutSession;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
		\Magento\Checkout\Model\Session $checkoutSession,
        \Codazon\ShoppingCartPro\Helper\Data $helper,
        array $data = []
    ){
        $this->helper = $helper;
		$this->_checkoutSession=$checkoutSession;
        parent::__construct($context, $data);
    }
        
    public function getHelper()
    {
        return $this->helper;
    }
	public function getQuoteData()
    {
         $this->_checkoutSession->getQuote();
        if (!$this->hasData('quote')) {
            $this->setData('quote', $this->_checkoutSession->getQuote());
        }
        return $this->_getData('quote');      
		
    }
}