<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_MarketPlace
 *
 * @copyright  Copyright (c) 2018 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\MarketPlace\Block\Adminhtml\Notifications;

class Message extends \Magento\Framework\View\Element\Template
{

 
    /**
     * @var \Lof\MarketPlace\Model\Ticket
     */
    protected $_ticket;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Lof\MarketPlace\Model\Ticket           $ticketCollection
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Lof\MarketPlace\Model\MessageAdmin $message
    ) {
        $this->message = $message;
        parent::__construct($context);
    }

    public function countUnread() {

        $message = $this->message->getCollection()->addFieldToFilter('is_read',0); 
        return count($message);
    }

}
