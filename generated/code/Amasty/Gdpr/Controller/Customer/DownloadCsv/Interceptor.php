<?php
namespace Amasty\Gdpr\Controller\Customer\DownloadCsv;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Customer\DownloadCsv
 */
class Interceptor extends \Amasty\Gdpr\Controller\Customer\DownloadCsv implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Amasty\Gdpr\Model\CustomerData $customerData, \Magento\Customer\Model\Session $customerSession, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Filesystem\Driver\File $fileDriver, \Magento\Customer\Model\Authentication $authentication, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Amasty\Gdpr\Model\Config $configProvider, \Amasty\Gdpr\Controller\Result\CsvFactory $csvFactory)
    {
        $this->___init();
        parent::__construct($context, $customerData, $customerSession, $logger, $fileDriver, $authentication, $formKeyValidator, $configProvider, $csvFactory);
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
