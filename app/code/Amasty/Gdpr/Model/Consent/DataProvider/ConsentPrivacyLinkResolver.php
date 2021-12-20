<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_Gdpr
 */


declare(strict_types=1);

namespace Amasty\Gdpr\Model\Consent\DataProvider;

use Amasty\Gdpr\Api\Data\ConsentInterface;
use Amasty\Gdpr\Model\Consent\ConsentStore\ConsentStore;
use Amasty\Gdpr\Model\Source\ConsentLinkType;
use Amasty\Gdpr\Model\Source\LinkToPolicy;
use Magento\Cms\Helper\Page as CmsHelper;

class ConsentPrivacyLinkResolver
{
    /**
     * @var CmsHelper
     */
    private $cmsHelper;

    public function __construct(
        CmsHelper $cmsHelper
    ) {
        $this->cmsHelper = $cmsHelper;
    }

    /**
     * @param ConsentInterface $consent
     *
     * @return string
     */
    public function getPrivacyLink(ConsentInterface $consent)
    {
        $privacyLinkType = $consent->getPrivacyLinkType() ?: ConsentLinkType::PRIVACY_POLICY;

        switch ($privacyLinkType) {
            case ConsentLinkType::CMS_PAGE:
                return (string)$this->cmsHelper->getPageUrl($consent->_getData(ConsentStore::CMS_PAGE_ID));
            default:
                return LinkToPolicy::PRIVACY_POLICY;
        }
    }
}
