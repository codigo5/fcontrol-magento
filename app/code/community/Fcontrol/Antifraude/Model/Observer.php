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
class Fcontrol_Antifraude_Model_Observer
{
    public function controllerFrontInitBefore($observer)
    {
        if ((bool)Mage::helper('fcontrol')->moduleActive()) return;

        if (version_compare(Mage::getVersion(), '1.3.0', '>')) {
            $path = array('customer/address/dob_show', 'customer/address/taxvat_show');

            $address = Mage::getModel('core/config_data')
                ->getCollection()
                ->addPathFilter('customer/address')
                ->load();

            /*if(count($address->getData()) <= 1) {
                if(count($address->getData()) == 1) {
                    
                    $result = $address->getData();
                    
                    if(($result[0]['value'] != 'req') && (in_array($result[0]['path'], $path))) {
                        $data = Mage::getModel('core/config_data')->load($result[0]['config_id']);
                        
                        $data->setValue('req')->save();
                    } else {
                        print_r($result);
                    }
                    
                } else {
                    
                    Mage::getModel('core/config_data')->setPath("customer/address/dob_show")
                    ->setValue('req')
                    ->save();

                    Mage::getModel('core/config_data')->setPath("customer/address/taxvat_show")
                    ->setValue('req')
                    ->save();
                }
            } else {
                
            }*/
        }

        //exit;
    }

    /**
     *  Get list of datas of orders
     *
     * @return string
     */
    public static function frameOrder($observer)
    {
        $order = Mage::getModel('sales/order')->loadByIncrementId($observer->getOrder()->getIncrementId());

        $api = Mage::getModel('fcontrol/api');

        $api->preparaTransacao($order);

        $api->analisaFrame();
    }

    /**
     *  Get list of datas of orders
     *
     * @return string
     */
    public static function checkStatusFrame()
    {
        Mage::helper("fcontrol")->saveLog("Cron executado: fcontrol_observer_check_status - function checkStatusFrame()");
        if (intval(Mage::helper('fcontrol')->getConfig('type_service')) === Fcontrol_Antifraude_Model_Api::FRAME) {

            try {
                $quotes = Mage::getModel('sales/order')->getCollection();

                $quotes->addAttributeToFilter('state',
                    array('in' =>
                        array(
                            Mage_Sales_Model_Order::STATE_COMPLETE,
                            Mage_Sales_Model_Order::STATE_CLOSED,
                            Mage_Sales_Model_Order::STATE_CANCELED
                        )
                    ));

                $quotes->load();

                foreach ($quotes as $quote) {
                    $api = Mage::getModel('fcontrol/api');

                    $api->codigoPedido = intval($quote->getIncrementId());

                    switch ($api->getState()) {
                        case Mage_Sales_Model_Order::STATE_COMPLETE:
                            $api->status = Fcontrol_Antifraude_Model_Api::STATUS_ENVIADO;
                            $api->comentario = "Status do pedido atualizado para 'completo' na Loja";
                            break;
                        case Mage_Sales_Model_Order::STATE_CLOSED:
                            $api->status = Fcontrol_Antifraude_Model_Api::STATUS_CANCELADO;
                            $api->comentario = "Status do pedido atualizado para 'fechado' na Loja";
                            break;
                        case Mage_Sales_Model_Order::STATE_CANCELED:
                            $api->status = Fcontrol_Antifraude_Model_Api::STATUS_CANCELADO;
                            $api->comentario = "Status do pedido atualizado para 'cancelado' na Loja";
                            break;
                    }

                    $api->alterarStatus();
                }
            } catch (Mage_Core_Exception $e) {
                Mage::helper("fcontrol")->saveLog("Exception - Fcontrol_Antifraude_Model_Observer->checkStatusFrame(): " . $e->getMessage());
            }
        }
    }

    /**
     *  Get list of datas of orders
     *
     * @return this
     */
    public function queueListOrder()
    {
        Mage::helper("fcontrol")->saveLog("Cron executado: fcontrol_observer_queue_transaction - function queueListOrder()");
        $quotes = Mage::getModel('sales/order')->getCollection();

        $quotes->addAttributeToFilter('state', Mage_Sales_Model_Order::STATE_NEW);
        $quotes->load();

        foreach ($quotes as $quote) {

            self::queueOrder($quote);
        }

        return $this;
    }

    /**
     *  Get queue of datas of orders
     *
     * @return string
     */
    public static function queueOrder($observer, $analyse = false)
    {
        try {
            $order = Mage::getModel('sales/order')->loadByIncrementId($observer->getIncrementId());

            $api = Mage::getModel('fcontrol/api');

            $api->preparaTransacao($order);

            if ($analyse) {
                return $api->analisarTransacao(); // not used still
            } else {
                return $api->enfileirarTransacao();
            }
        } catch (Mage_Core_Exception $e) {
            Mage::helper("fcontrol")->saveLog("Exception - Fcontrol_Antifraude_Model_Observer->queueOrder(): " . $e->getMessage());
        }
    }

    /**
     *  Get list of datas of orders
     *
     * @return string
     */
    public static function captureList()
    {
        try {
            $api = Mage::getModel('fcontrol/api');

            $data = $api->capturarResultados();

            return $data;

        } catch (Mage_Core_Exception $e) {
            Mage::helper("fcontrol")->saveLog("Exception - Fcontrol_Antifraude_Model_Observer->captureList(): " . $e->getMessage());
            return false;
        }
    }

    /**
     *  Get capture of orders
     *
     * @return string
     */
    public static function captureOrder()
    {
        try {
            Mage::helper("fcontrol")->saveLog("Cron executado: fcontrol_observer_capture_results - function captureOrder()");

            $data = self::captureList();

            $api = Mage::getModel('fcontrol/api');

            if (sizeof($data) == 1) {

                $data = array($data);
            }

            if (is_array($data) && sizeof($data) > 0) {
                $max = count($data);

                for ($i = 0; $i < $max; $i++) {

                    if (isset($data[$i]->CodigoCompra) && is_numeric($data[$i]->CodigoCompra)) {

                        $status = $data[$i]->Status;

                        $order_id = $data[$i]->CodigoCompra;

                        $order = Mage::getModel('sales/order');

                        $order->loadByIncrementId($order_id);

                        if ($order->getId()) {

                            switch ($order->getState()) {
                                case Mage_Sales_Model_Order::STATE_NEW:

                                    try {

                                        if (in_array($status, Fcontrol_Antifraude_Model_Api::$acaoAprovar)) {

                                            $orderState = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;

                                            $orderStatus = $order->getConfig()->getStateDefaultStatus($orderState);

                                            $comment = Mage::helper('fcontrol')->__('Pedido com Pagamento Pendente.');

                                            $order->setState($orderState, $orderStatus, $comment, $notified = true);

                                            $order->save();

                                            $api->confirmarRetorno($order_id);
                                        }

                                        if (in_array($status, Fcontrol_Antifraude_Model_Api::$acaoCancelar)) {
                                            if ($order->canCancel()) {

                                                $order->cancel()->save();

                                                $api->confirmarRetorno($order_id);
                                            }
                                        }

                                    } catch (Mage_Core_Exception $e) {
                                        // implement log
                                    }
                                    break;
                                case Mage_Sales_Model_Order::STATE_PENDING_PAYMENT:

                                    $api->codigoPedido = $order_id;
                                    $api->status = Fcontrol_Antifraude_Model_Api::STATUS_ENVIADO;
                                    $api->comentario = "Status do pedido atualizado para 'pagamento pendente' na Loja";

                                    $api->alterarStatus();
                                    $api->confirmarRetorno($order_id);
                                    break;
                                case Mage_Sales_Model_Order::STATE_PROCESSING:

                                    $api->codigoPedido = $order_id;
                                    $api->status = Fcontrol_Antifraude_Model_Api::STATUS_ENVIADO;
                                    $api->comentario = "Status do pedido atualizado para 'processando' na Loja";

                                    $api->alterarStatus();
                                    $api->confirmarRetorno($order_id);
                                    break;
                                case Mage_Sales_Model_Order::STATE_COMPLETE:

                                    $api->codigoPedido = $order_id;
                                    $api->status = Fcontrol_Antifraude_Model_Api::STATUS_ENVIADO;
                                    $api->comentario = "Status do pedido atualizado para 'completo' na Loja";

                                    $api->alterarStatus();
                                    $api->confirmarRetorno($order_id);
                                    break;
                                case Mage_Sales_Model_Order::STATE_CLOSED:

                                    $api->codigoPedido = $order_id;
                                    $api->status = Fcontrol_Antifraude_Model_Api::STATUS_CANCELADO;
                                    $api->comentario = "Status do pedido atualizado para 'fechado' na Loja";

                                    $api->alterarStatus();
                                    $api->confirmarRetorno($order_id);
                                    break;
                                case Mage_Sales_Model_Order::STATE_CANCELED:

                                    $api->codigoPedido = $order_id;
                                    $api->status = Fcontrol_Antifraude_Model_Api::STATUS_CANCELADO;
                                    $api->comentario = "Pedido atualizado para 'cancelado' na Loja";

                                    $api->alterarStatus();
                                    $api->confirmarRetorno($order_id);
                                    break;
                                case Mage_Sales_Model_Order::STATE_HOLDED:

                                    $api->codigoPedido = $order_id;
                                    $api->status = Fcontrol_Antifraude_Model_Api::STATUS_SOLICITADA_SUPERVISAO;
                                    $api->comentario = "Pedido atualizado para 'segurar' na Loja";

                                    $api->alterarStatus();
                                    $api->confirmarRetorno($order_id);
                                    break;
                            }
                        }
                    }
                }
            }
        } catch (Mage_Core_Exception $e) {
            Mage::helper("fcontrol")->saveLog("Exception - Fcontrol_Antifraude_Model_Observer->captureOrder(): " . $e->getMessage());
        }
    }
}