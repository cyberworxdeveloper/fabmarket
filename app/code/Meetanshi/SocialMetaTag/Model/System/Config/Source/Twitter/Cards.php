<?php

namespace Meetanshi\SocialMetaTag\Model\System\Config\Source\Twitter;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Cards
 * @package Meetanshi\SocialMetaTag\Model\System\Config\Source\Twitter
 */
class Cards implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'summary', 'label' => 'Summary Card',],
            ['value' => 'summary_large_image', 'label' => 'Summary Card with Large Image',]
        ];
    }
}
