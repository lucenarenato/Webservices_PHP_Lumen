<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// We need Guzzle for the POST requests
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class WSDLController extends Controller
{
    /**
     * Build the base of the XML SOAP request with the authentication header
     * @return [SimpleXMLElement] XML SOAP Envelope
     */
    private function xmlRequest() {
        $xml = new \SimpleXMLElement('<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:lgn="http://www.lagan.com/wsdl/FLTypes" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"/>');

        $header = $xml->addChild('Header');
        $security = $header->addChild('wsse:Security', '', 'wsse');
        $userToken = $security->addChild('wsse:UsernameToken');

        $userToken->addChild('wsse:Username', env('LAGAN_USER', ''));
        $userToken->addChild('wsse:Password', env('LAGAN_PASSWORD', ''));

        return $xml;
    }

    /**
     * Send a post request using Guzzle to with the SOAPAction and XML body
     * @param  [string] $action SOAPAction header
     * @param  [string] $xml    XML SOAP complete with auth headers
     * @return [string]         XML response from Lagan
     */
    private function sendRequest($action, $xml) {
      $url = sprintf('http://%s:%d/lagan/services/FL', env('LAGAN_HOST', 'localhost'), env('LAGAN_PORT', 8080));

      $client = new Client(); // Create the Guzzle Client
      $response = $client->post($url, [
        'headers' => [
          'SOAPAction' => $action, // Add the action
          'Content-Type' => 'text/xml'
        ],
        'body' => $xml // Put the xml in the body
      ]);

      // Return the response body as string
      return $response->getBody()->getContents();
    }

    /**
     * A real world Lagan WSDL call to retrieve case details
     * @param  [string]  $caseReference The case reference to return
     * @return [string]                 XML String
     */
    public function retrieveCaseDetails($caseReference) {
      $xml = $this->xmlRequest();

      $body = $xml->addChild('Body');

      $fwType = $body->addChild('lgn:FWTCaseFullDetailsRequest', '', 'lgn');
      $fwType->addChild('lgn:CaseReference', $caseReference);
      $fwType->addChild('Option', 'all', '');

      // Strip the <xml/> header and remove the xmlns:lgn= etc.
      $dom = dom_import_simplexml($xml);
      $cleanXML = preg_replace('/xmlns[^=]*="[a-z]*"/i', '',
        $dom->ownerDocument
          ->saveXML($dom->ownerDocument->documentElement)
      );

      // Make the WSDL call
      $response = $this->sendRequest('retrieveCaseDetails', $cleanXML);

      // TODO: Make something wonderful happen like json?
      $header['Content-Type'] = 'text/xml'; // Set the header
      return \Response::make($response, 200, $header); // Return OK with data and header
    }
}