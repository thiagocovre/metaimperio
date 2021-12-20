<?php

namespace Neoretail\InstallmentPrice\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

	const XML_BASE_PATH = 'catalog/';

	public function getConfigValue($field, $storeId = null) {
		return $this->scopeConfig->getValue(
			$field, ScopeInterface::SCOPE_STORE, $storeId
		);
	}

	public function getGeneralConfig($code, $storeId = null) {
		return $this->getConfigValue(self::XML_BASE_PATH .'installment_general/'. $code, $storeId);
	}

}
