<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_GdprCookie
 */


namespace Amasty\GdprCookie\Controller\Adminhtml\Cookie;

use Amasty\GdprCookie\Controller\Adminhtml\AbstractCookie;
use Amasty\GdprCookie\Model\Repository\CookieRepository;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;

class Edit extends AbstractCookie
{
    /**
     * @var CookieRepository
     */
    private $cookieRepository;

    public function __construct(
        Context $context,
        CookieRepository $cookieRepository
    ) {
        parent::__construct($context);
        $this->cookieRepository = $cookieRepository;
    }

    /**
     * Edit action
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');

        $title = __('New Cookie');

        if ($id) {
            $model = $this->cookieRepository->getById($id);
            $title = __('Edit Cookie %1', $model->getName());
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        if (!$id) {
            $resultPage->getLayout()->unsetElement('store_switcher');
        }

        $resultPage->setActiveMenu('Amasty_GdprCookie::cookies');
        $resultPage->addBreadcrumb(__('Cookies'), __('Cookies'));
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }
}
