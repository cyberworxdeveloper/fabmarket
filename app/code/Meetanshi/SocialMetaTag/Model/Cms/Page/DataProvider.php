<?php

namespace Meetanshi\SocialMetaTag\Model\Cms\Page;

use Magento\Cms\Model\Page\DataProvider as CoreDataProvider;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\ObjectManager;

/**
 * Class DataProvider
 * @package Meetanshi\SocialMetaTag\Model\Cms\Page
 */
class DataProvider extends CoreDataProvider
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var AuthorizationInterface
     */
    private $authorization;
    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData()
    {
        $this->storeManager = ObjectManager::getInstance()->get('Magento\Store\Model\StoreManagerInterface');

        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        foreach ($items as $page) {
            $this->loadedData[$page->getId()] = $page->getData();
        }

        $data = $this->dataPersistor->get('cms_page');

        if (!empty($data)) {
            $page = $this->collection->getNewEmptyItem();

            $page->setData($data);
            $this->loadedData[$page->getId()] = $page->getData();
            $this->dataPersistor->clear('cms_page');
        }

        if ($this->loadedData != null) {
            if (!empty($this->loadedData[$page->getId()]['fb_share_image'])) {
                $currentStore = $this->storeManager->getStore();
                $media_url = $currentStore->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

                $image_name = $this->loadedData[$page->getId()]['fb_share_image'];
                unset($this->loadedData[$page->getId()]['fb_share_image']);
                $this->loadedData[$page->getId()]['fb_share_image'][0]['name'] = $image_name;
                $this->loadedData[$page->getId()]['fb_share_image'][0]['url'] = $media_url . "catalog/tmp/category/" . $image_name;
            }
            if (!empty($this->loadedData[$page->getId()]['twitter_share_image'])) {
                $currentStore = $this->storeManager->getStore();
                $media_url = $currentStore->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

                $image_name = $this->loadedData[$page->getId()]['twitter_share_image'];
                unset($this->loadedData[$page->getId()]['twitter_share_image']);
                $this->loadedData[$page->getId()]['twitter_share_image'][0]['name'] = $image_name;
                $this->loadedData[$page->getId()]['twitter_share_image'][0]['url'] = $media_url . "catalog/tmp/category/" . $image_name;
            }
        }
        return $this->loadedData;
    }

    /**
     * @inheritdoc
     */
    public function getMeta()
    {
        $meta = parent::getMeta();

        $this->authorization = ObjectManager::getInstance()->get('Magento\Framework\AuthorizationInterface');

        if (!$this->authorization->isAllowed('Magento_Cms::save_design')) {
            $designMeta = [];
            $designFieldSets = ['design', 'custom_design_update'];

            foreach ($designFieldSets as $fieldSet) {
                $designMeta[$fieldSet] = [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'disabled' => true,
                            ],
                        ],
                    ],
                ];
            }

            $meta = array_merge_recursive($meta, $designMeta);
        }

        return $meta;
    }
}