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
abstract class Fcontrol_Antifraude_Model_Api_Abstract extends Varien_Object
{

    /* Tipo de Serviço */
    const FRAME = 1;
    const FILA_LOJISTA_UNICO = 2;
    const FILA_LOJISTA_PASSAGENS = 3;
    const FILA_VARIOS_LOJISTAS = 4;
    const RECARGA_WEBSERVICE = 5;

    /* Status */
    const STATUS_PENDENTE = 1;
    const STATUS_ENVIADO = 2;
    const STATUS_CANCELADO = 3;
    const STATUS_AGUARDANDO_DOCUMENTACAO = 5;
    const STATUS_CANCELADO_POR_SUSPEITA = 6;
    const STATUS_APROVADA = 7;
    const STATUS_EM_ESPERA = 8;
    const STATUS_SOLICITADA_SUPERVISAO = 9;
    const STATUS_FRAUDE_CONFIRMADA = 10;
    const STATUS_EM_RECUPERACAO_DE_PERDA = 11;
    const STATUS_RECUPERADO = 12;
    const STATUS_REPROVADO_OPERADORA_CARTAO = 13;
    const STATUS_DESCANCELADO = 14;
    const STATUS_AGUARDANDO_DOCUMENTACAO_FILA = 17;
    const STATUS_SOLICITAR_CONTATO = 18;
    const STATUS_CONTATO_EFETUADO = 19;
    const STATUS_APROVADO_OPERADORA_CARTAO = 23;

    public static $acaoAprovar = array(
        self::STATUS_ENVIADO,
        self::STATUS_APROVADA,
        self::STATUS_RECUPERADO,
        self::STATUS_DESCANCELADO,
        self::STATUS_APROVADO_OPERADORA_CARTAO
    );

    public static $acaoCancelar = array(
        self::STATUS_CANCELADO,
        self::STATUS_CANCELADO_POR_SUSPEITA,
        self::STATUS_FRAUDE_CONFIRMADA,
        self::STATUS_REPROVADO_OPERADORA_CARTAO
    );

    public static $acaoIndefinida = array(
        self::STATUS_PENDENTE,
        self::STATUS_ENVIADO,
        self::STATUS_AGUARDANDO_DOCUMENTACAO,
        self::STATUS_EM_ESPERA,
        self::STATUS_SOLICITADA_SUPERVISAO,
        self::STATUS_EM_RECUPERACAO_DE_PERDA,
        self::STATUS_REPROVADO_OPERADORA_CARTAO,
        self::STATUS_AGUARDANDO_DOCUMENTACAO_FILA,
        self::STATUS_SOLICITAR_CONTATO,
        self::STATUS_CONTATO_EFETUADO
    );

    public $_paymentMethod = array(
        1 => 'CartaoCredito',
        2 => 'CartaoVisa',
        3 => 'CartaoMasterCard',
        4 => 'CartaoDiners',
        5 => 'CartaoAmericanExpress',
        6 => 'CartaoHiperCard',
        7 => 'CartaoAura',
        10 => 'PagamentoEntrega',
        11 => 'DebitoTransferenciaEletronica',
        12 => 'BoletoBancario',
        13 => 'Financiamento',
        14 => 'Cheque',
        15 => 'Deposito',
        18 => 'ValePresente',
        21 => 'OiPaggo',
        25 => 'CartaoSoroCred',
        27 => 'BoletoAPrazo',
        34 => 'TransferenciaEletronicaBancoBrasil',
        35 => 'TransferenciaEletronicaBradesco',
        36 => 'TransferenciaEletronicaItau'
    );

    public $_levelRisk = array(
        0 => 'Baixo Risco',
        1 => 'Médio Risco',
        2 => 'Alto Risco'
    );

    public $_statusOrderReturned = array(
        2 => 'Enviado',
        3 => 'Cancelado',
        6 => 'Cancelado por Suspeita',
        7 => 'Aprovada',
        10 => 'Fraude Confirmada',
        13 => 'Não Aprovado pela operadora do cartão'
    );

    /**
     * Parameter $_wsdl
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    private $_wsdl;

    /**
     * Parameter $usuario
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $usuario;

    /**
     * Parameter $senha
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $senha;

    /**
     * Parameter $compradorNome
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorNome;

    /**
     * Parameter $compradorPais
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorPais;

    /**
     * Parameter $compradorCep
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorCep;

    /**
     * Parameter $compradorRua
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorRua;

    /**
     * Parameter $compradorNumero
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorNumero;

    /**
     * Parameter $compradorComplemento
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorComplemento;

    /**
     * Parameter $compradorBairro
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorBairro;

    /**
     * Parameter $compradorCidade
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorCidade;

    /**
     * Parameter $compradorEstado
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorEstado;

    /**
     * Parameter $compradorCpfCnpj
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorCpfCnpj;

    /**
     * Parameter $compradorDddTelefone1
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorDddTelefone1;

    /**
     * Parameter $compradorTelefone1
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorTelefone1;

    /**
     * Parameter $compradorDddCelular
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorDddCelular;

    /**
     * Parameter $compradorCelular
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorCelular;

    /**
     * Parameter $compradorIp
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorIp;

    /**
     * Parameter $compradorEmail
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorEmail;

    /**
     * Parameter $compradorSenha
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorSenha;

    /**
     * Parameter $compradorSexo
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorSexo;

    /**
     * Parameter $compradorDddTelefone2
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorDddTelefone2;

    /**
     * Parameter $compradorTelefone2
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorTelefone2;

    /**
     * Parameter $compradorDataNascimento
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compradorDataNascimento = '2000-01-01';

    /**
     * Parameter $entregaPais
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaPais;

    /**
     * Parameter $entregaCep
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaCep;

    /**
     * Parameter $entregaRua
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaRua;

    /**
     * Parameter $entregaNumero
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaNumero;

    /**
     * Parameter $entregaComplemento
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaComplemento;

    /**
     * Parameter $entregaBairro
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaBairro;

    /**
     * Parameter $entregaCidade
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaCidade;

    /**
     * Parameter $entregaEstado
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaEstado;

    /**
     * Parameter $entregaDddTelefone1
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaDddTelefone1;

    /**
     * Parameter $entregaNome
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaNome;

    /**
     * Parameter $entregaTelefone1
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaTelefone1;

    /**
     * Parameter $entregaDddCelular
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaDddCelular;

    /**
     * Parameter $entregaCelular
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaCelular;

    /**
     * Parameter $entregaDddTelefone2
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaDddTelefone2;

    /**
     * Parameter $entregaTelefone2
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaTelefone2;

    /**
     * Parameter $entregaCpfCnpj
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaCpfCnpj;

    /**
     * Parameter $entregaSexo
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaSexo;

    /**
     * Parameter $entregaDataNascimento
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaDataNascimento = '2000-01-01';

    /**
     * Parameter $entregaEmail
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $entregaEmail;

    /**
     * Parameter $metodoPagamento
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $metodoPagamento = 'CartaoCredito';

    /**
     * Parameter $nomeBancoEmissor
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $nomeBancoEmissor;

    /**
     * Parameter $numeroCartao
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $numeroCartao;

    /**
     * Parameter $dataValidadeCartao
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $dataValidadeCartao;

    /**
     * Parameter $nomeTitularCartao
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $nomeTitularCartao;

    /**
     * Parameter $cpfTitularCartao
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $cpfTitularCartao;

    /**
     * Parameter $bin
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $bin;

    /**
     * Parameter $quatroUltimosDigitosCartao
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $quatroUltimosDigitosCartao;

    /**
     * Parameter $bin2
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $bin2;

    /**
     * Parameter $binBanco
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $binBanco;

    /**
     * Parameter $binPais
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $binPais;

    /**
     * Parameter $pagadorDddTelefone
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $pagadorDddTelefone;

    /**
     * Parameter $pagadorTelefone
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $pagadorTelefone;

    /**
     * Parameter $valorPedido
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $valorPedido;

    /**
     * Parameter $numeroParcelas
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $numeroParcelas;

    /**
     * Parameter $codigoPedido
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $codigoPedido;

    /**
     * Parameter $dataCompra
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $dataCompra;

    /**
     * Parameter $itensDistintos
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $itensDistintos;

    /**
     * Parameter $itensTotal
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $itensTotal;

    /**
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $valorTotalCompra;

    /**
     * Parameter $valorTotalFrete
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $valorTotalFrete;

    /**
     * Parameter $prazoEntrega
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $prazoEntrega;

    /**
     * Parameter $formaEntrega
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $formaEntrega;

    /**
     * Parameter $observacao
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $observacao;

    /**
     * Parameter $canalVenda
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $canalVenda;

    /**
     * Parameter $extra1
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $extra1;

    /**
     * Parameter $extra2
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $extra2;

    /**
     * Parameter $extra3
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $extra3;

    /**
     * Parameter $extra4
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $extra4;

    /**
     * Parameter $produtoCodigo
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $produtoCodigo;

    /**
     * Parameter $produtoDescricao
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $produtoDescricao;

    /**
     * Parameter $produtoQtde
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $produtoQtde;

    /**
     * Parameter $produtoValor
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $produtoValor;

    /**
     * Parameter $produtoCategoria
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $produtoCategoria;

    /**
     * Parameter $produtoListaCasamento
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $produtoListaCasamento;

    /**
     * Parameter $produtoParaPresente
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $produtoParaPresente;

    /**
     * Parameter $status
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $status;

    /**
     * Parameter $comentario
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $comentario;

    /**
     * Parameter $compartilharComentario
     *
     * @var Fcontrol_Antifraude_Model_Api
     */
    public $compartilharComentario = false;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->_wsdl = $this->getEnvironmentUrl();
        $this->usuario = $this->getUser();
        $this->senha = $this->getPassword();
        $this->compradorPais = $this->getCountry();
        $this->entregaPais = $this->getCountry();
        $this->canalVenda = Mage::app()->getStore()->getName();
        $this->prazoEntrega = 0;
    }

    /**
     * preparaTransacao
     *
     * @param $order
     */
    public function preparaTransacao($order)
    {
        try {
            switch (Mage::helper('fcontrol')->getConfig('type_service')) {
                case self::FRAME:
                    $this->chargeFrameValues($order);
                    break;
                case self::FILA_LOJISTA_UNICO:
                case self::FILA_LOJISTA_PASSAGENS:
                case self::FILA_VARIOS_LOJISTAS:
                case self::RECARGA_WEBSERVICE:
                    $this->chargeFilaValues($order);
                    break;
            }


        } catch (Exception $e) {
            Mage::helper("fcontrol")->saveLog("Exception - Fcontrol_Antifraude_Model_Api->analisaFrame2: " . $e->getMessage());
        }
    }

    /**
     * function analisarTransacao
     *
     * @return mixed
     */
    public function analisarTransacao()
    {
        $this->_wsdl = $this->getEnvironmentUrl();
        $client = new Zend_Soap_Client($this->_wsdl,
            array(
                'soap_version' => SOAP_1_1,
                'encoding' => 'ISO-8859-1'
            )
        );

        $data = array(
            'pedido' => array(
                'DadosUsuario' => array(
                    'Login' => $this->usuario,
                    'Senha' => $this->senha
                ),
                'DadosComprador' => array(
                    'NomeComprador' => $this->compradorNome,
                    'Endereco' => array(
                        'Pais' => $this->compradorPais,
                        'Cep' => $this->compradorCep,
                        'Rua' => $this->xmlentities($this->compradorRua),
                        'Numero' => $this->compradorNumero,
                        'Complemento' => $this->xmlentities($this->compradorComplemento),
                        'Bairro' => $this->xmlentities($this->compradorBairro),
                        'Cidade' => $this->xmlentities($this->compradorCidade),
                        'Estado' => $this->compradorEstado
                    ),
                    'CpfCnpj' => $this->compradorCpfCnpj,
                    'DddTelefone' => $this->compradorDddTelefone1,
                    'NumeroTelefone' => $this->compradorTelefone1,
                    'DddCelular' => $this->compradorDddCelular,
                    'NumeroCelular' => $this->compradorCelular,
                    'IP' => $this->compradorIp,
                    'Email' => $this->compradorEmail,
                    'Senha' => $this->compradorSenha,
                    'Sexo' => $this->compradorSexo,
                    'DddTelefone2' => $this->compradorDddTelefone2,
                    'NumeroTelefone2' => $this->compradorTelefone2,
                    'DataNascimento' => $this->compradorDataNascimento
                ),
                'DadosEntrega' => array(
                    'Endereco' => array(
                        'Pais' => $this->entregaPais,
                        'Cep' => $this->entregaCep,
                        'Rua' => $this->xmlentities($this->entregaRua),
                        'Numero' => $this->entregaNumero,
                        'Complemento' => $this->xmlentities($this->entregaComplemento),
                        'Bairro' => $this->xmlentities($this->entregaBairro),
                        'Cidade' => $this->xmlentities($this->entregaCidade),
                        'Estado' => $this->entregaEstado
                    ),
                    'DddTelefone' => $this->entregaDddTelefone1,
                    'NumeroTelefone' => $this->entregaTelefone1,
                    'NomeEntrega' => $this->entregaNome,
                    'DddCelular' => $this->entregaDddCelular,
                    'NumeroCelular' => $this->entregaCelular,
                    'DddTelefone2' => $this->entregaDddTelefone2,
                    'NumeroTelefone2' => $this->entregaTelefone2,
                    'CpfCnpj' => $this->entregaCpfCnpj,
                    'Sexo' => $this->entregaSexo,
                    'DataNascimento' => $this->entregaDataNascimento,
                    'Email' => $this->entregaEmail
                ),
                'Pagamentos' => array(
                    'WsPagamento' => array(
                        'MetodoPagamento' => $this->metodoPagamento,
                        'Cartao' => array(
                            'NomeBancoEmissor' => $this->nomeBancoEmissor,
                            'NumeroCartao' => $this->numeroCartao,
                            'DataValidadeCartao' => $this->dataValidadeCartao,
                            'NomeTitularCartao' => $this->nomeTitularCartao,
                            'CpfTitularCartao' => $this->cpfTitularCartao,
                            'Bin' => $this->bin,
                            'quatroUltimosDigitosCartao' => $this->quatroUltimosDigitosCartao,
                            'Bin_payment' => $this->bin2,
                            'BinBanco' => $this->binBanco,
                            'BinPais' => $this->binPais,
                            'DddTelefone2' => $this->pagadorDddTelefone,
                            'NumeroTelefone2' => $this->pagadorTelefone
                        ),
                        'Valor' => $this->format($this->valorPedido),
                        'NumeroParcelas' => $this->numeroParcelas
                    )
                ),
                'CodigoPedido' => $this->codigoPedido,
                'DataCompra' => $this->dataCompra,
                'QuantidadeItensDistintos' => $this->itensDistintos,
                'QuantidadeTotalItens' => $this->itensTotal,
                'ValorTotalCompra' => $this->format($this->valorTotalCompra),
                'ValorTotalFrete' => $this->format($this->valorTotalFrete),
                'PedidoDeTeste' => false,
                'PrazoEntregaDias' => $this->prazoEntrega,
                'FormaEntrega' => $this->formaEntrega,
                'Observacao' => $this->observacao,
                'CanalVenda' => $this->canalVenda
            )
        );

        $data['Produtos'] = array();

        for ($i = 0; $i < count($this->produtoCodigo); $i++) {
            $data['Produtos']['WsProduto3'] = array(
                'Codigo' => $this->produtoCodigo[$i],
                'Descricao' => $this->produtoDescricao[$i],
                'Quantidade' => $this->produtoQtde[$i],
                'ValorUnitario' => $this->format($this->produtoValor[$i]),
                'Categoria' => $this->produtoCategoria[$i],
                'ListaDeCasamento' => $this->produtoListaCasamento[$i],
                'ParaPresente' => $this->produtoParaPresente[$i]
            );
        }

        $data['DadosExtra'] = array(
            'Extra1' => $this->extra1,
            'Extra2' => $this->extra2,
            'Extra3' => $this->extra3,
            'Extra4' => $this->extra4
        );

        $result = $client->analisarTransacao($data);

        return $result;
    }

    /**
     * function enfileirarTransacao
     *
     * @return mixed
     * @throws Exception
     */
    public function enfileirarTransacao()
    {
        $this->_wsdl = $this->getEnvironmentUrl();
        $client = new Zend_Soap_Client($this->_wsdl,
            array(
                'soap_version' => SOAP_1_1,
                'encoding' => 'UTF-8'
            )
        );
        $data = array(
            'pedido' => array(
                'DadosUsuario' => array(
                    'Login' => $this->usuario,
                    'Senha' => $this->senha
                ),
                'CodigoPedido' => $this->codigoPedido,
                'DataCompra' => (string)$this->dataCompra,
                'DataEntrega' => '2016-02-21T15:30:30',
                'QuantidadeItensDistintos' => (string)$this->itensDistintos,
                'QuantidadeTotalItens' => (string)$this->itensTotal,
                'ValorTotalCompra' => (string)$this->format($this->valorTotalCompra),
                'ValorTotalFrete' => (string)$this->format($this->valorTotalFrete),
                'PedidoDeTeste' => 'true',
                'PrazoEntregaDias' => '3'/*$this->prazoEntrega*/,
                'FormaEntrega' => 'sedex'/*$this->formaEntrega*/,
                'Observacao' => ''/*$this->observacao*/,
                'CanalVenda' => 'loja magento'/*$this->canalVenda*/,
                'StatusFinalizador' => 'Pendente',
                'CodigoIntegrador' => '0',
                'DadosComprador' => array(
                    'NomeComprador' => $this->compradorNome,
                    'Codigo' => 'U001',
                    'CpfCnpj' => $this->compradorCpfCnpj,
                    'Email' => $this->compradorEmail,
                    'DataCadastro' => '1900-01-01',
                    'Endereco' => array(
                        'Pais' => $this->compradorPais,
                        'Cep' => $this->compradorCep,
                        'Rua' => $this->xmlentities($this->compradorRua),
                        'Numero' => $this->compradorNumero,
                        'Complemento' => $this->xmlentities($this->compradorComplemento),
                        'Bairro' => $this->xmlentities($this->compradorBairro),
                        'Cidade' => $this->xmlentities($this->compradorCidade),
                        'Estado' => $this->compradorEstado
                    ),
                    'DataNascimento' => (string)$this->compradorDataNascimento,
                    'IP' => $this->compradorIp
                ),
                'DadosEntrega' => array(
                    'NomeEntrega' => $this->entregaNome,
                    'DataCadastro' => '1900-01-01',
                    'Endereco' => array(
                        'Pais' => $this->entregaPais,
                        'Cep' => $this->entregaCep,
                        'Rua' => $this->xmlentities($this->entregaRua),
                        'Numero' => $this->entregaNumero,
                        'Complemento' => $this->xmlentities($this->entregaComplemento),
                        'Bairro' => $this->xmlentities($this->entregaBairro),
                        'Cidade' => $this->xmlentities($this->entregaCidade),
                        'Estado' => $this->entregaEstado
                    ),
                    'DataNascimento' => (string)$this->entregaDataNascimento
                ),
                'Pagamentos' => array(
                    'WsPagamento2' => array(
                        'MetodoPagamento' => $this->metodoPagamento,
                        'Valor' => (string)$this->format($this->valorPedido),
                        'NumeroParcelas' => (string)$this->numeroParcelas
                    )
                )
            )
        );

        $result = $client->enfileirarTransacao9($data);

        if (!$result->enfileirarTransacao9Result->Sucesso) {
            throw new Exception($result->enfileirarTransacao9Result->Mensagem);
        }

        return $result;

        /* $xml = <<<EOT
 <enfileirarTransacao3 xmlns="http://tempuri.org/">
     <pedido>
         <DadosUsuario>
             <Login>{$this->usuario}</Login>
             <Senha>{$this->senha}</Senha>
         </DadosUsuario>
         <DadosComprador>
           <NomeComprador>{$this->compradorNome}</NomeComprador>
           <Endereco>
             <Pais>{$this->compradorPais}</Pais>
             <Cep>{$this->compradorCep}</Cep>
             <Rua>{$this->xmlentities($this->compradorRua)}</Rua>
             <Numero>{$this->compradorNumero}</Numero>
             <Complemento>{$this->xmlentities($this->compradorComplemento)}</Complemento>
             <Bairro>{$this->xmlentities($this->compradorBairro)}</Bairro>
             <Cidade>{$this->xmlentities($this->compradorCidade)}</Cidade>
             <Estado>{$this->compradorEstado}</Estado>
           </Endereco>
           <CpfCnpj>{$this->compradorCpfCnpj}</CpfCnpj>
           <DddTelefone>{$this->compradorDddTelefone1}</DddTelefone>
           <NumeroTelefone>{$this->compradorTelefone1}</NumeroTelefone>
           <DddCelular>{$this->compradorDddCelular}</DddCelular>
           <NumeroCelular>{$this->compradorCelular}</NumeroCelular>
           <IP>{$this->compradorIp}</IP>
           <Email>{$this->compradorEmail}</Email>
           <Senha>{$this->compradorSenha}</Senha>
           <Sexo>{$this->compradorSexo}</Sexo>
           <DddTelefone2>{$this->compradorDddTelefone2}</DddTelefone2>
           <NumeroTelefone2>{$this->compradorTelefone2}</NumeroTelefone2>
           <DataNascimento>{$this->compradorDataNascimento}</DataNascimento>
         </DadosComprador>
         <DadosEntrega>
           <Endereco>
             <Pais>{$this->entregaPais}</Pais>
             <Cep>{$this->entregaCep}</Cep>
             <Rua>{$this->xmlentities($this->entregaRua)}</Rua>
             <Numero>{$this->entregaNumero}</Numero>
             <Complemento>{$this->xmlentities($this->entregaComplemento)}</Complemento>
             <Bairro>{$this->xmlentities($this->entregaBairro)}</Bairro>
             <Cidade>{$this->xmlentities($this->entregaCidade)}</Cidade>
             <Estado>{$this->entregaEstado}</Estado>
           </Endereco>
           <DddTelefone>{$this->entregaDddTelefone1}</DddTelefone>
           <NumeroTelefone>{$this->entregaTelefone1}</NumeroTelefone>
           <NomeEntrega>{$this->entregaNome}</NomeEntrega>
           <DddTelefone2>{$this->entregaDddTelefone2}</DddTelefone2>
           <NumeroTelefone2>{$this->entregaTelefone2}</NumeroTelefone2>
           <DddCelular>{$this->entregaDddCelular}</DddCelular>
           <NumeroCelular>{$this->entregaCelular}</NumeroCelular>
           <CpfCnpj>{$this->entregaCpfCnpj}</CpfCnpj>
           <Sexo>{$this->entregaSexo}</Sexo>
           <DataNascimento>{$this->entregaDataNascimento}</DataNascimento>
           <Email>{$this->entregaEmail}</Email>
         </DadosEntrega>
         <Pagamentos>
           <WsPagamento>
             <MetodoPagamento>{$this->metodoPagamento}</MetodoPagamento>
             <Cartao>
               <NomeBancoEmissor>{$this->nomeBancoEmissor}</NomeBancoEmissor>
               <NumeroCartao>{$this->numeroCartao}</NumeroCartao>
               <DataValidadeCartao>{$this->dataValidadeCartao}</DataValidadeCartao>
               <NomeTitularCartao>{$this->nomeTitularCartao}</NomeTitularCartao>
               <CpfTitularCartao>{$this->cpfTitularCartao}</CpfTitularCartao>
               <Bin>{$this->bin}</Bin>
               <quatroUltimosDigitosCartao>{$this->quatroUltimosDigitosCartao}</quatroUltimosDigitosCartao>
               <Bin_payment>{$this->bin2}</Bin_payment>
               <BinBanco>{$this->binBanco}</BinBanco>
               <BinPais>{$this->binPais}</BinPais>
               <DddTelefone2>{$this->pagadorDddTelefone}</DddTelefone2>
               <NumeroTelefone2>{$this->pagadorTelefone}</NumeroTelefone2>
             </Cartao>
             <Valor>{$this->format($this->valorPedido)}</Valor>
             <NumeroParcelas>{$this->numeroParcelas}</NumeroParcelas>
           </WsPagamento>
         </Pagamentos>
         <CodigoPedido>{$this->codigoPedido}</CodigoPedido>
         <DataCompra>{$this->dataCompra}</DataCompra>
         <QuantidadeItensDistintos>{$this->itensDistintos}</QuantidadeItensDistintos>
         <QuantidadeTotalItens>{$this->itensTotal}</QuantidadeTotalItens>
         <ValorTotalCompra>{$this->format($this->valorTotalCompra)}</ValorTotalCompra>
         <ValorTotalFrete>{$this->format($this->valorTotalFrete)}</ValorTotalFrete>
         <PedidoDeTeste>false</PedidoDeTeste>
         <PrazoEntregaDias>{$this->prazoEntrega}</PrazoEntregaDias>
         <FormaEntrega>{$this->formaEntrega}</FormaEntrega>
         <Observacao>{$this->observacao}</Observacao>
         <CanalVenda>{$this->canalVenda}</CanalVenda>
         <Produtos>
 EOT;
         for ($i = 0; $i < count($this->produtoCodigo); $i++) {
             $xml .= "
         <WsProduto3>
             <Codigo>{$this->produtoCodigo[$i]}</Codigo>
             <Descricao>{$this->produtoDescricao[$i]}</Descricao>
             <Quantidade>{$this->produtoQtde[$i]}</Quantidade>
             <ValorUnitario>{$this->format($this->produtoValor[$i])}</ValorUnitario>
             <Categoria>{$this->produtoCategoria[$i]}</Categoria>
             <ListaDeCasamento>{$this->produtoListaCasamento[$i]}</ListaDeCasamento>
             <ParaPresente>{$this->produtoParaPresente[$i]}</ParaPresente>
         </WsProduto3>";
         }

         $xml .= "\n";

         $xml .= <<<EOT
         </Produtos>
         <DadosExtra>
           <Extra1>{$this->extra1}</Extra1>
           <Extra2>{$this->extra2}</Extra2>
           <Extra3>{$this->extra3}</Extra3>
           <Extra4>{$this->extra4}</Extra4>
         </DadosExtra>
     </pedido>
 </enfileirarTransacao3>
 EOT;

         $xml =
 <<<EOT
 <enfileirarTransacao9 xmlns="http://tempuri.org/">
       <pedido>
         <DadosUsuario>
           <Login>BettaTecnologiaFil@</Login>
           <Senha>b3tt@t3cfil@</Senha>
           <IdentificadorLojaFilho></IdentificadorLojaFilho>
         </DadosUsuario>
         <DadosComprador>
           <Codigo>COD0001</Codigo>
           <DataCadastro>2016-02-18</DataCadastro>
         </DadosComprador>
         <DadosEntrega>
           <CpfCnpj>39558850896</CpfCnpj>
           <Sexo>M</Sexo>
           <DataNascimento>1990-03-23</DataNascimento>
           <Email>vinicius.taveira@bettatecnologia.com.br</Email>
         </DadosEntrega>
         <Pagamentos>
           <WsPagamento2>
             <Nsu>123456789123</Nsu>
           </WsPagamento2>
           <WsPagamento2>
             <Nsu>123456789129</Nsu>
           </WsPagamento2>
         </Pagamentos>
         <CodigoPedido>PED001</CodigoPedido>
         <CodigoPedido2>PED002</CodigoPedido2>
         <DataCompra>2016-02-18T23:30:30</DataCompra>
         <DataEntrega>2016-02-18T23:30:30</DataEntrega>
         <QuantidadeItensDistintos>2</QuantidadeItensDistintos>
         <QuantidadeTotalItens>2</QuantidadeTotalItens>
         <ValorTotalCompra>15000</ValorTotalCompra>
         <ValorTotalFrete>15000</ValorTotalFrete>
         <PedidoDeTeste>true</PedidoDeTeste>
         <PrazoEntregaDias>3</PrazoEntregaDias>
         <FormaEntrega>sedex</FormaEntrega>
         <Observacao></Observacao>
         <CanalVenda>loja virtual</CanalVenda>
         <Produtos>
           <WsProduto3>
             <ParaPresente>false</ParaPresente>
           </WsProduto3>
           <WsProduto3>
             <ParaPresente>false</ParaPresente>
           </WsProduto3>
         </Produtos>
         <DadosExtra>
           <Extra1></Extra1>
           <Extra2></Extra2>
           <Extra3></Extra3>
           <Extra4></Extra4>
         </DadosExtra>
         <StatusFinalizador>Pendente</StatusFinalizador>
         <CodigoIntegrador>92</CodigoIntegrador>
       </pedido>
     </enfileirarTransacao9>
 EOT;
         $this->_wsdl = $this->getEnvironmentUrl();
         $client = new nusoap_client($this->_wsdl, true);

         $client->soap_defencoding = 'ISO-8859-1';

         $result = $client->call('enfileirarTransacao9', $xml);

         return $result;*/
    }

    /**
     * alterarStatus
     *
     * @return mixed
     */
    public function alterarStatus()
    {
        $data = array(
            'login' => $this->usuario,
            'senha' => $this->senha,
            'codigoPedido' => $this->codigoPedido,
            'status' => $this->status,
            'comentario' => $this->comentario,
            'compartilharComentario' => $this->compartilharComentario
        );

        $this->_wsdl = $this->getEnvironmentUrl();
        $client = new Zend_Soap_Client($this->_wsdl,
            array(
                'soap_version' => SOAP_1_1,
                'encoding' => 'ISO-8859-1'
            )
        );

        $result = $client->alterarStatus($data);

        return $result;
    }

    /**
     * capturarResultados
     *
     * @return null
     */
    public function capturarResultados()
    {
        $this->_wsdl = $this->getEnvironmentUrl();
        $this->usuario = $this->getUser();
        $this->senha = $this->getPassword();

        try {
            $data = array(
                'login' => $this->usuario,
                'senha' => $this->senha
            );

            $client = new Zend_Soap_Client($this->_wsdl,
                array(
                    'soap_version' => SOAP_1_1,
                    'encoding' => 'ISO-8859-1'
                )
            );

            $result = $client->capturarResultadosGeral2($data);

            return $result->capturarResultadosGeral2Result->WsAnalise2;

        } catch (Exception $e) {
            Mage::helper("fcontrol")->saveLog("Exception - Fcontrol_Antifraude_Model_Api_Abstract->capturarResultados(): " . $e->getMessage());
        }

        return null;
    }

    /**
     * confirmarPedido
     *
     * @param $pedido
     * @return mixed
     */
    public function confirmarRetorno($pedido)
    {
        $this->_wsdl = $this->getEnvironmentUrl();
        $this->usuario = $this->getUser();
        $this->senha = $this->getPassword();

        $data = array(
            'login' => $this->usuario,
            'senha' => $this->senha,
            'codigoPedido' => $pedido
        );

        $client = new Zend_Soap_Client($this->_wsdl,
            array(
                'soap_version' => SOAP_1_1,
                'encoding' => 'ISO-8859-1'
            )
        );

        $result = $client->confirmarRetorno($data);

        return $result;
    }

    /**
     * xmlentities
     *
     * @param $text
     * @return mixed
     */
    protected function xmlentities($text)
    {
        $text = str_replace("&", "&#38;#38;", $text);
        return $text;
    }

    /**
     * format
     *
     * @param $currency
     * @return float
     */
    protected function format($currency)
    {
        return (int)$currency * 100;
    }

    /**
     * getEnvironmentUrl
     *
     * @return string
     */
    public function getEnvironmentUrl()
    {
        $wsdlUrl = "http://secure.fcontrol.com.br/WSFControl2/WSFControl2.asmx?wsdl";
        if (!$this->hasData('fcontrol_sandbox')) {
            $this->setData('fcontrol_sandbox', Mage::getStoreConfig('sales/fcontrol/sandbox', $this->getStoreId()));
        }
        if ($this->getData('fcontrol_sandbox')) {
            $wsdlUrl = "http://sandbox.fcontrol.com.br/WSFControl2/WSFControl2.asmx?wsdl";
        }

        return $wsdlUrl;
    }

    /**
     * getUser
     *
     * @return mixed
     */
    public function getUser()
    {
        if (!$this->hasData('fcontrol_user')) {
            $this->setData('fcontrol_user', Mage::getStoreConfig('sales/fcontrol/user', $this->getStoreId()));
        }
        return $this->getData('fcontrol_user');
    }

    /**
     * getPassword
     *
     * @return mixed
     */
    public function getPassword()
    {
        if (!$this->hasData('fcontrol_password')) {
            $passwordDecrypt = Mage::helper('core')->decrypt(Mage::getStoreConfig('sales/fcontrol/password', $this->getStoreId()));
            $this->setData('fcontrol_password', $passwordDecrypt);
        }
        return $this->getData('fcontrol_password');
    }

    /**
     * getTypeService
     *
     * @return mixed
     */
    public function getTypeService()
    {
        if (!$this->hasData('fcontrol_type_service')) {
            $this->setData('fcontrol_type_service', Mage::getStoreConfig('sales/fcontrol/type_service', $this->getStoreId()));
        }
        return $this->getData('fcontrol_type_service');
    }

    /**
     * getNow
     *
     * @return mixed
     */
    public function getNow()
    {
        return Mage::getSingleton('core/date')->date('Y-m-d H:i:s');
    }

    /**
     * getCountry
     *
     * @param null $country_name
     * @return null
     */
    public function getCountry($country_name = null)
    {
        if (is_null($country_name)) {
            $countryId = Mage::getStoreConfig('general/country/default');

            $countryList = Mage::getModel('directory/country')->getResourceCollection()->getData();

            foreach ($countryList as $item) {
                if ($item['country_id'] == $countryId) {
                    $country_name = $item['iso3_code'];
                }
            }
        }

        return $country_name;
    }

    /**
     * chargeFrameValues
     *
     * @param $order
     */
    private function chargeFrameValues($order)
    {
        // call chargeOrderDataValues
        $this->chargeOrderDataValues($order);
    }

    /**
     * chargeFilaValues
     *
     * @param $order
     */
    private function chargeFilaValues($order)
    {
        /* @required */
        $this->compradorTelefone1 = str_replace("-", "", $order->getBillingAddress()->getData('telephone'));

        $this->compradorCelular = str_replace("-", "", $order->getBillingAddress()->getData('fax')); //Alteração Rodrigo


        if ($order->getCustomerGender()) {
            $this->compradorSexo = (intval($order->getCustomerGender()) === 1) ? 'M' : 'F';
        }

        if ($order->getCustomerDob()) {
            $dob = new DateTime($order->getCustomerDob());

            $this->compradorDataNascimento = $dob->format('Y-m-d');
        }

        if ($order->getCustomerGender()) {
            $this->entregaSexo = (intval($order->getCustomerGender()) === 1) ? 'M' : 'F';
        }

        if ($order->getCustomerDob()) {
            $dob = new DateTime($order->getCustomerDob());

            $this->entregaDataNascimento = $dob->format('Y-m-d');;
        }

        $this->entregaEmail = (is_null($order->getShippingAddress()->getEmail())) ? $order->getCustomerEmail() : $order->getShippingAddress()->getEmail();

        $adapter_payment = Mage::getModel('fcontrol/adapter_payment');

        $adapter_payment->filter($order->getPayment(), $this);

        $this->cpfTitularCartao = preg_replace("/[^0-9]/", "", $order->getCustomerTaxvat());

        $items_index = 0;
        if ($order->getAllItems()) {
            foreach ($order->getAllItems() as $items) {
                if (is_null($items->getParentItemId())) {
                    $this->produtoCodigo[$items_index] = utf8_decode($items->getProductId());
                    $this->produtoDescricao[$items_index] = utf8_decode(str_replace("&", "", $items->getName()));
                    $this->produtoQtde[$items_index] = number_format($items->getQtyOrdered(), 0, "", "");
                    $this->produtoValor[$items_index] = number_format($items->getPrice(), 2, ".", "");

                    $item_data = Mage::getModel('catalog/product')->load($items->getProductId());

                    $this->produtoCategoria[$items_index] = implode(";", $item_data->getCategoryIds());
                    $this->produtoListaCasamento[$items_index] = 'false';
                    $this->produtoParaPresente[$items_index] = 'false';
                    $items_index++;
                }
            }
        }

        // call chargeOrderDataValues
        $this->chargeOrderDataValues($order);
    }

    /**
     * chargeOrderDataValues
     *
     * @param $order
     */
    private function chargeOrderDataValues($order)
    {
        /* @required */
        $this->compradorNome = utf8_decode($order->getBillingAddress()->getFirstname() . ' ' . $order->getBillingAddress()->getLastname());

        /* @required */
        $this->compradorCep = preg_replace("/^(\d{5})(\d{3})$/", "\\1-\\2", $order->getBillingAddress()->getPostcode());

        /* @required */
        $this->compradorRua = utf8_decode($order->getBillingAddress()->getStreet1());

        /* @required */
        $this->compradorNumero = ($order->getBillingAddress()->getStreet2()) ? $order->getBillingAddress()->getStreet2() : 'SN';

        $this->compradorComplemento = utf8_decode($order->getBillingAddress()->getStreet3());

        $this->compradorBairro = utf8_decode($order->getBillingAddress()->getStreet4());

        /* @required */
        $this->compradorCidade = utf8_decode($order->getBillingAddress()->getCity());

        /* @required */
        $this->compradorEstado = utf8_decode($order->getBillingAddress()->getRegion());

        $telBilling = preg_replace("/[^0-9]/", "", $order->getBillingAddress()->getTelephone());

        $telBilling = trim($telBilling);

        switch (strlen($telBilling)) {
            case 8:
                $telephoneBilling = $telBilling;
                $dddTelephoneBilling = '';
                break;
            case 10:
                $telephoneBilling = substr($telBilling, -8);
                $dddTelephoneBilling = substr($telBilling, -10, 2);
                break;
            case 12:
                $telephoneBilling = substr($telBilling, -8);
                $dddTelephoneBilling = substr($telBilling, -10, 2);
                break;
        }

        $this->compradorDddTelefone1 = $dddTelephoneBilling;

        $this->compradorTelefone1 = $telephoneBilling;

        /* @required */
        $this->compradorCpfCnpj = preg_replace("/[^0-9]/", "", $order->getCustomerTaxvat());

        $telShipping = preg_replace("/[^0-9]/", "", $order->getShippingAddress()->getTelephone());

        $telShipping = trim($telShipping);

        switch (strlen($telShipping)) {
            case 8:
                $telephoneShipping = $telShipping;
                $dddTelephoneShipping = '';
                break;
            case 10:
                $telephoneShipping = substr($telShipping, -8);
                $dddTelephoneShipping = substr($telShipping, -10, 2);
                break;
            case 12:
                $telephoneShipping = substr($telShipping, -8);
                $dddTelephoneShipping = substr($telShipping, -10, 2);
                break;
        }

        $celBilling = preg_replace("/[^0-9]/", "", $order->getBillingAddress()->getFax());

        $celBilling = trim($celBilling);

        switch (strlen($celBilling)) {
            case 8:
                $celularBilling = $celBilling;
                $dddCelularBilling = '';
                break;
            case 9:
                $celularBilling = $celBilling;
                $dddCelularBilling = '';
                break;
            case 10:
                $celularBilling = substr($celBilling, -8);
                $dddCelularBilling = substr($celBilling, -10, 2);
                break;
            case 12:
                $celularBilling = substr($celBilling, -8);
                $dddCelularBilling = substr($celBilling, -10, 2);
                break;
            case 11:
                $celularBilling = substr($celBilling, -9);
                $dddCelularBilling = substr($celBilling, -11, 2);
                break;
        }

        $this->compradorDddCelular = $dddCelularBilling;

        $this->compradorCelular = $celularBilling;

        /* Alteração Rodrigo - Ddd Shipping*/
        $celShipping = preg_replace("/[^0-9]/", "", $order->getShippingAddress()->getFax());

        $celShipping = trim($celShipping);

        switch (strlen($celShipping)) {
            case 8:
                $celularShipping = $celShipping;
                $dddCelularShipping = '';
                break;
            case 9:
                $celularShipping = $celShipping;
                $dddCelularShipping = '';
                break;
            case 10:
                $celularShipping = substr($celShipping, -8);
                $dddCelularShipping = substr($celShipping, -10, 2);
                break;
            case 12:
                $celularShipping = substr($celShipping, -8);
                $dddCelularShipping = substr($celShipping, -10, 2);
                break;
            case 11:
                $celularShipping = substr($celShipping, -9);
                $dddCelularShipping = substr($celShipping, -11, 2);
                break;
        }

        /* @required */
        $this->compradorEmail = (is_null($order->getBillingAddress()->getEmail())) ? $order->getCustomerEmail() : $order->getBillingAddress()->getEmail();

        $this->entregaCep = preg_replace("/^(\d{5})(\d{3})$/", "\\1-\\2", $order->getShippingAddress()->getPostcode());

        $this->entregaRua = utf8_decode($order->getShippingAddress()->getStreet1());

        $this->entregaNumero = ($order->getShippingAddress()->getStreet2()) ? $order->getShippingAddress()->getStreet2() : 'SN';

        $this->entregaBairro = utf8_decode($order->getShippingAddress()->getStreet4());

        $this->entregaCidade = utf8_decode($order->getShippingAddress()->getCity());

        $this->entregaEstado = utf8_decode($order->getShippingAddress()->getRegion());

        $this->entregaComplemento = utf8_decode($order->getShippingAddress()->getStreet3());


        /* @required */
        $this->entregaNome = $order->getShippingAddress()->getFirstname() . ' ' . $order->getShippingAddress()->getLastname();

        $this->entregaDddTelefone1 = $dddTelephoneShipping;

        $this->entregaTelefone1 = $telephoneShipping;

        $this->entregaDddCelular = $dddCelularShipping; //Alteração Rodrigo

        $this->entregaCelular = $celularShipping; // Alteração Rodrigo

        if ($order->getRemoteIp()) {  //Alteração Rodrigo
            $this->compradorIp = $order->getRemoteIp();
        }

        $this->entregaCpfCnpj = preg_replace("/[^0-9]/", "", $order->getCustomerTaxvat());

        $this->entregaEmail = $order->getShippingAddress()->getEmail();

        /* @required */
        $adapter_payment = Mage::getModel('fcontrol/adapter_payment');

        $adapter_payment->filter($order->getPayment(), $this);

        /* @required */
        $this->numeroParcelas = 1;

        $this->codigoPedido = $order->getIncrementId();

        $created_at = new DateTime($order->getPayment()->getCreatedAt());
        /* @required; @format: ISO 8601 */
        $this->dataCompra = $created_at->format('Y-m-d\TH:i:s');

        $this->itensTotal = 0;
        $this->itensDistintos = 0;
        if ($order->getAllItems()) {
            foreach ($order->getAllItems() as $items) {
                if (is_null($items->getParentItemId())) {
                    $this->itensTotal += intval($items->getQtyOrdered());
                    $this->itensDistintos++;
                }
            }
        }

        $this->valorTotalFrete = number_format($order->getBaseShippingAmount(), 2, ".", "");
        $this->valorTotalCompra = number_format($order->getPayment()->getAmountOrdered(), 2, ".", "");

        /* @required */
        $this->valorPedido = number_format(($this->valorTotalFrete + $this->valorTotalCompra), 2, ".", "");
    }
}