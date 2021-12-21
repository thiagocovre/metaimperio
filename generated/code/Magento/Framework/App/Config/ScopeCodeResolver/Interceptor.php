<?php
namespace Magento\Framework\App\Config\ScopeCodeResolver;

/**
 * Interceptor class for @see \Magento\Framework\App\Config\ScopeCodeResolver
 */
class Interceptor extends \Magento\Framework\App\Config\ScopeCodeResolver implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\ScopeResolverPool $scopeResolverPool)
    {
        $this->___init();
        parent::__construct($scopeResolverPool);
    }

    /**
     * {@inheritdoc}
     */
    public function resolve($scopeType, $scopeCode)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'resolve');
        return $pluginInfo ? $this->___callPlugins('resolve', func_get_args(), $pluginInfo) : parent::resolve($scopeType, $scopeCode);
    }

    /**
     * {@inheritdoc}
     */
    public function clean()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'clean');
        return $pluginInfo ? $this->___callPlugins('clean', func_get_args(), $pluginInfo) : parent::clean();
    }
}
