<?php
namespace Magento\Customer\Block\Account\Navigation;

/**
 * Interceptor class for @see \Magento\Customer\Block\Account\Navigation
 */
class Interceptor extends \Magento\Customer\Block\Account\Navigation implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getLinks()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getLinks');
        return $pluginInfo ? $this->___callPlugins('getLinks', func_get_args(), $pluginInfo) : parent::getLinks();
    }
}
