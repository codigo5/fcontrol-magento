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
class Fcontrol_Antifraude_Model_Source_Service
{
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label' => '[ Frame ] Padrão'),
            array('value' => 2, 'label' => '[ Modelo de Filas ] Análise lojista único'),
            //array('value' => 3, 'label' => '[ Modelo de Filas ] Análise lojista único para Análise de Risco na venda de Passagens'),
            //array('value' => 4, 'label' => '[ Modelo de Filas ] Análise vários lojistas'),
            //array('value' => 5, 'label' => '[ Modelo Recarda ] WebService')
        );
    }
}
