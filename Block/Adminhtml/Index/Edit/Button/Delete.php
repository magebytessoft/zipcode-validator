<?php

/**
 * Created By : Magebytes Pvt. Ltd.
 */

namespace Magebytes\ZipCodeValidator\Block\Adminhtml\Index\Edit\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Delete extends Generic implements ButtonProviderInterface
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @param Context $context
     * @param AuthorRepositoryInterface $authorRepository
     */

    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    /**
     * get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        $id = $this->context->getRequest()->getParam('entity_id');
        if ($id) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        $id = $this->context->getRequest()->getParam('entity_id');
        return $this->getUrl('*/*/delete', ['entity_id' => $id]);
    }
}
