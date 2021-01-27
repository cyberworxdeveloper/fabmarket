<?php
namespace Vgroup65\Testimonial\Controller\Adminhtml\Testimonial;
use Vgroup65\Testimonial\Controller\Adminhtml\Testimonial;

class Edit extends Testimonial{

    public function execute(){
        $newsId = $this->getRequest()->getParam('id');
        
        $model = $this->_testimonialFactory->create();
        if($newsId){
            $model->load($newsId);
            if(!$model->getId()){
                $this->_messageManager->addError('This id is no longer exist');
                $this->_redirect('*/*/');
                return;
            }   
        }
        
        $this->_coreRegistry->register('vgroup_testimonial', $model);
        
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Vgroup65_Testimonial::main_menu');
        $resultPage->getConfig()->getTitle()->prepend(__(($newsId)?'Edit Client':'Add Client'));
        return $resultPage;
        
    }
    
}