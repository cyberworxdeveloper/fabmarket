<?php
/**
 * @author Aitoc Team
 * @copyright Copyright (c) 2019 Aitoc (https://www.aitoc.com)
 * @package Aitoc_TwoFactorAuthentication
 */

/**
 * Copyright © 2016 Aitoc. All rights reserved.
 */
namespace Aitoc\TwoFactorAuthentication\Model;

use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;

class Ip extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var RemoteAddress
     */
    private $remoteAddress;
    
    /**
     * @param RemoteAddress $remoteAddress
     */
    public function __construct(
        RemoteAddress $remoteAddress
    ) {
        $this->remoteAddress = $remoteAddress;
    }
    
    /**
     * Retrieve User IP
     *
     * @return string
     */
    public function getCurrentIp()
    {
        return $this->remoteAddress->getRemoteAddress();
    }
    
    /**
     * Search IP in specified list of IP's
     *
     * @param string $ip
     * @param string $ipList
     * @return bool
     */
    public function searchIpList($ip, $ipList)
    {
        $ipArray = explode(' ', $ipList);
        
        foreach ($ipArray as $ipItem) {
            if ($ipItem == $ip) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Verify IP
     *
     * @param mixed $data
     *
     * @return bool
     */
    public function userIpRestricted($data)
    {
        $ipList  = $data->getIpList();
        
        if (!empty($ipList) &&
            !$this->searchIpList($this->getCurrentIp(), $ipList)
        ) {
            return true;
        }
        return false;
    }
}