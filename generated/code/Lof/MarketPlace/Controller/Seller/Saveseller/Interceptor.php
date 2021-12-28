<?php
namespace Lof\MarketPlace\Controller\Seller\Saveseller;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Seller\Saveseller
 */
class Interceptor extends \Lof\MarketPlace\Controller\Seller\Saveseller implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $session, \Lof\MarketPlace\Model\Seller $seller, \Lof\MarketPlace\Model\Sender $sender, \Lof\MarketPlace\Model\ResourceModel\Group\Collection $groupCollection, \Lof\MarketPlace\Helper\Data $sellerHelper)
    {
        $this->___init();
        parent::__construct($context, $session, $seller, $sender, $groupCollection, $sellerHelper);
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
