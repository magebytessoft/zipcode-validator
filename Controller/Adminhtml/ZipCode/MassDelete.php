<?php
/**
 * Created By : Magebytes Pvt. Ltd.
 */
namespace Magebytes\ZipCodeValidator\Controller\Adminhtml\ZipCode;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magebytes\ZipCodeValidator\Model\ResourceModel\ZipCode\CollectionFactory;
use Magebytes\ZipCodeValidator\Model\ZipCode;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $filter;
    protected $collectionFactory;
    protected $zipCode;

    public function __construct(Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ZipCode $zipCode
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->zipCode = $zipCode;
        parent::__construct($context);
    }

    public function execute()
    {
        $values = $this->collectionFactory->create();

        foreach ($values as $value) {
            $valueId[]=$value['entity_id'];
        }
        $parameterData = $this->getRequest()->getParams('entity_id');
        $parameterId = $this->getRequest()->getParams('entity_id');
        if (array_key_exists("selected", $parameterData)) {
            $parameterId = $parameterData['selected'];
        }
        if (array_key_exists("excluded", $parameterData)) {
            if ($parameterData['excluded'] == 'false') {
                $parameterId = $valueId;
            } else {
                $parameterId = array_diff($valueId, $parameterData['excluded']);
            }
        }
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('entity_id', ['in'=>$parameterId]);
        $delete = 0;
        $model=[];
        foreach ($collection as $item) {
            $this->deleteById($item->getId());
            $delete++;
        }
        $this->messageManager->addSuccess(__('A total of %1 ZipCodes have been deleted.', $delete));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * [deleteById description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteById($id){
        $item = $this->zipCode->load($id);
        $item->delete();
        return;
    }
}
