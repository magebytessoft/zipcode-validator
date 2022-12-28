<?php

/**
 * Created By : Magebytes Pvt. Ltd.
 */

namespace Magebytes\ZipCodeValidator\Block\Product\View;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magebytes\ZipCodeValidator\Helper\Data as DataHelper;

/**
 * Class Data
 * @package Magebytes\ZipCodeValidator\Block\Product\View
 */

class Data extends Template
{
    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * ZipChecker constructor.
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        DataHelper $dataHelper,
        $data = []
    ) {
        parent::__construct($context, $data);
        $this->_registry = $registry;
        $this->dataHelper = $dataHelper;
    }

    /**
     * @return mixed
     */
    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }
    
    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->dataHelper->getIsActive();
    }
}
