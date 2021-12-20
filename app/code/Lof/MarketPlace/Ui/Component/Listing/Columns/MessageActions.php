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
namespace Lof\MarketPlace\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Lof\MarketPlace\Block\Adminhtml\Group\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\UrlInterface;

class MessageActions extends Column
{
	/** Url Path */
	const GROUP_URL_PATH_EDIT = 'lofmarketplace/message/edit';
	const GROUP_URL_PATH_DELETE = 'lofmarketplace/message/delete';

	/** @var UrlBuilder */
	protected $actionUrlBuilder;

	/** @var UrlInterface */
    protected $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;

    /**
     * @param ContextInterface   $context            
     * @param UiComponentFactory $uiComponentFactory 
     * @param UrlBuilder         $actionUrlBuilder   
     * @param UrlInterface       $urlBuilder         
     * @param array              $components         
     * @param array              $data               
     * @param [type]             $editUrl            
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlBuilder $actionUrlBuilder,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $deleteUrl = self::GROUP_URL_PATH_DELETE,
        $editUrl = self::GROUP_URL_PATH_EDIT
        ) {
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
        $this->editUrl = $editUrl;
        $this->deleteUrl = $deleteUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return void
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
           foreach ($dataSource['data']['items'] as & $item) {
                
                $name = $this->getData('name');
                if (isset($item['message_id'])) {
                    $item[$name]['edit'] = [
                    'href' => $this->urlBuilder->getUrl($this->editUrl, ['message_id' => $item['message_id']]),
                    'label' => __('View')
                    ];
                $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(
                            $this->deleteUrl,
                            [
                                'message_id' => $item['message_id']
                            ]
                        ),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "${ $.$data.subject }"'),
                            'message' => __('Are you sure you wan\'t to delete a "${ $.$data.subject }" record?')
                        ]
                ];      
                }
            }
        }
        return $dataSource;
    }
}