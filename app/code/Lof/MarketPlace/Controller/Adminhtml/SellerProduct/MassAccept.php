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
namespace Lof\MarketPlace\Controller\Adminhtml\SellerProduct;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Lof\MarketPlace\Model\ResourceModel\SellerProduct\CollectionFactory;

class MassAccept extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    protected $_productRepository;

    protected $helper;

    protected $sender;
    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        \Magento\Catalog\Model\Product $productRepository,
        CollectionFactory $collectionFactory,
        \Lof\MarketPlace\Helper\Data $helper,
        \Lof\MarketPlace\Model\Sender $sender
        )
    {
        $this->sender = $sender;
        $this->helper = $helper;
        $this->filter = $filter;
        $this->_productRepository = $productRepository;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance ();
        foreach ($collection as $item) {
           $product= $this->_productRepository->load($item->getData('product_id'));
           $product->setApproval(2)->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)->setStoreId(\Magento\Store\Model\Store::DEFAULT_STORE_ID);
            $this->_productRepository->save($product);
           $item->setData('status',2)->save();
           $seller = $this->_objectManager->create('Lof\MarketPlace\Model\Seller')->load($item->getData('seller_id'),'seller_id');
           $data = $item->getData();
           $data['email'] = $seller->getEmail();
            $data['url'] = $seller->getUrl();
           if($this->helper->getConfig('email_settings/enable_send_email')) {
                $this->sender->approveProduct($data);
            }
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been accepted.', $collection->getSize()));
       
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Check the permission to run it
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lof_MarketPlace::sellerproduct_save');
    }
}
