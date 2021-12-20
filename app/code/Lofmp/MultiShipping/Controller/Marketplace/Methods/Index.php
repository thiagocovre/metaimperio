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
 
namespace Lofmp\MultiShipping\Controller\Methods;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * Default seller dashboard page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        if(!$this->_getSession()->getSellerId()) {
            return; 
        }
        if(!$this->_objectManager->get('Lofmp\MultiShipping\Helper\Data')->isEnabled()) {
            $this->_redirect('csmarketplace/seller/index');
            return;
        }
        $resultPage = $this->resultPageFactory->create();        
        $resultPage->getConfig()->getTitle()->set(__('Shipping Methods'));
        return $resultPage;
        
    }
}