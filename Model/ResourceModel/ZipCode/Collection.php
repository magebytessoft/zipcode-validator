<?php

/**
 * Created By : Magebytes Pvt. Ltd.
 */

namespace Magebytes\ZipCodeValidator\Model\ResourceModel\ZipCode;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magebytes\ZipCodeValidator\Model\ZipCode as Model;
use Magebytes\ZipCodeValidator\Model\ResourceModel\ZipCode as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}