<?php

namespace Meetanshi\SocialMetaTag\Model\System\Config\Backend;

use Magento\Config\Model\Config\Backend\Image as CoreImage;

/**
 * Class Image
 * @package Meetanshi\SocialMetaTag\Model\System\Config\Backend
 */
class Image extends CoreImage
{
    /**
     *
     */
    const UPLOAD_DIR = 'socialmetatags';

    /**
     * @return string
     */
    protected function _getUploadDir()
    {
        return $this->_mediaDirectory->getAbsolutePath($this->_appendScopeInfo(self::UPLOAD_DIR));
    }

    /**
     * @return bool
     */
    protected function _addWhetherScopeInfo()
    {
        return true;
    }

    /**
     * @return array|string[]
     */
    protected function _getAllowedExtensions()
    {
        return ['jpg', 'jpeg', 'gif', 'png', 'svg'];
    }
}
