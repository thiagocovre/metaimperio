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

use Magento\Customer\Model\Account\Redirect as AccountRedirect;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\UrlFactory;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\InputException;

class CreatePost extends \Magento\Customer\Controller\AbstractAccount
{
    /** @var AccountManagementInterface */
    protected $accountManagement;
    /** @var FormFactory */
    protected $formFactory;
    /** @var Escaper */
    protected $escaper;
    /** @var \Magento\Framework\UrlInterface */
    protected $urlModel;
    /** @var DataObjectHelper  */
    protected $dataObjectHelper;
    /**
     *
     * @var Session
     */
    protected $session;
    /**
     *
     * @var AccountRedirect
     */
    private $accountRedirect;

    /**
     * @var \Lof\MarketPlace\Helper\Data
     */
    protected $_sellerHelper;
    /**
     * @var \Lof\MarketPlace\Model\Sender
     */
    protected $sender;
    /**
     * @var Magento\Customer\Api\Data\RegionInterfaceFactory
     */
    private $regionInterfaceFactory;
    /**
     * @var Magento\Customer\Api\Data\AddressInterfaceFactory
     */
    private $addressInterfaceFactory;
    /**
     * @var Magento\Customer\Model\Registration|Registration
     */
    private $registration;
    /**
     * @var Magento\Customer\Model\CustomerExtractor
     */
    private $customerExtractor;
    /**
     * @var Magento\Newsletter\Model\SubscriberFactory
     */
    private $subscriberFactory;
    /**
     * @var Magento\Customer\Model\Url
     */
    private $url;
    /**
     * @var Magento\Directory\Model\Region
     */
    private $region;
    /**
     * @var Lof\MarketPlace\Model\Seller
     */
    private $seller;
    /**
     * @var Magento\Customer\Helper\Address
     */
    private $address;
    /**
     * @var Magento\Store\Model\StoreManagerInterface
     */
    private $storeManagerInterface;

    /**
     *
     * @param Context $context
     * @param Session $customerSession
     * @param AccountManagementInterface $accountManagement
     * @param UrlFactory $urlFactory
     * @param Escaper $escaper
     * @param Magento\Customer\Model\Metadata\FormFactory $formFactory
     * @param Magento\Customer\Api\Data\RegionInterfaceFactory $regionInterfaceFactory
     * @param Magento\Customer\Api\Data\AddressInterfaceFactory $addressInterfaceFactory
     * @param Magento\Customer\Model\Registration $registration
     * @param Magento\Customer\Model\CustomerExtractor $customerExtractor
     * @param Magento\Newsletter\Model\SubscriberFactory $subscriberFactory
     * @param Magento\Directory\Model\Region $region
     * @param Magento\Customer\Helper\Address $address
     * @param Magento\Customer\Model\Url $url
     * @param Lof\MarketPlace\Model\Seller $seller
     * @param Magento\Store\Model\StoreManagerInterface $storeManagerInterface
     * @param DataObjectHelper $dataObjectHelper
     * @param \Lof\MarketPlace\Model\Sender $sender
     * @param \Lof\MarketPlace\Helper\Data $sellerHelper
     * @param AccountRedirect $accountRedirect
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        AccountManagementInterface $accountManagement,
        UrlFactory $urlFactory,
        Escaper $escaper,
        \Magento\Customer\Model\Metadata\FormFactory $formFactory,
        \Magento\Customer\Api\Data\RegionInterfaceFactory $regionInterfaceFactory,
        \Magento\Customer\Api\Data\AddressInterfaceFactory $addressInterfaceFactory,
        \Magento\Customer\Model\Registration $registration,
        \Magento\Customer\Model\CustomerExtractor $customerExtractor,
        \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory,
        \Magento\Directory\Model\Region $region,
        \Magento\Customer\Helper\Address $address,
        \Magento\Customer\Model\Url $url,
        \Lof\MarketPlace\Model\Seller $seller,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        DataObjectHelper $dataObjectHelper,
        \Lof\MarketPlace\Model\Sender $sender,
        \Lof\MarketPlace\Helper\Data $sellerHelper,
        AccountRedirect $accountRedirect
    )
    {
        $this->_sellerHelper = $sellerHelper;
        $this->sender = $sender;
        $this->seller = $seller;
        $this->address = $address;
        $this->registration = $registration;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->regionInterfaceFactory = $regionInterfaceFactory;
        $this->addressInterfaceFactory = $addressInterfaceFactory;
        $this->url = $url;
        $this->region = $region;
        $this->subscriberFactory = $subscriberFactory;
        $this->customerExtractor = $customerExtractor;
        $this->formFactory = $formFactory;
        $this->session = $customerSession;
        $this->accountManagement = $accountManagement;
        $this->escaper = $escaper;
        $this->urlModel = $urlFactory->create();
        $this->dataObjectHelper = $dataObjectHelper;
        $this->accountRedirect = $accountRedirect;
        parent::__construct($context);
    }

    /**
     * Add address to customer during create account
     *
     * @return AddressInterface|null
     */
    protected function extractAddress()
    {
        if (! $this->getRequest()->getPost('create_address')) {
            return null;
        }

        $addressForm = $this->formFactory->create('customer_address', 'customer_register_address');
        $allowedAttributes = $addressForm->getAllowedAttributes();

        $addressData = [ ];

        $regionDataObject = $this->regionInterfaceFactory->create();
        foreach ($allowedAttributes as $attribute) {
            $attributeCode = $attribute->getAttributeCode();
            $value = $this->getRequest()->getParam($attributeCode);
            if ($value === null) {
                continue;
            }
            switch ($attributeCode) {
                case 'region_id':
                    $regionDataObject->setRegionId($value);
                    break;
                case 'region':
                    $regionDataObject->setRegion($value);
                    break;
                default:
                    $addressData [$attributeCode] = $value;
            }
        }
        $addressDataObject = $this->addressInterfaceFactory->create();
        $this->dataObjectHelper->populateWithArray($addressDataObject, $addressData, '\Magento\Customer\Api\Data\AddressInterface');
        $addressDataObject->setRegion($regionDataObject);

        $addressDataObject->setIsDefaultBilling($this->getRequest()->getParam('default_billing', false))->setIsDefaultShipping($this->getRequest()->getParam('default_shipping', false));
        return $addressDataObject;
    }

    /**
     * Create customer account action
     *
     * @return void @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    {
        $resultRedirectFlag = 0;
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($this->session->isLoggedIn() || ! $this->registration->isAllowed()) {
            $resultRedirect->setPath('*/*/');
            return $resultRedirect;
        }

        if (! $this->getRequest()->isPost()) {
            $url = $this->urlModel->getUrl('*/*/create', [
                '_secure' => true
            ]);
            $resultRedirect->setUrl($this->_redirect->error($url));
            return $resultRedirect;
        }

        $this->session->regenerateId();
        $data = $this->getRequest()->getPost();

        try {
            $address = $this->extractAddress();
            $addresses = $address === null ? [ ] : [
                $address
            ];

            $customer = $this->customerExtractor->extract('customer_account_create', $this->_request);
            $customer->setAddresses($addresses);

            $password = $this->getRequest()->getParam('password');
            $confirmation = $this->getRequest()->getParam('password_confirmation');
            $redirectUrl = $this->session->getBeforeAuthUrl();

            $this->checkPasswordConfirmation($password, $confirmation);

            $customer = $this->accountManagement->createAccount($customer, $password, $redirectUrl);

            if ($this->getRequest()->getParam('is_subscribed', false)) {
                $this->subscriberFactory->create()->subscribeCustomerById($customer->getId());
            }

            $this->_eventManager->dispatch('customer_register_success', [
                'account_controller' => $this,
                'customer' => $customer
            ]);

            $confirmationStatus = $this->accountManagement->getConfirmationStatus($customer->getId());
            if ($confirmationStatus === AccountManagementInterface::ACCOUNT_CONFIRMATION_REQUIRED) {
                $email = $this->url->getEmailConfirmationUrl($customer->getEmail());

                $this->messageManager->addSuccess(__('You must confirm your account. Please check your email for the confirmation link or <a href="%1">click here</a> for a new link.', $email));

                $url = $this->urlModel->getUrl('*/*/index', [
                    '_secure' => true
                ]);
                $resultRedirect->setUrl($this->_redirect->success($url));
            } else {
                $this->session->setCustomerDataAsLoggedIn($customer);
                $this->messageManager->addSuccess($this->getSuccessMessage());
                $resultRedirect = $this->accountRedirect->getRedirect();
                $url = $this->urlModel->getUrl('customer/account', [
                    '_secure' => true
                ]);
                $resultRedirect->setUrl($this->_redirect->success($url));
            }
            $resultRedirectFlag = 1;
        } catch (StateException $e) {
            $url = $this->urlModel->getUrl('customer/account/forgotpassword');

            $message = __('There is already an account with this email address. If you are sure that it is your email address, <a href="%1">click here</a> to get your password and access your account.', $url);

            $this->messageManager->addError($message);
        } catch (InputException $e) {
            $this->messageManager->addError($this->escaper->escapeHtml($e->getMessage()));
            foreach ($e->getErrors() as $error) {
                $this->messageManager->addError($this->escaper->escapeHtml($error->getMessage()));
            }
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('We can\'t save the customer.'));
        }
        if ($resultRedirectFlag == 0) {
            $this->session->setCustomerFormData($this->getRequest()->getPostValue());
            $defaultUrl = $this->urlModel->getUrl('*/*/create', [
                '_secure' => true
            ]);
            $resultRedirect->setUrl($this->_redirect->error($defaultUrl));
        }

        $url                = $this->getRequest()->getPost('url');
        $group              = $this->getRequest()->getPost('group');
        $layout             = "2columns-left";
        $stores = array();
        $stores[] = $this->_sellerHelper->getCurrentStoreId();

        $customerSession    = $this->session;

        if ($customerSession->isLoggedIn()) {
            $customerId     = $customerSession->getId();
            $customerObject = $customerSession->getCustomer();
            $customerEmail  = $customerObject->getEmail();
            $customerName   = $customerObject->getName();
            $sellerApproval = $this->_sellerHelper->getConfig('general_settings/seller_approval');
            $street = '';
            $country = $this->_sellerHelper->getCountryname($data['country_id']);
            if (empty($data['region'])) {
                $region = $this->region->load($data['region_id']);
                $data['region'] = $region->getData('name');
            }
            foreach ($data['street'] as $key => $_street) {
                $street .= ' '.$_street;
            }
            if ($sellerApproval) {
                $sellerModel = $this->seller;
                try {
                    $sellerModel->setCity($data['city'])->setCommany($data['company'])->setTelephone($data['telephone'])->setContactNumber($data['telephone'])->setAddress($street)->setRegion($data['region'])->setRegionId($data['region_id'])->setPostcode($data['postcode'])->setCountry($country)->setCountryId($data['country_id'])->setName($customerName)->setEmail($customerEmail)->setStatus(0)->setGroupId($group)->setCustomerId($customerId)->setStores($stores)->setUrlKey($url)->setPageLayout($layout)->save();
                    if ($this->_sellerHelper->getConfig('email_settings/enable_send_email')) {
                        $data = [];
                        $data['name'] = $customerName;
                        $data['email'] = $customerEmail;
                        $data['group'] = $group;
                        $data['url'] = $sellerModel->getUrl();
                        $this->sender->noticeAdmin($data);
                    }
                    $this->_redirect('lofmarketplace/seller/becomeseller/approval/0');
                } catch (\Magento\Framework\Exception\LocalizedException $e) {
                    $this->messageManager->addError($e->getMessage());
                    $this->_redirect('lofmarketplace/seller/becomeseller');
                }
            } else {
                $sellerModel = $this->seller;
                try {
                    $sellerModel->setCity($data['city'])->setCommany($data['company'])->setCountryId($data['country_id'])->setTelephone($data['telephone'])->setAddress($street)->setRegion($data['region'])->setRegionId($data['region_id'])->setPostcode($data['postcode'])->setCountry($country)->setCountryId($data['country_id'])->setName($customerName)->setEmail($customerEmail)->setStatus(1)->setGroupId($group)->setCustomerId($customerId)->setStores($stores)->setUrlKey($url)->setPageLayout($layout)->save();
                    if ($this->_sellerHelper->getConfig('email_settings/enable_send_email')) {
                        $data = [];
                        $data['name'] = $customerName;
                        $data['email'] = $customerEmail;
                        $data['group'] = $group;
                        $data['url'] = $sellerModel->getUrl();
                        $this->sender->noticeAdmin($data);
                        $this->sender->approveSeller($data);
                    }
                    $this->_redirect('marketplace/catalog/dashboard');
                } catch (\Magento\Framework\Exception\LocalizedException $e) {
                    $this->messageManager->addError($e->getMessage());
                    $this->_redirect('lofmarketplace/seller/becomeseller');
                }
            }
        } else {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('lofmarketplace/seller/login/');
            return $resultRedirect;
        }
    }

    /**
     * Make sure that password and password confirmation matched
     *
     * @param string $password
     * @param string $confirmation
     * @return void
     * @throws InputException
     */
    protected function checkPasswordConfirmation($password, $confirmation)
    {
        if ($password != $confirmation) {
            throw new InputException(__('Please make sure your passwords match.'));
        }
    }

    /**
     * Retrieve success message
     *
     * @return string
     */
    protected function getSuccessMessage()
    {
        if ($this->address->isVatValidationEnabled()) {
            if ($this->address->getTaxCalculationAddressType() == Address::TYPE_SHIPPING) {
                $message = __('If you are a registered VAT customer, please <a href="%1">click here</a> to enter your shipping address for proper VAT calculation.', $this->urlModel->getUrl('customer/address/edit'));
            } else {
                $message = __('If you are a registered VAT customer, please <a href="%1">click here</a> to enter your billing address for proper VAT calculation.', $this->urlModel->getUrl('customer/address/edit'));
            }
        } else {
            $message = __('Thank you for registering with %1.', $this->storeManagerInterface->getStore()->getFrontendName());
        }
        return $message;
    }
}
