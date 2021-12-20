<?php
namespace Lof\MarketPlace\Block\Adminhtml\System\Config\Form\Field\Editor;

/**
 * Interceptor class for @see \Lof\MarketPlace\Block\Adminhtml\System\Config\Form\Field\Editor
 */
class Interceptor extends \Lof\MarketPlace\Block\Adminhtml\System\Config\Form\Field\Editor implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig)
    {
        $this->___init();
        parent::__construct($context, $wysiwygConfig);
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
