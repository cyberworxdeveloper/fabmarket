<?php
namespace Vgroup65\Testimonial\Block\Adminhtml\Testimonial\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
use Vgroup65\Testimonial\Model\System\Config\Status;
use Magento\Store\Model\System\Store;
use Magento\Directory\Model\Config\Source\Country;

class Info extends Generic implements TabInterface {

    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;
    protected $_status;
    protected $_systemStore;
    protected $_countryFactory;

    public function __construct(
    Context $context, Registry $registry, FormFactory $formFactory, Config $wysiwygConfig, Status $status, Country $countryFactory, Store $systemStore, array $data = []
    ) {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_status = $status;
        $this->_systemStore = $systemStore;
        $this->_countryFactory = $countryFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form fields
     *
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm() {
        /** @var $model \Tutorial\SimpleNews\Model\News */
        $model = $this->_coreRegistry->registry('vgroup_testimonial');
        

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('testimonial_');
        $form->setFieldNameSuffix('testimonial');

        $fieldset = $form->addFieldset(
                'base_fieldset', ['legend' => __('General')]
        );
        
        if ($model->getId()) {
            $fieldset->addField(
                'testimonial_id',
                'hidden',
                ['name' => 'testimonial_id']
            );
        }

        $fieldset->addField(
                'first_name', 'text', [
            'name' => 'first_name',
            'label' => __('Title'),
            'required' => true,
            'note' => "Maximum 50 characters",
            'maxlength' => 50
                ]
        );


        $fieldset->addType('image', 'Vgroup65\Testimonial\Block\Adminhtml\Helper\Image\Required');
        $fieldset->addField(
                'image', 'image', [
            'name' => 'image',
            'label' => __('Image'),
            'note' => 'Minimum Image size should be 200*200px'
                ]
        );



        $fieldset->addField(
                'status', 'select', [
            'name' => 'status',
            'label' => __('Status'),
            'options' => $this->_status->toOptionArray(),
            'required' => true
                ]
        );
        
        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);
        

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel() {
        return __('Client Info');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle() {
        return __('Client Info');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab() {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden() {
        return false;
    }

}
