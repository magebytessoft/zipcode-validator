<?php
/**
 * Created By : Magebytes Pvt. Ltd.
 */
namespace Magebytes\ZipCodeValidator\Controller\Adminhtml\ZipCode;

use Magento\Framework\Controller\ResultFactory;

class Read extends \Magento\Backend\App\Action
{
    /**
     * CSV 
     *
     * @var \Magento\Framework\File\Csv
     */
    protected $csv;

    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    protected $file;

    /**
     * @var \Magebytes\ZipCodeValidator\Model\ZipCodeFactory
     */
    protected $zipCodeFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\File\Csv                      $csv
     * @param \Magento\Framework\Filesystem\Driver\File        $file
     * @param \Magebytes\ZipCodeValidator\Model\ZipCodeFactory $zipCodeFactory
     * @param array                                            $data
    */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\File\Csv $csv,
        \Magebytes\ZipCodeValidator\Model\ZipCodeFactory $zipCodeFactory,
        \Magento\Framework\Filesystem\Driver\File $file
    ) {
        $this->csv = $csv;
        $this->file = $file;
        $this->zipCodeFactory = $zipCodeFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $file = $this->getRequest()->getFiles('import_csv');
        $csvData = $this->getCsvData($file);
    }

    public function getCsvData($file)
    {
        $csvDataAll = $this->csv->getData($file['tmp_name']);

        foreach ($csvDataAll as $row => $data) 
        {
            if($row > 0) 
            {
                $arrayData = [
                    'country_id' => $data[0],
                    'state' => $data[1],
                    'city' => $data[2],
                    'zip_code' => $data[3],
                    'status' => $data[4]
                ];

                if (!$arrayData) 
                {
                    $this->_redirect('mbzipcode/zipcode/read');
                    return;
                }

                try {
                    $rowData = $this->zipCodeFactory->create();
                    $rowData->setData($arrayData);
                    $rowData->save();
                    $this->messageManager->addSuccess(__('ZipCode has been successfully saved.'));
                } catch (\Exception $e) 
                {
                    $this->messageManager->addError(__($e->getMessage()));
                }
                $this->_redirect('mbzipcode/zipcode/index');
            }
        }
    }
}
