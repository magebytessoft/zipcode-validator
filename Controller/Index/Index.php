<?php

/**
 * Created By : Magebytes Pvt. Ltd.
 */

namespace Magebytes\ZipCodeValidator\Controller\Index;

use Magebytes\ZipCodeValidator\Helper\Data as DataHelper;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magebytes\ZipCodeValidator\Model\ZipFilter;

/*
 * Class Index
 * @package Magebytes\ZipCodeValidator\Controller\Index
 */

class Index extends Action
{ 
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
     * @param ZipFilter $zipFilter
     */

    public function __construct(
        Context $context,
        ProductFactory $productFactory,
        DataHelper $dataHelper,
        ZipFilter $zipFilter
    ) {
        parent::__construct($context);
        $this->productFactory = $productFactory;
        $this->dataHelper = $dataHelper;
        $this->zipFilter = $zipFilter;
    }

    public function execute()
    {
        $response = [];
        try {
            $zipcode = $this->zipFilter->getZipCodeData();
            if(!$this->zipFilter->getZipCodeData()){
                throw new \Exception("Pease enter the zipcode");
            }

            $zipData = $this->zipFilter->getZipCollection()->getData();
            if($zipData){
                $response['type'] = 'success';
                $response['message'] = __($this->dataHelper->getSuccessMessage(),$zipcode);  
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
