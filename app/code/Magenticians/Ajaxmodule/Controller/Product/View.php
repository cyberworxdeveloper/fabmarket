<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenticians\Ajaxmodule\Controller\Product;



use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class View
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param RequestInterface $request
     * @param ProductRepositoryInterface $productRepository
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        RequestInterface $request,
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storeManager
    ) {
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
    }

    public function afterExecute(
        \Magento\Catalog\Controller\Product\View $subject,
        $resultPage
    ) {
		
		
        if ($resultPage instanceof ResultInterface) {
            $productId = (int) $this->request->getParam('id');
            if ($productId) {
                try {
                    $product = $this->productRepository->getById($productId, false, $this->storeManager->getStore()->getId());
					
					 $product_detail_type= $product->getResource()->getAttribute('product_detail_type')->getFrontend()->getValue($product); 
                    if ($product_detail_type =='Artists') {
						//echo "test ".$product_detail_type;
                      // $pageConfig = $resultPage->getConfig();
                      // $pageConfig->setPageLayout('2columns-right'); //Set your page layout here.	
                    }else
					{
						//echo "test ".$product_detail_type;
                       // $pageConfig = $resultPage->getConfig();
                       // $pageConfig->setPageLayout('catalog_product_view_style04_type_downloadable'); //Set your page layout here.
					}
                } catch (NoSuchEntityException $e) {
                	// Add you exception message here.
                }
            }
        }
        return $resultPage;
    }
}