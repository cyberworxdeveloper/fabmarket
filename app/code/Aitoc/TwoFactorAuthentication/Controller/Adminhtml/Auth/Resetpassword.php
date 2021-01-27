<?php
/**
 * @author Aitoc Team
 * @copyright Copyright (c) 2019 Aitoc (https://www.aitoc.com)
 * @package Aitoc_TwoFactorAuthentication
 */

namespace Aitoc\TwoFactorAuthentication\Controller\Adminhtml\Auth;

class Resetpassword extends \Aitoc\TwoFactorAuthentication\Controller\Adminhtml\Auth
{
    /**
     * @var \Aitoc\TwoFactorAuthentication\Model\Authentication
     */
    protected $authModel;
    
    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $authStorage;
     
    /**
     * @var \Magento\Security\Model\AdminSessionsManager
     */
    protected $authManager;
    
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\User\Model\UserFactory $userFactory
     * @param \Aitoc\TwoFactorAuthentication\Model\Authentication $authModel
     * @param \Aitoc\TwoFactorAuthentication\Model\Ip $ipModel
     * @param \Aitoc\TwoFactorAuthentication\Model\User $user
     * @param \Magento\Backend\Model\Auth\Session $authStorage
     * @param \Magento\Security\Model\AdminSessionsManager $authManager
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\User\Model\UserFactory $userFactory,
        \Aitoc\TwoFactorAuthentication\Model\Authentication $authModel,
        \Aitoc\TwoFactorAuthentication\Model\Ip $ipModel,
        \Aitoc\TwoFactorAuthentication\Model\User $user,
        \Magento\Backend\Model\Auth\Session $authStorage,
        \Magento\Security\Model\AdminSessionsManager $authManager
    ) {
        parent::__construct(
            $context,
            $userFactory,
            $authModel,
            $ipModel,
            $user
        );
        $this->authModel   = $authModel;
        $this->authStorage = $authStorage;
        $this->authManager = $authManager;
    }

    /**
     * Send admin one time password action
     *
     * @return void
     */
    public function execute()
    {
        $user     = $this->authStorage->getTfaUser();
        $extUser  = $this->user->loadOriginal($user->getId());
        $password = (string)$this->getRequest()->getPost('password');

        if (!$this->ipModel->userIpRestricted($extUser)) {
            // show verification form
            if ($this->authStorage->getNeedVerification()) {
                $this->authStorage->setNeedVerification(false);
            
                $this->messageManager->getMessages(true);
                $this->messageManager->addSuccess(
                    __('The email with verification code has been succesfully sent to your account address.')
                );

                $this->_view->loadLayout();
                $this->_view->renderLayout();
                return;
            } elseif (!$this->authModel->userRestricted($extUser, $password)) {
                $this->authStorage
                    ->setTfaUser(null)
                    ->setUser($user)
                    ->processLogin();
                
                if ($this->authStorage->isLoggedIn()) {
                    $this->authManager->processLogin();
                    return $this->_homeRedirect();
                }
            }
        }
        
        $this->messageManager->addErrorMessage(
            __('You did not sign in correctly or access restricted.')
        );
        return $this->_homeRedirect();
    }
    
    protected function _homeRedirect($url = null)
    {
        if (is_null($url)) {
            $url = $this->_objectManager->get(\Magento\Backend\Helper\Data::class)->getHomePageUrl();
        }
        return $this->getResponse()->setRedirect($url);
    }
}