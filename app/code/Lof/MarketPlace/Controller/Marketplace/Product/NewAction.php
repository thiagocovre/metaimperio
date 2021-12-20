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

namespace Lof\MarketPlace\Controller\Marketplace\Product;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Catalog\Model\ProductFactory;
use Magento\Store\Model\StoreFactory;
use Magento\Catalog\Model\Product;
//use Magento\Cms\Model\Wysiwyg as WysiwygModel;

class NewAction extends \Magento\Framework\App\Action\Action  
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
     * @var \Lof\MarketPlace\Model\SellerFactory 
     */
    protected $sellerFactory;

    const FLAG_IS_URLS_CHECKED = 'check_url_settings';
    
    protected $_frontendUrl;

    /**
     * @var \Magento\Framework\App\ActionFlag
     */
    protected $_actionFlag;

    protected $productBuilder;
     /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $wysiwygConfig;

    /**
     *
     * @param Context $context            
     * @param Magento\Framework\App\Action\Session $customerSession            
     * @param PageFactory $resultPageFactory            
     */
    public function __construct(
        Context $context, 
        \Magento\Customer\Model\Session $customerSession, 
        \Lof\MarketPlace\Model\SellerFactory $sellerFactory,
        \Lof\MarketPlace\Model\GroupFactory $groupFactory,
        \Magento\Framework\Url $frontendUrl,
        Registry $registry,
        ProductFactory $productFactory,
        StoreFactory $storeFactory = null,
        \Lof\MarketPlace\Helper\Data $helper,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct ($context);
        $this->registry = $registry;
        $this->_frontendUrl = $frontendUrl;
        $this->_actionFlag = $context->getActionFlag();
        $this->sellerFactory     = $sellerFactory;
        $this->session           = $customerSession;
        $this->resultPageFactory = $resultPageFactory;
        $this->productFactory = $productFactory;
        $this->request = $request;
        $this->helper = $helper;
        $this->groupFactory = $groupFactory;
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
     * Customer login form page
     *
     * @return \Magento\Framework\Controller\Result\Redirect|\Magento\Framework\View\Result\Page
     */
    public function execute() {
        //Get Object Manager Instance
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $localeInterface = $objectManager->create('Magento\Framework\Locale\ResolverInterface');
        $localeInterface->setLocale('de_DE');
        // $localeInterface->loadData();
        $customerSession = $this->session;
        $customerId = $customerSession->getId();
        $seller = $this->sellerFactory->create()->load($customerId,'customer_id');
        $status = $seller->getStatus();
        
        if ($customerSession->isLoggedIn() && $status == 1) {
            if($this->helper->isEnableModule('Lofmp_SellerMembership')) {
                $group = $this->groupFactory->create()->load($seller->getData('group_id'),'group_id');
                $limit_product = $group->getData('limit_product');
                $product_count = $seller->getData('product_count');
                if($limit_product > 0 && $limit_product <= $product_count) {
                    $this->messageManager->addNotice(__( 'Your product limit is %1, please upgrade the membership package',$limit_product) );
                    $result = $this->_redirect('catalog/product/');
                    return $result;
                }
            }
            //$product = $this->productBuilder->build($this->getRequest());
            $request = $this->request;
            $productId = (int) $request->getParam('id');
            $storeId = $request->getParam('store', 0);
            $attributeSetId = (int) $request->getParam('set');
            $typeId = $request->getParam('type');
            $product = $this->createEmptyProduct($typeId, $attributeSetId, $storeId);
            $store = $this->storeFactory->create();
            $store->load($storeId);

            $this->registry->register('product', $product);
            $this->registry->register('current_product', $product);
            $this->registry->register('current_store', $store);
            $this->_eventManager->dispatch('catalog_product_new_action', ['product' => $product]);
            //$this->wysiwygConfig->setStoreId($storeId);
            $resultPage = $this->resultPageFactory->create();
            return $resultPage;
        } elseif($customerSession->isLoggedIn() && $status == 0) {
            $this->_redirectUrl ( $this->getFrontendUrl('lofmarketplace/seller/becomeseller') );
        } else {
            $this->messageManager->addNotice(__( 'You must have a seller account to access' ) );
            $this->_redirectUrl ($this->getFrontendUrl('lofmarketplace/seller/login'));
        }
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
