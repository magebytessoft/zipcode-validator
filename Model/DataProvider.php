<?php
/**
 * Created By : Magebytes Pvt. Ltd.
 */
namespace Magebytes\ZipCodeValidator\Model;

use Magebytes\ZipCodeValidator\Model\ResourceModel\ZipCode\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $PostCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $PostCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $Job) {
            $this->loadedData[$Job->getId()] = $Job->getData();
        }
        return $this->loadedData;
    }
}
