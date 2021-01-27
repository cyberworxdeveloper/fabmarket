<?php
namespace Vgroup65\Testimonial\Controller\Adminhtml\Testimonial;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Vgroup65\Testimonial\Helper\Data;
use Vgroup65\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory;

class MassExport extends \Magento\Backend\App\Action {
    
    /**
     * Massactions filter.?_
     * @var Filter
     */
    protected $_filter;
    
    protected $helper;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @param Context           $context
     * @param Filter            $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
    Context $context, Filter $filter, CollectionFactory $collectionFactory, Data $helper
    ) {
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * @return void
     */
    public function execute() {
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());

        /* @var Vgroup65\News\Helper\Data */
        $imageHelper = $this->helper;
        $basePath = $imageHelper->getBaseDir();

        $heading = [
            __('Client ID'),
            __('Title'),
            __('Status')
        ];
        $outputFile = $basePath . "/TestimonialList.csv";
        $handle = fopen($outputFile, 'w');
        fputcsv($handle, $heading);
        foreach ($collection->getItems() as $testimonial) {

            //status
            $status = 'Disabled';
            if ($testimonial->getData('status') == '1'):
                $status = 'Enabled';
            endif;

            //image 
            $testimonialImageValue = '';
            $testimonialImage = $testimonial->getData('image');
            if (!empty($testimonialImage)):
                if (!filter_var($testimonialImage, FILTER_VALIDATE_URL)):
                    $getBaseUrl = $imageHelper->getBaseUrl();
                    $testimonialImageValue = $getBaseUrl . $testimonialImage;
                endif;
            endif;

            $row = [
                $testimonial->getData('testimonial_id'),
                $testimonial->getData('first_name'),
                $status
            ];
            fputcsv($handle, $row);
        }
        $this->downloadCsv($outputFile);
    }

    public function downloadCsv($file) {
        if (file_exists($file)) {
            //set appropriate headers
            header('Content-Description: File Transfer');
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

}
