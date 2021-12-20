<?php

namespace Neoretail\InstallmentPrice\Block\Lists;

class Installment extends \Magento\Framework\View\Element\Template {

    private $installmentData;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Neoretail\InstallmentPrice\Helper\Data $installmentData,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->installmentData = $installmentData;
        $this->localeFormat = $localeFormat;
        $this->_jsonEncoder = $jsonEncoder;
    }

    public function getPriceFormat(){
        return $this->localeFormat->getPriceFormat();
    }

    public function getJsonConfig($product){
        $config = [
            'productId' => $product->getId(),
            'priceFormat' => $this->localeFormat->getPriceFormat()
        ];
        return $this->_jsonEncoder->encode($config);
    }

    public function getInstallmentNumber(){
        return $this->installmentData->getGeneralConfig('installment_number');
    }

    public function getInstallmentMinAmount(){
        return $this->installmentData->getGeneralConfig('installment_minamout');
    }
}
