<?php
namespace Magebytes\ZipCodeValidator\Model;

use Magento\Framework\App\RequestInterface;

class ZipFilter extends \Magento\Framework\View\Element\Template
{

	/**
     * @var ZipCodeFactory
     */
    protected $zipCodeFactory;
    
    /**
     * @var RequestInterface
     */
    protected $request;

    public function __construct(
        \Magebytes\ZipCodeValidator\Model\ZipCodeFactory $zipCodeFactory,
        \Magento\Backend\Block\Template\Context $context,
        RequestInterface $request,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->zipCodeFactory = $zipCodeFactory;
    }

    public function getZipCodeData() {
    	$zipcode = $this->getRequest()->getParam('zipcode');
 		return $zipcode;
    }

    public function getZipCollection()
    {	
    	$zipcode = $this->getZipCodeData();
    	$resultPage = $this->zipCodeFactory->create();
        $collection = $resultPage->getCollection();
        $collection = $collection->addFieldToSelect('zip_code')->addFieldToFilter('zip_code',['eq' => $zipcode])->addFieldToFilter('status',array('eq'=>'1'));
        return $collection;
    }
}