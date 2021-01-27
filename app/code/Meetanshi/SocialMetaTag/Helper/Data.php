<?php

namespace Meetanshi\SocialMetaTag\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Meetanshi\SocialMetaTag\Helper
 */
class Data extends AbstractHelper
{
    const BUNDLE_PRODUCT_PRICE_TYPE = 'socialmetatag/general/product_price_bundled';
    const PRODUCT_IMAGE_FALLBACK_ORDER = 'socialmetatag/general/product_img_fallback_order';
    const PRODUCT_IMAGE_FALLBACK_ORDER_CUSTOM = 'socialmetatag/general/product_img_fallback_order_custom';
    const SOCIAL_META_TAG_ENABLED = 'socialmetatag/general/enabled';

    const FACEBOOK_ENABLED = 'socialmetatag/facebook/enabled';
    const FACEBOOK_APP_ID = 'socialmetatag/facebook/app_id';
    const FACEBOOK_PRODUCT_TYPE = 'socialmetatag/facebook/use_product_type';
    const FACEBOOK_FALLBACK_IMAGE = 'socialmetatag/facebook/og_fallback_image';

    const TWITTER_ENABLED = 'socialmetatag/twitter/enabled';
    const TWITTER_USERNAME = 'socialmetatag/twitter/card_site';
    const TWITTER_AUTHOR = 'socialmetatag/twitter/card_creator';
    const TWITTER_CARD_TYPE_CMS = 'socialmetatag/twitter/card_type_cms';
    const TWITTER_CARD_TYPE_CATEGORY = 'socialmetatag/twitter/card_type_category';
    const TWITTER_CARD_TYPE_PRODUCT = 'socialmetatag/twitter/card_type_product';
    const TWITTER_THUMBNAIL_SUMMARY_IMAGE = 'socialmetatag/twitter/force_thumbnail_summary';
    const TWITTER_THUMBNAIL_PRODUCT_IMAGE = 'socialmetatag/twitter/force_thumbnail_product';
    const TWITTER_FALLBACK_IMAGE = 'socialmetatag/twitter/last_fallback_image';

    /**
     * Data constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context
    )
    {
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function isEnableSocialMetaTag()
    {
        return $this->scopeConfig->getValue(
            self::SOCIAL_META_TAG_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getBundledProductPriceType()
    {
        return $this->scopeConfig->getValue(
            self::BUNDLE_PRODUCT_PRICE_TYPE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getProductImageFbackOrder()
    {
        return $this->scopeConfig->getValue(
            self::PRODUCT_IMAGE_FALLBACK_ORDER,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getProductImageFbackCustomOrder()
    {
        return $this->scopeConfig->getValue(
            self::PRODUCT_IMAGE_FALLBACK_ORDER_CUSTOM,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function isEnableOpenGraph()
    {
        return $this->scopeConfig->getValue(
            self::FACEBOOK_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function isFacebookProductType()
    {
        return $this->scopeConfig->getValue(
            self::FACEBOOK_PRODUCT_TYPE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getFacebookFBackImg()
    {
        return $this->scopeConfig->getValue(
            self::FACEBOOK_FALLBACK_IMAGE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getFacebookAppId()
    {
        return $this->scopeConfig->getValue(
            self::FACEBOOK_APP_ID,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function isTwitterEnabled()
    {
        return $this->scopeConfig->getValue(
            self::TWITTER_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getTwitterUserName()
    {
        return $this->scopeConfig->getValue(
            self::TWITTER_USERNAME,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getTwitterAuthor()
    {
        return $this->scopeConfig->getValue(
            self::TWITTER_AUTHOR,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getTwitterCardCms()
    {
        return $this->scopeConfig->getValue(
            self::TWITTER_CARD_TYPE_CMS,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getTwitterCardCategory()
    {
        return $this->scopeConfig->getValue(
            self::TWITTER_CARD_TYPE_CATEGORY,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getTwitterCardProduct()
    {
        return $this->scopeConfig->getValue(
            self::TWITTER_CARD_TYPE_PRODUCT,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function isTwitterSummaryThumb()
    {
        return $this->scopeConfig->getValue(
            self::TWITTER_THUMBNAIL_SUMMARY_IMAGE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function isTwitterProductThumb()
    {
        return $this->scopeConfig->getValue(
            self::TWITTER_THUMBNAIL_PRODUCT_IMAGE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getTwitterFBackImg()
    {
        return $this->scopeConfig->getValue(
            self::TWITTER_FALLBACK_IMAGE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @param $path
     * @return mixed
     */
    public function getCustomDataEnable($path)
    {
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE
        );
    }
}
