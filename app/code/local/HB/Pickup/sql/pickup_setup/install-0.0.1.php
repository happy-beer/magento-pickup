<?php
/* @var $installer Mage_Sales_Model_Resource_Setup */
$installer = Mage::getResourceModel('sales/setup', 'sales_setup');

$installer->startSetup();

$installer->addAttribute('order', 'pickup_point', array(
    'label' => 'Pickup point',
    'type' => 'varchar',
    'input' => 'text',
    'required' => false,
));

$installer->endSetup();