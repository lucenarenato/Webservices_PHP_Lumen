<?php

namespace App\Http\Controllers;

use SoapClient;
use SoapFault;
use StdClass;
use SoapHeader;
use GuzzleHttp\Client;
use App\Types\ClientType;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Zend\Config\Config;
use Zend\Config\Writer\Xml;
use Zend\Server\Client as ServerClient;
use Zend\Stdlib\ArrayUtils;
use Artisaninweb\SoapWrapper\SoapWrapper;
use App\Soap\Request\GetConversionAmount;
use App\Soap\Response\GetConversionAmountResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerSearchController
{
    public function index()
    {
        try {
            $options = ['loginUser' => '*******', 'senhaUser' => '*******', 'codigoUser' => '********'];
            $client = new \SoapClient('http://scorehmws.guep.com.br/guepsoap/autenticar/autenticacao.php?wsdl');
            
            $retorno = $client->__soapCall('GuepWS.ativarToken', [
                'ativarTokenRequest' => $options
            ]);
    
            var_dump($retorno);

        } catch (\SoapFault $exception) {
            var_dump($exception);
        }
    }

    public function teste()
    {
        //$client = new \SoapClient($wsdl, $options);
        //$options = ['loginUser' => '******', 'senhaUser' => '*******', 'codigoUser' => '********'];
        $url = 'http://scorehmws.guep.com.br/guepsoap/autenticar/autenticacao.php?wsdl';
        $client = new \SoapClient($url);

        $CustomerSearch = array(
            'loginUser' => '******',
            'senhaUser' => '*******',
            'codigoUser' => '********'
        );

        $xml = array('CustomerSearch' => $CustomerSearch);

        $result = $client->CustomerSearch(array('xml' => $xml));
        var_dump($result);
        return son_response()->make($result);
    }
    public function teste2()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');

        echo $response->getStatusCode(); # 200
        echo $response->getHeaderLine('content-type'); # 'application/json; charset=utf8'
        echo $response->getBody(); # '{"id": 1420053, "name": "guzzle", ...}'
    }

    public function testeG()
    {
        $client = new Client();
        $account = ['loginUser' => '******', 'senhaUser' => '*******', 'codigoUser' => '********'];
        $response = $client->get('http://scorehmws.guep.com.br/guepsoap/autenticar/autenticacao.php?wsdl', [
            \GuzzleHttp\RequestOptions::JSON => ['foo' => 'bar']
        ]);
        var_dump($response);
    }

    public function teste3()
    {
        $account = ['loginUser' => '******', 'senhaUser' => '*******', 'codigoUser' => '********'];
        $client = new \GuzzleHttp\Client(['base_uri' => 'http://scorehmws.guep.com.br/guepsoap/autenticar/autenticacao.php?wsdl']);
        $response = $client->get($account);
        echo $response->getBody();
    }

    public function exemplo()
    {
        //EXEMPLO DE AUTENTICACAO

        //Dados que serão enviados na requisição
        //No score, eles sempre irão possui um "cabeçalho", nesse exemplo, o ativarTokenRequest
        $options = [
            'ativarTokenRequest' => [
                'loginUser' => '******',
                'senhaUser' => '*******',
                'codigoUser' => '********'
            ]
        ];

        echo "<h3>DADOS ENVIADOS</h3><br/>";
        print_r($options);
        echo "<br/>";

        //"Rota" que será utilizada para chamar os métodos
        $client = new \SoapClient('http://scorehmws.guep.com.br/guepsoap/autenticar/autenticacao.php?wsdl');

        /*
        * O método __soapCall vai receber no minimo 2 parâmetros
        * function_name -> Nome da função que será requisitada (O nome das funções estão descritas no manual)
        * arguments -> array com os dados da requisição.
        * Essa informação é mais facilmente visualizada no wsdl
        * Retorno da API sempre será um objeto, com diferentes atributos a depender do que está sendo requisitado
        */
        $retornoAuth = $client->__soapCall('GuepWs.ativarToken', $options);

        //Os atributos do retorno da autenticação estão descritos no manual.
        //Pelo manual, você poderá visualizar os formatos de retorno, e quais atributos esse objeto poderá possuir

        echo "<h3>RETORNO AUTENTICACAO</h3> <br/>";
        print_r($retornoAuth);


        echo '***************************************************************************************************** <br/>';
    }

    public function pesquisa()
    {
        //ini_set('soap.wsdl_cache_enabled',0); 
        //ini_set('soap.wsdl_cache_ttl',0);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);

        error_reporting(E_ALL);

        echo '<pre/>';

        try {

            //EXEMPLO DE AUTENTICACAO

            //Dados que serão enviados na requisição
            //No score, eles sempre irão possui um "cabeçalho", nesse exemplo, o ativarTokenRequest
            $options = [
                'ativarTokenRequest' => [
                    'loginUser' => '******',
                    'senhaUser' => '*******',
                    'codigoUser' => '********'
                ]
            ];

            echo "<h3>DADOS ENVIADOS</h3><br/>";
            print_r($options);
            echo "<br/>";

            //"Rota" que será utilizada para chamar os métodos
            $client = new \SoapClient('http://scorehmws.guep.com.br/guepsoap/autenticar/autenticacao.php?wsdl');

            /*
            * O método __soapCall vai receber no minimo 2 parâmetros
            * function_name -> Nome da função que será requisitada (O nome das funções estão descritas no manual)
            * arguments -> array com os dados da requisição.
            * Essa informação é mais facilmente visualizada no wsdl
            * Retorno da API sempre será um objeto, com diferentes atributos a depender do que está sendo requisitado
            */
            $retornoAuth = $client->__soapCall('GuepWs.ativarToken', $options);

            //Os atributos do retorno da autenticação estão descritos no manual.
            //Pelo manual, você poderá visualizar os formatos de retorno, e quais atributos esse objeto poderá possuir

            echo "<h3>RETORNO AUTENTICACAO</h3> <br/>";
            print_r($retornoAuth);


            echo '***************************************************************************************************** <br/>';

            //EXEMPLO DE PESQUISA
         

            $options = [
                'PesquisaRequest' => [
                    'tokenAuth' => $retornoAuth->tokenAuth,
                    'codeMatriz' => '********',
                    'codigoUser' => '********',
                    //'status' => true,
                    //'mensagem' => 'sucesso',
                    'nome' => 'Renato Lucena ACORDO',
                    'nome_mae' => 'Nome da Mae',
                    'data_nascimento' => '30/06/1985',
                    'documento' => '00000000000',
                    'placa' => 'NNN8888',
                    'renavam' => '97746879515',
                    'renavam_uf' => 'GO',
                    'criterio' => 'Consulta Veiculo PF'
                ]
            ];

            echo '<h3>EXEMPLO DE PESQUISA </h3><br/>';
            print_r($options);

            echo "<br/>";

            $client = new \SoapClient('http://scorehmws.guep.com.br/guepsoap/pesquisa/pesquisa.php?wsdl');

            $retornoPesquisa = $client->__soapCall('GuepPesquisa.pesquisa', $options);

       
            echo '<h3>RETORNO JSON</h3><br/>';
            echo "<pre>".json_encode($retornoPesquisa, JSON_PRETTY_PRINT)."</pre>";

            echo '<h3>RETORNO PESQUISA COM ERRO</h3><br/>';
            print_r($retornoPesquisa);

        }catch (\SoapFault $exception) {
            var_dump($exception);
        }

    }
    
    // usar zend - Autenticação OK!
    public function zend()
    {
        try {
            $options = [
                'ativarTokenRequest' => [
                    'loginUser' => '******',
                    'senhaUser' => '*******',
                    'codigoUser' => '********'
                ]
            ];

            print_r($options);

            $client = new \Zend\Soap\Client('http://scorehmws.guep.com.br/guepsoap/autenticar/autenticacao.php?wsdl', array('soap_version' => SOAP_1_1));
            
            $retornoAuth = $client->__call('GuepWs.ativarToken', $options);
    
            print_r($retornoAuth);

            //PESQUISA usando zend
            $options = [
                'PesquisaRequest' => [
                    'tokenAuth' => $retornoAuth->tokenAuth,
                    'codeMatriz' => '********',
                    'codigoUser' => '********',
                    //'status' => true,
                    //'mensagem' => 'sucesso',
                    'nome' => 'Renato Lucena ACORDO',
                    'nome_mae' => 'Nome da Mae',
                    'data_nascimento' => '30/06/1985',
                    'documento' => '76798518168',
                    'placa' => 'KFB1189',
                    'renavam' => '75488211885',
                    'renavam_uf' => 'GO',
                    'criterio' => 'Consulta Veiculo PF'
                ]
            ];
            print_r($options);
            $client = new \Zend\Soap\Client('http://scorehmws.guep.com.br/guepsoap/pesquisa/pesquisa.php?wsdl', array('soap_version' => SOAP_1_1));

            $retornoPesquisa = $client->__call('GuepPesquisa.pesquisa', $options);

            print_r($retornoPesquisa);

        } catch (SoapFault $exception) {
            echo $exception->getMessage();
            //echo $exception;
            //var_dump($exception);
        }
 
    }

    public function zendConsulta()
    {
        try {
            $options = [
                'ativarTokenRequest' => [
                    'loginUser' => '******',
                    'senhaUser' => '*******',
                    'codigoUser' => '********'
                ]
            ];

            //print_r($options);

            $client = new \Zend\Soap\Client('http://scorehmws.guep.com.br/guepsoap/autenticar/autenticacao.php?wsdl', array('soap_version' => SOAP_1_1));
            
            $retornoAuth = $client->__call('GuepWs.ativarToken', $options);
    
            print_r($retornoAuth);

            //PESQUISA usando zend
            $options = [
                'consultaRequest' => [
                    'tokenAuth' => $retornoAuth->tokenAuth,
                    'referencia' => 'MOBILE_5DF3AA19AD25C',
                    'conjunto' => 'N',
                    'codeMatriz' => '********',
                    'codigoUser' => '********',
                    'CPFCNPJ' => '76798518168'
                ]
            ];
            print_r($options);
            $client = new \Zend\Soap\Client('http://scorews.guep.com.br/guepsoap/consulta/consulta.php?wsdl', array('soap_version' => SOAP_1_1));

            $retornoConsulta = $client->__call('GuepConsulta.gerarConsulta', $options);

            print_r($retornoConsulta);

        } catch (SoapFault $exception) {
            echo $exception->getMessage();
        }
 
    }

    public function zend1()
    {
        try {
            $options = [
                'ativarTokenRequest' => [
                    'loginUser' => '******',
                    'senhaUser' => '*******',
                    'codigoUser' => '********'
                ]
            ];
            $client = new \Zend\Soap\Client('http://scorehmws.guep.com.br/guepsoap/autenticar/autenticacao.php?wsdl', array('soap_version' => SOAP_1_1));
            
            $retornoAuth = $client->__call('GuepWs.ativarToken', $options);
    
            print_r($retornoAuth);

        } catch (SoapFault $exception) {
            echo $exception->getMessage();
            //echo $exception;
            //var_dump($exception);
        }
 
    }

   
    protected function getXML($data)
    {
        if($data instanceof Arrayable){
            $data = $data->toArray();
        }
        $config = new Config(['result' => $data],true);
        $xmlWriter = new Xml();
        return $xmlWriter->toString($config);
    }

    function mod()
    {
        return [
            'wsdl' => 'http://www.webservicex.net/uszip.asmx?WSDL',
            'auth' => false,
            'user' => '',
            'pass' => '',
            'options' => [
                    'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
                    'style'=>SOAP_RPC,
                    'use'=>SOAP_ENCODED,
                    'soap_version'=>SOAP_1_1,
                    'cache_wsdl'=>WSDL_CACHE_NONE,
                    'connection_timeout'=>15,
                    'trace'=>true,
                    'encoding'=>'UTF-8',
                    'exceptions'=>true,
            ],
        ];
    }
    public function request($method, $request)
    {
        try {
            $data = $this->client->__soapCall($method,[$request]);
        }
        catch(Exception $e) {
            die($e->getMessage());
        }
        $data = simplexml_load_string($data->{$method.'Result'}->any);
//        $data = json_encode($data);
//        $data = json_decode($data,TRUE);
        return $data;
    }

    //Exemplo de todos aeroportos
    public function exemploAirPort()
    {
        $urlWsdl = 'http://www.webservicex.net/airport.asmx?WSDL';
        try {
        $soapClient = new \SoapClient($urlWsdl, [
                'exceptions' => true
            ]);
        $requestData = [ 'country' => 'brazil' ];

        $response = $soapClient->GetAirportInformationByCountry($requestData);

        // https://www.php.net/manual/pt_BR/class.simplexmlelement.php
        // retorno uma string XML que pode ser facilmente convertida para uma estrutura de objetos com a biblioteca SimpleXmlElement
        } catch (SoapFault $exception) {
        echo $exception->getMessage();
        return;
        }
    }
}
/**
* $a = new SimpleXMLElement("<a/>");
* $a->addChild('b');
* var_dump($a->asXML());
 * * */