<?php
namespace Lofmp\MultiShipping\Block\Onepage;

/**
 * Interceptor class for @see \Lofmp\MultiShipping\Block\Onepage
 */
class Interceptor extends \Lofmp\MultiShipping\Block\Onepage implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Data\Form\FormKey $formKey, \Magento\Checkout\Model\CompositeConfigProvider $configProvider, \Magento\Framework\ObjectManagerInterface $objectInterface, array $layoutProcessors = [], array $data = [])
    {
        $this->___init();
        parent::__construct($context, $formKey, $configProvider, $objectInterface, $layoutProcessors, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getJsLayout()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getJsLayout');
        return $pluginInfo ? $this->___callPlugins('getJsLayout', func_get_args(), $pluginInfo) : parent::getJsLayout();
    }
}
