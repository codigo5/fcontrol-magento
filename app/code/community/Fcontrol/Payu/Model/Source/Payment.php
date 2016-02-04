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
class Fcontrol_Payu_Model_Source_Payment
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = $this->getActivePaymentMethods(true);

        return $options;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $result = $this->getActivePaymentMethods(false);

        return $result;
    }

    /**
     * Busca métodos de pagamento ativos na loja
     *
     * @return array
     */
    private function getActivePaymentMethods($optionArray = false)
    {
        $payments = Mage::getSingleton('payment/config')->getActiveMethods();

        $methods = null;
        if ($optionArray) {
            $options = array();
            foreach ($payments as $paymentCode => $paymentModel) {
                $paymentTitle = Mage::getStoreConfig('payment/' . $paymentCode . '/title');
                $options[] = array('value' => $paymentCode, 'label' => $paymentTitle);
            }
            $methods = $options;
        } else {
            $methods = array();
            foreach ($payments as $paymentCode => $paymentModel) {
                $paymentTitle = Mage::getStoreConfig('payment/' . $paymentCode . '/title');
                $methods[$paymentCode] = $paymentTitle;
            }
        }

        return $methods;

    }
}
