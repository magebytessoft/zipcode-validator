<?php

/**
 * Created By : Magebytes Pvt. Ltd.
 */

namespace Magebytes\ZipCodeValidator\Controller\Index;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResponseInterface;
class ExportCsv extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;
    /**
     * @var \Magebytes\ZipCodeValidator\Model\ZipCodeFactory
     */
    protected $zipCodeFactory;
    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $resultLayoutFactory;
    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csvProcessor;
    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $directoryList;
    /**
     * @param \Magento\Framework\App\Action\Context            $context
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magebytes\ZipCodeValidator\Model\ZipCodeFactory $zipCodeFactory
     * @param \Magento\Framework\View\Result\LayoutFactory     $resultLayoutFactory
     * @param \Magento\Framework\File\Csv                      $csvProcessor
     * @param \Magento\Framework\App\Filesystem\DirectoryList  $directoryList
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magebytes\ZipCodeValidator\Model\ZipCodeFactory $zipCodeFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Framework\File\Csv $csvProcessor,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList
    ) {
        $this->fileFactory = $fileFactory;
        $this->zipCodeFactory = $zipCodeFactory;
        $this->resultLayoutFactory = $resultLayoutFactory;
        $this->csvProcessor = $csvProcessor;
        $this->directoryList = $directoryList;
        parent::__construct($context);
    }
    /**
     * CSV Create and Download
     *
     * @return ResponseInterface
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function execute()
    {
        /** Add yout header name here */
        $content[] = [
            'entity_id' => __('Entity ID'),
            'country_id' => __('Country ID'),
            'state' => __('State'),
            'city' => __('City'),
            'zip_code' => __('Zip Code'),
            'status' => __('Status'),
            'created_at' => __('Created At'),
            'updated_at' => __('Updated At'),
        ];
        $resultLayout = $this->resultLayoutFactory->create();
        $product = $this->zipCodeFactory->create()->getCollection();
        $collection = $this->zipCodeFactory->create()->getCollection();
        
        $fileName = 'zipcode.csv'; // Add Your CSV File name
        $filePath =  $this->directoryList->getPath(DirectoryList::MEDIA) . "/" . $fileName;
        while ($product = $collection->fetchItem()) {
            $content[] = [
                $product->getEntityId(),
                $product->getCountryId(),
                $product->getState(),
                $product->getCity(),
                $product->getZipCode(),
                $product->getStatus(),
                $product->getCreatedAt(),
                $product->getUpdatedAt()
            ];
        }
        $this->csvProcessor->setEnclosure('"')->setDelimiter(',')->saveData($filePath, $content);
        return $this->fileFactory->create(
            $fileName,
            [
                'type'  => "filename",
                'value' => $fileName,
                'rm'    => true,
            ],
            DirectoryList::MEDIA,
            'text/csv',
            null
        );
    }
}