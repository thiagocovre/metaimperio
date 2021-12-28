<?php
namespace Amasty\Gdpr\Controller\Adminhtml\Customer\DownloadCsv;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Adminhtml\Customer\DownloadCsv
 */
class Interceptor extends \Amasty\Gdpr\Controller\Adminhtml\Customer\DownloadCsv implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Gdpr\Controller\Result\CsvFactory $csvFactory, \Amasty\Gdpr\Model\CustomerData $customerData)
    {
        $this->___init();
        parent::__construct($context, $csvFactory, $customerData);
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
