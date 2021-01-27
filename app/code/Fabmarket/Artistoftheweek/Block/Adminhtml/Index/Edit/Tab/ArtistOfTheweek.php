<?php
namespace Fabmarket\Artistoftheweek\Block\Adminhtml\Index\Edit\Tab;
class ArtistOfTheweek extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = array()
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
		/* @var $model \Magento\Cms\Model\Page */
        $model = $this->_coreRegistry->registry('artistoftheweek_index');
		$isElementDisabled = false;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => __('Artist of theweek')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }

		$fieldset->addField(
            'title',
            'text',
            array(
                'name' => 'title',
                'label' => __('title'),
                'title' => __('title'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'sortdescription',
            'textarea',
            array(
                'name' => 'sortdescription',
                'label' => __('sort description'),
                'title' => __('sort description'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'description',
            'textarea',
            array(
                'name' => 'description',
                'label' => __('description'),
                'title' => __('description'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'audiourl',
            'text',
            array(
                'name' => 'audiourl',
                'label' => __('audio url'),
                'title' => __('audio url'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'imageurl',
            'image',
            array(
                'name' => 'imageurl',
                'label' => __('image url'),
                'title' => __('image url'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'linkurl',
            'text',
            array(
                'name' => 'linkurl',
                'label' => __('link url'),
                'title' => __('link url'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'extrainfo',
            'text',
            array(
                'name' => 'extrainfo',
                'label' => __('extra info'),
                'title' => __('extra info'),
                /*'required' => true,*/
            )
        );
		/*{{CedAddFormField}}*/
        
        if (!$model->getId()) {
            $model->setData('status', $isElementDisabled ? '2' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();   
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Artist of theweek');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Artist of theweek');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
