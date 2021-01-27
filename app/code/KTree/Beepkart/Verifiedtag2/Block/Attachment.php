<?php
namespace Beepkart\Verifiedtag2\Block;

class Attachment extends \Magento\Catalog\Block\Product\View {

    public function getMediaUrl() {
    	return $this->_storeManager->getStore()
        	->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    public function getProductAttachmentUrl($attachment) {

    	return $this->getMediaUrl()."catalog/product/attachment/".$attachment;

    }
}