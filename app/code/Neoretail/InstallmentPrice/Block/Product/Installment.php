<?php

namespace Neoretail\InstallmentPrice\Block\Product;

class Installment extends \Magento\Catalog\Block\Product\View {

    private $installmentData;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Neoretail\InstallmentPrice\Helper\Data $installmentData,
        array $data = []
    ){
        parent::__construct(
            $context, $urlEncoder, $jsonEncoder, $string,
            $productHelper, $productTypeConfig, $localeFormat,
            $customerSession, $productRepository, $priceCurrency
        );

        $this->installmentData = $installmentData;
    }

    public function getFinalPrice(){
        $product = $this->getProduct();
        if($product->getTypeId() == "grouped"){
            $_associatedProducts = $product->getTypeInstance()->getAssociatedProducts($product);
            $_hasAssociatedProducts = count($_associatedProducts) > 0;

            $finalPrice = 0;

            foreach ($_associatedProducts as $_item) {
                $finalPrice += $_item->getFinalPrice() * $_item->getQty();
            }

            return $finalPrice;
        } else {
            return $product->getFinalPrice();
        }
    }

    public function getInstallmentNumber(){
        return $this->installmentData->getGeneralConfig('installment_number');
    }

    public function getInstallmentMinAmount(){
        return $this->installmentData->getGeneralConfig('installment_minamout');
    }

    public function getInstallmentListNumber(){
        return $this->installmentData->getGeneralConfig('installment_list_number');
    }
}
