<?php

class HB_Pickup_Model_Observer
{
    protected $code = 'hb_pickup';
    protected $carrier;

    public function __construct()
    {
        $this->carrier = Mage::getSingleton('shipping/config')->getCarrierInstance($this->code);
    }

    /**
     * Set pickup point name to order
     *
     * @param Varieb_Object $observer
     * @return HB_Pickup_Model_Observer
     */
    public function saveCustomData($observer)
    {

        $session = Mage::getSingleton("core/session");
        $request = $observer->getEvent()->getRequest();

        $method = $request->getParam('shipping_method');

        $session->setData('pickup_point', '');

        if ($this->checkShipping($method)) {
            $point = $request->getParam('pickup_point');
            $points = $this->carrier->getPoints();
            if ($points[$point]) {
                $point_name = $points[$point]['value'];
                $session->setData('pickup_point', $point_name);
            }
        }

        return $this;
    }

    /**
     * Сhecks if the method belongs to the module
     *
     * @param string $method
     * @return bool
     */
    protected function checkShipping($method)
    {
        if (strpos($method, $this->code) === 0) {
            return true;
        } else {
            return false;
        }
    }



    public function updateOrderCreationQuoteWithPickupPoint($observer)
    {
        $event = $observer->getEvent();
        $order = $event->getOrder();

        $method = $order->getShippingMethod();

        if($this->checkShipping($method)){
            $session = Mage::getSingleton("core/session");
            $point = $session->getData('pickup_point');
            $order->setPickupPoint($point);
        }
    }
}