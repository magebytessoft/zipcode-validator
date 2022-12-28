<?php
/**
 * Created By : Magebytes Pvt. Ltd.
 */
namespace Magebytes\ZipCodeValidator\Controller\Adminhtml\ZipCode;

use Magento\Backend\App\Action;
use Magebytes\ZipCodeValidator\Model\ZipCode;
use Magento\Backend\Model\Session;

class Save extends \Magento\Backend\App\Action
{
    protected $zipCode;
    protected $adminsession;

    public function __construct(
        Action\Context $context,
        ZipCode $zipCode,
        Session $adminsession
    ) {
        parent::__construct($context);
        $this->zipCode = $zipCode;
        $this->adminsession = $adminsession;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $id = $this->getRequest()->getParam('entity_id');

            if ($id) {
                $this->zipCode->load($id);
            }

            $this->zipCode->setData($data);

            try {
                $this->zipCode->save();
                $this->messageManager->addSuccess(__('The zipcode has been saved.'));
                $this->adminsession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/add');
                    } else {
                        return $resultRedirect->setPath(
                            'mbzipcode/zipcode/index',
                            [
                                'entity_id' => $this->zipCode->getId(),
                                '_current' => true
                            ]
                        );
                    }
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the zipcode.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
