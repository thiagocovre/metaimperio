<?php
namespace Amasty\Label\Controller\Adminhtml\Labels\MassEnable;

/**
 * Interceptor class for @see \Amasty\Label\Controller\Adminhtml\Labels\MassEnable
 */
class Interceptor extends \Amasty\Label\Controller\Adminhtml\Labels\MassEnable implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Label\Model\ResourceModel\Labels\CollectionFactory $collectionFactory, \Amasty\Label\Model\Indexer\LabelIndexer $labelIndexer, \Amasty\Label\Api\LabelRepositoryInterface $labelRepository, \Psr\Log\LoggerInterface $logger, \Magento\Ui\Component\MassAction\Filter $filter)
    {
        $this->___init();
        parent::__construct($context, $collectionFactory, $labelIndexer, $labelRepository, $logger, $filter);
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
