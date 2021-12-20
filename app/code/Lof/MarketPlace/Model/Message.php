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
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\MarketPlace\Model;

use Magento\Authorization\Model\CompositeUserContext;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;

/**
 * Orderitems Model
 */
class Message extends \Magento\Framework\Model\AbstractModel implements \Lof\MarketPlace\Api\SellerMessageRepositoryInterface
{
    protected $userContext;
    protected $sellerFactory;
    public function __construct(Context $context, \Magento\Framework\Registry $registry,
                                AbstractResource $resource = null,
                                CompositeUserContext $userContext,
                                SellerFactory $sellerFactory,
                                \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = [])
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->userContext = $userContext;
        $this->sellerFactory = $sellerFactory;
    }

    /**
     * Define resource model
     */
    protected function _construct() {
        $this->_init ( 'Lof\MarketPlace\Model\ResourceModel\Message' );
    }

    /**
     * GET seller seller message
     * @param int $customerId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getSellerMessages($customerId){
        $seller = $this->sellerFactory->create()->getCollection()->addFieldToFilter('customer_id',$customerId)->load();
        if(count($seller->getData())>0)
        {
            $sellerId = $seller->getData()[0]['seller_id'];
        }
        else{
            throw new NoSuchEntityException(__('Customer has not registered the seller yet'));
        }
        $res = [
            "code" => 405,
            "message" => "Get data failed"
        ];
        $data = $this->getCollection()->addFieldToFilter('seller_send',$sellerId)->getData();
        $res = [
            "code" => 0,
            "message" => "Get data success"
        ];
        $res["result"] = [
            "message" => $data
        ];
        return $res;
    }
    /**
     * GET seller seller message by id
     * @param int $customerId
     * @param int $messageId
     * @return mixed
     * @throws NoSuchEntityException
     */

    public function getSellermessageById($customerId, $messageId){
        $seller = $this->sellerFactory->create()->getCollection()->addFieldToFilter('customer_id',$customerId)->load();
        if(count($seller->getData())>0)
        {
            $sellerId = $seller->getData()[0]['seller_id'];
        }
        else{
            throw new NoSuchEntityException(__('Customer has not registered the seller yet'));
        }
        $res = [
            "code" => 405,
            "message" => "Get data failed"
        ];
        $data = $this->getCollection()
                ->addFieldToFilter('owner_id', array('eq' => $sellerId))
                ->addFieldToFilter('message_id',array('eq' => $messageId))->getFirstItem()->getData();
            $res = [
                "code" => 0,
                "message" => "Get data success"
            ];
            $res["result"] = [
                "message" => $data
            ];
        return $res;
    }

    public function ReplyMessage(\Lof\MarketPlace\Api\Data\SellerMessageInterface $message)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->create("Lof\MarketPlace\Helper\Data");
        $sender = $objectManager->create("Lof\MarketPlace\Model\Sender");
        if($message){
            $check_auth = $helper->checkAuth();
            if ($check_auth) {
                $check_auth = json_decode($check_auth);
                $result = ["code" => 405, "message" => "Error"];

                if($check_auth){
                    $data['status'] = 1;
                    $data['owner_id'] = $check_auth->id;
                    $data['sender_email'] = $check_auth->email;
                    $data['receiver_id'] = 0;
                    $data['seller_send'] = 1;
                    $data['message_id'] = $message->getMessageId();
                    $data['sender_name'] = $check_auth->firstname . ' ' . $check_auth->lastname;
                    $data['content'] = $message->getContent();
                    $data['receiver_name'] = $message->getReceiverName();
                    $data['receiver_email'] = $message->getReceiverEmail();
                    $messageModel = $objectManager->get('Lof\MarketPlace\Model\MessageDetail')->load($data['message_id']);
                    $message = $this->load($data['message_id']);

                    if($data['status'] != $message->getData('status')) {
                        $message->setData('status',$data['status'])->save();
                    }

                    $messageModel->setData($data);
                    if ($messageModel->save()) {
                        $result = ["code" => 0, "message" => "Reply message success"];
                    }

                    if($helper->getConfig('email_settings/enable_send_email')) {
                        $sender->sellerNewMessage($data);
                    }
                }
            }
        }
        echo json_encode($result, JSON_PRETTY_PRINT);
 }
}