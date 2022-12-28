<?php

/**
 * Created By : Magebytes Pvt. Ltd.
 */

namespace Magebytes\ZipCodeValidator\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ZipCode extends AbstractDb
{
    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('mb_zipcodevalidator', 'entity_id');
    }
}