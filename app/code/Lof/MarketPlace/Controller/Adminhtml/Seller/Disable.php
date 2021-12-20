<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://www.landofcoder.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_MarketPlace
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\MarketPlace\Controller\Adminhtml\Seller;

class Disable extends \Magento\Backend\App\Action
{
    protected $helper;

    protected $sender;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Lof\MarketPlace\Helper\Data $helper,
        \Lof\MarketPlace\Model\Sender $sender
        ) {
        $this->sender = $sender;
        $this->helper = $helper;
        parent::__construct($context);
    }
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lof_MarketPlace::seller_enable');
    }

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be disapproved
        $id = $this->getRequest()->getParam('seller_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create('Lof\MarketPlace\Model\Seller');
                $model->load($id);
                $title = $model->getTitle();
                $data = $model->getData();
                $data['url'] = $model->getUrl();
                $model->setStatus(0)->save();

                if($this->helper->getConfig('email_settings/enable_send_email')) {
                    $this->sender->unapproveSeller($data);
                }
                // display success message
                $this->messageManager->addSuccess(__('The seller has been disapproved.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['seller_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a seller to disapproved.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }

}