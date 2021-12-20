<?php
namespace Lof\MarketPlace\Controller\Adminhtml\Group\InlineEdit;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Adminhtml\Group\InlineEdit
 */
class Interceptor extends \Lof\MarketPlace\Controller\Adminhtml\Group\InlineEdit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Cms\Api\PageRepositoryInterface $groupRepository, \Magento\Framework\Controller\Result\JsonFactory $jsonFactory, \Lof\MarketPlace\Model\Group $groupModel)
    {
        $this->___init();
        parent::__construct($context, $groupRepository, $jsonFactory, $groupModel);
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
