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

    protected $Custommodel;

    protected $adminsession;


    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\File\Csv                      $csv
     * @param \Magento\Framework\Filesystem\Driver\File        $file
     * @param array                                            $data
    */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\File\Csv $csv,
        \Magebytes\ZipCodeValidator\Model\ZipCodeFactory $Custommodel,
        \Magento\Backend\Model\Session $adminsession,
        \Magento\Framework\Filesystem\Driver\File $file
    ) {
        $this->csv = $csv;
        $this->file = $file;
        $this->Custommodel = $Custommodel;
        $this->adminsession = $adminsession;
        parent::__construct($context);
    }

    public function execute()
    {
        $file = $this->getRequest()->getFiles('import_csv');
        $csvData = $this->getCsvData($file);
    }

    public function getCsvData($file){
        $csvDataAll = $this->csv->getData($file['tmp_name']);
        $resultRedirect = $this->resultRedirectFactory->create();


        foreach ($csvDataAll as $row => $data) 
        {
            if($row > 0) 
            {
                $modelData = [
                    'country_id' => $data[1],
                    'state' => $data[2],
                    'city' => $data[3],
                    'zip_code' => $data[4],
                    'status' => $data[5],
                    'created_at' => $data[6],
                    'updated_at' => $data[7],
                ];


                if (!$modelData) 
                {
                    $this->_redirect('grid/zipcode/read');
                    return;
                }

                try {
                    
                    $rowData = $this->Custommodel->create();
                    $rowData->setData($modelData);
                    $rowData->save();
                    $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
                    } catch (\Exception $e) 
                    {
                        $this->messageManager->addError(__($e->getMessage()));
                    }
                    $this->_redirect('grid/zipcode/index');
        }
    }
}
}
