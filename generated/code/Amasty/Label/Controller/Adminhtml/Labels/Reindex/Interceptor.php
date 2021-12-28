<?php
namespace Amasty\Label\Controller\Adminhtml\Labels\Reindex;

/**
 * Interceptor class for @see \Amasty\Label\Controller\Adminhtml\Labels\Reindex
 */
class Interceptor extends \Amasty\Label\Controller\Adminhtml\Labels\Reindex implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Psr\Log\LoggerInterface $logger, \Amasty\Label\Model\Indexer\LabelIndexer $labelIndexer)
    {
        $this->___init();
        parent::__construct($context, $logger, $labelIndexer);
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
