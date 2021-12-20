<?php
namespace Lof\MarketPlace\Controller\Adminhtml\Seller\MassUnverify;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Adminhtml\Seller\MassUnverify
 */
class Interceptor extends \Lof\MarketPlace\Controller\Adminhtml\Seller\MassUnverify implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Lof\MarketPlace\Model\ResourceModel\Seller\CollectionFactory $collectionFactory, \Lof\MarketPlace\Helper\Data $helper, \Lof\MarketPlace\Model\Sender $sender)
    {
        $this->___init();
        parent::__construct($context, $filter, $collectionFactory, $helper, $sender);
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
