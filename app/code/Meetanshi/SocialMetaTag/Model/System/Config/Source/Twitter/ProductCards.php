<?php

namespace Meetanshi\SocialMetaTag\Model\System\Config\Source\Twitter;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class ProductCards
 * @package Meetanshi\SocialMetaTag\Model\System\Config\Source\Twitter
 */
class ProductCards implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'summary', 'label' => 'Summary Card'],
            ['value' => 'summary_large_image', 'label' => 'Summary Card with Large Image'],
            ['value' => 'product', 'label' => 'Product Card']
        ];
    }
}
