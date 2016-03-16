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
class Fcontrol_Antifraude_Model_Api extends Fcontrol_Antifraude_Model_Api_Abstract
{

    protected $_urlFrame;

    public function __construct()
    {
        $validatorFrameUrl = "https://secure.fcontrol.com.br/validatorframe";
        if (Mage::getStoreConfig('sales/fcontrol/sandbox', $this->getStoreId())) {
            $validatorFrameUrl = "https://sandbox.fcontrol.com.br/validatorframe";
        }
        $this->_urlFrame = $validatorFrameUrl;
        $this->usuario = $this->getUser();
        $this->senha = $this->getPassword();
        $this->compradorPais = $this->getCountry();
        $this->entregaPais = $this->getCountry();
    }

    public function analisaFrame()
    {
        $url_base = $this->_urlFrame . '/validatorframe.aspx';

        $ufComprador = $this->getStateSigla($this->compradorEstado);
        $ufEntrega = $this->getStateSigla($this->entregaEstado);


        $url_base .= '?login=' . $this->getUser();
        $url_base .= '&senha=' . $this->getPassword();

        $url = "";
        $url .= '&nomeComprador=' . urlencode($this->compradorNome);
        $url .= '&sexoComprador=' . urlencode($this->compradorSexo);
        $url .= '&ruaComprador=' . urlencode($this->compradorRua);
        $url .= '&numeroComprador=' . urlencode($this->compradorNumero);
        $url .= '&bairroComprador=' . urlencode($this->compradorBairro);
        $url .= '&complementoComprador=' . urlencode($this->compradorComplemento);
        $url .= '&cidadeComprador=' . urlencode($this->compradorCidade);
        $url .= '&ufComprador=' . $ufComprador;
        $url .= '&paisComprador=' . urlencode($this->compradorPais);
        $url .= '&cepComprador=' . $this->compradorCep;
        $url .= '&cpfComprador=' . $this->compradorCpfCnpj;
        $url .= '&dddComprador=' . $this->compradorDddTelefone1;
        $url .= '&telefoneComprador=' . $this->compradorTelefone1;
        $url .= '&dddCelularComprador=' . $this->compradorDddCelular;
        $url .= '&celularComprador=' . $this->compradorCelular;
        $url .= '&dddComprador2=' . $this->compradorDddCelular;
        $url .= '&telefoneComprador2=' . $this->compradorCelular;
        $url .= '&emailComprador=' . urlencode($this->compradorEmail);
        $url .= '&dataNascimentoComprador=' . $this->compradorDataNascimento;
        $url .= '&ip=' . $this->compradorIp;
        $url .= '&nomeEntrega=' . urlencode($this->entregaNome);
        $url .= '&cpfEntrega=' . $this->entregaCpfCnpj;
        $url .= '&ruaEntrega=' . urlencode($this->entregaRua);
        $url .= '&numeroEntrega=' . urlencode($this->entregaNumero);
        $url .= '&cidadeEntrega=' . urlencode($this->entregaCidade);
        $url .= '&complementoEntrega=' . urlencode($this->entregaComplemento);
        $url .= '&bairroEntrega=' . urlencode($this->entregaBairro);
        $url .= '&ufEntrega=' . $ufEntrega;
        $url .= '&paisEntrega=' . urlencode($this->entregaPais);
        $url .= '&cepEntrega=' . $this->entregaCep;
        $url .= '&dddEntrega=' . $this->entregaDddTelefone1;
        $url .= '&telefoneEntrega=' . $this->entregaTelefone1;
        $url .= '&dddCelularEntrega=' . $this->entregaDddCelular;
        $url .= '&celularEntrega=' . $this->entregaCelular;
        $url .= '&dddEntrega2=' . $this->entregaDddCelular;
        $url .= '&telefoneEntrega2=' . $this->entregaCelular;
        $url .= '&dataNascimentoEntrega=' . $this->entregaDataNascimento;
        $url .= '&codigoPedido=' . $this->codigoPedido;
        $url .= '&quantidadeItensDistintos=' . $this->itensDistintos;
        $url .= '&quantidadeTotalItens=' . $this->itensTotal;
        $url .= '&valorTotalCompra=' . ($this->valorTotalCompra * 100);
        $url .= '&dataCompra=' . $this->dataCompra;
        $url .= '&formaEntrega=' . urlencode($this->formaEntrega);
        $url .= '&metodoPagamentos=' . urlencode($this->metodoPagamento);
        $url .= '&numeroParcelasPagamentos=' . $this->numeroParcelas;
        $url .= '&valorPagamentos=' . ($this->valorPedido * 100);
        
        $url = $url_base . $url;

        echo '<div style="float:left;"><iframe height="85" frameborder="0" width="295" src="' . $url . '"></iframe></div>' . $this->checkRequiredFields();
    }

    /* Proposta */
    public function analisaFrame2()
    {
        try {
            $client = new Zend_Http_Client();

            $url = $this->_urlFrame . '/validatorframe.aspx';

            $client->setUri($url);

            $client->resetParameters();

            $client->setParameterGet('login', $this->getUser());
            $client->setParameterGet('senha', $this->getPassword());
            $client->setParameterGet('nomeComprador', $this->compradorNome);
            $client->setParameterGet('ruaComprador', $this->compradorRua);
            $client->setParameterGet('numeroComprador', $this->compradorNumero);
            $client->setParameterGet('cidadeComprador', $this->compradorCidade);
            $client->setParameterGet('ufComprador', $this->compradorEstado);
            $client->setParameterGet('paisComprador', $this->compradorPais);
            $client->setParameterGet('cepComprador', $this->compradorCep);
            $client->setParameterGet('cpfComprador', $this->compradorCpfCnpj);
            $client->setParameterGet('emailComprador', $this->compradorEmail);
            $client->setParameterGet('nomeEntrega', $this->entregaNome);
            $client->setParameterGet('ruaEntrega', $this->entregaRua);
            $client->setParameterGet('numeroEntrega', $this->entregaNumero);
            $client->setParameterGet('cidadeEntrega', $this->entregaCidade);
            $client->setParameterGet('ufEntrega', $this->entregaEstado);
            $client->setParameterGet('paisEntrega', $this->entregaPais);
            $client->setParameterGet('cepEntrega', $this->entregaCep);
            $client->setParameterGet('dddEntrega', $this->entregaDddTelefone1);
            $client->setParameterGet('telefoneEntrega', $this->entregaTelefone1);
            $client->setParameterGet('codigoPedido', $this->codigoPedido);
            $client->setParameterGet('quantidadeItensDistintos', $this->itensDistintos);
            $client->setParameterGet('quantidadeTotalItens', $this->itensTotal);
            $client->setParameterGet('valorTotalCompra', ($this->valorTotalCompra * 100));
            $client->setParameterGet('dataCompra', $this->dataCompra);
            $client->setParameterGet('metodoPagamentos', $this->metodoPagamento);
            $client->setParameterGet('numeroParcelasPagamentos', $this->numeroParcelas);
            $client->setParameterGet('valorPagamentos', ($this->valorPedido * 100));

            $content = $client->request();

            $body = $content->getBody();

            $images = array();

            preg_match_all('/(img|src)\=(\"|\')[^\"\'\>]+/i', $body, $media);

            preg_match_all('/BACKGROUND-IMAGE:[\s]*url\(.*.gif\);/', $body, $background_images);

            $data_images = preg_replace('/(img|src)(\"|\'|\=\"|\=\')(.*)/i', "$3", $media[0]);

            // images
            foreach ($data_images as $url) {
                $body = preg_replace("~$url~", $this->_urlFrame . "/{$url}", $body);
            }

            foreach ($background_images[0] as $background) {
                $background = str_replace("BACKGROUND-IMAGE: url(", "", $background);
                $background = str_replace(");", "", $background);
                $body = preg_replace("~$background~", $this->_urlFrame . "{$background}", $body);
            }

            echo $body;

        } catch (Exception $e) {
            Mage::helper("fcontrol")->saveLog("Exception - Fcontrol_Antifraude_Model_Api->analisaFrame2: " . $e->getMessage());
            return;
        }
    }

    /**
     * Método para checagem de campos obrigatório na requisição
     * e retorno de instruções para correção
     *
     * @return string
     */
    private function checkRequiredFields()
    {
        $required = $this->requiredList();
        $invalids_fields = "";
        $qtdInvalids = 0;
        foreach ($this as $key => $value) {
            if (in_array($key, $required)) {
                if (empty($value) || is_null($value)) {
                    $qtdInvalids++;
                    $invalids_fields .= (empty($invalids_fields) ? $key : (', ' . $key));
                }
            }
        }
        if ($qtdInvalids > 0) {
            $textNotify = ' campos obrigatórios não preenchidos';
            if ($qtdInvalids == 1) {
                $textNotify = ' campo obrigatório não preenchido';
            }
            $invalids_fields = '<div style="float:left; margin-left: 8px;"><b>Atenção! ' . $qtdInvalids . $textNotify . ' . (' . $invalids_fields . ')</b></div>';
        }
        return $invalids_fields;
    }

    /**
     * Retona array com campos obrigatórios na requisição
     *
     * @return array
     */
    private function requiredList()
    {
        $list = array("_urlFrame",
            "usuario",
            "senha",
            "compradorNome",
            "compradorRua",
            "compradorNumero",
            "compradorCidade",
            "compradorEstado",
            "compradorPais",
            "compradorCep",
            "compradorCpfCnpj",
            "compradorEmail",
            "compradorDataNascimento",
            "entregaNome",
            "entregaRua",
            "entregaCidade",
            "entregaEstado",
            "entregaPais",
            "entregaCep",
            "entregaDddTelefone1",
            "entregaTelefone1",
            "entregaCpfCnpj",
            "codigoPedido",
            "itensDistintos",
            "itensTotal",
            "valorTotalCompra",
            "dataCompra",
            /*"valorTotalFrete",*/
            "metodoPagamento",
            "numeroParcelas",
            "valorPedido");

        return $list;
    }

    private function getStateSigla($estado)
    {
        $uf = $this->removeAcentos($estado);
        $uf = strtolower($uf);
        $uf = str_replace(' ', '_', $uf);

        $_state_sigla = array(
            'acre' => 'AC',
            'alagoas' => 'AL',
            'amapa' => 'AP',
            'amazonas' => 'AM',
            'bahia' => 'BA',
            'ceara' => 'CE',
            'distrito_federal' => 'DF',
            'espirito_santo' => 'ES',
            'goias' => 'GO',
            'maranhao' => 'MA',
            'mato_grosso' => 'MT',
            'mato_grosso_do_sul' => 'MS',
            'minas_gerais' => 'MG',
            'para' => 'PA',
            'paraiba' => 'PB',
            'parana' => 'PR',
            'pernambuco' => 'PE',
            'piaui' => 'PI',
            'rio_de_janeiro' => 'RJ',
            'rio_grande_do_norte' => 'RN',
            'rio_grande_do_sul' => 'RS',
            'rondonia' => 'RO',
            'roraima' => 'RR',
            'santa_catarina' => 'SC',
            'sao_paulo' => 'SP',
            'sergipe' => 'SE',
            'tocatins' => 'TO'
        );

        if (isset($_state_sigla[$uf])) {
            return $_state_sigla[$uf];
        } else {
            return strtoupper($uf);
        }
    }

    /***
     * Função para remover acentos de uma string
     */
    private function removeAcentos($string, $slug = false)
    {
        $string = strtolower($string);
        // Código ASCII das vogais
        $ascii['a'] = range(224, 230);
        $ascii['e'] = range(232, 235);
        $ascii['i'] = range(236, 239);
        $ascii['o'] = array_merge(range(242, 246), array(240, 248));
        $ascii['u'] = range(249, 252);
        // Código ASCII dos outros caracteres
        $ascii['b'] = array(223);
        $ascii['c'] = array(231);
        $ascii['d'] = array(208);
        $ascii['n'] = array(241);
        $ascii['y'] = array(253, 255);
        foreach ($ascii as $key => $item) {
            $acentos = '';
            foreach ($item AS $codigo) $acentos .= chr($codigo);
            $troca[$key] = '/[' . $acentos . ']/i';
        }
        $string = preg_replace(array_values($troca), array_keys($troca), $string);
        // Slug?
        if ($slug) {
            // Troca tudo que não for letra ou número por um caractere ($slug)
            $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
            // Tira os caracteres ($slug) repetidos
            $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
            $string = trim($string, $slug);
        }
        return $string;
    }
}