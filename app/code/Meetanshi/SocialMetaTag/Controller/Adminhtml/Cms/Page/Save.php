<?php

namespace Meetanshi\SocialMetaTag\Controller\Adminhtml\Cms\Page;

use Magento\Backend\App\Action;
use Magento\Cms\Controller\Adminhtml\Page\PostDataProcessor;
use Magento\Cms\Model\Page;
use Magento\Cms\Controller\Adminhtml\Page\Save as CoreSave;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Model\PageFactory;

/**
 * Class Save
 * @package Meetanshi\SocialMetaTag\Controller\Adminhtml\Cms\Page
 */
class Save extends CoreSave
{
    /**
     *
     */
    const ADMIN_RESOURCE = 'Magento_Cms::save';
    /**
     * @var
     */
    protected $dataProcessor;
    /**
     * @var
     */
    protected $dataPersistor;
    /**
     * @var Page
     */
    private $pageFactory;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param PageFactory $pageFactory
     * @param PageRepositoryInterface|null $pageRepository
     */
    public function __construct(Action\Context $context, PostDataProcessor $dataProcessor, DataPersistorInterface $dataPersistor, PageFactory $pageFactory, PageRepositoryInterface $pageRepository = null)
    {
        $this->pageFactory = $pageFactory->create();
        parent::__construct($context, $dataProcessor, $dataPersistor, $pageFactory, $pageRepository);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $data = $this->dataProcessor->filter($data);
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Page::STATUS_ENABLED;
            }
            if (empty($data['page_id'])) {
                $data['page_id'] = null;
            }

            $model = $this->pageFactory;

            $id = $this->getRequest()->getParam('page_id');
            if ($id) {
                $model->load($id);
            }

            if (isset($data['fb_share_image']) && is_array($data['fb_share_image'])) {
                $data['fb_share_image'] = $data['fb_share_image'][0]['name'];
            }

            if (isset($data['twitter_share_image']) && is_array($data['twitter_share_image'])) {
                $data['twitter_share_image'] = $data['twitter_share_image'][0]['name'];
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'cms_page_prepare_save',
                ['page' => $model, 'request' => $this->getRequest()]
            );

            if (!$this->dataProcessor->validate($data)) {
                return $resultRedirect->setPath('*/*/edit', ['page_id' => $model->getId(), '_current' => true]);
            }

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the page.'));
                $this->dataPersistor->clear('cms_page');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['page_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the page.'));
            }
            $this->dataPersistor->set('cms_page', $data);
            return $resultRedirect->setPath('*/*/edit', ['page_id' => $this->getRequest()->getParam('page_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Meetanshi_SocialMetaTag::socialmetatag_configuration');
    }
}
