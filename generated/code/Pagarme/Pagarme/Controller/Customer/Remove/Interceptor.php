<?php
namespace Pagarme\Pagarme\Controller\Customer\Remove;

/**
 * Interceptor class for @see \Pagarme\Pagarme\Controller\Customer\Remove
 */
class Interceptor extends \Pagarme\Pagarme\Controller\Customer\Remove implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $jsonFactory, \Magento\Framework\View\Result\PageFactory $pageFactory, \Pagarme\Pagarme\Model\CardsRepository $cardsRepository, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\App\Request\Http $request, \Pagarme\Pagarme\Gateway\Transaction\Base\Config\Config $config)
    {
        $this->___init();
        parent::__construct($context, $jsonFactory, $pageFactory, $cardsRepository, $customerSession, $request, $config);
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
