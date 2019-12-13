<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Artisaninweb\SoapWrapper\SoapWrapper;
 
class HomeController extends Controller
{
      protected $soapWrapper;
 
   
   public function __construct(SoapWrapper $soapWrapper)
   {
     $this->soapWrapper = $soapWrapper;
   }
 
   public function index()
   {
    $this->soapWrapper->add('Holidays', function ($service) {
       $service
         ->wsdl('http://www.holidaywebservice.com/Holidays/US/USHolidayService.asmx?wsdl')
         ->trace(true);
     });
 
   	     $data = $this->soapWrapper->call('Holidays.GetHolidaysForYear', [[
   	     'year' => request('year')
   	     ]]);
 
   	     $response = $data->GetHolidaysForYearResult->any;
 
 
   	    $sxe = new \SimpleXMLElement($response);
         $sxe->registerXPathNamespace('d', 'urn:schemas-microsoft-com:xml-msdata');
         $result = $sxe->xpath("//NewDataSet");
         echo "<pre>";
         foreach ($result[0] as $title) {
             echo "<strong>" . $title->Key . "</strong>: " . $title->Name . "(" . $title->Date . ")" . "<br/>";
         }
   }
 
}