<?php
namespace Lof\MarketPlace\Controller\Marketplace\Index\Render;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Marketplace\Index\Render
 */
class Interceptor extends \Lof\MarketPlace\Controller\Marketplace\Index\Render implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Lof\MarketPlace\App\Action\Context $context, \Magento\Framework\View\Element\UiComponentFactory $factory)
    {
        $this->___init();
        parent::__construct($context, $factory);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        return $pluginInfo ? $this->___callPlugins('dispatch', func_get_args(), $pluginInfo) : parent::dispatch($request);
    }
}
