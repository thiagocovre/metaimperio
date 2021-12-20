<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lof\MarketPlace\Controller\Marketplace\Product;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreFactory;
use Magento\Framework\Registry;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
/**
 * Backend reload of product create/edit form
 */
class Reload extends \Magento\Framework\App\Action\Action  
{
    /**
     *
     * @var Magento\Framework\App\Action\Session
     */
    protected $session;
    
    /**
     *
     * @var Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
      /**
     *
     * @var Lof\MarketPlace\Helper\Data
     */
    protected $helper;

    /**
     *
     * @param Context $context            
     * @param Magento\Framework\App\Action\Session $customerSession            
     * @param PageFactory $resultPageFactory            
     */
    public function __construct(
        Context $context, 
        Registry $registry,
         StoreFactory $storeFactory = null,
         ProductFactory $productFactory,
        \Lof\MarketPlace\Helper\Data $helper,
        \Magento\Customer\Model\Session $customerSession, 
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->session           = $customerSession;
        $this->resultPageFactory = $resultPageFactory;
        $this->helper = $helper;
        $this->registry = $registry;
        $this->request = $request;
         $this->productFactory = $productFactory;
         $this->storeFactory = $storeFactory ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Store\Model\StoreFactory::class);
        parent::__construct ($context);
    }
    /**
     * {@inheritdoc}
     */
    public function execute()
    {

        if (!$this->getRequest()->getParam('set')) {
            return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('noroute');
        }
        $productId = (int) $this->getRequest()->getParam('id');
        /** @var \Magento\Framework\View\Result\Layout $resultLayout */
        $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
        if($productId) {
            $product = $this->helper->getProductById($productId);
        } else {
            $request = $this->request;
            $storeId = $request->getParam('store', 0);
            $attributeSetId = (int) $request->getParam('set');
            $typeId = $request->getParam('type');
            $product = $this->createEmptyProduct($typeId, $attributeSetId, $storeId);
        }
            $store = $this->storeFactory->create();
            $store->load($product->getStoreId());
            $this->registry->register('product', $product);
            $this->registry->register('current_product', $product);
            $this->registry->register('current_store', $store);
            
            $resultLayout->getLayout()->getUpdate()->addHandle(['catalog_product_' . $product->getTypeId()]);
            $resultLayout->getLayout()->getUpdate()->removeHandle('default');
            $resultLayout->setHeader('Content-Type', 'application/json', true);
        
        return $resultLayout;
    }
     /**
     * @param int $typeId
     * @param int $attributeSetId
     * @param int $storeId
     * @return \Magento\Catalog\Model\Product
     */
    public function createEmptyProduct($typeId, $attributeSetId, $storeId): Product
    {
        /** @var $product \Magento\Catalog\Model\Product */
        $product = $this->productFactory->create();
        $product->setData('_edit_mode', true);

        if ($typeId !== null) {
            $product->setTypeId($typeId);
        }

        if ($storeId !== null) {
            $product->setStoreId($storeId);
        }

        if ($attributeSetId) {
            $product->setAttributeSetId($attributeSetId);
        }

        return $product;
    }
}
