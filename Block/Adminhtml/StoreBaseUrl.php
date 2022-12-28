<?php

/**
 * Created By : Magebytes Pvt. Ltd.
 */

namespace Magebytes\ZipCodeValidator\Block\Adminhtml;

class StoreBaseUrl extends \Magento\Framework\View\Element\Template
{
    protected $_storeManager;    

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,        
        \Magento\Store\Model\StoreManagerInterface $storeManager,        
        array $data = []
    )
    {        
        $this->_storeManager = $storeManager;        
        parent::__construct($context, $data);
    }

    /**
     * Get store identifier
     *
     * @return  int
     */
    public function getStoreUrl()
    {
		$storeBaseUrl = $this->_storeManager->getStore()->getBaseUrl();
		return $storeBaseUrl;
    }
}