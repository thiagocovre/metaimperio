<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lofmp_Dhlshipping
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
  
 
namespace Lofmp\MultiShipping\Controller\Marketplace\Settings;
use Magento\Framework\App\Action\Context;
class Save extends \Magento\Framework\App\Action\Action
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
    /**
     *
     * @param Context $context            
     * @param Magento\Framework\App\Action\Session $customerSession            
     * @param PageFactory $resultPageFactory            
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context, 
        \Magento\Customer\Model\Session $customerSession, 
        \Lof\MarketPlace\Model\SellerFactory $sellerFactory,
        \Magento\Framework\Url $frontendUrl,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct ($context);

        $this->_frontendUrl = $frontendUrl;
         $this->_actionFlag = $context->getActionFlag();
        $this->sellerFactory     = $sellerFactory;
        $this->session           = $customerSession;
        $this->resultPageFactory = $resultPageFactory;
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
    } 
    /**
     * Default seller dashboard page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $customerSession = $this->session;
        $customerId = $customerSession->getId();
        $helper = $this->_objectManager->get('Lof\MarketPlace\Helper\Data');
        if(!$customerSession->isLoggedIn()) {
            $this->_redirectUrl('catalog/dashboard');
            return;
        }
        
        
        $section = $this->getRequest()->getParam('section', '');
        $groups = $this->getRequest()->getPost('groups', array());

        if(strlen($section) > 0 && count($groups)>0) {
            $seller_id = (int)$helper->getSellerId();  
            try {
                $this->_objectManager->get('Lofmp\MultiShipping\Helper\Data')->saveShippingData($section, $groups, $seller_id);
                $this->messageManager->addSuccess(__('The Shipping Methods has been saved.'));
                $this->_redirect('*/*/index');
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_redirect('*/*/index');
                return;
            }
        }
        $this->_redirect('*/*/index');        
    }
}
