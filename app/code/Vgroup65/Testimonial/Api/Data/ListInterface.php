<?php
namespace Vgroup65\Testimonial\Api\Data;
 
interface ListInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ENTITY_ID = 'testimonial_id';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const PUBLISH_DATE = 'publish_date';
    const IS_ACTIVE = 'is_active';
    const UPDATE_TIME = 'update_time';
    const CREATED_AT = 'created_at';
 
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getEntityId();
 
    /**
     * Set EntityId.
     */
    public function setEntityId($entityId);
 
    /**
     * Get Title.
     *
     * @return varchar
     */
    public function getFirstName();
 
    /**
     * Set Title.
     */
    public function setFirstName($title);
 
    /**
     * Get Content.
     *
     * @return varchar
     */
    public function getLastName();
 
    /**
     * Set Content.
     */
    public function setLastName($content);
 
    /**
     * Get Publish Date.
     *
     * @return varchar
     */
    public function getPublishDate();
 
    /**
     * Set PublishDate.
     */
    public function setPublishDate($publishDate);
 
    /**
     * Get IsActive.
     *
     * @return varchar
     */
    public function getIsActive();
 
    /**
     * Set StartingPrice.
     */
    public function setIsActive($isActive);
 
    /**
     * Get UpdateTime.
     *
     * @return varchar
     */
    public function getUpdateTime();
 
    /**
     * Set UpdateTime.
     */
    public function setUpdateTime($updateTime);
 
    /**
     * Get CreatedAt.
     *
     * @return varchar
     */
    public function getCreatedAt();
 
    /**
     * Set CreatedAt.
     */
    public function setCreatedAt($createdAt);
}