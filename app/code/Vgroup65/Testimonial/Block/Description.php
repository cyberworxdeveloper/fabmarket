<?php
namespace Vgroup65\Testimonial\Block;
class Description extends \Magento\Framework\View\Element\Template
{
    protected $_testimonial;
    protected $helper;
//    protected $_configuration;
    
    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Vgroup65\Testimonial\Model\TestimonialFactory $testimonialFactory, \Vgroup65\Testimonial\Helper\Data $helper
                              ) {
        parent::__construct($context);
        $this->_testimonial = $testimonialFactory;
        $this->helper = $helper;
//        $this->_configuration = $configurationFactory;
    }
    
    protected function _prepareLayout() { 
        $topMenuText = $this->helper->getConfig('configuration/top_menu_link');
        $breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
        $breadcrumbs->addCrumb('home', array('label'=>__('Home'), 'title'=>__('Home'), 'link'=> $this->getUrl()));
        $breadcrumbs->addCrumb($topMenuText, array('label'=>$topMenuText, 'title'=> __($topMenuText), 'link'=>$this->getUrl('testimonial/')));
        
        //get Testimonial
        $getTestimonialDetails = $this->getTestimonialDetails();
        foreach($getTestimonialDetails as $testimonialDetails):
            $testimonialName = $testimonialDetails['first_name'] . " " . $testimonialDetails['last_name']; 
            $testimonialId = $testimonialDetails['testimonial_id'];
        endforeach;
        
        if(!empty($testimonialId)):
        $breadcrumbs->addCrumb($testimonialName, array('label'=>__($testimonialName), 'title'=> __($topMenuText), 'link'=>$this->getUrl('testimonial/view/detail/', array('testimonial'=> $testimonialId))));
        endif;
        $this->getLayout()->getBlock('breadcrumbs')->toHtml();
        $this->pageConfig->getTitle()->set(__($topMenuText));

        parent::_prepareLayout();
    }

    public function getTestimonialDetails() {
        //get values of current limit
        $getParam = $this->getRequest()->getParam('testimonial');
        $testimonialId = $this->getRequest()->getParam('testimonial');
        $testimonialList = $this->_testimonial->create();
        $testimonialCollection = $testimonialList->getCollection();
        $testimonialCollection->addFieldToFilter('testimonial_id' , $getParam);
        return $testimonialCollection;
    }
    
    public function getHelper(){
        return $this->helper;
    }
    
}
