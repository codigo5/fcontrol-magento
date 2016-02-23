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
class Fcontrol_Antifraude_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View
{

    public function  __construct()
    {
        $confirmFcontrol = $this->getRequest()->getParam('fcontrol');
        if (!$confirmFcontrol) {
            $url = $this->getUrl('*/sales_order/view', array('fcontrol' => true));

            $this->_addButton('fcontrol_button', array(
                'label' => Mage::helper('sales')->__('Consultar FControl'),
                'onclick' => 'setLocation(\'' . $url . '\')',
                'class' => 'go'
            ));
        }

        parent::__construct();
    }

}