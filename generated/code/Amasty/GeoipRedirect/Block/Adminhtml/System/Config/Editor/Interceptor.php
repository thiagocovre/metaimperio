<?php
namespace Amasty\GeoipRedirect\Block\Adminhtml\System\Config\Editor;

/**
 * Interceptor class for @see \Amasty\GeoipRedirect\Block\Adminhtml\System\Config\Editor
 */
class Interceptor extends \Amasty\GeoipRedirect\Block\Adminhtml\System\Config\Editor implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig, \Magento\Framework\App\RequestInterface $request, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $wysiwygConfig, $request, $data);
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
