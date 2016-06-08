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
class Fcontrol_Antifraude_Block_Config_Adminhtml_Form_Field_Integrations extends Mage_Core_Block_Html_Select
{
    public function _toHtml()
    {
        $integrations_code = array(
            '1' => 'Cartão de Crédito',
            '2' => 'Cartão Visa',
            '3' => 'Cartão MasterCard',
            '4' => 'Cartão Diners',
            '5' => 'Cartão American Express',
            '6' => 'Cartão HiperCard',
            '7' => 'Cartão Aura',
            '10' => 'Pagamento na Entrega',
            '11' => 'Débito/Transferência Eletrônica',
            '12' => 'Boleto Bancário',
            '13' => 'Financiamento',
            '14' => 'Cheque',
            '15' => 'Depósito',
            '18' => 'Vale Presente',
            '21' => 'Oi Paggo',
            '25' => 'Cartão Soro Cred',
            '27' => 'Boleto a Prazo',
            '34' => 'Transferência Eletrônica Banco do Brasil',
            '35' => 'Transferência Eletrônica Bradesco',
            '36' => 'Transferência Eletrônica Itaú',
            '37' => 'Débito em Conta Itaú',
            '46' => 'Cartão Elo',
            '50' => 'Cartão Fidelidade',
            '55' => 'Cielo',
            '56' => 'PayPal',
            '57' => 'Cupom'
        );

        foreach ($integrations_code as $code => $value) {
            $this->addOption($code, '(' . $code . ') ' . $value);
        }
        return parent::_toHtml();
    }

    public function setInputName($value)
    {
        return $this->setName($value);
    }
}