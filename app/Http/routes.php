<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return view('index');
});
// $app->get('/', function () use ($app) {
//     return $app->version();
// });
$app->get('holiday', function () use ($app) {
    $app->get('holiday', 'HomeController@index');
});


$app->group([
    'prefix' => 'api/clients',
    'namespace' => 'App\Http\Controllers'
], function () use ($app) {
    $app->get('', 'ClientsController@index');
    $app->get('{id}', 'ClientsController@show');
    $app->post('', 'ClientsController@store');
    $app->put('{id}', 'ClientsController@update');
    $app->delete('{id}', 'ClientsController@destroy');
});

$app->group([
    'prefix' => 'api/clients/{client}/addresses',
    'namespace' => 'App\Http\Controllers'
], function () use ($app) {
    $app->get('', 'AddressesController@index');
    $app->get('{id}', 'AddressesController@show');
    $app->post('', 'AddressesController@store');
    $app->put('{id}', 'AddressesController@update');
    $app->delete('{id}', 'AddressesController@destroy');
});
// Web Services Description Language - WSDL 
$app->get('tcu', function () {
    $client = new \Zend\Soap\Client('http://contas.tcu.gov.br/debito/CalculoDebito?wsdl');
    echo "Informações do Servidor:";
    print_r($client->getOptions());
    echo "Funções:";
    print_r($client->getFunctions());
    echo "Tipos:";
    print_r($client->getTypes());
    echo "Resultado:";
    print_r($client->obterSaldoAtualizado([
        'parcelas' => [
            'parcela' => [
                'data' => '1995-01-01',
                'tipo' => 'D',
                'valor' => 3500
            ]
        ],
        'aplicaJuros' => true,
        'dataAtualizacao' => '2019-12-04'
    ]));

});
// Simple Object Access Protocol - SOAP
$app->get('auth', function () use ($app) {
    $app->get('auth', 'CustomerSearchController@index');
});

$app->get('tango', 'CustomerSearchController@index');
$app->get('teste2', 'CustomerSearchController@teste2');
$app->get('teste3', 'CustomerSearchController@teste3');
$app->get('testeG', 'CustomerSearchController@testeG');
$app->get('exemplo', 'CustomerSearchController@exemplo');
$app->get('search', 'CustomerSearchController@pesquisa');
$app->get('zend', 'CustomerSearchController@zend');
$app->get('zendConsulta', 'CustomerSearchController@zendConsulta');

$app->get('autentica', function () {
    try {
        $options = ['loginUser' => 'wwwww', 'senhaUser' => 'ssssss', 'codigoUser' => 'FDFDFDFDF'];
        $client = new \SoapClient('http://scorehmws.guep.com.br/guepsoap/autenticar/autenticacao.php?wsdl');
        
        $retorno = $client->__soapCall('GuepWS.ativarToken', [
            'ativarTokenRequest' => $options
        ]);

        var_dump($retorno);

    }catch (\SoapFault $exception) {
        var_dump($exception);
    }
});

$app->get('pesquisa', function () {
    try {
        $options = ['loginUser' => 'wwwww', 'senhaUser' => 'ssssss', 'codigoUser' => 'FDFDFDFDF'];
        $autentica = new \SoapClient('http://scorehmws.guep.com.br/guepsoap/autenticar/autenticacao.php?wsdl');
        $auth = $autentica->__soapCall('GuepWS.ativarToken', [
            'ativarTokenRequest' => $options
        ]);

        $client = new \SoapClient('http://scorehmws.guep.com.br/guepsoap/pesquisa/pesquisa.php?wsdl');
        //ValidadeRequest
        $retorno = $client->__soapCall('GuepPesquisa.validade', [
            'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
            'tokenAuth' => $auth,
            'codigoUser' => $auth,
            'codigoMatriz' => 'FDFDFDFDF',
            'documento' => '99999999999',//$client,
            'placa' => 'NEP9502',
            'criterio' => 'CONSULTA VEICULO PF'
        ]);
        
        //dd($retorno);
        var_dump($retorno);
        

    } catch (\SoapFault $exception) {
        var_dump($exception);
    }
});

/* $app->get('nusoap', function () {
    try {
        $proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
        $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
        $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
        $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
        $useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
        $client = new nusoap_client('http://scorehmws.guep.com.br/guepsoap/autenticar/autenticacao.php?wsdl', 'wsdl',
                                $proxyhost, $proxyport, $proxyusername, $proxypassword);
        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2>';
            echo '<pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }
        $client->setUseCurl($useCURL);
        $client->soap_defencoding = 'UTF-8';
        $client->decode_utf8 = false;
        $utf8string = array('stuff' => "\xc2\xa9\xc2\xae\xc2\xbc\xc2\xbd\xc2\xbe");
        $result = $client->call('echoback', $utf8string);
        if ($client->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        } else {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
                echo '<h2>Result</h2><pre>';
                // Decode the result: it so happens we sent Latin-1 characters
                if (isset($result['return'])) {
                    $result1 = utf8_decode($result['return']);
                } elseif (!is_array($result)) {
                    $result1 = utf8_decode($result);
                } else {
                    $result1 = $result;
                }
                print_r($result1);
                echo '</pre>';
            }
        }
        echo '<h2>Request</h2>';
        echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
        echo '<h2>Response</h2>';
        echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
        echo '<h2>Debug</h2>';
        echo '<pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';

    }catch (SoapFault $exception) {
        var_dump($exception);
    }
}); */

// /*  $app->get('teste', function () {
//     $client = ('http://scorehmws.guep.com.br/guepsoap/autenticar/autenticacao.php?wsdl');
//     $loginUser = 'wwwww';
//     $senhaUser = 'ssssss';
//     $codigoUser = 'FDFDFDFDF';
//     $guep = new SoapClient($client, array('loginUser' => $loginUser, 'senhaUser' => $senhaUser, 'codigoUser' => $codigoUser));
//     print_r($guep);

//     echo "teste: ";
    
//     $teste = new SoapClient('http://scorehmws.guep.com.br/guepsoap/autenticar/autenticacao.php?wsdl',[
//         'trace'=>1,'cache_wsdl'=>WSDL_CACHE_NONE, 'loginUser' => 'wwwww', 'senhaUser' => 'ssssss'
//         ]);
//     print_r($teste);

// });*/

// /*$app->get('guepesq', function () {
//     $client = new \Zend\Soap\Client('http://scorehmws.guep.com.br/guepsoap/pesquisa/pesquisa.php?wsdl');
//     echo "Informações do Servidor:";
//     print_r($client->getOptions());
//     echo "Funções:";
//     print_r($client->getFunctions());
//     echo "Tipos:";
//     print_r($client->getTypes());
//     echo "+++:";
//     print_r($client);
//     //echo "Resultado:";
    

// });*/
// /*$app->get('consulta', function () {
//     $client = new \Zend\Soap\Client('http://scorehmws.guep.com.br/guepsoap/consulta/consulta.php?wsdl');
//     echo "Informações do Servidor:";
//     print_r($client->getOptions());
//     echo "Funções:";
//     print_r($client->getFunctions());
//     echo "Tipos:";
//     print_r($client->getTypes());
//     echo "Resultado:";
//     dd($client);

// });*/

// /*$uri = 'http://son-soap.dev:8080';
// $app->get('son-soap.wsdl', function () use ($uri) {
//     $autoDiscover = new \Zend\Soap\AutoDiscover();
//     $autoDiscover->setUri("$uri/server");
//     $autoDiscover->setServiceName('SONSOAP');
//     $autoDiscover->addFunction('soma');
//     $autoDiscover->handle();
// });

// $app->post('server', function () use ($uri) {
//     $server = new \Zend\Soap\Server("$uri/son-soap.wsdl", [
//         'cache_wsdl' => WSDL_CACHE_NONE
//     ]);
//     $server->setUri("$uri/server");
//     return $server
//         ->setReturnResponse(true)
//         ->addFunction('soma')
//         ->handle();
// });

// $app->get('soap-test', function () use ($uri) {
//     $client = new \Zend\Soap\Client("$uri/son-soap.wsdl", [
//         'cache_wsdl' => WSDL_CACHE_NONE
//     ]);
//     print_r($client->soma(100, 200));

// });


// //SOAP SERVER COM CLIENT
// $uriClient = "$uri/client";
// $app->get('client/son-soap.wsdl', function () use ($uriClient) {
//     $autoDiscover = new \Zend\Soap\AutoDiscover();
//     $autoDiscover->setUri("$uriClient/server");
//     $autoDiscover->setServiceName('SONSOAP');
//     $autoDiscover->setClass(\App\Soap\ClientsSoapController::class);
//     $autoDiscover->handle();
// });

// $app->post('client/server', function () use ($uriClient) {
//     $server = new \Zend\Soap\Server("$uriClient/son-soap.wsdl", [
//         'cache_wsdl' => WSDL_CACHE_NONE
//     ]);
//     $server->setUri("$uriClient/server");
//     return $server
//         ->setReturnResponse(true)
//         ->setClass(\App\Soap\ClientsSoapController::class)
//         ->handle();
// });

// $app->get('soap-client', function () use ($uriClient) {
//     $client = new \Zend\Soap\Client("$uriClient/son-soap.wsdl", [
//         'cache_wsdl' => WSDL_CACHE_NONE
//     ]);
//     //print_r($client->listAll());
//     print_r($client->create([
//         'name' => 'Luiz Carlos',
//         'email' => 'luizcarlos@schoolofnet.com',
//         'phone' => '5555',
//     ]));

// });


// function soma($num1, $num2)
// {
//     return $num1 + $num2;
// }*/



 /*'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
            'style'=>SOAP_RPC,
            'use'=>SOAP_ENCODED,
            'soap_version'=>SOAP_1_1,
            'cache_wsdl'=>WSDL_CACHE_NONE,
            'connection_timeout'=>15,
            'trace'=>true,
            'encoding'=>'UTF-8',
            'exceptions'=>true,*/
            //