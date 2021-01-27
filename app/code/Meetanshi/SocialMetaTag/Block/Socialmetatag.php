<?php

namespace Meetanshi\SocialMetaTag\Block;

use Magento\Framework\UrlInterface;
use Meetanshi\SocialMetaTag\Helper\Data;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Magento\Framework\App\Request\Http;
use Magento\Cms\Model\Page;
use Magento\Store\Model\StoreManagerInterface;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use Magento\Catalog\Helper\Output as CoreHelper;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;
use Magento\Catalog\Model\Category;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\App\ObjectManager;

/**
 * Class Socialmetatag
 * @package Meetanshi\SocialMetaTag\Block
 */
class Socialmetatag extends Template
{
    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var UrlInterface
     */
    private $urlInterface;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var Data
     */
    private $moduleHelper;
    /**
     * @var Http
     */
    private $request;
    /**
     * @var Page
     */
    private $cmsPage;
    /**
     * @var StockItemRepository
     */
    private $stockItemRepository;
    /**
     * @var CoreHelper
     */
    private $coreHelper;
    /**
     * @var Category
     */
    private $category;
    /**
     * @var PriceHelper
     */
    private $priceHelper;
    /**
     * @var StockRegistryInterface
     */
    protected $stockRegistry;
    /**
     * @var
     */
    protected $getMagentoVersion;

    /**
     * Socialmetatag constructor.
     * @param Template\Context $context
     * @param Registry $registry
     * @param StoreManagerInterface $storeManager
     * @param Data $moduleHelper
     * @param Page $cmsPage
     * @param Http $request
     * @param UrlInterface $urlInterface
     * @param Category $category
     * @param StockItemRepository $stockItemRepository
     * @param CoreHelper $helper
     * @param PriceHelper $priceHelper
     * @param StockRegistryInterface $stockRegistry
     * @param ProductMetadataInterface $productMetadata
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Registry $registry,
        StoreManagerInterface $storeManager,
        Data $moduleHelper,
        Page $cmsPage,
        Http $request,
        UrlInterface $urlInterface,
        Category $category,
        StockItemRepository $stockItemRepository,
        CoreHelper $helper,
        PriceHelper $priceHelper,
        ProductMetadataInterface $productMetadata,
        array $data = []
    )
    {

        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->request = $request;
        $this->moduleHelper = $moduleHelper;
        $this->storeManager = $storeManager;
        $this->urlInterface = $urlInterface;
        $this->stockItemRepository = $stockItemRepository;
        $this->category = $category;
        $this->coreHelper = $helper;
        $this->cmsPage = $cmsPage;
        $this->priceHelper = $priceHelper;
        $this->getMagentoVersion = $productMetadata;
    }

    /**
     * @return array|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getTags()
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $currentCategory = $this->registry->registry('current_category');
        $currentProduct = $this->registry->registry('current_product');
        $storeName = $this->storeManager->getStore()->getName();

        $tags = [];

        if ($this->moduleHelper->isEnableSocialMetaTag() && $this->moduleHelper->isEnableOpenGraph()) {
            $fbImg = '';
            $price = '';
            $currency = '';
            $ogType = '';
            $title = $desc = $url = '';
            $stock = $cat = '';
            $imageSize = [];

            try {
                if ($currentProduct) {
                    $title = $currentProduct->getData('opengraph_meta_title');
                    $desc = $currentProduct->getData('opengraph_meta_description');

                    if (empty($title)) {
                        $title = $currentProduct->getMetaTitle();
                    }

                    if (empty($title)) {
                        $title = $currentProduct->getName();
                    }

                    if (empty($desc)) {
                        $desc = $currentProduct->getMetaDescription();
                    }

                    if (empty($desc)) {
                        $desc = $this->coreHelper->productAttribute($currentProduct, $currentProduct->getShortDescription(), 'short_description');
                    }

                    if (empty($desc)) {
                        $desc = $this->coreHelper->productAttribute($currentProduct, $currentProduct->getDescription(), 'description');
                    }

                    if (strlen($desc) > 300) {
                        $desc = substr($desc, 0, 300);
                    }

                    $title = strip_tags(htmlspecialchars($title));
                    $desc = strip_tags(htmlspecialchars($desc));

                    $imageOrder = $this->moduleHelper->getProductImageFbackOrder();
                    $stockItem = $this->getProductAvailableStatus($currentProduct->getId(),$currentProduct->getSku());

                    if (!empty($currentProduct->getData('fb_share_image'))) {
                        $fbImg = $mediaUrl . 'catalog/product' . $currentProduct->getData('fb_share_image');
                    } elseif (!empty($imageOrder)) {
                        if ($imageOrder == 'custom') {
                            $ProductImages = explode(",", $this->moduleHelper->getProductImageFbackCustomOrder());
                        } else {
                            $ProductImages = explode(",", $imageOrder);
                        }
                        for ($i = 0; $i < count($ProductImages); $i++) {
                            if (!empty($ProductImages[$i]) && $currentProduct->getData($ProductImages[$i])) {
                                $fbImg = $mediaUrl . 'catalog/product' . $currentProduct->getData($ProductImages[$i]);
                                break;
                            }
                        }
                    } elseif (!empty($this->moduleHelper->getFacebookFBackImg())) {
                        $fbImg = $mediaUrl . 'socialmetatags/' . $this->moduleHelper->getFacebookFBackImg();
                    } else {
                        $fbImg = '';
                    }

                    $url = $this->urlInterface->getCurrentUrl();

                    if ($this->moduleHelper->isFacebookProductType()) {
                        $type = $currentProduct->getTypeId();
                        $ogType = 'product';
                        $price = $currentProduct->getFinalPrice();

                        if ($type == 'bundle') {
                            if ($this->moduleHelper->getBundledProductPriceType() == 1) {
                                $price = $currentProduct->getPriceInfo()->getPrice('regular_price')->getMinimalPrice()->getBaseAmount();
                            } elseif ($this->moduleHelper->getBundledProductPriceType() == 2) {
                                $price = $currentProduct->getPriceInfo()->getPrice('regular_price')->getMaximalPrice()->getBaseAmount();
                            }
                        }

                        $currency = $this->storeManager->getStore()->getCurrentCurrency()->getCode();
                        if ($stockItem) {
                            $stock = 'instock';
                        } else {
                            $stock = 'oos';
                        }

                        $categoryIds = $currentProduct->getCategoryIds();
                        if (!empty($categoryIds)) {
                            foreach ($categoryIds as $id) {
                                $cat_id = $id;
                            }
                        }
                        if (isset($cat_id)) {
                            $categories = $this->category->load($cat_id);
                            $cat = '';
                            if (!empty($categories)) {
                                foreach ($categories as $category) {
                                    if (isset($category)) {
                                        $cat = $category['name'];
                                        break;
                                    }
                                }
                            }
                        }
                    }
                } elseif ($currentCategory) {
                    $title = $currentCategory->getData('facebook_meta_title');
                    $desc = $currentCategory->getData('facebook_meta_description');

                    if (empty($title)) {
                        $title = $currentCategory->getMetaTitle();
                    }
                    if (empty($title)) {
                        $title = $currentCategory->getName();
                    }
                    if (empty($desc)) {
                        $desc = $currentCategory->getMetaDescription();
                    }
                    if (empty($desc)) {
                        $desc = $this->coreHelper->categoryAttribute($currentCategory, $currentCategory->getDescription(), 'description');
                    }
                    if (strlen($desc) > 300) {
                        $desc = substr($desc, 0, 300);
                    }

                    $title = strip_tags(htmlspecialchars($title));
                    $desc = strip_tags(htmlspecialchars($desc));

                    if (!empty($currentCategory->getData('fb_share_image'))) {
                        $fbImg = $mediaUrl . 'catalog/category/' . $currentCategory->getData('fb_share_image');
                    } elseif (!empty($currentCategory->getImageUrl())) {
                        $fbImg = $currentCategory->getImageUrl();
                    } else {
                        $fbImg = '';
                    }

                    $url = $this->urlInterface->getCurrentUrl();
                    $ogType = 'category';
                } elseif ($this->request->getModuleName() == 'cms') {
                    $title = $this->cmsPage->getData('facebook_meta_title');
                    $desc = $this->cmsPage->getData('facebook_meta_description');

                    if (empty($title)) {
                        $title = $this->cmsPage->getMetaTitle();
                    }
                    if (empty($title)) {
                        $title = $this->cmsPage->getTitle();
                    }

                    if (empty($desc)) {
                        $desc = $this->cmsPage->getMetaDescription();
                    }
                    if (empty($desc)) {
                        $desc = $this->cmsPage->getContent();
                    }

                    if (strlen($desc) > 300) {
                        $desc = substr($desc, 0, 300);
                    }

                    $title = strip_tags(htmlspecialchars($title));
                    $desc = strip_tags(htmlspecialchars($desc));

                    if (!empty($this->cmsPage->getData('fb_share_image'))) {
                        $fbImg = $mediaUrl . 'catalog/tmp/category/' . $this->cmsPage->getData('fb_share_image');
                    } else {
                        $fbImg = '';
                    }

                    $url = $this->urlInterface->getCurrentUrl();
                    $ogType = 'website';
                }


                $tags['og:site_name'] = $storeName;
                $tags['og:url'] = $url;
                $tags['og:title'] = $title;
                $tags['og:description'] = $desc;
                $tags['og:image'] = $fbImg;
                $tags['og:type'] = $ogType;
                $tags['og:category'] = $cat;
                $tags['product:price:amount'] = $price;
                $tags['product:price:currency'] = $currency;
                $tags['product:availability'] = $stock;
                if (file_exists($fbImg) || !empty($fbImg)) {
                    if (getimagesize($fbImg)) {
                        $imageSize = getimagesize($fbImg);
                        $tags['og:image:width'] = $imageSize[0];
                        $tags['og:image:height'] = $imageSize[1];
                    }
                }
            } catch (\Exception $e) {
                ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($e->getMessage());
            }
        }

        if ($this->moduleHelper->isEnableSocialMetaTag() && $this->moduleHelper->isTwitterEnabled()) {
            $twitterImg = '';
            $price = $url = '';
            $specialPrice = $regularPrice = '';
            $ImageSize = [];
            $title = $desc = '';

            $twitterUserName = $this->moduleHelper->getTwitterUserName();
            $twitterAuthorName = $this->moduleHelper->getTwitterAuthor();
            $cardType = $this->moduleHelper->getTwitterCardCategory();

            try {
                if ($currentProduct) {
                    $title = $currentProduct->getData('twitter_meta_title');
                    $desc = $currentProduct->getData('twitter_meta_description');

                    if (empty($title)) {
                        $title = $currentProduct->getMetaTitle();
                    }
                    if (empty($title)) {
                        $title = $currentProduct->getName();
                    }
                    if (empty($desc)) {
                        $desc = $currentProduct->getMetaDescription();
                    }
                    if (empty($desc)) {
                        $desc = $this->coreHelper->productAttribute($currentProduct, $currentProduct->getShortDescription(), 'short_description');
                    }
                    if (empty($desc)) {
                        $desc = $this->coreHelper->productAttribute($currentProduct, $currentProduct->getDescription(), 'description');
                    }
                    if (strlen($desc) > 300) {
                        $desc = substr($desc, 0, 300);
                    }

                    $title = strip_tags(htmlspecialchars($title));
                    $desc = strip_tags(htmlspecialchars($desc));

                    $imageOrder = $this->moduleHelper->getProductImageFbackOrder();
                    $specialPrice = $currentProduct->getSpecialPrice();
                    $regularPrice = $currentProduct->getPrice();

                    if (!empty($currentProduct->getData('twitter_share_image'))) {
                        $twitterImg = $mediaUrl . 'catalog/product' . $currentProduct->getData('twitter_share_image');
                    } elseif (!empty($imageOrder)) {
                        if ($imageOrder == 'custom') {
                            $ProductImages = explode(",", $this->moduleHelper->getProductImageFbackCustomOrder());
                        } else {
                            $ProductImages = explode(",", $imageOrder);
                        }
                        for ($i = 0; $i < count($ProductImages); $i++) {
                            if (!empty($ProductImages) && $currentProduct->getData($ProductImages[$i])) {
                                $twitterImg = $mediaUrl . 'catalog/product' . $currentProduct->getData($ProductImages[$i]);
                                break;
                            }
                        }
                    } elseif (!empty($this->moduleHelper->getTwitterFBackImg())) {
                        $twitterImg = $mediaUrl . 'socialmetatags/' . $this->moduleHelper->getTwitterFBackImg();
                    } else {
                        $twitterImg = '';
                    }

                    $url = $this->urlInterface->getCurrentUrl();
                    $productType = $this->moduleHelper->getTwitterCardProduct();

                    $stockItem = $this->getProductAvailableStatus($currentProduct->getId(),$currentProduct->getSku());

                    if ($productType == 'product') {
                        for ($i = 1; $i <= 2; $i++) {
                            if (!$this->moduleHelper->getCustomDataEnable('socialmetatag/twitter/card_data_' . $i . '_enabled')) {
                                continue;
                            }
                            $content = $this->moduleHelper->getCustomDataEnable('socialmetatag/twitter/card_data_' . $i . '_content');

                            if ($content == 'lowest_price') {
                                if ($this->moduleHelper->getCustomDataEnable('socialmetatag/twitter/card_data_' . $i . '_formatprice')) {
                                    $price = $this->priceHelper->currency($currentProduct->getFinalPrice(), true, false);
                                } else {
                                    $price = $currentProduct->getFinalPrice();
                                }

                                $tags['twitter:data' . $i] = $price;
                            } elseif ($content == 'regular_price') {
                                if ($this->moduleHelper->getCustomDataEnable('socialmetatag/twitter/card_data_' . $i . '_formatprice')) {
                                    $price = $this->priceHelper->currency($currentProduct->getPrice(), true, false);
                                } else {
                                    $price = $regularPrice = $currentProduct->getPrice();
                                }

                                $tags['twitter:data' . $i] = $price;
                            } elseif ($content == 'special_price') {
                                if ($this->moduleHelper->getCustomDataEnable('socialmetatag/twitter/card_data_' . $i . '_formatprice')) {
                                    $price = $this->priceHelper->currency($currentProduct->getSpecialPrice(), true, false);
                                } else {
                                    $price = $specialPrice = $currentProduct->getSpecialPrice();
                                }

                                $tags['twitter:data' . $i] = $price;
                            } elseif ($content == 'sku') {
                                $sku = $currentProduct->getSku();
                                $tags['twitter:data' . $i] = $sku;
                            } elseif ($content == 'is_in_stock') {
                                if ($stockItem) {
                                    $stock = 'instock';
                                } else {
                                    $stock = 'oos';
                                }
                                $tags['twitter:data' . $i] = $stock;
                            } else {
                                $tags['twitter:data' . $i] = $this->moduleHelper->getCustomDataEnable('socialmetatag/twitter/card_data_' . $i);
                            }
                            $tags['twitter:label' . $i] = $this->moduleHelper->getCustomDataEnable('socialmetatag/twitter/card_data_' . $i . '_label');
                        }
                    }
                } elseif ($currentCategory) {
                    $title = $currentCategory->getData('twitter_meta_title');
                    $desc = $currentCategory->getData('twitter_meta_description');

                    if (empty($title)) {
                        $title = $currentCategory->getMetaTitle();
                    }
                    if (empty($title)) {
                        $title = $currentCategory->getName();
                    }
                    if (empty($desc)) {
                        $desc = $currentCategory->getMetaDescription();
                    }
                    if (empty($desc)) {
                        $desc = $this->coreHelper->categoryAttribute($currentCategory, $currentCategory->getDescription(), 'description');
                    }

                    if (strlen($desc) > 300) {
                        $desc = substr($desc, 0, 300);
                    }

                    $title = strip_tags(htmlspecialchars($title));
                    $desc = strip_tags(htmlspecialchars($desc));

                    $url = $this->urlInterface->getCurrentUrl();

                    if (!empty($currentCategory->getData('twitter_share_image'))) {
                        $twitterImg = $mediaUrl . 'catalog/category/' . $currentCategory->getData('twitter_share_image');
                    } elseif (!empty($this->moduleHelper->getTwitterFBackImg())) {
                        $twitterImg = $mediaUrl . 'socialmetatags/' . $this->moduleHelper->getTwitterFBackImg();
                    } elseif (!empty($currentCategory->getImageUrl())) {
                        $twitterImg = $currentCategory->getImageUrl();
                    } else {
                        $twitterImg = '';
                    }
                } elseif ($this->request->getModuleName() == 'cms') {
                    $title = strip_tags(htmlspecialchars($this->cmsPage->getData('twitter_meta_title')));
                    $desc = strip_tags(htmlspecialchars($this->cmsPage->getData('twitter_meta_description')));

                    if (empty($title)) {
                        $title = $this->cmsPage->getMetaTitle();
                    }
                    if (empty($title)) {
                        $title = $this->cmsPage->getTitle();
                    }
                    if (empty($desc)) {
                        $desc = $this->cmsPage->getMetaDescription();
                    }
                    if (empty($desc)) {
                        $desc = $this->cmsPage->getContent();
                    }
                    if (strlen($desc) > 300) {
                        $desc = substr($desc, 0, 300);
                    }

                    $title = strip_tags(htmlspecialchars($title));
                    $desc = strip_tags(htmlspecialchars($desc));

                    $url = $this->urlInterface->getCurrentUrl();

                    if (!empty($this->cmsPage->getData('twitter_share_image'))) {
                        $twitterImg = $mediaUrl . 'catalog/tmp/category/' . $this->cmsPage->getData('twitter_share_image');
                    } elseif (!empty($this->moduleHelper->getTwitterFBackImg())) {
                        $twitterImg = $mediaUrl . 'socialmetatag/' . $this->moduleHelper->getTwitterFBackImg();
                    } else {
                        $twitterImg = '';
                    }
                }

                $tags['twitter:creator'] = $twitterAuthorName;
                $tags['twitter:card'] = $cardType;
                $tags['twitter:site'] = $twitterUserName;
                $tags['twitter:image'] = $twitterImg;
                if (file_exists($twitterImg) || !empty($twitterImg)) {
                    if (getimagesize($twitterImg)) {
                        $ImageSize = getimagesize($twitterImg);
                        $tags['twitter:image:width'] = $ImageSize[0];
                        $tags['twitter:image:height'] = $ImageSize[1];
                    }
                }
                $tags['twitter:title'] = $title;
                $tags['twitter:description'] = $desc;
                $tags['twitter:url'] = $url;
            } catch (\Exception $e) {
                ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($e->getMessage());
            }
        }
        return $tags;
    }

    public function getProductAvailableStatus($id, $sku)
    {
        if (version_compare($this->getMagentoVersion->getVersion(), '2.3.0', '<')) {
            $this->stockRegistry = ObjectManager::getInstance()->get('Magento\CatalogInventory\Api\StockRegistryInterface');
            try {
                $isStock = $this->stockItemRepository->get($id)->getIsInStock();
                return $isStock;
            } catch (\Exception $e) {
                $productStockObj = $this->stockRegistry->getStockItem($id);
                $isStock = $productStockObj->getIsInStock();
                return $isStock;
            }
        } else {
            try {
                $objectManager = ObjectManager::getInstance();
                $getSalableQuantityDataBySku = $objectManager->create('\Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku');

                $productAvailableQuantity = null;
                if (isset($getSalableQuantityDataBySku->execute($sku)[0]['qty'])) {
                    $productAvailableQuantity = $getSalableQuantityDataBySku->execute($sku)[0]['qty'];
                }
                if ($productAvailableQuantity != null && $productAvailableQuantity > 0) {
                    return true;
                } else {
                    return false;
                }
            } catch (\Exception $e) {
                ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($e->getMessage());
            }
        }
    }
}
