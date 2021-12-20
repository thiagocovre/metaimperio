<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://www.landofcoder.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_MarketPlace
 * @copyright  Copyright (c) 2014 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\MarketPlace\Controller\Seller;

use Lof\MarketPlace\Helper\Data;
use Lof\MarketPlace\Model\Seller;
use Lof\MarketPlace\Model\Sender;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Lof\MarketPlace\Model\ResourceModel\Group\Collection;

class Saveseller extends \Magento\Framework\App\Action\Action
{


    /**
     * @var Data
     */
    protected $_sellerHelper;
    /**
     * @var Sender
     */
    protected $sender;
    /**
     * @var Collection
     */
    private $groupCollection;
    /**
     * @var Seller
     */
    private $seller;
    /**
     * @var Session
     */
    private $sesson;

    /**
     * @param Context $context [description]
     * @param Session $session
     * @param Seller $seller
     * @param Sender $sender
     * @param Data $sellerHelper [description]
     */
    public function __construct(
        Context $context,
        Session $session,
        Seller $seller,
        Sender $sender,
        Collection $groupCollection,
        Data $sellerHelper
    ) {
        parent::__construct($context);
        $this->sesson = $session;
        $this->seller = $seller;
        $this->groupCollection = $groupCollection;
        $this->_sellerHelper = $sellerHelper;
        $this->sender = $sender;
    }

    /**
     * Execute the result
     *
     * @return Redirect|void $resultPage
     * @throws LocalizedException
     */
    public function execute()
    {
        $approvedConditions = $this->getRequest()->getPost('privacy_policy');
        $url = $this->getRequest()->getPost('url');
        $group = $this->getRequest()->getPost('group');
        $existGroup = $this->groupCollection->addFieldToFilter('group_id', $group)->addFieldToFilter('status', '1');
        if (!$existGroup->getData()) {
            $this->messageManager->addError(__('Sorry. You can\'t create seller in this store.'));
            $this->_redirect('lofmarketplace/seller/becomeseller');
            return;
        }
        $layout = "2columns-left";
        $stores = array();
        $stores[] = $this->_sellerHelper->getCurrentStoreId();

        $customerSession = $this->sesson;

        if ($customerSession->isLoggedIn()) {
            if ($approvedConditions == 1) {
                $customerId = $customerSession->getId();
                $customerObject = $customerSession->getCustomer();
                $customerEmail = $customerObject->getEmail();
                $customerName = $customerObject->getName();
                $sellerApproval = $this->_sellerHelper->getConfig('general_settings/seller_approval');
                if ($customerObject->getAddresses()) {
                    $country = $customerObject->getAddresses()[$customerObject->getDefaultBilling()]->getCountryId();
                    if (!$this->checkCountry($country)) {
                        $this->messageManager->addError(__('Sorry. The store does not support to create sellers in your country'));
                        $this->_redirect('lofmarketplace/seller/becomeseller');
                        return;
                    }
                }
                if ($sellerApproval) {
                    $sellerModel = $this->seller;
                    try {
                        $sellerModel->setName($customerName)->setEmail($customerEmail)->setStatus(0)->setGroupId($group)->setCustomerId($customerId)->setStores($stores)->setUrlKey($url)->setPageLayout($layout)->save();
                        $this->_eventManager->dispatch(
                            'controller_action_seller_save_entity_after',
                            ['controller' => $this, 'data' => $customerObject->getData()]
                        );
                        $this->_redirect('lofmarketplace/seller/becomeseller/approval/0');
                    } catch (LocalizedException $e) {
                        $this->messageManager->addError($e->getMessage());
                        $this->_redirect('lofmarketplace/seller/becomeseller');
                    }
                } else {
                    $sellerModel = $this->seller;
                    try {
                        $sellerModel->setName($customerName)->setEmail($customerEmail)->setStatus(1)->setGroupId($group)->setCustomerId($customerId)->setStores($stores)->setUrlKey($url)->setPageLayout($layout)->save();
                        $this->_eventManager->dispatch(
                            'controller_action_seller_save_entity_after',
                            ['controller' => $this, 'data' => $customerObject->getData()]
                        );
                        $this->_redirect('marketplace/catalog/dashboard');
                    } catch (LocalizedException $e) {
                        $this->messageManager->addError($e->getMessage());
                        $this->_redirect('lofmarketplace/seller/becomeseller');
                    }
                }

                if ($this->_sellerHelper->getConfig('email_settings/enable_send_email')) {
                    $data = [];
                    $data['name'] = $customerName;
                    $data['email'] = $customerEmail;
                    $data['group'] = $group;
                    $data['url'] = $sellerModel->getUrl();
                    $this->sender->registerSeller($data);
                    $this->sender->approveSeller($data);
                }
            }
        } else {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('account/login/');
            return $resultRedirect;
        }
        /**
         * Load page layout
         */
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
    public function checkCountry($country)
    {
        $availableCountries = $this->_sellerHelper->getConfig('available_countries/available_countries');
        $enableAvailableCountries = $this->_sellerHelper->getConfig('available_countries/enable_available_countries');
        if ($enableAvailableCountries == '1' && $availableCountries) {
            $availableCountries = explode(',', $availableCountries);
            if (!in_array($country, $availableCountries)) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
}
