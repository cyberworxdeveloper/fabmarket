<?php
/**
 * Copyright © 2015 Fabmarket. All rights reserved.
 */
namespace Fabmarket\Subscribedetails\Model\ResourceModel;

/**
 * Index resource
 */
class Index extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('subscribedetails_index', 'id');
    }

  
}
