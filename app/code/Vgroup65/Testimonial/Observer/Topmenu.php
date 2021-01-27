<?php
namespace Vgroup65\Testimonial\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Event\ObserverInterface;
use Vgroup65\Testimonial\Helper\Data;

class Topmenu implements ObserverInterface {

    protected $_url;
    protected $helper;

    public function __construct(\Magento\Cms\Block\Block $cmsBlock, \Magento\Framework\UrlInterface $url, Data $helper) {
        $this->_url = $url;
        $this->helper = $helper;
    }

    /**
     * @param EventObserver $observer
     * @return $this
     */
    public function execute(EventObserver $observer) {
        $menu = $observer->getMenu();
        $tree = $menu->getTree();
        $displayTop = $this->helper->getConfig('configuration/display_top_menu');
        $headerLabel = $this->helper->getConfig('configuration/top_navigation_menu_text');
        
        if (!$headerLabel)
            $headerLabel = 'Testimonial';

        if ($displayTop == 1):
            $data = [
                'name' => __($headerLabel),
                'id' => 'vgroupinc-testimonial-menu-id',
                'url' => $this->_url->getUrl('testimonial'),
                'is_active' => false
            ];
            $node = new Node($data, 'id', $tree, $menu);
            $menu->addChild($node);
        endif;
        return $this;
    }

}









//namespace Vgroup65\Testimonial\Observer;
//
//use Magento\Framework\Event\Observer as EventObserver;
//use Magento\Framework\Data\Tree\Node;
//use Magento\Framework\Event\ObserverInterface;
//class Topmenu implements ObserverInterface
//{
//    protected $testimonialConfiguration;
//    
//    protected $_url;
//    public function __construct(
//       \Magento\Cms\Block\Block $cmsBlock, \Magento\Framework\UrlInterface $url,     
//       \Vgroup65\Testimonial\Model\ConfigurationFactory $configuration
//    )
//    {
//        $this->_url = $url;
//        $this->testimonialConfiguration = $configuration;
//    }
//    /**
//     * @param EventObserver $observer
//     * @return $this
//     */
//    public function execute(EventObserver $observer)
//    {
//        $testimonialConfiguration = $this->testimonialConfiguration->create();
//        $testimonialConfigurationCollection = $testimonialConfiguration->getCollection(); 
//        $testimonialConfigurationCollection->addFieldToFilter('configuration_id', '1');
//        foreach($testimonialConfigurationCollection as $values):
//            $title = $values['top_menu_link'];
//            $display_top_menu = $values['display_top_menu'];
//        endforeach;
//        
//        /** @var \Magento\Framework\Data\Tree\Node $menu */
//        $menu = $observer->getMenu();
//        
//        if($display_top_menu == 1):
//            $tree = $menu->getTree();
//            $data = [
//                'name'      => __($title),
//                'id'        => 'vgroupinc-testimonial-menu-id',
//                'url'       => $this->_url->getUrl('testimonial'),
//                'is_active' => false
//            ];
//            $node = new Node($data, 'id', $tree, $menu);
//            $menu->addChild($node);
//        endif;     
//        return $this;
//    }
//}