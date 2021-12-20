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
 * @package    Lof_FollowUpEmail
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\MarketPlace\Observer;
use Magento\Framework\Event\ObserverInterface;
class ProductCollectionLoadAfter implements ObserverInterface
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    protected $hideprice;

    protected $_resource;

    protected $helper;

    protected $validator;
    /**
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\App\ResourceConnection $resource         
     */
    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->_resource    = $resource;
    }
	/**
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $collection    = $observer->getCollection();
        $collection->addAttributeToSelect("approval")
                    ->addAttributeToFilter('approval',array('in' => array(0,2)));
    }
}