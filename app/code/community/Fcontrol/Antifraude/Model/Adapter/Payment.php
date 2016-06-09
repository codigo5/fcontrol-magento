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
class Fcontrol_Antifraude_Model_Adapter_Payment extends Varien_Object
{

    protected static $_service = array();
    protected static $_additional_data = '10_A01';

    /**
     * Fcontrol_Antifraude_Model_Adapter_Payment constructor.
     */
    public function __construct()
    {
        $allowedPaymentMethods = Mage::helper('fcontrol')->getConfig('payments');
        if (!empty($allowedPaymentMethods)) {
            $allowedPaymentMethods = explode(',', $allowedPaymentMethods);

            // Constrói array com métodos de pagamentos habilitados para FControl
            $methods = array();
            foreach ($allowedPaymentMethods as $method) {
                $methods[$method] = true;
            }

            self::$_service = $methods;
        }
    }

    /**
     * Verifica se a forma de pagamento do pedido pode ser utilizada com o FControl
     *
     * @param null $payment
     * @return bool
     */
    public function validate($payment = null)
    {
        if (in_array($payment->getMethod(), self::$_service)) {
            if (self::$_service[$payment->getMethod()]) {

                if ($payment->getMethod() == "ipgcore") {
                    if ($payment->getData('additional_data') == self::$_additional_data) {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return true;
                }
            }
        }

        return false;
    }

    public function filter($payment = null, Fcontrol_Antifraude_Model_Api_Abstract $api = null)
    {
        if ($api && in_array($payment->getMethod(), self::$_service)) {
            $api->valorPedido = number_format($payment->getAmountOrdered(), 2, ".", "");
            $api->numeroParcelas = 1;
            switch ($api->metodoPagamento) {
                case '1': // Cartão de Crédito
                case '2': // Cartão Visa
                case '3': // Cartão MasterCard
                case '4': // Cartão Diners
                case '5': // Cartão American Express
                case '6': // Cartão HiperCard
                case '7': // Cartão Aura
                case '46': // Cartão Elo
                case '50': // Cartão Fidelidade
                    $api->valorPedido = number_format($payment->getAmountOrdered(), 2, ".", "");
                    $api->nomeBancoEmissor = $payment->getCcType();
                    $api->numeroCartao = $payment->getCcNumber();
                    $api->dataValidadeCartao = $payment->getCcExpMonth() . '/' . $payment->getCcExpYear();
                    $api->nomeTitularCartao = $payment->getCcOwner();
                    $api->quatroUltimosDigitosCartao = $payment->getCcLast4();
                    break;
            }
        }

        return $api;
    }

}
