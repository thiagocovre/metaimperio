<?php
namespace Amasty\Label\Controller\Ajax\Label;

/**
 * Interceptor class for @see \Amasty\Label\Controller\Ajax\Label
 */
class Interceptor extends \Amasty\Label\Controller\Ajax\Label implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Label\Model\LabelViewer $labelViewer, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Psr\Log\LoggerInterface $logger, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($labelViewer, $productRepository, $logger, $context);
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
