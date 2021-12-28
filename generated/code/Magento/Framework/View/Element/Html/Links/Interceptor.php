<?php
namespace Magento\Framework\View\Element\Html\Links;

/**
 * Interceptor class for @see \Magento\Framework\View\Element\Html\Links
 */
class Interceptor extends \Magento\Framework\View\Element\Html\Links implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getLinks()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getLinks');
        return $pluginInfo ? $this->___callPlugins('getLinks', func_get_args(), $pluginInfo) : parent::getLinks();
    }
}
