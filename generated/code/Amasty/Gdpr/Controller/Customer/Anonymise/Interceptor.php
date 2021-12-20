<?php
namespace Amasty\Gdpr\Controller\Customer\Anonymise;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Customer\Anonymise
 */
class Interceptor extends \Amasty\Gdpr\Controller\Customer\Anonymise implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Amasty\Gdpr\Model\Anonymizer $anonymizer, \Magento\Customer\Model\Session $customerSession, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Customer\Model\Authentication $authentication, \Amasty\Gdpr\Model\Config $configProvider, \Magento\Framework\App\ProductMetadataInterface $productMetadata, \Amasty\Gdpr\Model\GiftRegistryDataFactory $giftRegistryDataFactory)
    {
        $this->___init();
        parent::__construct($context, $anonymizer, $customerSession, $logger, $formKeyValidator, $authentication, $configProvider, $productMetadata, $giftRegistryDataFactory);
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
