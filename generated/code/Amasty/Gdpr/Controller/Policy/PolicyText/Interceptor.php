<?php
namespace Amasty\Gdpr\Controller\Policy\PolicyText;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Policy\PolicyText
 */
class Interceptor extends \Amasty\Gdpr\Controller\Policy\PolicyText implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Amasty\Gdpr\Api\PolicyRepositoryInterface $policyRepository, \Amasty\Gdpr\Model\Config $configProvider, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Cms\Model\Template\FilterProvider $filterProvider)
    {
        $this->___init();
        parent::__construct($context, $policyRepository, $configProvider, $storeManager, $filterProvider);
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
