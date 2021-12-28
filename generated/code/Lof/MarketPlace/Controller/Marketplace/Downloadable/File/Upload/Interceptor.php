<?php
namespace Lof\MarketPlace\Controller\Marketplace\Downloadable\File\Upload;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Marketplace\Downloadable\File\Upload
 */
class Interceptor extends \Lof\MarketPlace\Controller\Marketplace\Downloadable\File\Upload implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Downloadable\Model\Link $link, \Magento\Downloadable\Model\Sample $sample, \Magento\Downloadable\Helper\File $fileHelper, \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory, \Magento\MediaStorage\Helper\File\Storage\Database $storageDatabase)
    {
        $this->___init();
        parent::__construct($context, $link, $sample, $fileHelper, $uploaderFactory, $storageDatabase);
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
