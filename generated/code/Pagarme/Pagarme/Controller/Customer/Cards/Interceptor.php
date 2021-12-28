<?php
namespace Pagarme\Pagarme\Controller\Customer\Cards;

/**
 * Interceptor class for @see \Pagarme\Pagarme\Controller\Customer\Cards
 */
class Interceptor extends \Pagarme\Pagarme\Controller\Customer\Cards implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $jsonFactory, \Magento\Framework\View\Result\PageFactory $pageFactory, \Magento\Customer\Model\Session $customerSession)
    {
        $this->___init();
        parent::__construct($context, $jsonFactory, $pageFactory, $customerSession);
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
