<?php
namespace Lof\All\Block\Adminhtml\System\Market;

/**
 * Interceptor class for @see \Lof\All\Block\Adminhtml\System\Market
 */
class Interceptor extends \Lof\All\Block\Adminhtml\System\Market implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\App\ResourceConnection $resource, \Lof\All\Helper\Data $helper, \Lof\All\Model\License $license, \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress)
    {
        $this->___init();
        parent::__construct($context, $resource, $helper, $license, $remoteAddress);
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
