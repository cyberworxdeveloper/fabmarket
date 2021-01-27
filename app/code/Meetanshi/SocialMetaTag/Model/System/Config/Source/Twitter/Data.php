<?php

namespace Meetanshi\SocialMetaTag\Model\System\Config\Source\Twitter;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Data
 * @package Meetanshi\SocialMetaTag\Model\System\Config\Source\Twitter
 */
class Data implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'lowest_price', 'label' => 'Price (lowest available)'],
            ['value' => 'regular_price', 'label' => 'Regular price'],
            ['value' => 'special_price', 'label' => 'Special price'],
            ['value' => 'sku', 'label' => 'Sku'],
            ['value' => 'is_in_stock', 'label' => 'Availability (In stock/Out of stock)'],
            ['value' => 'custom', 'label' => 'Custom (enter attribute code)']
        ];
    }
}
