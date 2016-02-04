<?php

/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to suporte@fcontrol.com.br so we can send you a copy immediately.
 *
 * @category   Fcontrol
 * @package    Fcontrol_Payu
 * @copyright  Copyright (c) 2016 FCONTROL (https://www.fcontrol.com.br/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Fcontrol_Payu_Block_Adminhtml_System_Config_Payments extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    const CONFIG_PATH = 'sales/fcontrol/payments';
    protected $_values = null;

    protected function _construct()
    {
        $this->setTemplate('fcontrol/payu/system/config/payments.phtml');
        return parent::_construct();
    }

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setNamePrefix($element->getName())
            ->setHtmlId($element->getHtmlId());
        return $this->_toHtml();
    }

    public function getValues()
    {
        $values = $this->getActivePaymentMethods();

        return $values;
    }

    public function getIsChecked($name)
    {
        return in_array($name, $this->getCheckedValues());
    }

    public function getCheckedValues()
    {
        if (is_null($this->_values)) {
            $data = $this->getConfigData();
            if (isset($data[self::CONFIG_PATH])) {
                $data = $data[self::CONFIG_PATH];
            } else {
                $data = '';
            }
            $this->_values = explode(',', $data);
        }
        return $this->_values;
    }

    private function getActivePaymentMethods()
    {
        $payments = Mage::getSingleton('payment/config')->getActiveMethods();

        $methods = array();

        foreach ($payments as $paymentCode => $paymentModel) {
            $paymentTitle = Mage::getStoreConfig('payment/' . $paymentCode . '/title');
            $methods[$paymentCode] = $paymentTitle . ' <i>(' . $paymentCode . ')</i>';
        }

        return $methods;

    }
}