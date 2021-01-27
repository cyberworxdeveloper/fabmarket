<?php
namespace Vgroup65\Testimonial\Block\Widget;

use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template\Context;
use Vgroup65\Testimonial\Helper\Data; 
class ShowTestimonials extends \Magento\Framework\View\Element\Template implements BlockInterface {

    protected $_template = 'widget/testimonial.phtml';
    protected $_testimonial;
//    protected $_configuration;
    protected $helper;
    public function __construct(Context $context , \Vgroup65\Testimonial\Model\TestimonialFactory $testimonialFactory, \Vgroup65\Testimonial\Helper\Data $helper) {
        parent::__construct($context);
        $this->_testimonial = $testimonialFactory;
//        $this->_configuration = $configurationFactory;
        $this->helper = $helper;
    }
    
    public function getTestimonialList() {
        //get testimonial configuration count
        $testimonialCount = $this->getConfigurationTestimonialCount();
        if($testimonialCount == 0):
            return array('status' => '0');
        endif;
        
        $testimonialList = $this->_testimonial->create();
        $testimonialCollection = $testimonialList->getCollection();
        $testimonialCollection->addFieldToFilter('status' , '1');
        $testimonialCollection->setOrder('testimonial_id', 'DESC');
 
        $testimonialCollection->setPageSize($testimonialCount);
        return array('status' => '1' , 'testimonials' => $testimonialCollection);
    }
    
    public function getConfigurationTestimonialCount() {
//        $testimonialConfiguration = $this->_configuration->create();
//        $testimonialCollection = $testimonialConfiguration->getCollection();
//        $testimonialCollection->addFieldToFilter('configuration_id', '1');
//        foreach($testimonialCollection as $values):
//                $noOfTestimonial = $values->getNoOfTestimonial();
//        endforeach;
        $noOfTestimonial = $this->helper->getConfig('configuration/no_of_display');
        return $noOfTestimonial;
    }
    
    public function getTestimonialConfiguration() {
//        $testimonialConfiguration = $this->_configuration->create();
//        $testimonialCollection = $testimonialConfiguration->getCollection();
//        $testimonialCollection->addFieldToFilter('configuration_id', '1');
//        foreach($testimonialCollection as $values):
//                return $values->getTopMenuLink();
//        endforeach;
        $top_menu = $this->helper->getConfig('configuration/top_navigation_menu_text');
        return $top_menu;
    }
    
    public function getWidgetAutoRotate() {
//        $testimonialConfiguration = $this->_configuration->create();
//        $testimonialCollection = $testimonialConfiguration->getCollection();
//        $testimonialCollection->addFieldToFilter('configuration_id', '1');
//        foreach($testimonialCollection as $values):
//                return $values->getAutoRotate();
//        endforeach;
        $auto_rotate = $this->helper->getConfig('configuration/auto_rotation');
        return $auto_rotate;
        
    }
    
    public function getBaseUrl(){
        return $this->helper->getBaseUrl();
    }
    
}