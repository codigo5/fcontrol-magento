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
 * @package    Fcontrol_Antifraude
 * @copyright  Copyright (c) 2016 FCONTROL (https://www.fcontrol.com.br/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Fcontrol_Antifraude_Block_Config_Adminhtml_Form_Field_Payments extends Mage_Core_Block_Html_Select
{
    public function _toHtml()
    {
        $payments = Mage::getSingleton('payment/config')->getActiveMethods();
        foreach ($payments as $paymentCode => $paymentModel) {
            $paymentTitle = Mage::getStoreConfig('payment/' . $paymentCode . '/title');
            $this->_paymentsRenderer[] = array('value' => $paymentCode, 'label' => $paymentTitle);

            $this->addOption($paymentCode, $paymentTitle);
        }
        return parent::_toHtml();
    }

    public function setInputName($value)
    {
        return $this->setName($value);
    }
}