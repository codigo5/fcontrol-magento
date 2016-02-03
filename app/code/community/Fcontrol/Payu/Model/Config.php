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
class Fcontrol_Payu_Model_Config extends Varien_Object
{
    const XML_PATH = 'sales/fcontrol/';

    const XML_PATH_ACTIVE = 'sales/fcontrol/active';

    const XML_PATH_ACCOUNT = 'sales/fcontrol/account';

    protected $_config = array();

    public function getConfigData($key, $storeId = null)
    {
        if (!isset($this->_config[$key][$storeId])) {
            $value = Mage::getStoreConfig(self::XML_PATH . $key, $storeId);
            $this->_config[$key][$storeId] = $value;
        }
        return $this->_config[$key][$storeId];
    }

    public function getAccount($store = null)
    {
        if (!$this->hasData('fcontrol_account')) {
            $this->setData('fcontrol_account', $this->getConfigData('account', $storeId));
        }

        return $this->getData('fcontrol_account');
    }
}