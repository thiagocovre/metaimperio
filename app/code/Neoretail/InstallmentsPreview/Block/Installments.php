<?php
/**
 * Neoretail E-comm
 *
 * NOTICE OF LICENSE
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to https://www.neoretail.com for more information.
 *
 * @category Neoretail
 * @package base
 *
 * @copyright Copyright (c) 2021 Neoretail E-comm. (https://www.neoretail.com)
 *
 * @author Neoretail E-comm <contato@neoretail.com>
 */

declare(strict_types=1);

namespace Neoretail\InstallmentsPreview\Block;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\View\AbstractView;
use Magento\Framework\Stdlib\ArrayUtils;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Neoretail\InstallmentPrice\Helper\Data;

class Installments extends AbstractView
{
    protected $priceCurrency;
    /**
     *  @var PriceCurrencyInterface $priceCurrency
     */

    /**
     * @var Data
     */
    private $helperInstallmentPrice;

    /**
     * Installments constructor.
     * @param Context $context
     * @param ArrayUtils $arrayUtils
     * @param Data $helperInstallmentPrice
     * @param array $data
     */
    public function __construct(
        Context $context,
        ArrayUtils $arrayUtils,
        PriceCurrencyInterface $priceCurrency,
        Data $helperInstallmentPrice,
        array $data = []
    ) {
        parent::__construct($context, $arrayUtils, $data);
        $this->priceCurrency = $priceCurrency;
        $this->helperInstallmentPrice = $helperInstallmentPrice;
    }

    protected function _construct()
    {
        $this->setTemplate('Neoretail_InstallmentsPreview::table.phtml');
    }

    /**
     * @return array
     */
    public function calculateInstallments()
    {
        $result = [];

        $maxInstallments = $this->maxInstallments();
        $finalPrice = $this->productFinalPrice();

        for( $installmentsCounter = 1; $installmentsCounter <= $maxInstallments; $installmentsCounter++){
            $installmentPrice = $finalPrice / $installmentsCounter;
            if($installmentPrice > $this->minInstallmentsValue()){
                $result[$installmentsCounter] =
                '<td>'.$installmentsCounter.'x</td>
                <td class="installment-table-price" data-price="'.$installmentPrice.'">de R$ '.$this->getFormatedPrice($installmentPrice).'</td>
                <td>Sem juros</td>
                <td class="installment-table-price" data-price="'.$finalPrice.'">Total '. $this->getFormatedPrice($finalPrice) .'</td>';
            }
        }

        return $result;
    }

    /**
     * @return int
     */
    private function productFinalPrice()
    {
        $product = $this->getProduct();

        return $product->getFinalPrice();
    }

    /**
     * @return int
     */
    private function maxInstallments()
    {
        return $this->helperInstallmentPrice->getGeneralConfig('installment_number');
    }

    /**
     * @return int
     */
    private function minInstallmentsValue()
    {
        return $this->helperInstallmentPrice->getGeneralConfig('installment_minamout');
    }

    /**
     * Get formatted by price and currency
     *
     * @param   $price
     * @param   $currency
     * @return  array || float
     */
    public function getFormatedPrice($price)
    {
        $precision = 2;  // for displaying price decimals 2 point
        return $this->priceCurrency->format(
            $price,
            $includeContainer = true,
            $precision,
            $scope = null,
            'BRL'
        );
    }
}
