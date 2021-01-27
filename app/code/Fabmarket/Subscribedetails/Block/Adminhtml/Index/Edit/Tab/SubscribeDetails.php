<?php
namespace Fabmarket\Subscribedetails\Block\Adminhtml\Index\Edit\Tab;
class SubscribeDetails extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
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
        $model = $this->_coreRegistry->registry('subscribedetails_index');
		$isElementDisabled = false;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => __('Subscribe Details')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }

		$fieldset->addField(
            'quoteid',
            'text',
            array(
                'name' => 'quoteid',
                'label' => __('quoteid'),
                'title' => __('quoteid'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'noofepisode',
            'text',
            array(
                'name' => 'noofepisode',
                'label' => __('noofepisode'),
                'title' => __('noofepisode'),
                /*'required' => true,*/
            )
        );
		
		$fieldset->addField(
            'itemid',
            'text',
            array(
                'name' => 'itemid',
                'label' => __('itemid'),
                'title' => __('itemid'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'customerid',
            'text',
            array(
                'name' => 'customerid',
                'label' => __('customerid'),
                'title' => __('customerid'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'produtid',
            'text',
            array(
                'name' => 'produtid',
                'label' => __('produtid'),
                'title' => __('produtid'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'frequency',
            'text',
            array(
                'name' => 'frequency',
                'label' => __('frequency'),
                'title' => __('frequency'),				 
                /*'required' => true,*/
            )
        );
		
		$fieldset->addField(
            'subscriptionprice',
            'text',
            array(
                'name' => 'subscriptionprice',
                'label' => __('subscriptionprice'),
                'title' => __('subscriptionprice'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'productsku',
            'text',
            array(
                'name' => 'productsku',
                'label' => __('productsku'),
                'title' => __('productsku'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'subscriptiondate',
            'date',
            array(
                'name' => 'subscriptiondate',
                'label' => __('subscriptiondate'),
                'title' => __('subscriptiondate'),
				'date_format' => 'yyyy-MM-dd',
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'flag',
            'text',
            array(
                'name' => 'flag',
                'label' => __('flag'),
                'title' => __('flag'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'nextepisodedate',
            'date',
            array(
                'name' => 'nextepisodedate',
                'label' => __('nextepisodedate'),
                'title' => __('nextepisodedate'),
				'date_format' => 'yyyy-MM-dd',
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
        return __('Subscribe Details');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Subscribe Details');
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
