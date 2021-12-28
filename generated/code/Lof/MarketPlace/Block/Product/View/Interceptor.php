<?php
namespace Lof\MarketPlace\Block\Product\View;

/**
 * Interceptor class for @see \Lof\MarketPlace\Block\Product\View
 */
class Interceptor extends \Lof\MarketPlace\Block\Product\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Magento\Framework\Url\EncoderInterface $urlEncoder, \Magento\Framework\Json\EncoderInterface $jsonEncoder, \Magento\Framework\Stdlib\StringUtils $string, \Magento\Catalog\Helper\Product $productHelper, \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig, \Magento\Framework\Locale\FormatInterface $localeFormat, \Magento\Customer\Model\Session $customerSession, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency, \Lof\MarketPlace\Model\Vacation $vacation, \Lof\MarketPlace\Helper\Data $sellerHelper, \Lof\MarketPlace\Model\Seller $sellerCollection, \Magento\Framework\App\ResourceConnection $resource, \Lof\MarketPlace\Model\Orderitems $orderitems, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection, \Lof\MarketPlace\Model\ResourceModel\Rating\CollectionFactory $collectionRateFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat, $customerSession, $productRepository, $priceCurrency, $vacation, $sellerHelper, $sellerCollection, $resource, $orderitems, $productCollection, $collectionRateFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function canEmailToFriend()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canEmailToFriend');
        return $pluginInfo ? $this->___callPlugins('canEmailToFriend', func_get_args(), $pluginInfo) : parent::canEmailToFriend();
    }

    /**
     * {@inheritdoc}
     */
    public function getQuantityValidators()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getQuantityValidators');
        return $pluginInfo ? $this->___callPlugins('getQuantityValidators', func_get_args(), $pluginInfo) : parent::getQuantityValidators();
    }

    /**
     * {@inheritdoc}
     */
    public function getImage($product, $imageId, $attributes = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getImage');
        return $pluginInfo ? $this->___callPlugins('getImage', func_get_args(), $pluginInfo) : parent::getImage($product, $imageId, $attributes);
    }
}
