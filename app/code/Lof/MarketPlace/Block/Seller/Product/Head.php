<?php

namespace Lof\MarketPlace\Block\Seller\Product;
use Magento\Framework\App\RequestInterface;
class Head extends \Magento\Framework\View\Element\Template
{
	
    protected $request;

    private $productRepository;
    /**
     * @param \Magento\Framework\View\Element\Template\Context
     * @param \Magento\Framework\Registry
     * @param \Lof\MarketPlace\Model\Seller
     * @param \Magento\Framework\App\ResourceConnection
     * @param array
    */
	public function __construct(
    	\Magento\Framework\View\Element\Template\Context $context,
        RequestInterface $request,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $data = []
        ) {
        parent::__construct($context);
        $this->productRepository = $productRepository;
        $this->request = $request;

        
    }
   
   public function getProductId() {
        $productId = $this->request->getParam('id');
        return $productId;
   }

   public function getProduct() {
        $product = '';
        if($this->getProductId()) {
            $product = $this->productRepository->getById($this->getProductId());
        }
        return $product;
   }
    public function getTypeProduct() {
        $type = $this->request->getParam('type');
        return $type;
    }
     
}