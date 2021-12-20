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
 * @copyright  Copyright (c) 2014 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\MarketPlace\Controller\Adminhtml\Message;

use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{

    /**
     * @param Action\Context $context
     */
    public function __construct(Action\Context $context)
    {
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
    	return $this->_authorization->isAllowed('Lof_MarketPlace::message_save');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
    	$data = $this->getRequest()->getPostValue();

    	/** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
    	$resultRedirect = $this->resultRedirectFactory->create();
    	if ($data) {
    		$model = $this->_objectManager->create('Lof\MarketPlace\Model\MessageAdmin');

    		$id = $this->getRequest()->getParam('message_id');

            if ($id) {
                $model->load($id);
            }

            $_data =  $model->getData();
            $_data['message'] = $data['message'];
            // init model and set data
            $model->setData($_data);
           
           // try {
                $model->save();
            
                $this->messageManager->addSuccess(__('You saved this message.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['message_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
           /* } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the message.'));
            }*/

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['message_id' => $this->getRequest()->getParam('message_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}