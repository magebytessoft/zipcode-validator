<?php
/**
 * Created By : Magebytes Pvt. Ltd.
 */

namespace Magebytes\ZipCodeValidator\Model;

use Magento\Framework\Model\AbstractModel;
use Magebytes\ZipCodeValidator\Model\ResourceModel\ZipCode as ResourceModel;

class ZipCode extends AbstractModel
{
    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}