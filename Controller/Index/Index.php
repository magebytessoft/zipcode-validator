<?php

/**
 * Created By : Magebytes Pvt. Ltd.
 */

namespace Magebytes\ZipCodeValidator\Controller\Index;

use Magebytes\ZipCodeValidator\Helper\Data as DataHelper;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magebytes\ZipCodeValidator\Model\ZipCodeFactory;

/*
 * Class Index
 * @package Magebytes\ZipCodeValidator\Controller\Index
 */

class Index extends Action
{
    protected $zipCodeFactory;    
    /**
     * @var ProductModel
     */
    protected $_productModel;
    /**
     * @var DataHelper
     */
    protected $_helper;

    /**
     * ZipChecker constructor.
     * @param Context $context
     * @param ProductFactory $productFactory
     * @param DataHelper $dataHelper
     */

    public function __construct(
        Context $context,
        ProductFactory $productFactory,
        DataHelper $dataHelper,
        ZipCodeFactory $zipCodeFactory
    ) {
        parent::__construct($context);
        $this->productFactory = $productFactory;
        $this->dataHelper = $dataHelper;
        $this->zipCodeFactory = $zipCodeFactory;
    }

    public function execute()
    {

        $zipcode = $this->getRequest()->getParam('zipcode');
        $resultPage = $this->zipCodeFactory->create();
        $collection = $resultPage->getCollection();
        $collection = $collection->addFieldToSelect('zip_code')->addFieldToFilter('zip_code',['eq' => $zipcode])->addFieldToFilter('status',array('eq'=>'1'));
        $response = [];
        try {
            if(!$this->getRequest()->isAjax()){
                throw new \Exception("Invalid Request. Try again.");
            }

            if(!$zipcode = $this->getRequest()->getParam('zipcode')){
                throw new \Exception("Pease enter zipcode");
            }

            $productId = $this->getRequest()->getParam('id', 0);
            $product = $this->productFactory->create()->load($productId);

            if(!$product->getId()){
                throw new \Exception("Product not found");
            }

            $zipData = $collection->getData();
            if($zipData){
                $response['type'] = 'success';
                $response['message'] = __($this->dataHelper->getSuccessMessage(),$zipcode); 
                $response['isActive'] = __($this->dataHelper->getIsActive(),$zipcode); 
                $response['zipValid'] = $zipData;
            } else {
                $response['type'] = 'error';
                $response['message'] = __($this->dataHelper->getErrorMessage(),$zipcode);
            }
        } catch (\Exception $e) {
            $response['type'] = 'error';
            $response['message'] = $e->getMessage();
        }
        $this->getResponse()->setContent(json_encode($response));
    }
}
