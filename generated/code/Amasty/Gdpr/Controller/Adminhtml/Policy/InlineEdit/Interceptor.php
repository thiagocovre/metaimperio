<?php
namespace Amasty\Gdpr\Controller\Adminhtml\Policy\InlineEdit;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Adminhtml\Policy\InlineEdit
 */
class Interceptor extends \Amasty\Gdpr\Controller\Adminhtml\Policy\InlineEdit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Gdpr\Api\PolicyRepositoryInterface $repository, \Amasty\Gdpr\Model\ResourceModel\Policy $policy, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($repository, $policy, $context);
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
