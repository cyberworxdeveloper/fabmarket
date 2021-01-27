<?php

namespace Meetanshi\SocialMetaTag\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class ImageFallback
 * @package Meetanshi\SocialMetaTag\Model\System\Config\Source
 */
class ImageFallback implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'image,small_image,thumbnail', 'label' => 'base -> small -> thumbnail'],
            ['value' => 'image,thumbnail,small_image', 'label' => 'base -> thumbnail -> small'],
            ['value' => 'small_image,image,thumbnail', 'label' => 'small -> base -> thumbnail'],
            ['value' => 'small_image,thumbnail,image', 'label' => 'small -> thumbnail -> base'],
            ['value' => 'thumbnail,small_image,image', 'label' => 'thumbnail -> small -> base'],
            ['value' => 'thumbnail,image,small_image', 'label' => 'thumbnail -> base -> small'],
            ['value' => 'custom', 'label' => 'Custom Order']
        ];
    }
}
