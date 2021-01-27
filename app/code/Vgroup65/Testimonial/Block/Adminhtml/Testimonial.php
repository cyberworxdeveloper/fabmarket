<?php
namespace Vgroup65\Testimonial\Block\Adminhtml;
use Magento\Backend\Block\Widget\Grid\Container;
class Testimonial extends Container
{
   protected function _construct()
    {
        $this->_controller = 'adminhtml_testimonial';
        $this->_blockGroup = 'Vgroup65_Testimonial';
        $this->_headerText = __('Client list');
        $this->_addButtonLabel = __('Add New');
        parent::_construct();
    }
}