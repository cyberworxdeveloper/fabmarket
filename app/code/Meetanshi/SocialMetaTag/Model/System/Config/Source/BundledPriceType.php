<?php

namespace Meetanshi\SocialMetaTag\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class BundledPriceType
 * @package Meetanshi\SocialMetaTag\Model\System\Config\Source
 */
class BundledPriceType implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '0', 'label' => 'Do not show any price'],
            ['value' => '1', 'label' => 'Show minimum price'],
            ['value' => '2', 'label' => 'Show maximum price']
        ];
    }
}
