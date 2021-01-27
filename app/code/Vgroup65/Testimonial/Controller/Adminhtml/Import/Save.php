<?php

namespace Vgroup65\Testimonial\Controller\Adminhtml\Import;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vgroup65\Testimonial\Controller\Adminhtml\Testimonial;

class Save extends Testimonial {

    public function execute() {
        $dataFiles = $this->getRequest()->getFiles('testimonial');

        foreach ($dataFiles as $values):
            $fileType = $values['type'];
            $fileTmpName = $values['tmp_name'];
        endforeach;

        //check csv file
        if ($fileType != 'application/vnd.ms-excel' && $fileType != 'text/csv'):
            $this->messageManager->addError('Please import .csv file.');
            $this->_redirect('*/*/');
            return;
        endif;

        $row = 1;

        if (($handle = fopen($fileTmpName, "r")) !== FALSE) {
            $no = 0;
            $checkValidTestimonialId = array();
            $testimonialFileArray = array();
            $checkEmptyFirstNameField = array();
            $checkEmptyLastNameField = array();
            $checkEmptyDesignationField = array();
            $checkEmptyCompanyField = array();
            $checkEmptyTestimonialField = array();
            $checkEmptyCountryField = array();
            $checkImageUrl = array();
            $checkWebsiteUrl = array();
            $checkGender = array();
            $checkStatus = array();
            $checkAge = array();
            $checkValidImageUrl = array();
            $checkImageResolution = array();

            $testimonialModelsInstance = $this->_testimonialFactory->create();
            $count = 0;
            $dataCount = [];
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $rowHasError = 0;
                if ($no == 0):
                    $no++;
                    continue;
                endif;

                $num = count($data);                
                $rowArray = [];
                for ($c = 0; $c < $num; $c++) {
                    //echo $data[$c] . "<br />\n";
                    $rowArray[] = $data[$c];
                }

                //check valid testimonial id
                if (!empty(trim($rowArray[0]))):
                    $testimonialModelCollectionForId = $testimonialModelsInstance->getCollection();
                    $testimonialModelCollectionForId->addFieldToFilter('testimonial_id', trim($rowArray[0]));
                    if ($testimonialModelCollectionForId->count() == 0):
                        $checkValidTestimonialId[] = $no;
                        $rowHasError = 1;
                    endif;
                endif;

                //check first name field
                if (empty($rowArray[1])):
                    $checkEmptyFirstNameField[] = $no;
                    $rowHasError = 1;
                endif;

                //check last name field
                if (empty($rowArray[2])):
                    $checkEmptyLastNameField[] = $no;
                    $rowHasError = 1;
                endif;

                //check Designation field
                if (empty($rowArray[5])):
                    $checkEmptyDesignationField[] = $no;
                    $rowHasError = 1;
                endif;

                //check Company field
                if (empty($rowArray[6])):
                    $checkEmptyCompanyField[] = $no;
                    $rowHasError = 1;
                endif;

                //check Testimonial field
                if (empty($rowArray[8])):
                    $checkEmptyTestimonialField[] = $no;
                    $rowHasError = 1;
                endif;

                //check Country field
                if (empty($rowArray[11])):
                    $checkEmptyCountryField[] = $no;
                    $rowHasError = 1;
                endif;

                //check image url
                if ($rowArray[7]!=''):
                    if (!filter_var(trim($rowArray[7]), FILTER_VALIDATE_URL)):
                        $checkImageUrl[] = $no;
                        $rowHasError = 1;
                    else:
                        if (@getImageSize(trim($rowArray[7]))):
                            $getImageSize = @getImageSize(trim($rowArray[7]));
                            if (!empty($getImageSize) && count($getImageSize) > 0):
                                if ($getImageSize[0] < 200 || $getImageSize[1] < 200):
                                    $checkImageResolution[] = $no;
                                    $rowHasError = 1;
                                endif;
                            endif;

                        else:
                            $checkValidImageUrl[] = $no;
                            $rowHasError = 1;
                        endif;
                    endif;
                endif;

                //check Website url
                if (!empty($rowArray[9])):
                    if (!filter_var(trim($rowArray[9]), FILTER_VALIDATE_URL)):
                        $checkWebsiteUrl[] = $no;
                        $rowHasError = 1;
                    endif;
                endif;

                //check gender
                if (!empty($rowArray[3])):
                    $gender = strtolower(trim($rowArray[3]));
                    if ($gender == 'male' || $gender == 'female'):
                    else:
                        $checkGender[] = $no;
                        $rowHasError = 1;
                    endif;
                endif;

                //check status
                if (!empty($rowArray[14])):
                    $status = strtolower(trim($rowArray[14]));
                    if ($status == 'enabled' || $status == 'disabled'):
                    else:
                        $rowHasError = 1;
                        $checkStatus[] = $no;
                    endif;
                endif;

                //check Age
                if (!empty(trim($rowArray[4]))):
                    if (!is_numeric(trim($rowArray[4]))):
                        $checkAge[] = $no;
                        $rowHasError = 1;
                    endif;
                endif;

                // for data count.
                $dataCount[] = $rowArray;
                if (!$rowHasError) {
                    $testimonialFileArray[] = $rowArray;
                }
                $no++;
            }
            fclose($handle);
            
            if(!$dataCount) {
                $this->messageManager->addError('File is not having any records.');
                $this->_redirect('*/*/');
                return;
            }


            $checkRequiredFields = $this->checkRequiredFields($checkValidTestimonialId, $checkEmptyFirstNameField, $checkEmptyLastNameField, $checkEmptyDesignationField, $checkEmptyCompanyField, $checkEmptyTestimonialField, $checkEmptyCountryField, $checkImageUrl, $checkWebsiteUrl, $checkGender, $checkStatus, $checkValidImageUrl, $checkImageResolution, $checkAge);

            if (!empty($checkRequiredFields)):
                $this->messageManager->addError($checkRequiredFields);
//                $this->_redirect('*/*/');
//                return;
            endif;
        }

        $testimonialModelInstance = $this->_testimonialFactory->create();
        $formData = array();
        try {
            foreach ($testimonialFileArray as $key => $testimonial):
                //update testimonial 
                if (!empty($testimonial[0])):
                    $responce = $this->UpdateTestimonial($testimonial);
                    $count++;
                    if ($responce):
                        continue;
                    endif;
                endif;

                //create testimonial  
                //status value
                $statusForUpdate = 1;
                if (strtolower(trim($testimonial[14])) == 'disabled'):
                    $statusForUpdate = 0;
                endif;

                $imageFormValue = '';
                if (!empty($testimonial[7])):
                    $imageFileValue = trim($testimonial[7]);
                    $imageData = file_get_contents($imageFileValue);
                    $basename = basename($imageFileValue);

                    $fileName = @explode('.', $basename);
                    $fileName[0] = $fileName[0] . date('His');
                    $helper = $this->helper;
                    $baseDir = $helper->getBaseDir();
                    $image = $baseDir . '/' . @implode('.', $fileName);
                    file_put_contents($image, $imageData);
                    $imageFormValue = '/' . @implode('.', $fileName);
                endif;

                $resizeImageFormValue = '';
                if (!empty($testimonial[7])):
                    $resizeImage = $this->resize($imageFormValue, 200, 200);
                    if ($resizeImage):
                        $resizeImageFormValue = '/resize/' . basename($imageFormValue);
                    endif;
                endif;



                try {
                    $formdata = array('first_name' => trim($testimonial[1]),
                    
                        'image' => $imageFormValue,
                        'resize_image' => $resizeImageFormValue,
                        'status' => $statusForUpdate
                    );

                    $testimonialModelInstance->setData($formdata);
                    $responce = $testimonialModelInstance->save();
                    $count++;
                } catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                    $this->_redirect('*/*/');
                    return;
                }
            endforeach;
            if ($count) {
                $this->messageManager->addSuccess(__('Total ' . $count . ' Clients(s) imported successfully.'));
            }
            $this->_redirect('*/*/');
            return;
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_redirect('*/*/');
            return;
        }
    }

    public function UpdateTestimonial($testimonial) {
        //get testimonial list instence
        $testimonialModelInstance = $this->_testimonialFactory->create();
        $testimonialModelInstance->load($testimonial[0]);
        $currentImage = $testimonialModelInstance->getImage();
        $currentResizeImage = $testimonialModelInstance->getResizeImage();
        $helper = $this->helper;
        $baseDir = $helper->getBaseDir();

        $imageFormValue = '';
        //update image 
        if (!empty($testimonial[7])):
            $imageUrl = trim($testimonial[7]);
            $imageData = file_get_contents($imageUrl);
            $basename = basename($imageUrl);
            $fileName = @explode('.', $basename);
            $fileName[0] = $fileName[0] . date('His');
            $image = $baseDir . '/' . @implode('.', $fileName);
            file_put_contents($image, $imageData);
            $imageFormValue = '/' . @implode('.', $fileName);

            if (!empty($currentImage)):
                if (file_exists($baseDir . $currentImage)):
                    unlink($baseDir . $currentImage);
                endif;
            endif;
        endif;

        //resize image
        $resizeimageFormValue = '';
        if (!empty($testimonial[7])):
            $resizeImageResponce = $this->resize($imageFormValue, 200, 200);
            if ($resizeImageResponce):
                $resizeimageFormValue = '/resize/' . basename($imageFormValue);
                //unlink resized image
                if (!empty($currentResizeImage)):
                    if (file_exists($baseDir . $currentResizeImage)):
                        unlink($baseDir . $currentResizeImage);
                    endif;
                endif;
            endif;
        endif;

        //status value
        $statusForUpdate = 1;
        if (strtolower($testimonial[14]) == 'disabled'):
            $statusForUpdate = 0;
        endif;

        $formdata = array('testimonial_id' => $testimonial[0],
            'first_name' => trim($testimonial[1]),
            'image' => $imageFormValue,
            'resize_image' => $resizeimageFormValue,
            'status' => $statusForUpdate
        );

        $testimonialModelInstance->setData($formdata);
        $updateResponce = $testimonialModelInstance->save();
        return true;
    }

    public function checkRequiredFields($checkValidTestimonialId, $checkEmptyFirstNameField, $checkEmptyLastNameField, $checkEmptyDesignationField, $checkEmptyCompanyField, $checkEmptyTestimonialField, $checkEmptyCountryField, $checkImageUrl, $checkWebsiteUrl, $checkGender, $checkStatus, $checkValidImageUrl, $checkImageResolution, $checkAge) {
        $BlnkFieldErrorMsg = '';
        if (!empty($checkValidTestimonialId)):
            $BlnkFieldErrorMsg .= 'Row ' . @implode(',', $checkValidTestimonialId) . ' has Invalid Client Id. <br>';
        endif;
        if (!empty($checkEmptyFirstNameField)):
            $BlnkFieldErrorMsg .= 'Row ' . @implode(',', $checkEmptyFirstNameField) . ' has blank Title  field. <br>';
        endif;
      
    
     
      
        if (!empty($checkImageUrl)):
            $BlnkFieldErrorMsg .= 'Row ' . @implode(',', $checkImageUrl) . ' has Invalid Image Url field. <br>';
        endif;
       
      
     
        if (!empty($checkValidImageUrl)):
            $BlnkFieldErrorMsg .= 'Row ' . @implode(',', $checkValidImageUrl) . ' has Invalid Image Url. <br>';
        endif;

        if (!empty($checkImageResolution)):
            $BlnkFieldErrorMsg .= 'Row ' . @implode(',', $checkImageResolution) . ' has Invalid Image resolution(i.e less then 200*200). <br>';
        endif;

        return $BlnkFieldErrorMsg;
    }

    // pass imagename, width and height
    public function resize($image, $width = 200, $height = 200) {
        $getBaseDir = $this->helper->getBaseDir();
        $absolutePath = $getBaseDir . $image;
        $imageResized = $getBaseDir . '/resize/' . basename($image);

        //create image factory...
        $imageResize = $this->_imageFactory->create();
        $imageResize->open($absolutePath);
        $imageResize->constrainOnly(TRUE);
        $imageResize->keepTransparency(TRUE);
        $imageResize->keepFrame(FALSE);
//        $imageResize->keepAspectRatio(TRUE);         
        $imageResize->resize($width, $height);
        //destination folder                
        $destination = $imageResized;
        //save image      
        $imageResize->save($destination);
        return true;
    }

}
