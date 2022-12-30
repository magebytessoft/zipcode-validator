<?php 

namespace Magebytes\ZipCodeValidator\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class State extends \Magento\Ui\Component\Listing\Columns\Column
{
	/**
     * @var \Magento\Directory\Model\RegionFactory
     */
	protected $regionFactory;

	/**
     * Factory for UI Component
     *
     * @var UiComponentFactory
     */
    protected $uiComponentFactory;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Directory\Model\RegionFactory $regionFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->regionFactory = $regionFactory;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
            	if (is_numeric($item['state'])) {
            		$resultPage = $this->regionFactory->create();
            		$collection = $resultPage->getCollection();
            		$collectionData = $collection->addFieldToFilter('main_table.region_id',array('eq'=> $item['state']));
            		if ($collectionData) {
            			$item['state'] = $collectionData->getData()[0]['name'];
            		}
            	}
            }
        }
        return $dataSource;
    }
}