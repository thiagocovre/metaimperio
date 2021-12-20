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
namespace Lof\MarketPlace\Controller\Adminhtml\Seller;

use Exception;
use Lof\MarketPlace\Helper\Data;
use Lof\MarketPlace\Model\Seller;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Helper\Js;
use Magento\Backend\Model\Session;
use Magento\Catalog\Model\Product\Url;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Escaper;
use Magento\Framework\Filesystem;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Save extends \Magento\Customer\Controller\AbstractAccount
{
    const XML_PATH_EMAIL_SENDER = 'lofmarketplace/email_settings/sender_email_identity';

    /**
     * @var Filesystem
     */
    protected $_fileSystem;

    protected $helper;
    /**
     * @var CustomerFactory
     */
    private $customer;
    /**
     * @var Js
     */
    private $jsHelper;
    /**
     * @var CustomerInterfaceFactory
     */
    private $customerFactory;
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;
    /**
     * @var StoreManagerInterface
     */
    private $store;
    /**
     * @var Seller
     */
    private $seller;
    /**
     * @var UrlInterface
     */
    private $_urlInterface;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var TransportBuilder
     */
    private $_transportBuilder;
    /**
     * @var Escaper
     */
    private $_escaper;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var Url
     */
    private $url;

    /**
     * @param Context $context
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $store
     * @param Js $jsHelper
     * @param CustomerInterfaceFactory $customerFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerFactory $customer
     * @param UrlInterface $urlInterface
     * @param TransportBuilder $transportBuilder
     * @param ScopeConfigInterface $scopeConfig
     * @param Seller $seller
     * @param Escaper $escaper
     * @param Data $helper
     */
    public function __construct(
        Context $context,
        Filesystem $filesystem,
        StoreManagerInterface $store,
        Js $jsHelper,
        CustomerInterfaceFactory $customerFactory,
        CustomerRepositoryInterface $customerRepository,
        CustomerFactory $customer,
        UrlInterface $urlInterface,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        Session $session,
        Url $url,
        Seller $seller,
        Escaper $escaper,

        Data $helper
    ) {
        $this->helper = $helper;
        $this->customer = $customer;
        $this->store = $store;
        $this->seller = $seller;
        $this->_escaper = $escaper;
        $this->session = $session;
        $this->url = $url;
        $this->_urlInterface = $urlInterface;
        $this->_fileSystem = $filesystem;
        $this->scopeConfig = $scopeConfig;
        $this->_transportBuilder = $transportBuilder;
        $this->jsHelper = $jsHelper;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;

        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lof_MarketPlace::seller_save');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            !isset($data['tw_active'])?$data['tw_active'] = 0:$data['tw_active'] = 1;
            !isset($data['fb_active'])?$data['fb_active'] = 0:$data['fb_active'] = 1;
            !isset($data['gplus_active'])?$data['gplus_active'] = 0:$data['gplus_active'] = 1;
            !isset($data['youtube_active'])?$data['youtube_active'] = 0:$data['youtube_active'] = 1;
            !isset($data['vimeo_active'])?$data['vimeo_active'] = 0:$data['vimeo_active'] = 1;
            !isset($data['instagram_active'])?$data['instagram_active'] = 0:$data['instagram_active'] = 1;
            !isset($data['linkedin_active'])?$data['linkedin_active'] = 0:$data['linkedin_active'] = 1;
            !isset($data['pinterest_active'])?$data['pinterest_active'] = 0:$data['pinterest_active'] = 1;

            $model = $this->seller;

            $id = $this->getRequest()->getParam('seller_id');
            if ($id) {
                $model->load($id);
            }

            /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
            $mediaDirectory = $this->_fileSystem->getDirectoryRead(DirectoryList::MEDIA);
            $mediaFolder = 'lof/seller/';
            $path = $mediaDirectory->getAbsolutePath($mediaFolder);

            // Delete, Upload Image
            $imagePath = $mediaDirectory->getAbsolutePath($model->getImage());
            if (isset($data['image']['delete']) && file_exists($imagePath)) {
                unlink($imagePath);
                $data['image'] = '';
            }
            if (isset($data['image']) && is_array($data['image'])) {
                unset($data['image']);
            }
            if ($image = $this->uploadImage('image')) {
                $data['image'] = $image;
            }

            // Delete, Upload Thumbnail
            $thumbnailPath = $mediaDirectory->getAbsolutePath($model->getThumbnail());
            if (isset($data['thumbnail']['delete']) && file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
                $data['thumbnail'] = '';
            }
            if (isset($data['thumbnail']) && is_array($data['thumbnail'])) {
                unset($data['thumbnail']);
            }
            if ($thumbnail = $this->uploadImage('thumbnail')) {
                $data['thumbnail'] = $thumbnail;
            }

            if ($data['url_key']=='') {
                $data['url_key'] = $data['name'];
            }
            $url_key = $this->url->formatUrlKey($data['url_key']);
            $data['url_key'] = $url_key;

            $this->_eventManager->dispatch('lof_marketplace_urlkey', ['data' => $data]);

            $links = $this->getRequest()->getPost('links');
            $links = is_array($links) ? $links : [];
            if (!empty($links) && isset($links['related'])) {
                $products = $this->jsHelper->decodeGridSerializedInput($links['related']);
                $data['products'] = $products;
            }
            if ($data['customer_id'] != '0') {
                $customer = $this->helper->getCustomerById($data['customer_id']);
                $data['email'] = $customer->getData('email');
            } else {
                if (!(filter_var($data['email'], FILTER_VALIDATE_EMAIL))) {
                    $this->messageManager->addErrorMessage(__('Please enter the correct email.'));
                    if ($id) {
                        return $resultRedirect->setPath('*/*/edit', ['seller_id' => $this->getRequest()->getParam('seller_id')]);
                    } else {
                        return $resultRedirect->setPath('*/*/');
                    }
                }
                $customer = $this->helper->getCustomerByEmail($data['email']);
                if ($customer->getData()) {
                    $data['customer_id'] = $customer->getEntityId();
                } else {
                    try {
                        $customer = $this->customer->create();
                        $customer->setEmail($data['email']);
                        $customer->setFirstname($data['name']);
                        $customer->setLastname(' ');
                        $password = $this->randomPassword();
                        $customer->setPassword($password);
                        /** @var \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository*/
                        $customer->save();
                        $data['customer_id'] = $this->customer->create()->getCollection()->addFieldToFilter('email', $data['email'])->getFirstItem()->getData('entity_id');
                        $template = 'lofmarketplace_email_settings_create_seller_template';
                        $url = $this->_urlInterface->getBaseUrl().'marketplace/'.$data['url_key'];
                        $dataEmail = ['name'=>$data['name'],'email'=> $data['email'], 'password' => $password, 'url'=> $url];
                        $this->sendEmail($dataEmail, $data['email'], $template);
                    } catch (Exception $e) {
                    }
                }
            }
            $existedSellerId = $model->getCollection()->addFieldToFilter('email', $data['email'])->getFirstItem()->getData('seller_id');
            if ($id && $existedSellerId && $existedSellerId != $id) {
                $this->messageManager->addErrorMessage(__('This email has already been registered for another seller.'));
                return $resultRedirect->setPath('*/*/edit', ['seller_id' => $this->getRequest()->getParam('seller_id')]);
            } elseif ($existedSellerId && !$id) {
                $this->messageManager->addErrorMessage(__('This email has already been registered for another seller.'));
                return $resultRedirect->setPath('*/*/new');
            }
            $model->setData($data);
            try {
                $model->save();
                $this->_eventManager->dispatch('lof_marketplace_urlkey', ['data' => $model->getData()]);
                $this->messageManager->addSuccess(__('You saved this seller.'));
                $this->session->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['seller_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the seller.'));
            }
            //$this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['seller_id' => $this->getRequest()->getParam('seller_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    public function uploadImage($fieldId = 'image')
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if (isset($_FILES[$fieldId]) && $_FILES[$fieldId]['name']!='') {
            $uploader = $this->_objectManager->create(
                'Magento\Framework\File\Uploader',
                array('fileId' => $fieldId)
            );
            $path = $this->_fileSystem->getDirectoryRead(
                DirectoryList::MEDIA
            )->getAbsolutePath(
                'catalog/category/'
            );

            /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
            $mediaDirectory = $this->_fileSystem
                ->getDirectoryRead(DirectoryList::MEDIA);
            $mediaFolder = 'lof/seller/';
            try {
                $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $result = $uploader->save(
                    $mediaDirectory->getAbsolutePath($mediaFolder)
                );
                $result['name'] = str_replace(' ', '_', $result['name']);
                return $mediaFolder.$result['name'];
            } catch (Exception $e) {
                //$this->_logger->critical($e);
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['seller_id' => $this->getRequest()->getParam('seller_id')]);
            }
        }
        return;
    }
    public function randomPassword()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $password = [];
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $password[] = $alphabet[$n];
        }
        return implode($password);
    }
    public function sendEmail($data, $emailRecipient, $template)
    {
        try {
            $storeScope = ScopeInterface::SCOPE_STORE;
            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($data);
            $senderData = $this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER, $storeScope);
            if (!empty($senderData)) {
                $senderDataName = $this->scopeConfig->getValue('trans_email/ident_' . $senderData . '/name', $storeScope);
                $senderDataEmails = $this->scopeConfig->getValue('trans_email/ident_' . $senderData . '/email', $storeScope);
            } else {
                $senderDataName = $this->scopeConfig->getValue('trans_email/ident_general/name', $storeScope);
                $senderDataEmails = $this->scopeConfig->getValue('trans_email/ident_general/email', $storeScope);
            }
            $sender = [
                'name' => $this->_escaper->escapeHtml($senderDataName),
                'email' => $this->_escaper->escapeHtml($senderDataEmails),
            ];

            $transport = $this->_transportBuilder
                ->setTemplateIdentifier($template)
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars(['data' => $postObject])
                ->setFrom($sender)
                ->addTo($emailRecipient)
                ->getTransport();

            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->messageManager->addError(
                __('We can\'t process your request right now. Sorry, that\'s all we know.' . $e->getMessage())
            );
        }
    }
}
