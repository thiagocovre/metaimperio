<?php
namespace Lof\MarketPlace\Controller\Router;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Router
 */
class Interceptor extends \Lof\MarketPlace\Controller\Router implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\ActionFactory $actionFactory, \Magento\Framework\App\ResponseInterface $response, \Magento\Framework\Event\ManagerInterface $eventManager, \Lof\MarketPlace\Model\Seller $sellerCollection, \Lof\MarketPlace\Model\Group $groupCollection, \Lof\MarketPlace\Helper\Data $sellerHelper, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($actionFactory, $response, $eventManager, $sellerCollection, $groupCollection, $sellerHelper, $storeManager);
    }

    /**
     * {@inheritdoc}
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'match');
        return $pluginInfo ? $this->___callPlugins('match', func_get_args(), $pluginInfo) : parent::match($request);
    }
}
