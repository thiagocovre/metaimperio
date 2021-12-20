<?php
namespace Lof\MarketPlace\Controller\Marketplace\Product\Gallery\RetrieveImage;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Marketplace\Product\Gallery\RetrieveImage
 */
class Interceptor extends \Lof\MarketPlace\Controller\Marketplace\Product\Gallery\RetrieveImage implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Magento\Catalog\Model\Product\Media\Config $mediaConfig, \Magento\Framework\Filesystem $fileSystem, \Magento\Framework\Image\AdapterFactory $imageAdapterFactory, \Magento\Framework\HTTP\Adapter\Curl $curl, \Magento\MediaStorage\Model\ResourceModel\File\Storage\File $fileUtility)
    {
        $this->___init();
        parent::__construct($context, $resultRawFactory, $mediaConfig, $fileSystem, $imageAdapterFactory, $curl, $fileUtility);
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
