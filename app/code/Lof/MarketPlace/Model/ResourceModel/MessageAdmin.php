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
namespace Lof\MarketPlace\Model\ResourceModel;

use Magento\Framework\DataObject\IdentityInterface;

/**
 * Message Model
 */
class MessageAdmin extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb 
{
	    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;


    protected $authSession;

    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Backend\Model\Auth\Session $authSession,
        $connectionName = null
        ) {
        parent::__construct($context, $connectionName);
        $this->_storeManager = $storeManager;
        $this->authSession = $authSession;
    }
	 /**
     * Define order
     */
    protected function _construct() {
        $this->_init ( 'lof_marketplace_message_admin', 'message_id' );
    }
      /**
     * Perform operations after object save
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {

    	 $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        if($object->getMessage()) {
    
            $user = $this->authSession->getUser();
            $data_message = [];   
            $data_message = [
                'message_id' => (int)$object->getMessageId(),
                'content' => $object->getMessage(),
                'seller_send' => 0,
                'sender_id'=> $user->getId(),
				'sender_email' => $user->getEmail(),
                'sender_name' => $user->getFirstname().' '.$user->getLastname(),
                'receiver_id' => $object->getSellerId(),
                'receiver_name' => $object->getSellerName(),
                'receiver_email' =>$object->getSellerEmail(),
                'message_admin' => 1
                
 			];
            $messageModel = $objectManager->get('Lof\MarketPlace\Model\MessageDetail');

            $messageModel->setData($data_message)->save();

        }     
    }
}