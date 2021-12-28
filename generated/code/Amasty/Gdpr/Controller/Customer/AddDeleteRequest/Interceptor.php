<?php
namespace Amasty\Gdpr\Controller\Customer\AddDeleteRequest;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Customer\AddDeleteRequest
 */
class Interceptor extends \Amasty\Gdpr\Controller\Customer\AddDeleteRequest implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Psr\Log\LoggerInterface $logger, \Amasty\Gdpr\Model\DeleteRequestFactory $deleteRequestFactory, \Amasty\Gdpr\Api\DeleteRequestRepositoryInterface $deleteRequestRepository, \Amasty\Gdpr\Model\ActionLogger $actionLogger, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Customer\Model\Authentication $authentication, \Amasty\Gdpr\Model\Config $configProvider, \Amasty\Gdpr\Model\ResourceModel\DeleteRequest\CollectionFactory $deleteRequestCollectionFactory, \Amasty\Gdpr\Model\DeleteRequest\Notifier $notifier)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $logger, $deleteRequestFactory, $deleteRequestRepository, $actionLogger, $formKeyValidator, $authentication, $configProvider, $deleteRequestCollectionFactory, $notifier);
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
