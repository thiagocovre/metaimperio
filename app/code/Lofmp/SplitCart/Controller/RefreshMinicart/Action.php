<?php

namespace Lofmp\SplitCart\Controller\RefreshMinicart;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;

/**
 * Class Action
 * @package Lofmp\SplitCart\Controller\RefreshMinicart
 */
class Action extends \Magento\Framework\App\Action\Action
{

    private $resultJsonFactory;

    private $resultForwardFactory;

    /**
     * Action constructor.
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        if($this->getRequest()->isAjax()) {
            return $result->setData(['Message' => 'Success']);
        }

        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('cms/noroute/index');
    }
}