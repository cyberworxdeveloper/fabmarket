<?php
namespace Fabmarket\Subscribedetails\Controller\Adminhtml\Index;
use Magento\Framework\App\Filesystem\DirectoryList;
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
	public function execute()
    {
		
       // $data = $this->getRequest()->getParams();
		$nextdate="";
        $data = $this->getRequest()->getParams();		
		/*date_default_timezone_set('Asia/Kolkata');
		if($data['frequency']=="daily")
		{
			$date = $data['subscriptiondate'];
			$nextdate = strtotime(date("Y-m-d", strtotime($date)) . " +1 day");
		}
		else if($data['frequency']=="weekly")
		{
			$date = $data['subscriptiondate'];
			$nextdate = strtotime(date("Y-m-d", strtotime($date)) . " +1 week");
		}
		else if($data['frequency']=="monthly")
		{
			$date = $data['subscriptiondate'];
			$nextdate = strtotime(date("Y-m-d", strtotime($date)) . " +1 month");			
		}
		// current date
		if($nextdate!="")
		{
			$newshowdate=date("Y-m-d",$nextdate);
			$data['nextepisodedate']=$newshowdate;
		}*/
        if ($data) {
            $model = $this->_objectManager->create('Fabmarket\Subscribedetails\Model\Index');
		
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
