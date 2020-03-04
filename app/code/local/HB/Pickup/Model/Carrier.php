<?php

class HB_Pickup_Model_Carrier
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{
    protected $_code = 'hb_pickup';

    public function collectRates(
        Mage_Shipping_Model_Rate_Request $request
    )
    {
        $result = Mage::getModel('shipping/rate_result');
        /* @var $result Mage_Shipping_Model_Rate_Result */

        $result->append($this->_getStandardShippingRate());

        return $result;
    }

    public function getPoints()
    {
        $points = unserialize($this->getConfigData('points'));

        return $points;
    }

    public function getAllowedMethods()
    {
        return array(
            'standard' => 'Standard',
        );
    }

    protected function _getStandardShippingRate()
    {

        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $rate = Mage::getModel('shipping/rate_result_method');
        /* @var $rate Mage_Shipping_Model_Rate_Result_Method */

        $rate->setCarrier($this->_code);
        /**
         * getConfigData(config_key) returns the configuration value for the
         * carriers/[carrier_code]/[config_key]
         */
        $rate->setCarrierTitle($this->getConfigData('title'));

        $rate->setMethod('standand');
        $rate->setMethodTitle('Standard');

        $rate->setPrice(0);
        $rate->setCost(0);

        return $rate;
    }
}