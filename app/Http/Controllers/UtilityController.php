<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Illuminate\Support\Arr;
class UtilityController extends Controller
{
    public function convert_number_to_words($number) {

        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'fourty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            100000             => 'lakh',
            10000000          => 'crore'
        );
    
        if (!is_numeric($number)) {
            return false;
        }
    
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }
    
        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }
    
        $string = $fraction = null;
    
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
    
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            case $number < 100000:
                $thousands   = ((int) ($number / 1000));
                $remainder = $number % 1000;
    
                $thousands = $this->convert_number_to_words($thousands);
    
                $string .= $thousands . ' ' . $dictionary[1000];
                if ($remainder) {
                    $string .= $separator . $this->convert_number_to_words($remainder);
                }
                break;
            case $number < 10000000:
                $lakhs   = ((int) ($number / 100000));
                $remainder = $number % 100000;
    
                $lakhs = $this->convert_number_to_words($lakhs);
    
                $string = $lakhs . ' ' . $dictionary[100000];
                if ($remainder) {
                    $string .= $separator . $this->convert_number_to_words($remainder);
                }
                break;
            case $number < 1000000000:
                $crores   = ((int) ($number / 10000000));
                $remainder = $number % 10000000;
    
                $crores = $this->convert_number_to_words($crores);
    
                $string = $crores . ' ' . $dictionary[10000000];
                if ($remainder) {
                    $string .= $separator . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }
    
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
    
        return $string;
    }

    public function universal_API($xmldata,$api_url){
        $CREDENTIALS =app('App\Http\Controllers\UniversalConfigAPIController')->CREDENTIALS();
        $auth = base64_encode("$CREDENTIALS");
        // $soap_do = curl_init("https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService");
        $soap_do = curl_init($api_url);
        /*("https://americas.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService");*/
        $header = array(
            "Content-Type: text/xml;charset=UTF-8",
            "Accept: gzip,deflate",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: \"\"",
            "Authorization: Basic $auth",
            "Content-length: ".strlen($xmldata),
        );
        //        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
        //        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
        //        curl_setopt($soap_do, CURLOPT_POST, true );
        curl_setopt($soap_do, CURLOPT_POSTFIELDS, $xmldata);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($soap_do);
        curl_close($soap_do);
        return $return;
    }

    public function Universal_API_SearchXML($travel_class,$flightFrom,$flightTo,$SearchDate,$var_adults,$var_children,$var_infant,$var_currency_code){
        $Provider =app('App\Http\Controllers\UniversalConfigAPIController')->Provider();
        $TARGETBRANCH =app('App\Http\Controllers\UniversalConfigAPIController')->TARGETBRANCH();
        
        $searchLegModifier = ' <air:AirLegModifiers>
              	<air:PreferredCabins>
              	<com:CabinClass xmlns="http://www.travelport.com/schema/common_v42_0" Type="'. $travel_class.'"></com:CabinClass>
              	</air:PreferredCabins>
              </air:AirLegModifiers>';
        $travel_details='';
        for ($i=1; $i <= $var_adults; $i++) { 
            $travel_details.='<com:SearchPassenger BookingTravelerRef="ADT'.$i.'" Code="ADT" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>';
        }
        for ($i=1; $i <= $var_children; $i++) { 
            $travel_details.='<com:SearchPassenger BookingTravelerRef="CNN'.$i.'" Code="CNN" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>';
        }
        for ($i=1; $i <= $var_infant; $i++) { 
            $travel_details.='<com:SearchPassenger BookingTravelerRef="INF'.$i.'" Code="INF" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>';
        }

        $currency_xml='';
        if($var_currency_code!=''){
            $currency_xml='<air:AirPricingModifiers FaresIndicator="PublicFaresOnly" CurrencyType="'.$var_currency_code.'">
            <air:AccountCodes>
                <com:AccountCode xmlns="http://www.travelport.com/schema/common_v42_0" Code="-" />
            </air:AccountCodes>
            </air:AirPricingModifiers>';
        }
             
      $message = <<<EOM
      <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"> 
      <soapenv:Body>
         <air:LowFareSearchReq TraceId="trace" AuthorizedBy="user" SolutionResult="true" TargetBranch="$TARGETBRANCH" xmlns:air="http://www.travelport.com/schema/air_v42_0" xmlns:com="http://www.travelport.com/schema/common_v42_0">
            <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
            <air:SearchAirLeg>
               <air:SearchOrigin>
                  <com:Airport Code="$flightFrom"/>
               </air:SearchOrigin>
               <air:SearchDestination>
                  <com:Airport Code="$flightTo"/>
               </air:SearchDestination>
               <air:SearchDepTime PreferredTime="$SearchDate">
               </air:SearchDepTime>
               $searchLegModifier
            </air:SearchAirLeg>
            <air:AirSearchModifiers>
               <air:PreferredProviders>
                  <com:Provider Code="$Provider"/>
               </air:PreferredProviders>
            </air:AirSearchModifiers>   
            $travel_details
            $currency_xml
            </air:LowFareSearchReq>
      </soapenv:Body>
   </soapenv:Envelope>
EOM;

        return $message;

    }

    public function Universal_API_SearchXMLReturn($travel_class,$flightFrom,$flightTo,$SearchPreferredDate,$SearchDate,$var_adults,$var_children,$var_infant,$var_currency_code){
        $Provider =app('App\Http\Controllers\UniversalConfigAPIController')->Provider();
        $TARGETBRANCH =app('App\Http\Controllers\UniversalConfigAPIController')->TARGETBRANCH();
        
        $travel_details='';
        for ($i=1; $i <= $var_adults; $i++) { 
            $travel_details.='<com:SearchPassenger BookingTravelerRef="ADT'.$i.'" Code="ADT" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>';
        }
        for ($i=1; $i <= $var_children; $i++) { 
            $travel_details.='<com:SearchPassenger BookingTravelerRef="CNN'.$i.'" Code="CNN" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>';
        }
        for ($i=1; $i <= $var_infant; $i++) { 
            $travel_details.='<com:SearchPassenger BookingTravelerRef="INF'.$i.'" Code="INF" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>';
        }

        $currency_xml='';
        if($var_currency_code!=''){
            $currency_xml='<air:AirPricingModifiers FaresIndicator="PublicFaresOnly" CurrencyType="'.$var_currency_code.'">
            <air:AccountCodes>
                <com:AccountCode xmlns="http://www.travelport.com/schema/common_v42_0" Code="-" />
            </air:AccountCodes>
            </air:AirPricingModifiers>';
        }

        $searchLegModifier = ' <air:AirLegModifiers>
              	<air:PreferredCabins>
              	<com:CabinClass xmlns="http://www.travelport.com/schema/common_v42_0" Type="'. $travel_class.'"></com:CabinClass>
              	</air:PreferredCabins>
              </air:AirLegModifiers>';
   
             
      $message = <<<EOM
      <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"> 
      <soapenv:Body>
         <air:LowFareSearchReq TraceId="trace" AuthorizedBy="user" SolutionResult="true" TargetBranch="$TARGETBRANCH" xmlns:air="http://www.travelport.com/schema/air_v42_0" xmlns:com="http://www.travelport.com/schema/common_v42_0">
            <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
            <air:SearchAirLeg>
               <air:SearchOrigin>
                  <com:Airport Code="$flightTo"/>
               </air:SearchOrigin>
               <air:SearchDestination>
                  <com:Airport Code="$flightFrom"/>
               </air:SearchDestination>
               <air:SearchDepTime PreferredTime="$SearchPreferredDate">
               </air:SearchDepTime>
               $searchLegModifier
            </air:SearchAirLeg>
            <air:SearchAirLeg>
               <air:SearchOrigin>
                  <com:Airport Code="$flightFrom"/>
               </air:SearchOrigin>
               <air:SearchDestination>
                  <com:Airport Code="$flightTo"/>
               </air:SearchDestination>
               <air:SearchDepTime PreferredTime="$SearchDate">
               </air:SearchDepTime>
               $searchLegModifier
            </air:SearchAirLeg>
            <air:AirSearchModifiers>
               <air:PreferredProviders>
                  <com:Provider Code="$Provider"/>
               </air:PreferredProviders>
            </air:AirSearchModifiers> 
            $travel_details  
            $currency_xml
         </air:LowFareSearchReq>
      </soapenv:Body>
   </soapenv:Envelope>
EOM;

        return $message;

    }

    // flight details Retrieve Request
    public function universal_API_FlightDetails($datasegment){
        $Provider =app('App\Http\Controllers\UniversalConfigAPIController')->Provider();
        $TARGETBRANCH =app('App\Http\Controllers\UniversalConfigAPIController')->TARGETBRANCH();
            $message = <<<EOM
            <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
               <air:AirPriceReq AuthorizedBy="user" TargetBranch="$TARGETBRANCH" FareRuleType="long" xmlns:air="http://www.travelport.com/schema/air_v42_0">
                  <BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
                  <air:AirItinerary>
                    $datasegment
                  </air:AirItinerary>
                  <air:AirPricingModifiers/>
                  <com:SearchPassenger Key="1" Code="ADT" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>
                  <air:AirPricingCommand/>
               </air:AirPriceReq>
            </soap:Body>
         </soap:Envelope>
EOM;
        return $message ;
    }

    // Air Ticketing Retrieve Request
    public function universal_API_AirTicketing($AirReservation,$AirPricingInfoKey){
        $Provider =app('App\Http\Controllers\UniversalConfigAPIController')->Provider();
        $TARGETBRANCH =app('App\Http\Controllers\UniversalConfigAPIController')->TARGETBRANCH();
        
        $message = <<<EOM
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
            <air:AirTicketingReq AuthorizedBy="user" TargetBranch="$TARGETBRANCH" TraceId="trace" xmlns:air="http://www.travelport.com/schema/air_v42_0">
            <BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
            <air:AirReservationLocatorCode>$AirReservation</air:AirReservationLocatorCode>
            <air:AirPricingInfoRef Key="$AirPricingInfoKey" />
            </air:AirTicketingReq>   
        </soap:Body>
    </soap:Envelope>
EOM;
        return $message;
    }


    // Universal Record Retrieve Request
    public function UniversalRecordRetrieveReq($UniversalRecord){
        $Provider =app('App\Http\Controllers\UniversalConfigAPIController')->Provider();
        $TARGETBRANCH =app('App\Http\Controllers\UniversalConfigAPIController')->TARGETBRANCH();
        
        $message = <<<EOM
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
        <soapenv:Body>
           <univ:UniversalRecordRetrieveReq TargetBranch="$TARGETBRANCH" TraceId="trace" xmlns:univ="http://www.travelport.com/schema/universal_v42_0" xmlns:com="http://www.travelport.com/schema/common_v42_0">
              <com:BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
              <univ:UniversalRecordLocatorCode>$UniversalRecord</univ:UniversalRecordLocatorCode>
           </univ:UniversalRecordRetrieveReq>
        </soapenv:Body>
     </soapenv:Envelope>
EOM;
        return $message;
    }

    // tarveller details datasegment return
    public function TravelDetailsDatasagment($var_adults,$var_children,$var_infant){
        $travel_details='';
        for ($i=0; $i < $var_adults; $i++) { 
            $travel_details.='<com:SearchPassenger BookingTravelerRef="ADT'.$i.'" Code="ADT" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>';
        }
        for ($i=0; $i < $var_children; $i++) { 
            $travel_details.='<com:SearchPassenger BookingTravelerRef="CNN'.$i.'" Code="CNN" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>';
        }
        for ($i=0; $i < $var_infant; $i++) { 
            $travel_details.='<com:SearchPassenger BookingTravelerRef="INF'.$i.'" Code="INF" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>';
        }
        return $travel_details;
    }
}
