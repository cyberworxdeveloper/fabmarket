<?php

namespace Vgroup65\Testimonial\Model;

class Testimonial extends \Magento\Framework\Model\AbstractModel {

    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'vgroup_testimonial';

    /**
     * @var string
     */
    protected $_cacheTag = 'vgroup_testimonial';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'vgroup_testimonial';

    /**
     * Initialize resource model.
     */
    protected function _construct() {
        $this->_init('Vgroup65\Testimonial\Model\ResourceModel\Testimonial');
    }

    /**
     * Get EntityId.
     *
     * @return int
     */
//    public function getEntityId() {
//        return $this->getData(self::ENTITY_ID);
//    }
//
//    /**
//     * Set EntityId.
//     */
//    public function setEntityId($entityId) {
//        return $this->setData(self::ENTITY_ID, $entityId);
//    }
//
//    /**
//     * Get Title.
//     *
//     * @return varchar
//     */
//    public function getFirstName() {
//        return $this->getData(self::FIRST_NAME);
//    }
//
//    /**
//     * Set Title.
//     */
//    public function setFirstName($title) {
//        return $this->setData(self::FIRST_NAME, $title);
//    }
//
//    /**
//     * Get getContent.
//     *
//     * @return varchar
//     */
//    public function getLastName() {
//        return $this->getData(self::LAST_NAME);
//    }
//
//    /**
//     * Set Content.
//     */
//    public function setLastName($content) {
//        return $this->setData(self::LAST_NAME, $content);
//    }
//
//    /**
//     * Get PublishDate.
//     *
//     * @return varchar
//     */
//    public function getPublishDate() {
//        return $this->getData(self::PUBLISH_DATE);
//    }
//
//    /**
//     * Set PublishDate.
//     */
//    public function setPublishDate($publishDate) {
//        return $this->setData(self::PUBLISH_DATE, $publishDate);
//    }
//
//    /**
//     * Get IsActive.
//     *
//     * @return varchar
//     */
//    public function getStatus() {
//        return $this->getData(self::STATUS);
//    }
//
//    /**
//     * Set IsActive.
//     */
//    public function setStatus($isActive) {
//        return $this->setData(self::STATUS, $isActive);
//    }
//
//    /**
//     * Get UpdateTime.
//     *
//     * @return varchar
//     */
//    public function getUpdateTime() {
//        return $this->getData(self::UPDATE_TIME);
//    }
//
//    /**
//     * Set UpdateTime.
//     */
//    public function setUpdateTime($updateTime) {
//        return $this->setData(self::UPDATE_TIME, $updateTime);
//    }
//
//    /**
//     * Get CreatedAt.
//     *
//     * @return varchar
//     */
//    public function getCreatedAt() {
//        return $this->getData(self::CREATED_AT);
//    }
//
//    /**
//     * Set CreatedAt.
//     */
//    public function setCreatedAt($createdAt) {
//        return $this->setData(self::CREATED_AT, $createdAt);
//    }

}

//namespace Vgroup65\Testimonial\Model;
//
//class Testimonial extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface {
//
//    const CACHE_TAG = 'vgroup_testimonial';
//    protected $_cacheTag = 'vgroup_testimonial';
//    protected $_eventPrefix = 'vgroup_testimonial';
//
//    protected function _construct() {
//        $this->_init('Vgroup65\Testimonial\Model\ResourceModel\Testimonial');
//    }
//
//    public function getIdentities() {
//        return [self::CACHE_TAG . '_' . $this->getId()];
//    }
//
//    public function getDefaultValues() {
//        $values = [];
//        return $values;
//    }
//
//}
