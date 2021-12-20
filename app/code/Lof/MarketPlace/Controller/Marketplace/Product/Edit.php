<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lof\MarketPlace\Controller\Marketplace\Product;

use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Store\Model\StoreFactory;
use Magento\Cms\Model\Wysiwyg as WysiwygModel;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Edit extends \Magento\Framework\App\Action\Action 
{
    /**
     * Array of actions which can be processed without secret key validation
     *
     * @var array
     */
    protected $_publicActions = ['edit'];

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $productBuilder;

    const FLAG_IS_URLS_CHECKED = 'check_url_settings';
    
    protected $_frontendUrl;

    /**
     * @var \Magento\Framework\App\ActionFlag
     */
    protected $_actionFlag;
    /**
     *
     * @var Magento\Framework\App\Action\Session
     */
    protected $session;
      /**
     *
     * @var Lof\MarketPlace\Helper\Data
     */
    protected $helper;
        /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $wysiwygConfig;
        /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;
    /**
     * 
     * @param \Lof\Vendors\App\Action\Context $context
     * @param ProductFactory $productFactory
     * @param \Lof\Vendors\App\ConfigInterface $config
     * @param Registry $coreRegistry
     * @param Date $dateFilter
     * @param \Magento\Catalog\Controller\Adminhtml\Product\Builder $productBuilder
     * @param \Magento\Catalog\Controller\Adminhtml\Product\Initialization\StockDataFilter $stockFilter
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
       ProductFactory $productFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Url $frontendUrl,
        Registry $registry,
        \Magento\Customer\Model\Session $customerSession, 
        \Lof\MarketPlace\Helper\Data $helper,
         StoreFactory $storeFactory = null,
       ProductRepositoryInterface $productRepository = null,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        parent::__construct($context);
        $this->productRepository = $productRepository ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->get(ProductRepositoryInterface::class);
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->_frontendUrl = $frontendUrl;
        $this->registry = $registry;
        $this->_actionFlag = $context->getActionFlag();
        $this->session           = $customerSession;
        $this->helper = $helper;
         $this->_url = $context->getUrl();
         $this->storeFactory = $storeFactory ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Store\Model\StoreFactory::class);
    }
    public function getFrontendUrl($route = '', $params = []){
        return $this->_frontendUrl->getUrl($route,$params);
    }
    /**
     * Redirect to URL
     * @param string $url
     * @return \Magento\Framework\App\ResponseInterface
     */
    protected function _redirectUrl($url){
        $this->getResponse()->setRedirect($url);
        $this->session->setIsUrlNotice($this->_actionFlag->get('', self::FLAG_IS_URLS_CHECKED));
        return $this->getResponse();
    }
    /**
     * Product edit form
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $customerSession = $this->session;
        if(!$customerSession->isLoggedIn()) {
            $this->messageManager->addNotice(__( 'You must have a seller account to access' ) );
            $this->_redirectUrl ($this->getFrontendUrl('lofmarketplace/seller/login'));
        }

        $productId = (int) $this->getRequest()->getParam('id');
        if($productId) {
            //$sellerId = $this->helper->getSellerIdByProduct($productId);
            $sellerId = $this->helper->getSellerId();
            if($this->helper->getSellerId() !=  $sellerId) {
                $this->messageManager->addNotice(__( 'That product is not yours' ) );
                return $this->_redirect(
                'catalog/product'
                );
            }
        }
        $storeId = $this->getRequest()->getParam('store');
        if(!$storeId) {
            $storeId = 0;
        }
        
       $product = $this->productRepository->getById($productId, true, $storeId);

        /*if ($attributeSetId) {
            $product->setAttributeSetId($attributeSetId);
        }*/

        if ($productId && !$product->getId()) {
            $this->messageManager->addError(__('This product no longer exists.'));
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('catalog/*/');
        }

        $store = $this->storeFactory->create();
        //$store->load($product->getStoreId());
        $store->load(0);
        $this->registry->register('product', $product);
        $this->registry->register('current_product', $product);
         $this->registry->register('current_store', $store);
        // $this->wysiwygConfig->setStoreId(0);
         $resultPage = $this->resultPageFactory->create();
          $title = $resultPage->getConfig()->getTitle();
            $title->prepend(__("Catalog"));
            $title->prepend(__("Manage Products"));
            $title->prepend($product->getName());
            // $breadCrumbBlock = $resultPage->getLayout()->getBlock('breadcrumbs');
            // $breadCrumbBlock->addLink(__("Catalog"), __("Catalog"))
            //     ->addLink(__("Manage Products"), __("Manage Products"),$this->getUrl('catalog/product'))
            //     ->addLink($product->getName(), $product->getName());

        if (!$this->_objectManager->get('Magento\Store\Model\StoreManagerInterface')->isSingleStoreMode()
            &&
            ($switchBlock = $resultPage->getLayout()->getBlock('store_switcher'))
        ) {
            $switchBlock->setDefaultStoreName(__('Default Values'))
                ->setWebsiteIds($product->getWebsiteIds())
                ->setSwitchUrl(
                     $this->_url->getUrl(
                        'catalog/product/*/*',
                        ['_current' => true, 'active_tab' => null, 'tab' => null, 'store' => null]
                    )
                );
        }

        $block = $resultPage->getLayout()->getBlock('catalog.wysiwyg.js');
        if ($block) {
            $block->setStoreId(0);
        }
        return $resultPage;
    }
    
}
