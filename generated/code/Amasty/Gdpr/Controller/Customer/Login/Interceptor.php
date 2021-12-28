<?php
namespace Amasty\Gdpr\Controller\Customer\Login;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Customer\Login
 */
class Interceptor extends \Amasty\Gdpr\Controller\Customer\Login implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Amasty\Gdpr\Model\ConsentQueue\Email $email, \Magento\Customer\Model\Session $customerSession, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Psr\Log\LoggerInterface $logger, \Amasty\Gdpr\Model\ConsentLogger $consentLogger)
    {
        $this->___init();
        parent::__construct($context, $email, $customerSession, $customerRepository, $logger, $consentLogger);
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
