<?php
namespace Magento\Checkout\Block\Cart\Grid;

/**
 * Interceptor class for @see \Magento\Checkout\Block\Cart\Grid
 */
class Interceptor extends \Magento\Checkout\Block\Cart\Grid implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Catalog\Model\ResourceModel\Url $catalogUrlBuilder, \Magento\Checkout\Helper\Cart $cartHelper, \Magento\Framework\App\Http\Context $httpContext, \Magento\Quote\Model\ResourceModel\Quote\Item\CollectionFactory $itemCollectionFactory, \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $joinProcessor, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $customerSession, $checkoutSession, $catalogUrlBuilder, $cartHelper, $httpContext, $itemCollectionFactory, $joinProcessor, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function toHtml()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toHtml');
        return $pluginInfo ? $this->___callPlugins('toHtml', func_get_args(), $pluginInfo) : parent::toHtml();
    }
}
