<?php
namespace Amasty\Gdpr\Controller\Customer\Settings;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Customer\Settings
 */
class Interceptor extends \Amasty\Gdpr\Controller\Customer\Settings implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Amasty\Gdpr\Model\Config $configProvider, \Amasty\Gdpr\Model\Consent\DataProvider\PrivacySettingsDataProvider $privacySettingsDataProvider)
    {
        $this->___init();
        parent::__construct($context, $configProvider, $privacySettingsDataProvider);
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
