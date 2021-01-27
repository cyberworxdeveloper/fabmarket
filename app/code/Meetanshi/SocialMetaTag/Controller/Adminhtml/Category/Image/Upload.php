<?php

namespace Meetanshi\SocialMetaTag\Controller\Adminhtml\Category\Image;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Catalog\Model\ImageUploader;
use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;

/**
 * Class Upload
 * @package Meetanshi\SocialMetaTag\Controller\Adminhtml\Category\Image
 */
class Upload extends Action
{
    /**
     * @var ImageUploader
     */
    private $imageUploader;
    /**
     * @var UploaderFactory
     */
    private $uploaderFactory;
    /**
     * @var Filesystem\Directory\WriteInterface
     */
    private $mediaDirectory;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var Database
     */
    private $coreFileStorageDatabase;

    /**
     * Upload constructor.
     * @param Context $context
     * @param ImageUploader $imageUploader
     * @param UploaderFactory $uploaderFactory
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param Database $coreFileStorageDatabase
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        Context $context,
        ImageUploader $imageUploader,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager,
        Database $coreFileStorageDatabase
    )
    {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
        $this->uploaderFactory = $uploaderFactory;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->storeManager = $storeManager;
        $this->coreFileStorageDatabase = $coreFileStorageDatabase;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Meetanshi_SocialMetaTag::socialmetatag_configuration');
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        try {
            $result = $this->imageUploader->saveFileToTmpDir($data['param_name']);
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
