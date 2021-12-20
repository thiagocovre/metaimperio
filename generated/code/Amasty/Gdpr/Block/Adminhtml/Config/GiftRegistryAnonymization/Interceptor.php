<?php
namespace Amasty\Gdpr\Block\Adminhtml\Config\GiftRegistryAnonymization;

/**
 * Interceptor class for @see \Amasty\Gdpr\Block\Adminhtml\Config\GiftRegistryAnonymization
 */
class Interceptor extends \Amasty\Gdpr\Block\Adminhtml\Config\GiftRegistryAnonymization implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\ProductMetadataInterface $productMetadata, \Magento\Backend\Block\Template\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($productMetadata, $context, $data);
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
