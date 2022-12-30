<?php

/**
 * Created By : Magebytes Pvt. Ltd.
 */

namespace Magebytes\ZipCodeValidator\ViewModel;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\Element\Template\Context;
use Magebytes\ZipCodeValidator\Helper\Data as DataHelper;

/**
 * @package Magebytes\ZipCodeValidator\ViewModel
 */

class Data implements ArgumentInterface
{
    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     * @param DataHelper $dataHelper
     */
    public function __construct(
        Context $context,
        Registry $registry,
        DataHelper $dataHelper,
        $data = []
    ) {
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
