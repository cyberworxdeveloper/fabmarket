<?php

namespace Meetanshi\SocialMetaTag\Model\Category;

use Magento\Catalog\Model\Category\DataProvider as CoreDataProvider;

/**
 * Class DataProvider
 * @package Meetanshi\SocialMetaTag\Model\Category
 */
class DataProvider extends CoreDataProvider
{
    /**
     * @return array
     */
    protected function getFieldsMap()
    {
        $fields = parent::getFieldsMap();
        return $fields;
    }
}
