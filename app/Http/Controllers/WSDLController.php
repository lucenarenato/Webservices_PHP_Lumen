<?php

namespace App\Http\Controllers\Lagan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// We need Guzzle for the POST requests
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Oxymel; // XML Builder

class WSDLController extends Controller
{
    /**
     * Build the base of the XML SOAP request with the authentication header
     * @return [Oxymel] XML SOAP Envelope
     */
    private function xmlRequest() {

      $xml = new Oxymel;

      $xml->tag('soapenv:Envelope', [
        'xmlns:soapenv' => "http://schemas.xmlsoap.org/soap/envelope/",
        'xmlns:flt' => "http://www.lagan.com/wsdl/FLTypes",
        'xmlns:wsse' => "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"])
        ->contains
        ->tag('soapenv:Header')
          ->contains
          ->tag('wsse:Security')
            ->contains
              ->tag('wsse:UsernameToken')
                ->contains
                ->tag('wsse:Username', env('LAGAN_USER', ''))
                ->tag('wsse:Password', env('LAGAN_PASSWORD', ''))
              ->end
            ->end
          ->end
        ->tag('soapenv:Body'); // Don't end this

      return $xml;
    }

    /**
     * Send a post request using Guzzle to with the SOAPAction and XML body
     * @param  [string] $action SOAPAction header
     * @param  [Oxymel] $xml    Oxymel XML SOAP complete with auth headers
     * @return [Array]          { status, data }
     */
    private function sendRequest($action, $xml) {
      $url = sprintf('http://%s:%d/lagan/services/FL', env('LAGAN_HOST', 'localhost'), env('LAGAN_PORT', 8080));

      $client = new Client(); // Create the Guzzle Client
      try {
        $response = $client->post($url, [
          'headers' => [
            'SOAPAction' => $action, // Add the action
            'Content-Type' => 'text/xml'
          ],
          'body' => $xml->to_string() // Put the xml in the body
        ]);
      } catch (GuzzleException $e) {
        return [ 'status' => $e->getResponse()->getStatusCode(), 'message' => $e->getResponse()->getReasonPhrase()];
      }

      $status = $response->getStatusCode();

      // Convert the response body to array
      $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3",
      $response->getBody()->getContents()); // Strip the namespaces
      $xml = new \SimpleXMLElement($response); // Convert the response to xml
      $array = json_decode(json_encode((array)$xml), true); // Make an array!
      $data =  $array["soapenvBody"]; // We only want the body

      return [ 'status' => $status, 'data' => $data ];
    }

    /**
     * A real world Lagan WSDL call to retrieve a specific case detail
     * @param  [string]  $caseReference The case reference to return
     * @return [Array]                 Array/json response { status, data }
     */
    public function retrieveCaseDetails($caseReference) {
      $xml = $this->xmlRequest(); // Oxymel @ Body

      $xml->contains
        ->tag('flt:FWTCaseFullDetailsRequest')
          ->contains
            ->tag('flt:CaseReference', $caseReference)
            ->tag('Option', 'all')
          ->end
        ->end
      ->end;

      // Make the WSDL call
      $response = $this->sendRequest('retrieveCaseDetails', $xml);

      return $response;
    }

    /**
     * WSDL call to searchForCases
     * @param  [Oxymel] $fWTCaseSearch XML Builder
     * @return [Array]                Array/json response
     */
    private function searchForCases($fWTCaseSearch) {
      $xml = $this->xmlRequest();

      $xml->contains
        ->oxymel($fWTCaseSearch)
        ->end
      ->end;

      // Make the WSDL call
      $response = $this->sendRequest('retrieveCaseDetails', $xml);

      return $response;

    }

    /**
     * Call searchForCases by passing in parameters to look for Open cases
     * @return [Array] Array/json response
     */
    public function searchForOpenCases() {
      $fWTCaseSearch = new Oxymel;

      $fWTCaseSearch->tag('flt:FWTCaseSearch')
        ->contains
          ->tag('Status', 'open')
        ->end;

      return $this->searchForCases($fWTCaseSearch);

    }

}