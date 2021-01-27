<?php
namespace Vgroup65\Testimonial\Model\ResourceModel\Testimonial;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'testimonial_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Vgroup65\Testimonial\Model\Testimonial', 'Vgroup65\Testimonial\Model\ResourceModel\Testimonial');
    }
}