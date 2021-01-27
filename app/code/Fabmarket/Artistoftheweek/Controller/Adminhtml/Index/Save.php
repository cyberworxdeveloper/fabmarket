<?php
namespace Fabmarket\Artistoftheweek\Controller\Adminhtml\Index;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
	protected $_fileUploaderFactory;
	public function __construct(
		\Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
		 \Magento\Backend\App\Action\Context $context
		 
	) {
 
		$this->_fileUploaderFactory = $fileUploaderFactory;
		parent::__construct($context);
	}
	public function execute()
    {
		
        $data = $this->getRequest()->getParams();
        if ($data) {
            $model = $this->_objectManager->create('Fabmarket\Artistoftheweek\Model\Index');
			if(isset($_FILES['imageurl']['name']) && $_FILES['imageurl']['name'] != '') {
				try{
					$uploader = $this->_fileUploaderFactory->create(['fileId' => 'imageurl']);
			 
					$uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
					 
					$uploader->setAllowRenameFiles(true);
					 
					$uploader->setFilesDispersion(true);

					$path = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();				 
					$result = $uploader->save($path);
					unset($result['tmp_name']);
					unset($result['path']);
					$data['imageurl'] = $result['file'];					
				}
				catch (Exception $e) {
						//$data['image'] = $_FILES['image']['name'];
				}
			}
			else{
				$data['imageurl'] = $data['imageurl']['value'];
			} 
            /* if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
				try {
					    $uploader = $this->_objectManager->create('Magento\Core\Model\File\Uploader', array('fileId' => 'image'));
						$uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
						$uploader->setAllowRenameFiles(true);
						$uploader->setFilesDispersion(true);
						$mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
							->getDirectoryRead(DirectoryList::MEDIA);
						$config = $this->_objectManager->get('Magento\Bannerslider\Model\Banner');
						$result = $uploader->save($mediaDirectory->getAbsolutePath('bannerslider/images'));
						unset($result['tmp_name']);
						unset($result['path']);
						$data['image'] = $result['file'];
				} catch (Exception $e) {
					$data['image'] = $_FILES['image']['name'];
				}
			}
			else{
				$data['image'] = $data['image']['value'];
			} */
			$id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }
			
            $model->setData($data);
			
            try {
                $model->save();
                $this->messageManager->addSuccess(__('The Frist Grid Has been Saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current' => true));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (\Magento\Framework\Model\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the banner.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('banner_id' => $this->getRequest()->getParam('banner_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
}
