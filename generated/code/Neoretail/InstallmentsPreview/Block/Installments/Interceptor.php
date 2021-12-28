<?php
namespace Neoretail\InstallmentsPreview\Block\Installments;

/**
 * Interceptor class for @see \Neoretail\InstallmentsPreview\Block\Installments
 */
class Interceptor extends \Neoretail\InstallmentsPreview\Block\Installments implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Magento\Framework\Stdlib\ArrayUtils $arrayUtils, \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency, \Neoretail\InstallmentPrice\Helper\Data $helperInstallmentPrice, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $arrayUtils, $priceCurrency, $helperInstallmentPrice, $data);
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
