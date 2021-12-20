<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_Gdpr
 */


namespace Amasty\Gdpr\Block\Adminhtml\Customer\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Customer\Controller\RegistryConstants;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DownloadCustomerData implements ButtonProviderInterface
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var AuthorizationInterface
     */
    protected $authorization;

    public function __construct(
        Context $context,
        Registry $registry
    ) {
        $this->authorization = $context->getAuthorization();
        $this->urlBuilder = $context->getUrlBuilder();
        $this->registry = $registry;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if (!$this->getCustomerId() || !$this->authorization->isAllowed('Amasty_Gdpr::personal_data')) {
            return $data;
        }

        $data =  [
            'label' => __('Download Personal Data'),
            'on_click' => sprintf("location.href = '%s';", $this->getDownloadUrl()),
            'sort_order' => 75,
        ];

        return $data;
    }

    /**
     * @return string
     */
    public function getDownloadUrl()
    {
        return $this->urlBuilder->getUrl(
            'amasty_gdpr/customer/downloadCsv',
            ['customerId' => $this->getCustomerId(), '_nosid' => true,]
        );
    }

    /**
     * Return the customer Id.
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        $customerId = $this->registry->registry(RegistryConstants::CURRENT_CUSTOMER_ID);

        return $customerId;
    }
}
