<?php
namespace Lof\MarketPlace\Model\Widget;

/**
 * Interceptor class for @see \Lof\MarketPlace\Model\Widget
 */
class Interceptor extends \Lof\MarketPlace\Model\Widget implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Escaper $escaper, \Magento\Widget\Model\Config\Data $dataStorage, \Magento\Framework\View\Asset\Repository $assetRepo, \Magento\Framework\View\Asset\Source $assetSource, \Magento\Framework\View\FileSystem $viewFileSystem, \Magento\Widget\Helper\Conditions $conditionsHelper)
    {
        $this->___init();
        parent::__construct($escaper, $dataStorage, $assetRepo, $assetSource, $viewFileSystem, $conditionsHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function getPlaceholderImageUrl($type)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPlaceholderImageUrl');
        return $pluginInfo ? $this->___callPlugins('getPlaceholderImageUrl', func_get_args(), $pluginInfo) : parent::getPlaceholderImageUrl($type);
    }
}
