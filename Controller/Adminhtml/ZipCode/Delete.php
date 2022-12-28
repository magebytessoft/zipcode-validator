<?php
/**
 * Created By : Magebytes Pvt. Ltd.
 */
namespace Magebytes\ZipCodeValidator\Controller\Adminhtml\ZipCode;

use Magento\Backend\App\Action;

class Delete extends Action
{
    protected $modelJob;

    public function __construct(
        Action\Context $context,
        \Magebytes\ZipCodeValidator\Model\ZipCode $model
    ) {
        parent::__construct($context);
        $this->modelJob = $model;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('grid_customform::index_delete');
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->modelJob;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Record deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }
        $this->messageManager->addError(__('Record does not exist'));
        return $resultRedirect->setPath('*/*/');
    }
}
