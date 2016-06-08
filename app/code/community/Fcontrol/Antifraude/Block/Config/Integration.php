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
class Fcontrol_Antifraude_Block_Config_Integration extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    protected $_paymentsRenderer;
    protected $_integrationsRenderer;

    public function _prepareToRender()
    {
        $this->addColumn('payment_method', array(
            'label' => 'Método de pagamento',
            'renderer' => $this->_getPaymentsRenderer(),
        ));
        $this->addColumn('integration_code', array(
            'label' => 'Tipo do método de pagamento',
            'renderer' => $this->_getIntegrationsRenderer(),
        ));

        $this->_addAfter = false;
        $this->_addButtonLabel = 'Adicionar novo';
    }

    protected function _getPaymentsRenderer()
    {
        if (!$this->_paymentsRenderer) {
            $this->_paymentsRenderer = $this->getLayout()->createBlock(
                'fcontrol_antifraude_block_config_adminhtml_form_field_payments', '',
                array('is_render_to_js_template' => true)
            );
        }
        return $this->_paymentsRenderer;
    }

    protected function _getIntegrationsRenderer()
    {
        if (!$this->_integrationsRenderer) {
            $this->_integrationsRenderer = $this->getLayout()->createBlock(
                'fcontrol_antifraude_block_config_adminhtml_form_field_integrations', '',
                array('is_render_to_js_template' => true)
            );
        }
        return $this->_integrationsRenderer;
    }

    protected function _prepareArrayRow(Varien_Object $row)
    {
        $row->setData(
            'option_extra_attr_' . $this->_getPaymentsRenderer()
                ->calcOptionHash($row->getData('payment_method')),
            'selected="selected"'
        );

        $row->setData(
            'option_extra_attr_' . $this->_getIntegrationsRenderer()
                ->calcOptionHash($row->getData('integration_code')),
            'selected="selected"'
        );
    }
}