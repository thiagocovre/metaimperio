<?php
namespace Amasty\Gdpr\Controller\Result\Csv;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Result\Csv
 */
class Interceptor extends \Amasty\Gdpr\Controller\Result\Csv implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Filesystem\Driver\File $fileDriver, string $fileName = 'data.csv')
    {
        $this->___init();
        parent::__construct($fileDriver, $fileName);
    }

    /**
     * {@inheritdoc}
     */
    public function renderResult(\Magento\Framework\App\ResponseInterface $response)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'renderResult');
        return $pluginInfo ? $this->___callPlugins('renderResult', func_get_args(), $pluginInfo) : parent::renderResult($response);
    }
}
