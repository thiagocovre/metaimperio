<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_Gdpr
 */


namespace Amasty\Gdpr\Controller\Policy;

use Amasty\Gdpr\Api\PolicyRepositoryInterface;
use Amasty\Gdpr\Model\Config;
use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\StoreManagerInterface;

class PolicyText extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PolicyRepositoryInterface
     */
    private $policyRepository;

    /**
     * @var Config
     */
    private $configProvider;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var FilterProvider
     */
    private $filterProvider;

    public function __construct(
        Context $context,
        PolicyRepositoryInterface $policyRepository,
        Config $configProvider,
        StoreManagerInterface $storeManager,
        FilterProvider $filterProvider
    ) {
        parent::__construct($context);
        $this->policyRepository = $policyRepository;
        $this->configProvider = $configProvider;
        $this->storeManager = $storeManager;
        $this->filterProvider = $filterProvider;
    }

    public function execute()
    {
        $data = '';

        if ($this->configProvider->isModuleEnabled()) {
            $policy = $this->policyRepository->getCurrentPolicy(
                $this->storeManager->getStore()->getId()
            );

            if ($policy) {
                $data = $this->filterProvider->getPageFilter()->filter($policy->getContent());
            }

            return $this->resultFactory->create(ResultFactory::TYPE_RAW)->setContents($data);
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
            ->setUrl($this->_url->getUrl('no-route'));
    }
}
