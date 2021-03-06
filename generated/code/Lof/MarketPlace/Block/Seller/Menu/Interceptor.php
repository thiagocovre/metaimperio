<?php
namespace Lof\MarketPlace\Block\Seller\Menu;

/**
 * Interceptor class for @see \Lof\MarketPlace\Block\Seller\Menu
 */
class Interceptor extends \Lof\MarketPlace\Block\Seller\Menu implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Backend\Model\Menu\Filter\IteratorFactory $iteratorFactory, \Magento\Backend\Model\Auth\Session $authSession, \Magento\Backend\Model\Menu\Config $menuConfig, \Magento\Framework\Locale\ResolverInterface $localeResolver, \Lof\MarketPlace\Model\Menu\Config $config, \Lof\MarketPlace\Model\SellerFactory $sellerFactory, \Lof\MarketPlace\Helper\Data $helper, \Magento\Backend\Block\AnchorRenderer $anchorRenderer, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $iteratorFactory, $authSession, $menuConfig, $localeResolver, $config, $sellerFactory, $helper, $anchorRenderer, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function renderNavigation($menu, $level = 0, $limit = 0, $colBrakes = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'renderNavigation');
        return $pluginInfo ? $this->___callPlugins('renderNavigation', func_get_args(), $pluginInfo) : parent::renderNavigation($menu, $level, $limit, $colBrakes);
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
