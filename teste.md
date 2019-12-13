use SoapClient;

or reference it directly later:

$client = new \SoapClient($wsdl, $options);



**********************************************************************
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

**********************************************************************


<?php
/**
* Preparando requisição
*/
$parameters = new stdClass();
$parameters->merchantId = 'xxx'; //aqui você vai colocar seu merchantId
$parameters->request = array(
'conteudo1',
'conteudo2',
'...',
'conteudoN'
);


/**
* Aqui enviamos a requisição
*/
try {
$braspag = new SoapClient( 'https-~~-//homologacao.pagador.com.br/BraspagGeneralService/BraspagGeneralService.asmx?WSDL',
	array(
		'trace'			=> 1,
		'exceptions'	=> 1,
		'style'			=> SOAP_DOCUMENT,
		'use'			=> SOAP_LITERAL,
		'soap_version'	=> SOAP_1_1,
		'encoding'		=> 'UTF-8'
	)
);

/**
	* A variável $EncryptRequestResult abaixo conterá o conteúdo criptografado se tudo ocorrer bem
	*/
$EncryptRequestResult = $braspag->EncryptRequest( $parameters );

echo $EncryptRequestResult; //Exibindo o conteúdo criptografado
} catch( SoapFault $fault ){
echo 'Ocorreu um erro: ' , $fault->getMessage();
}



******************************************

<?php
/**
* Preparando requisição
*/
$parameters = new stdClass();
$parameters->Total = '0.01'; //aqui você vai colocar seu merchantId
$parameters->Transacao = '04';
$parameters->Parcelas = '00';
$parameters->Filiacao = '123123';
$parameters->NumPedido = '123';
$parameters->Nrcartao = '1234123412341234';
$parameters->CVC2 = '123';
$parameters->Mes = '11';
$parameters->Ano = '11';
$parameters->Portador = 'Frederic Chopin';
$parameters->IATA = NULL;
$parameters->Distribuidor = NULL;
$parameters->Concentrador = NULL;
$parameters->TaxaEmbarque = NULL;
$parameters->Entrada = NULL;
$parameters->Pax1 = NULL;
$parameters->Pax2 = NULL;
$parameters->Pax3 = NULL;
$parameters->Pax4 = NULL;
$parameters->Numdoc1 = NULL;
$parameters->Numdoc2 = NULL;
$parameters->Numdoc3 = NULL;
$parameters->Numdoc4 = NULL;
$parameters->ConfTxn = NULL;
$parameters->Add_Data = NULL;


/**
* Aqui enviamos a requisição
*/
try {
       $komerci = new SoapClient( 'https://ecommerce.redecard.com.br/pos_virtual/wskomerci/cap.asmx?WSDL',
               array(
                       'trace'                 => 1,
                       'exceptions'    		=> 1,
                       'style'                 => SOAP_DOCUMENT,
                       'use'                   => SOAP_LITERAL,
                       'soap_version'  		=> SOAP_1_1,
                       'encoding'              => 'UTF-8'
               )
       );

       /**
       * A variável $EncryptRequestResult abaixo conterá o conteúdo criptografado se tudo ocorrer bem
       */
$GetAuthorizedResponse = $komerci->GetAuthorized( $parameters );

echo $GetAuthorizedResponse->GetAuthorizedResult; //Exibindo o conteúdo criptografado

} catch( SoapFault $fault ){

	echo 'Ocorreu um erro: ' , $fault->getMessage();

}

?>


-------------------

composer require lagan/core


https://stackoverflow.com/questions/16595789/sending-xml-input-to-wsdl-using-soapclient
https://warlord0blog.wordpress.com/2018/08/17/laravel-and-lagan-web-services-soap-api/
https://gist.github.com/warlord0/3b000a06734158f3c27445d08b8a12a2#file-wsdlcontroller-php
https://github.com/carlosenambam/placetoplay
https://github.com/pduran5/laravelgallery


$body' = '<?xml version="1.0" encoding="ISO-8859-1"?><serviceRequest serviceName="MobileLoginSP.login"><requestBody><NOMUSU>TESTE</NOMUSU><INTERNO>12345</INTERNO></requestBody></serviceRequest>';

$response = $client->post('http://192.168.1.212:8380/mge/service.sbr?serviceName=MobileLoginSP.login', 
  ['headers' => ['Content-Type'=>'text/xml; charset=ISO-8859-1'],
  'body' => $body
]);

$request = new Request(
    'POST', 
    $uri,
    ['Content-Type' => 'text/xml; charset=UTF8'],
    $xml
);


$client = new \GuzzleHttp\Client();
$response = $client->request('GET', 'your URL');
$response = $response->getBody()->getContents();
return $response;

-----------------------------------------------------------------------------------

Sending XML input to WSDL using SoapClient
Ask Question
Asked 6 years, 6 months ago
Active 5 years, 4 months ago
Viewed 55k times

5


4
I have this WSDL: https://secure.softwarekey.com/solo/webservices/XmlCustomerService.asmx?WSDL

I am trying to use SoapClient to send a request to the CustomerSearch method.

The code I'm using is as follows:

$url = 'https://secure.softwarekey.com/solo/webservices/XmlCustomerService.asmx?WSDL';
$client = new SoapClient($url);

$CustomerSearch = array(
    'AuthorID' => $authorID,
    'UserID' => $userID,
    'UserPassword' => $userPassword,
    'Email' => $customerEmail 
);

$xml = array('CustomerSearch' => $CustomerSearch);

$result = $client->CustomerSearch(array('xml' => $xml));

$xml = "
<?xml version=\"1.0\" encoding=\"utf-8\"?> 
<CustomerSearch>
    <AuthorID>$authorID</AuthorID>
    <UserID>$userID</UserID>
    <UserPassword>$userPassword</UserPassword>
    <Email>$customerEmail</Email>
</CustomerSearch>
";
---------------------------------------
$url = 'https://secure.softwarekey.com/solo/webservices/XmlCustomerService.asmx?WSDL';
$client = new SoapClient($url);

$xmlr = new SimpleXMLElement("<CustomerSearch></CustomerSearch>");
$xmlr->addChild('AuthorID', $authorID);
$xmlr->addChild('UserID', $userID);
$xmlr->addChild('UserPassword', $userPassword);
$xmlr->addChild('Email', $customerEmail);

$params = new stdClass();
$params->xml = $xmlr->asXML();

$result = $client->CustomerSearchS($params);


---------------------------------------


## Interacting with a soap API without WSDL in PHP
Recently got access to a soap API for a hotel management service. They have provided documentation which shows a basic example of a request:

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">    
<soapenv:Header>       
  <Auth xmlns="http://xxxx/xxxxAPI">          
  <FromSystemId ID="1">CompanyName</FromSystemId>          
    <UserName>username</UserName>          
    <Password>password</Password>       
  </Auth>    
</soapenv:Header>    
<soapenv:Body>       
  <GetRegions Timestamp="2016-04-11" Version="1.0" Lang="en" 
     xmlns="http://xxxx/xxxxAPI">
  <Country Code="GB" />  
  </GetRegions>    
</soapenv:Body> 
</soapenv:Envelope>


---------------------------------------
$soapURL = "http://xxxx/xxxxAPI" ;
$soapParameters = Array('login' => "username", 'password' => "password") ;
$soapFunction = "getRegions";
$soapFunctionParameters = Array('countrycode' => 'GB');

$soapClient = new SoapClient($soapURL, $soapParameters);

$soapResult = $soapClient->__soapCall($soapFunction, 
$soapFunctionParameters) ;

if(is_array($soapResult) && isset($soapResult['someFunctionResult'])) {
    // Process result.
} else {
    // Unexpected result
    if(function_exists("debug_message")) {
        debug_message("Unexpected soapResult for {$soapFunction}: ".print_r($soapResult, TRUE)) ;
    }
}

---------------------------------------

Here is a small example.

$opts = array(
    'location' => 'http://xxxx/xxxxAPI',
    'uri' => 'urn:http://test-uri/'
);

$client = new SOAPClient(null, $opts);

$headerData = array(
    'FromSystemId' => 'CompanyName',
    'UserName' => 'username',
    'Password' => 'password',
);

// Create Soap Header.
$header = new SOAPHeader('http://xxxx/xxxxAPI', 'Auth', $headerData);

// Set the Headers of Soap Client.
$client->__setSoapHeaders($header);


$result = $client->__soapCall('getRegions', array('GB'));

// $return = $client->__soapCall('getRegions', array(new SoapParam(new SoapVar('GB', XSD_STRING), 'countryCode')));

var_dump($result);


---------------------------------------

$soapContent = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">    
<soapenv:Header>       
  <Auth xmlns="http://xxxx/xxxxAPI">          
  <FromSystemId ID="1">CompanyName</FromSystemId>          
    <UserName>username</UserName>          
    <Password>password</Password>       
  </Auth>    
</soapenv:Header>    
<soapenv:Body>       
  <GetRegions Timestamp="2016-04-11" Version="1.0" Lang="en" 
     xmlns="http://xxxx/xxxxAPI">
  <Country Code="GB" />  
  </GetRegions>    
</soapenv:Body> 
</soapenv:Envelope>';

$client = new GuzzleHttp\Client([
    'headers' => [ 'SOAPAction' => '"urn:http://xxxx/xxxxAPI/#getRegions"' ]
]);

$response = $client->post('http://xxxx/xxxxAPI',
    ['body' => $soapContent]
);

echo $response;


---------------------------------------

- https://stackoverflow.com/questions/47371556/interacting-with-a-soap-api-without-wsdl-in-php/47372897#47372897
- https://stackoverflow.com/questions/16595789/sending-xml-input-to-wsdl-using-soapclient
- https://github.com/Bolinha1/web-services




