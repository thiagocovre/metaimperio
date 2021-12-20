<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_Gdpr
 */


namespace Amasty\Gdpr\Controller\Customer;

use Amasty\Gdpr\Block\Settings as BlockSettings;
use Amasty\Gdpr\Model\Anonymizer;
use Amasty\Gdpr\Model\Config;
use Amasty\Gdpr\Model\GiftRegistryDataFactory;
use Magento\Customer\Model\Authentication;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;
use Psr\Log\LoggerInterface;

class Anonymise extends Action
{
    const ORDER_INCREMENT_ID_REQUEST_KEY_NAME = 'order_increment_id';

    /**
     * @var Anonymizer
     */
    private $anonymizer;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var FormKeyValidator
     */
    private $formKeyValidator;

    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @var Config
     */
    private $configProvider;

    /**
     * @var ProductMetadataInterface
     */
    private $productMetadata;

    /**
     * @var GiftRegistryDataFactory
     */
    private $giftRegistryDataFactory;

    public function __construct(
        Context $context,
        Anonymizer $anonymizer,
        Session $customerSession,
        LoggerInterface $logger,
        FormKeyValidator $formKeyValidator,
        Authentication $authentication,
        Config $configProvider,
        ProductMetadataInterface $productMetadata,
        GiftRegistryDataFactory $giftRegistryDataFactory
    ) {
        parent::__construct($context);
        $this->anonymizer = $anonymizer;
        $this->customerSession = $customerSession;
        $this->logger = $logger;
        $this->formKeyValidator = $formKeyValidator;
        $this->authentication = $authentication;
        $this->configProvider = $configProvider;
        $this->productMetadata = $productMetadata;
        $this->giftRegistryDataFactory = $giftRegistryDataFactory;
    }

    /**
     * Anonymize customer request
     *
     * @return void
     */
    public function execute()
    {
        $isOrderAnonymisation = $this->getRequest()->getParam(BlockSettings::IS_ORDER_LAYOUT_VARIABLE_NAME);
        $errorMessage = '';

        if (!$this->formKeyValidator->validate($this->getRequest())) {
            $errorMessage = __('Invalid Form Key. Please refresh the page.');
        }

        if (!$this->configProvider->isAllowed(Config::ANONYMIZE)) {
            $errorMessage = __('Access denied.');
        }

        if ($errorMessage) {
            $this->messageManager->addErrorMessage($errorMessage);
            $this->_redirect($this->_redirect->getRefererUrl());

            return;
        }

        $customerId = (int)$this->customerSession->getCustomerId();
        $customerPass = $this->getRequest()->getParam('current_password');

        try {
            if ($customerId) {
                $this->authentication->authenticate($customerId, $customerPass);
            }
        } catch (\Magento\Framework\Exception\AuthenticationException $e) {
            $this->messageManager->addErrorMessage(__('Wrong Password. Please recheck it.'));
            $this->_redirect($this->_redirect->getRefererUrl());

            return;
        }

        try {
            $errorMessage = '';

            if ($isOrderAnonymisation) {
                $result = $this->anonymizer->anonymizeOrderByIncrementId($this->getOrderIncrementId());

                if (!$result) {
                    $errorMessage = __('We can not anonymize order');
                }
            } else {
                $ordersData = $this->anonymizer->getCustomerActiveOrders($customerId);
                if (!empty($ordersData)) {
                    $orderIncrementIds = '';

                    foreach ($ordersData as $order) {
                        $orderIncrementIds .= ' ' . $order['increment_id'];
                    }

                    $errorMessage = __(
                        'We can not anonymize your account right now, because you have non-completed order(s):%1',
                        $orderIncrementIds
                    );
                } elseif ($this->productMetadata->getEdition() === 'Enterprise'
                    && $this->configProvider->isAvoidGiftRegistryAnonymization()
                    && $this->checkGiftRegistries($customerId)
                ) {
                    $errorMessage = __(
                        'We can not anonymize your account right now, because you have active Gift Registry'
                    );
                } else {
                    $this->anonymizer->anonymizeCustomer($this->customerSession->getCustomerId());
                }
            }

            if ($errorMessage) {
                $this->messageManager->addErrorMessage($errorMessage);
            } else {
                $this->messageManager->addSuccessMessage(__('Anonymisation was successful'));
            }

        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('An error has occurred'));
            $this->logger->critical($exception);
        }

        $this->_redirect($this->_redirect->getRefererUrl());
    }

    /**
     * @return string|int
     */
    private function getOrderIncrementId()
    {
        return $this->getRequest()->getParam(self::ORDER_INCREMENT_ID_REQUEST_KEY_NAME);
    }

    /**
     * @param int $customerId
     *
     * @return bool
     */
    private function checkGiftRegistries($customerId)
    {
        return (bool)$this->giftRegistryDataFactory->create(GiftRegistryDataFactory::GIFT_REGISTRY_ENTITY_KEY)
            ->filterByCustomerId($customerId)
            ->filterByActive()
            ->getSize();
    }
}
