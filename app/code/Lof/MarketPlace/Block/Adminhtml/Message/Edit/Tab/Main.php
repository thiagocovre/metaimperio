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
namespace Lof\MarketPlace\Block\Adminhtml\Message\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
	/**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;
    protected $_wysiwygConfig1;

    /**
     * @param \Magento\Backend\Block\Template\Context $context       
     * @param \Magento\Framework\Registry             $registry      
     * @param \Magento\Framework\Data\FormFactory     $formFactory   
     * @param \Magento\Store\Model\System\Store       $systemStore   
     * @param \Magento\Cms\Model\Wysiwyg\Config       $wysiwygConfig 
     * @param array                                   $data          
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Lof\MarketPlace\Model\MessageDetail $message_detail,
        \Lof\MarketPlace\Model\MessageAdmin $message,
        \Lof\MarketPlace\Helper\Data $helper,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->message = $message;
        $this->message_detail = $message_detail;
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_wysiwygConfig1 = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }


    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm(){
    	/** @var $model \Lof\MarketPlace\Model\Seller */
    	$model = $this->_coreRegistry->registry('lof_marketplace_message');

    	/**
    	 * Checking if user have permission to save information
    	 */
    	if($this->_isAllowedAction('Lof_MarketPlace::message_edit')){
    		$isElementDisabled = false;
    	}else {
    		$isElementDisabled = true;
    	}

    	/** @var \Magento\Framework\Data\Form $form */
    	$form = $this->_formFactory->create();

    	$form->setHtmlIdPrefix('seller_');

    	$fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Message Information')]);

    	if ($model->getId()) {
    		$fieldset->addField('message_id', 'hidden', ['name' => 'message_id']);
    	}
        if($model->getSubject()) {
              $fieldset->addField(
                'subject',
                'note',
                [
                'name'     => ' subject',
                'label'    => __('Subject'),
                'text'     => $model->getSubject()
                ]                
                ); 
         } else {
            $fieldset->addField(
                'subject',
                'text',
                ['name' => 'subject', 'label' => __('Subject'), 'title' => __('Subject'), 'required' => true]
            );
        }
       if($model->getDescription()) {
              $fieldset->addField(
                'description',
                'note',
                [
                'name'     => ' description',
                'label'    => __('Description'),
                'text'     => $model->getDescription()
                ]                
                ); 
         } else {
            $fieldset->addField(
                'description',
                'textarea',
                [
                'name'     => ' description',
                'label'    => __('Description'),
                'disabled' => $isElementDisabled,
                ]
                ); 
        }
    	  $fieldset->addField(
            'message',
            'textarea',
            ['name' => 'message', 'label' => __('Message'), 'title' => __('Message'),
            'disabled' => $isElementDisabled,
             'after_element_html' => $this->_getMessageContentAfterHtml($model->getId(),$model->getSellerId())
            ]
        );
   


    	$form->setValues($model->getData());
    	$this->setForm($form);

    	return parent::_prepareForm();
    }

    protected function _getMessageContentAfterHtml($message_id,$seller_id)
    {
        if($message_id) {
             $_messsage = $this->message->getCollection()->addFieldToFilter('seller_id',$seller_id)->addFieldToFilter('is_read',0);
            foreach ($_messsage as $key => $_msg) {
                $_msg->setData('is_read',1)->save();
            }
            $message = $this->message_detail->getCollection()->addFieldToFilter('message_id',$message_id)->addFieldToFilter('message_admin',1);
            $data = '';
            $class = '';
            foreach ($message as $key => $_message) {
                if($_message->getData('seller_send')) {
                    $name = $_message->getData('sender_name');
                    $class = 'user';
                } else {
                    $name = $_message->getData('sender_name');
                    $class = '';
                }
                $data .= '<div class="lof-ticket-history">';
                    $data .= '<div class="lof-message">';
                        $data .= '<div class="lof-message-header">';
                            $data .= '<strong>'.$name.'</strong>';
                            $data .= '<span class="minor">'.__('added %1 (%2)', $this->helper->nicetime($_message->getCreatedAt()), $_message->getCreatedAt()).'</span>';
                        $data .= '</div>';
                        $data .= '<div class="lof-message-body '.$class.'">';
                            $data .= $_message->getContent();
                            
                            
                        $data .= '</div>';
                        
                    $data .= '</div>';
                $data .= '</div>';
            }
            
            return $data;
        }
       
    }
    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Message Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Message Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}