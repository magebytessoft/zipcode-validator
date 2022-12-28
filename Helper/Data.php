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
     *
     */
    const CONFIG_IS_ENABLED = 'zipcodevalidator/magebytes_zipcodes/is_enabled';
    /**
     *
     */
    const CONFIG_ZIPCODES = 'zipcodevalidator/magebytes_zipcodes/zipcodes';
    /**
     *
     */
    const CONFIG_SUCCESS_MESSAGE = 'zipcodevalidator/magebytes_zipcodes/success_message_code';
    /**
     *
     */
    const CONFIG_ERROR_MESSAGE = 'zipcodevalidator/magebytes_zipcodes/error_message_code';

    /**
     * @var ScopeConfig
     */
    protected $_scopeConfig;

    /**
     * Data constructor.
     * @param Context $context
     * @param ScopeConfig $scopeConfig
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
        $this->_scopeConfig = $context->getScopeConfig();
    }

    /**
     * @param $storePath
     * @return mixed
     */
    public function getStoreConfig($storePath)
    {
        return $this->_scopeConfig->getValue(
            $storePath,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getZipCodes()
    {
        return trim(self::getStoreConfig(self::CONFIG_ZIPCODES));
    }

    /**
     * @return mixed
     */
    public function getSuccessMessage()
    {
        return self::getStoreConfig(self::CONFIG_SUCCESS_MESSAGE);
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return self::getStoreConfig(self::CONFIG_ERROR_MESSAGE);
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return self::getStoreConfig(self::CONFIG_IS_ENABLED);
    }
}
