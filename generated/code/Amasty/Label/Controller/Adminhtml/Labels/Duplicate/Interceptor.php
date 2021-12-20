<?php
namespace Amasty\Label\Controller\Adminhtml\Labels\Duplicate;

/**
 * Interceptor class for @see \Amasty\Label\Controller\Adminhtml\Labels\Duplicate
 */
class Interceptor extends \Amasty\Label\Controller\Adminhtml\Labels\Duplicate implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Filesystem $filesystem, \Magento\Framework\Filesystem\Io\File $ioFile, \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory, \Amasty\Label\Helper\Shape $shapeHelper, \Psr\Log\LoggerInterface $logger, \Amasty\Base\Model\Serializer $serializer, \Amasty\Label\Model\RuleFactory $ruleFactory, \Amasty\Label\Model\Indexer\LabelIndexer $labelIndexer, \Amasty\Label\Helper\Config $config, \Amasty\Label\Api\LabelRepositoryInterface $labelRepository, \Magento\Framework\Escaper $escaper)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $resultPageFactory, $filesystem, $ioFile, $fileUploaderFactory, $shapeHelper, $logger, $serializer, $ruleFactory, $labelIndexer, $config, $labelRepository, $escaper);
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
