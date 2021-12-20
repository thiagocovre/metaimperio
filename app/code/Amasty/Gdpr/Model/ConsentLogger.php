<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_Gdpr
 */


namespace Amasty\Gdpr\Model;

use Amasty\Gdpr\Api\PolicyRepositoryInterface;
use Amasty\Gdpr\Api\WithConsentRepositoryInterface;
use Amasty\Gdpr\Model\ResourceModel\WithConsent as WithConsentResource;
use Amasty\Gdpr\Model\Source\ConsentLinkType;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class ConsentLogger
{
    const EMPTY_EMAIL_PLACEHOLDER = '-';

    const FROM_REGISTRATION = 'registration';
    const FROM_CHECKOUT = 'checkout';
    const FROM_SUBSCRIPTION = 'subscription';
    const FROM_CONTACTUS = 'contactus';
    const FROM_EMAIL = 'email';
    const FROM_PRIVACY_SETTINGS = 'privacy_settings';

    const CMS_PAGE = 'CMS Page';

    /**
     * @var WithConsentRepositoryInterface
     */
    private $withConsentRepository;

    /**
     * @var WithConsentFactory
     */
    private $consentFactory;

    /**
     * @var PolicyRepositoryInterface
     */
    private $policyRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var WithConsentResource
     */
    private $withConsent;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Amasty\Gdpr\Model\Visitor
     */
    private $visitor;

    /**
     * @var Config
     */
    private $configProvider;

    public function __construct(
        WithConsentRepositoryInterface $withConsentRepository,
        WithConsentFactory $consentFactory,
        PolicyRepositoryInterface $policyRepository,
        ActionLogger $logger,
        WithConsentResource $withConsent,
        StoreManagerInterface $storeManager,
        Visitor $visitor,
        Config $configProvider
    ) {
        $this->withConsentRepository = $withConsentRepository;
        $this->consentFactory = $consentFactory;
        $this->policyRepository = $policyRepository;
        $this->logger = $logger;
        $this->withConsent = $withConsent;
        $this->storeManager = $storeManager;
        $this->visitor = $visitor;
        $this->configProvider = $configProvider;
    }

    /**
     * @param string|int $customerId
     * @param string $from
     * @param Consent\Consent $consentModel
     * @param string|null $email
     *
     * @return void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function log($customerId, $from, $consentModel = null, string $email = null)
    {
        if (!$customerId && !$this->configProvider->isLogGuest($this->storeManager->getStore()->getWebsiteId())) {
            return;
        }

        if ($policy = $this->policyRepository->getCurrentPolicy()) {
            try {
                /** @var WithConsent $withConsent */
                $withConsent = $this->consentFactory->create();
                $privacyPolicyVersionValue = $consentModel->getPrivacyLinkType() === ConsentLinkType::PRIVACY_POLICY ?
                    $policy->getPolicyVersion() : self::CMS_PAGE;
                $withConsent->setPolicyVersion($privacyPolicyVersionValue);
                $withConsent->setGotFrom($from);
                $withConsent->setWebsiteId($this->storeManager->getWebsite()->getId());
                $withConsent->setIp($this->visitor->getRemoteIp());
                $withConsent->setCustomerId($customerId);
                $withConsent->setAction($consentModel->isConsentAccepted());
                $withConsent->setConsentCode($consentModel->getConsentCode());
                $withConsent->setLoggedEmail($email ?? self::EMPTY_EMAIL_PLACEHOLDER);

                $this->withConsentRepository->save($withConsent);
            } catch (\Exception $exception) {
                $this->logger->critical($exception);
            }
        }
    }
}
