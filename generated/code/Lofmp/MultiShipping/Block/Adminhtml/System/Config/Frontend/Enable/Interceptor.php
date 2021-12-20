<?php
namespace Lofmp\MultiShipping\Block\Adminhtml\System\Config\Frontend\Enable;

/**
 * Interceptor class for @see \Lofmp\MultiShipping\Block\Adminhtml\System\Config\Frontend\Enable
 */
class Interceptor extends \Lofmp\MultiShipping\Block\Adminhtml\System\Config\Frontend\Enable implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\ObjectManagerInterface $objectManager, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $objectManager, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'render');
        return $pluginInfo ? $this->___callPlugins('render', func_get_args(), $pluginInfo) : parent::render($element);
    }
}
