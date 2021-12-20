<?php
namespace Lof\MarketPlace\Controller\Adminhtml\Seller\Disable;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Adminhtml\Seller\Disable
 */
class Interceptor extends \Lof\MarketPlace\Controller\Adminhtml\Seller\Disable implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Lof\MarketPlace\Helper\Data $helper, \Lof\MarketPlace\Model\Sender $sender)
    {
        $this->___init();
        parent::__construct($context, $helper, $sender);
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
