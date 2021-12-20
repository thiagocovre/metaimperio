<?php
namespace Dotdigitalgroup\Chat\Block\Adminhtml\Config\Settings\ConfigureWidgetButton;

/**
 * Interceptor class for @see \Dotdigitalgroup\Chat\Block\Adminhtml\Config\Settings\ConfigureWidgetButton
 */
class Interceptor extends \Dotdigitalgroup\Chat\Block\Adminhtml\Config\Settings\ConfigureWidgetButton implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Dotdigitalgroup\Chat\Model\Config $config, \Dotdigitalgroup\Email\Helper\Data $helper, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $config, $helper, $data);
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
