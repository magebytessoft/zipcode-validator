<?php

/**
 * Created By : Magebytes Pvt. Ltd.
 */

namespace Magebytes\ZipCodeValidator\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Magebytes\ZipCodeValidator\Helper
 */

class Data extends AbstractHelper
{

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * @param $storePath
     * @return mixed
     */
    public function getConfigValue($field)
    {
        return $this->scopeConfig->getValue($field, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getZipCodes()
    {
        return trim($this->getConfigValue('zipcodevalidator/magebytes_zipcodes/zipcodes'));
    }

    /**
     * @return mixed
     */
    public function getSuccessMessage()
    {
        return $this->getConfigValue('zipcodevalidator/magebytes_zipcodes/success_message_code');
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->getConfigValue('zipcodevalidator/magebytes_zipcodes/error_message_code');
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->getConfigValue('zipcodevalidator/magebytes_zipcodes/is_enabled');
    }
}
