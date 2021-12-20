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

namespace Lof\MarketPlace\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Model\ProductFactory;


class CustomerLogin implements ObserverInterface
{
    /**
     * Product Factory
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productFactory;
    
    protected $_cacheTypeList;
    /**
     * Constructor
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param Date $dateFilter
     */
    public function __construct(
        ProductFactory $productFactory,
        \Magento\Framework\View\Element\Context $context, 
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList, 
        array $data = []
    ) {
         $this->_cacheTypeList       = $cacheTypeList;
        $this->_productFactory = $productFactory;

    }
    
    /**
     * Set the vendor id in bulk for product
     * 
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

       $this->_cacheTypeList->cleanType('full_page');
     $this->_cacheTypeList->cleanType('block_html');
     $this->_cacheTypeList->cleanType('config');
    }
    
    
}
