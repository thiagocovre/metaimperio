<?php

namespace Lof\MarketPlace\Block\Seller;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\UrlInterface;

class BottomLink extends \Magento\Framework\View\Element\Html\Link
{
    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;
    protected $_urlInterface;
    private $_fastOrderHelper;


    public function __construct(
        Template\Context $context,
        array $data = [],
        ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\Session $customerSession,
        UrlInterface $urlInterface
    )

    {
        parent::__construct($context, $data);
        $this->_scopeConfig = $scopeConfig;
        $this->customerSession = $customerSession;
        $this->_urlInterface = $urlInterface;
    }

    protected function _toHtml()
    {
        $router = $this->getUrl('lofmarketplace/seller/login');
        return '<li><a href="' . $this->_urlInterface->getUrl($router) . '" >' . $this->escapeHtml($this->getLabel()) . '</a></li>';
    }


}
