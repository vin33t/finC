Air Book-Request
******************************************************************** 
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
   <soap:Body>
      <univ:AirCreateReservationReq RetainReservation="Both" RetrieveProviderReservationDetails="true" TraceId="1232346" TargetBranch="P7102538" AuthorizedBy="UAPITESTING" Version="0" xmlns:univ="http://www.travelport.com/schema/universal_v50_0">
         <com:BillingPointOfSaleInfo OriginApplication="UAPI" xmlns:com="http://www.travelport.com/schema/common_v50_0"/>
         <com:BookingTraveler Key="Qm9va2luZ1RyYXZlbGVyMQ==" TravelerType="ADT" xmlns:com="http://www.travelport.com/schema/common_v50_0">
            <com:BookingTravelerName Prefix="Mr" First="CARSTEN" Last="LINDELOEV"/>
            <com:PhoneNumber Key="1005359" CountryCode="011" Location="DEN" Number="227-722-2454" Extension="22" AreaCode="222" Type="Home" Text="Abc-Xy"/>
            <com:Email Type="Home" EmailID="jtestora@travelport.com"/>
            <com:SSR Key="1" Type="DOCS" Status="HK" Carrier="SA" FreeText="P/CA/F9850356/GB/04JAN80/M/01JAN14/LINDELOEV/CARSTENGJELLERUPMr"/>
            <com:Address>
               <com:AddressName>Jan Restora</com:AddressName>
               <com:Street>6901 S. Havana</com:Street>
               <com:Street>Apt 3</com:Street>
               <com:City>Englewood</com:City>
               <com:State>CO</com:State>
               <com:PostalCode>80111</com:PostalCode>
               <com:Country>US</com:Country>
            </com:Address>
         </com:BookingTraveler>
         <com:BookingTraveler Key="Qm9va2luZ1RyYXZlbGVyMg==" TravelerType="ADT" xmlns:com="http://www.travelport.com/schema/common_v50_0">
            <com:BookingTravelerName Prefix="Mr" First="john" Last="Long"/>
            <com:PhoneNumber Key="1015359" CountryCode="011" Location="DEN" Number="227-702-2454" Extension="22" AreaCode="222" Type="Home" Text="Abd-Xy"/>
            <com:Email Type="Home" EmailID="jtestora@travelport.com"/>
            <com:SSR Key="2" Type="DOCS" Status="HK" Carrier="SA" FreeText="P/CA/F9850356/GB/04JAN80/M/01JAN14/Long/JhonJELLERUPMr"/>
            <com:Address>
               <com:AddressName>Jan Restora</com:AddressName>
               <com:Street>6901 S. Havana</com:Street>
               <com:Street>Apt 3</com:Street>
               <com:City>Englewood</com:City>
               <com:State>CO</com:State>
               <com:PostalCode>80111</com:PostalCode>
               <com:Country>US</com:Country>
            </com:Address>
         </com:BookingTraveler>
         <GeneralRemark UseProviderNativeMode="true" TypeInGds="Basic" xmlns="http://www.travelport.com/schema/common_v50_0">
            <RemarkData>Booking 1</RemarkData>
         </GeneralRemark>
         <GeneralRemark UseProviderNativeMode="true" TypeInGds="Basic" xmlns="http://www.travelport.com/schema/common_v50_0">
            <RemarkData>Re- Booking 1</RemarkData>
         </GeneralRemark>
         <com:ContinuityCheckOverride Key="1T" xmlns:com="http://www.travelport.com/schema/common_v50_0">true</com:ContinuityCheckOverride>
         <com:FormOfPayment Key="PDz8y7xu4hGfaM/wYIhwmw==" Type="Credit" xmlns:com="http://www.travelport.com/schema/common_v50_0">
            <com:CreditCard Type="CA" Number="5555555555555557" ExpDate="2021-01" Name="JAYA KUMAR" CVV="123" Key="GAJOYrVu4hGShsrlYIhwmw==">
               <com:BillingAddress>
                  <com:AddressName>Jan Testora</com:AddressName>
                  <com:Street>6901 S. Havana</com:Street>
                  <com:Street>Apt 2</com:Street>
                  <com:City>Englewood</com:City>
                  <com:State>CO</com:State>
                  <com:PostalCode>8011</com:PostalCode>
                  <com:Country>AU</com:Country>
               </com:BillingAddress>
            </com:CreditCard>
         </com:FormOfPayment>
         <air:AirPricingSolution Key="sQTWMC3R2BKAZsvFCAAAAA==" TotalPrice="ZAR15724.60" BasePrice="ZAR4120.00" ApproximateTotalPrice="ZAR15724.60" ApproximateBasePrice="ZAR4120.00" Taxes="ZAR11604.60" Fees="ZAR0.00" ApproximateTaxes="ZAR11604.60" QuoteDate="2020-03-03" xmlns:air="http://www.travelport.com/schema/air_v50_0">
            <air:AirSegment Key="sQTWMC3R2BKAPsvFCAAAAA==" Group="0" Carrier="SA" FlightNumber="8854" ProviderCode="1G" Origin="PHW" Destination="JNB" DepartureTime="2020-04-21T13:15:00.000+02:00" ArrivalTime="2020-04-21T14:35:00.000+02:00" FlightTime="80" TravelTime="80" Distance="243" ClassOfService="W" Equipment="J41" ChangeOfPlane="false" OptionalServicesIndicator="false" AvailabilitySource="S" ParticipantLevel="Secure Sell" LinkAvailability="true" PolledAvailabilityOption="O and D cache or polled status used with different local status" AvailabilityDisplayType="Fare Specific Fare Quote Unbooked">
               <air:CodeshareInfo OperatingCarrier="SA">South African Airways</air:CodeshareInfo>
               <air:FlightDetails Key="sQTWMC3R2BKAQsvFCAAAAA==" Origin="PHW" Destination="JNB" DepartureTime="2020-04-21T13:15:00.000+02:00" ArrivalTime="2020-04-21T14:35:00.000+02:00" FlightTime="80" TravelTime="80" Distance="243"/>
            </air:AirSegment>
            <air:AirSegment Key="sQTWMC3R2BKARsvFCAAAAA==" Group="0" Carrier="SA" FlightNumber="8411" ProviderCode="1G" Origin="JNB" Destination="BFN" DepartureTime="2020-04-21T15:45:00.000+02:00" ArrivalTime="2020-04-21T16:45:00.000+02:00" FlightTime="60" TravelTime="60" Distance="238" ClassOfService="W" Equipment="ER3" ChangeOfPlane="false" OptionalServicesIndicator="false" AvailabilitySource="S" ParticipantLevel="Secure Sell" LinkAvailability="true" PolledAvailabilityOption="O and D cache or polled status used with different local status" AvailabilityDisplayType="Fare Specific Fare Quote Unbooked">
               <air:CodeshareInfo OperatingCarrier="SA">South African Airways</air:CodeshareInfo>
               <air:FlightDetails Key="sQTWMC3R2BKASsvFCAAAAA==" Origin="JNB" Destination="BFN" DepartureTime="2020-04-21T15:45:00.000+02:00" ArrivalTime="2020-04-21T16:45:00.000+02:00" FlightTime="60" TravelTime="60" Distance="238"/>
            </air:AirSegment>
            <air:AirSegment Key="sQTWMC3R2BKATsvFCAAAAA==" Group="0" Carrier="SA" FlightNumber="1058" ProviderCode="1G" Origin="BFN" Destination="CPT" DepartureTime="2020-04-21T18:40:00.000+02:00" ArrivalTime="2020-04-21T20:20:00.000+02:00" FlightTime="100" TravelTime="100" Distance="564" ClassOfService="G" Equipment="CR2" ChangeOfPlane="false" OptionalServicesIndicator="false" AvailabilitySource="S" ParticipantLevel="Secure Sell" LinkAvailability="true" PolledAvailabilityOption="O and D cache or polled status used with different local status" AvailabilityDisplayType="Fare Specific Fare Quote Unbooked">
               <air:CodeshareInfo OperatingCarrier="SA">South African Airways</air:CodeshareInfo>
               <air:FlightDetails Key="sQTWMC3R2BKAUsvFCAAAAA==" Origin="BFN" Destination="CPT" DepartureTime="2020-04-21T18:40:00.000+02:00" ArrivalTime="2020-04-21T20:20:00.000+02:00" FlightTime="100" TravelTime="100" Distance="564"/>
            </air:AirSegment>
            <air:AirSegment Key="sQTWMC3R2BKAVsvFCAAAAA==" Group="1" Carrier="SA" FlightNumber="346" ProviderCode="1G" Origin="CPT" Destination="JNB" DepartureTime="2020-04-26T15:05:00.000+02:00" ArrivalTime="2020-04-26T17:00:00.000+02:00" FlightTime="115" TravelTime="115" Distance="788" ClassOfService="G" Equipment="359" ChangeOfPlane="false" OptionalServicesIndicator="false" AvailabilitySource="S" ParticipantLevel="Secure Sell" LinkAvailability="true" PolledAvailabilityOption="O and D cache or polled status used with different local status" AvailabilityDisplayType="Fare Specific Fare Quote Unbooked">
               <air:CodeshareInfo OperatingCarrier="SA">South African Airways</air:CodeshareInfo>
               <air:FlightDetails Key="sQTWMC3R2BKAWsvFCAAAAA==" Origin="CPT" Destination="JNB" DepartureTime="2020-04-26T15:05:00.000+02:00" ArrivalTime="2020-04-26T17:00:00.000+02:00" FlightTime="115" TravelTime="115" Distance="788"/>
            </air:AirSegment>
            <air:AirSegment Key="sQTWMC3R2BKAXsvFCAAAAA==" Group="1" Carrier="SA" FlightNumber="8853" ProviderCode="1G" Origin="JNB" Destination="PHW" DepartureTime="2020-04-27T11:45:00.000+02:00" ArrivalTime="2020-04-27T12:55:00.000+02:00" FlightTime="70" TravelTime="70" Distance="243" ClassOfService="W" Equipment="J41" ChangeOfPlane="false" OptionalServicesIndicator="false" AvailabilitySource="S" ParticipantLevel="Secure Sell" LinkAvailability="true" PolledAvailabilityOption="O and D cache or polled status used with different local status" AvailabilityDisplayType="Fare Specific Fare Quote Unbooked">
               <air:CodeshareInfo OperatingCarrier="SA">South African Airways</air:CodeshareInfo>
               <air:FlightDetails Key="sQTWMC3R2BKAYsvFCAAAAA==" Origin="JNB" Destination="PHW" DepartureTime="2020-04-27T11:45:00.000+02:00" ArrivalTime="2020-04-27T12:55:00.000+02:00" FlightTime="70" TravelTime="70" Distance="243"/>
            </air:AirSegment>
            <air:AirPricingInfo Key="sQTWMC3R2BKAfsvFCAAAAA==" TotalPrice="ZAR7862.30" BasePrice="ZAR2060.00" ApproximateTotalPrice="ZAR7862.30" ApproximateBasePrice="ZAR2060.00" ApproximateTaxes="ZAR5802.30" Taxes="ZAR5802.30" LatestTicketingTime="2020-03-04T23:59:00.000+02:00" PricingMethod="Guaranteed" IncludesVAT="false" ETicketability="Yes" PlatingCarrier="SA" ProviderCode="1G">
               <air:FareInfo Key="sQTWMC3R2BKAmsvFCAAAAA==" FareBasis="WOW4Z" PassengerTypeCode="ADT" Origin="PHW" Destination="JNB" EffectiveDate="2020-03-03T02:30:00.000+02:00" DepartureDate="2020-04-21" Amount="ZAR390.00" NotValidBefore="2020-04-21" NotValidAfter="2020-04-21" TaxAmount="ZAR1480.86">
                  <air:FareRuleKey FareInfoRef="sQTWMC3R2BKAmsvFCAAAAA==" ProviderCode="1G">6UUVoSldxwgoBDod9lw1CsbKj3F8T9EyxsqPcXxP0TLGyo9xfE/RMsuWFfXVd1OAly5qxZ3qLwOXLmrFneovA5cuasWd6i8Dly5qxZ3qLwOXLmrFneovA0prhS7A5XirjynaV73G5Ybzd/VTAJtvZe8qN4ghecdLNgYTMBz3e8ooQAOB3NUwHgOyWVEtUxxB7lC94aKWBT/MN4B6NiLACBll6FxyIC6cYuAWfcH2w92IEQfz1U0L7yHjHE8eyooBjnqTLWH39jvqkp0FEw0raOCbZ1nsUQQBmwGc7eJ+B+zU2+I59dhHLYuFsAExMoVlv4Xvb2u1Qx+/he9va7VDH7+F729rtUMfv4Xvb2u1Qx+/he9va7VDHzyxauAs+veBE308BFXsd7QPNqcmmS6r7B2WN4EjYakqaX94QGLUjiICtVjYv91BNPvQb2zWrtbY5GwF8kqQiiA=</air:FareRuleKey>
                  <air:Brand Key="sQTWMC3R2BKAmsvFCAAAAA==" BrandID="245008" UpSellBrandID="245011" Name="Saver" Carrier="SA" BrandTier="0001">
                     <air:Title Type="External" LanguageCode="EN">Saver</air:Title>
                     <air:Title Type="Short" LanguageCode="EN">Saver</air:Title>
                     <air:Text Type="MarketingConsumer" LanguageCode="EN">� Combinable with any other fare class.

� Ticket payment period: as per fare rule.

� Flight changes allowed at no charge subject to the applicable booking class being available, If the applicable booking class is not available. 

� Upgrade permitted to the higher applicable fare.

� No name changes allowed after ticketing.

� Select seat at check-in only or purchase on flysaa.com.

� 1 Voyager Mile for every R1.60 spent.

� Re-routing permitted.

� Standby not permitted.

� Complimentary onboard meals or snacks.

� Refunds - partially/non-refundable within terms and conditions.

� No show fee will apply.

� Checked-in baggage allowance from 1 piece up to 23kg (depending on destination - refer to flysaa.com for full details).

� One piece of cabin baggage, each not exceeding 8kg in weight.

� Please note that if the flight is operated by another airline then the onboard product or service maybe different to that described above.</air:Text>
                     <air:Text Type="MarketingAgent" LanguageCode="EN">� Combinable with any other fare class.

� Ticket payment period: as per fare rule.

� Flight changes allowed at no charge subject to the applicable booking class being available, If the applicable booking class is not available. 

� Upgrade permitted to the higher applicable fare.

� No name changes allowed after ticketing.

� Select seat at check-in only or purchase on flysaa.com.

� 1 Voyager Mile for every R1.60 spent.

� Re-routing permitted.

� Standby not permitted.

� Complimentary onboard meals or snacks.

� Refunds - partially/non-refundable within terms and conditions.

� No show fee will apply.

� Checked-in baggage allowance from 1 piece up to 23kg (depending on destination - refer to flysaa.com for full details).

� One piece of cabin baggage, each not exceeding 8kg in weight.

� Please note that if the flight is operated by another airline then the onboard product or service maybe different to that described above.</air:Text>
                     <air:Text Type="Strapline" LanguageCode="EN">Our best available fare</air:Text>
                     <air:ImageLocation Type="Consumer" ImageWidth="1400" ImageHeight="800">https://cdn.travelport.com/southafrican/SA_general_large_45797.jpg</air:ImageLocation>
                     <air:ImageLocation Type="Agent" ImageWidth="150" ImageHeight="150">https://cdn.travelport.com/southafrican/SA_general_medium_484.jpg</air:ImageLocation>
                     <air:OptionalServices>
                        <air:OptionalService Type="Baggage" CreateDate="2020-03-03T00:30:10.337+00:00" Key="sQTWMC3R2BKArsvFCAAAAA==" Chargeable="Included in the brand" OptionalServicesRuleRef="sQTWMC3R2BKAssvFCAAAAA==" Tag="Checked Baggage" DisplayOrder="2">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAPsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Checked baggage</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105382.jpg"/>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105382.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Check in your bags for extra convenience</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">� Saver passengers can check in 1 piece of baggage up to 23kg.

� Plus passengers can check in 1 piece of baggage up to 23kg.

� Select passengers can check in 1 piece of baggage up to 23kg.

� Priority passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.

� Premium passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">� Saver passengers can check in 1 piece of baggage up to 23kg.

� Plus passengers can check in 1 piece of baggage up to 23kg.

� Select passengers can check in 1 piece of baggage up to 23kg.

� Priority passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.

� Premium passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Checked baggage</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Y,1,23,Bag</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Baggage" CreateDate="2020-03-03T00:30:10.337+00:00" Key="sQTWMC3R2BKAtsvFCAAAAA==" SecondaryType="CY" Chargeable="Included in the brand" OptionalServicesRuleRef="sQTWMC3R2BKAusvFCAAAAA==" Tag="Other" DisplayOrder="999">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAPsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Hand baggage</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105388.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105388.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Taking bags on board</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">1x8kg (max 56 x 36 x 23cm).</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">1x8kg (max 56 x 36 x 23cm).</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Hand baggage</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Y,1,8,CY</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Branded Fares" CreateDate="2020-03-03T00:30:10.337+00:00" Key="sQTWMC3R2BKAvsvFCAAAAA==" SecondaryType="VC" Chargeable="Available for a charge" Tag="Rebooking" DisplayOrder="3">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAPsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Changes</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55886.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55886.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:Text Type="Strapline" LanguageCode="EN">Making changes to your reservation</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Changes</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Changes</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Branded Fares" CreateDate="2020-03-03T00:30:10.337+00:00" Key="sQTWMC3R2BKAwsvFCAAAAA==" SecondaryType="RF" Chargeable="Not offered" Tag="REFUNDABLE TICKET" DisplayOrder="22">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAPsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Refunds</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55887.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55887.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Cancelling your reservation</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Refunds</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Refunds</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="PreReservedSeatAssignment" CreateDate="2020-03-03T00:30:10.337+00:00" Key="sQTWMC3R2BKAxsvFCAAAAA==" Chargeable="Available for a charge" Tag="Seat Assignment" DisplayOrder="5">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAPsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Seat Selection</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105390.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105390.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Pre book your preferred seat in advance</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">Saver fares can select advanced seat reservation available on flysaa.com at a small fee

Plus fares (domestic) can select seat at check-in free of charge. Advanced seat reservation available on flysaa.com at a small fee. 
Plus fares (international) seating available at time of booking.

Select fares seating available at time of booking.

Emergency Exit seats available at a fee for Saver, Plus and Select fares.

Priority and Premium fares seating available at time of booking.

Please note that if the flight is operated by another airline then the options to pre assign seats might be different.</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">Saver fares can select advanced seat reservation available on flysaa.com at a small fee

Plus fares (domestic) can select seat at check-in free of charge. Advanced seat reservation available on flysaa.com at a small fee. 
Plus fares (international) seating available at time of booking.

Select fares seating available at time of booking.

Emergency Exit seats available at a fee for Saver, Plus and Select fares.

Priority and Premium fares seating available at time of booking.

Please note that if the flight is operated by another airline then the options to pre assign seats might be different.</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Seat Selection</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Seating</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="MealOrBeverage" CreateDate="2020-03-03T00:30:10.337+00:00" Key="sQTWMC3R2BKAysvFCAAAAA==" Chargeable="Included in the brand" Tag="Other" DisplayOrder="999">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAPsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Meals</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105386.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105386.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">On board catering</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">� Saver, Plus and Select passengers can enjoy a complementary meal and a variety of beverages.

� Priority and Premium passengers can enjoy award-winning cuisine prepared by world-renowned chefs</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">� Saver, Plus and Select passengers can enjoy a complementary meal and a variety of beverages.

� Priority and Premium passengers can enjoy award-winning cuisine prepared by world-renowned chefs</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Meals</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Meals</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="InFlightEntertainment" CreateDate="2020-03-03T00:30:10.337+00:00" ServiceSubCode="" Key="sQTWMC3R2BKAzsvFCAAAAA==" SecondaryType="IT" Chargeable="Not offered" Tag="WiFi" DisplayOrder="7">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAPsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>WiFi</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105389.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105389.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Stay connected whilst in the air</air:Text>
                           <air:Title Type="External" LanguageCode="EN">WiFi</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">WiFi</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Lounge" CreateDate="2020-03-03T00:30:10.337+00:00" Key="sQTWMC3R2BKA0svFCAAAAA==" Chargeable="Not offered" OptionalServicesRuleRef="sQTWMC3R2BKA1svFCAAAAA==" Tag="Lounge Access" DisplayOrder="8">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAPsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Lounge Access</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105387.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105387.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">The destination between destinations</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">Beautifully designed facilities, with elegant finishes, spacious interiors, a smoker�s lounge and bar to make you feel right at home without the queues or the fuss.</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">Beautifully designed facilities, with elegant finishes, spacious interiors, a smoker�s lounge and bar to make you feel right at home without the queues or the fuss.</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Lounge Access</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Lounge Acc</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="TravelServices" CreateDate="2020-03-03T00:30:10.337+00:00" Key="sQTWMC3R2BKA2svFCAAAAA==" Chargeable="Not offered" OptionalServicesRuleRef="sQTWMC3R2BKA3svFCAAAAA==" Tag="Other" DisplayOrder="999">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAPsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Priority</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105391.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105391.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Beat the queues at the airport</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">Business Class passengers can enjoy the benefits of priority check in with its own entrance and priority boarding to skip the queues</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">Business Class passengers can enjoy the benefits of priority check in with its own entrance and priority boarding to skip the queues</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Priority</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Priority</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Upgrades" CreateDate="2020-03-03T00:30:10.337+00:00" Key="sQTWMC3R2BKA4svFCAAAAA==" SecondaryType="ME" Chargeable="Not offered" Tag="Upgrades" DisplayOrder="11">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAPsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Upgradeable fare</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105392.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105392.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Use your miles to upgrade</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Upgradeable fare</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Upgrades</air:Title>
                        </air:OptionalService>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKAssvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">Y,1,KG,23,BAG</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKAusvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">Y,1,KG,8,CY - W23,H36,L56,CM</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKA1svFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">We have lounges in 5 of South Africa�s major Domestic cities with presence in Harare, Lagos and Lusaka. You are legible to use the lounges when travelling on SAA or a Star Alliance partner airline, (this applies to your guests as well) on the same day of travel.
This is applicable to:
SAA Voyager Lifetime Platinum or Platinum Card holder, entitled to two guests;
SAA Voyager Gold member, entitled to one guest;
SAA Voyager Silver members, no guest is allowed;
SAA Business Class passenger, no guest is allowed;
Star Gold member, entitled to one guest;
SAA NEDBANK Platinum Credit Card membership does not include guest invitations. This card may be used when travelling on a SAA flight number, and is only valid in local lounges (South Africa).

Within the SAA Baobab lounges at ORTIA (both domestic &amp;amp; international sides), we have exclusive lounge areas for Lifetime Platinum and Platinum members.</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKA3svFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">*Only available for Business Class passengers</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                     </air:OptionalServices>
                     <air:Rules>
                        <air:RulesText>*For detailed fare conditions please refer to fare notes as per the fare display</air:RulesText>
                     </air:Rules>
                  </air:Brand>
               </air:FareInfo>
               <air:FareInfo Key="sQTWMC3R2BKA5svFCAAAAA==" FareBasis="WOW4Z" PassengerTypeCode="ADT" Origin="JNB" Destination="BFN" EffectiveDate="2020-03-03T02:30:00.000+02:00" DepartureDate="2020-04-21" Amount="ZAR150.00" NotValidBefore="2020-04-21" NotValidAfter="2020-04-21" TaxAmount="ZAR845.61">
                  <common_v50_0:Endorsement Value="NONEND" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <common_v50_0:Endorsement Value="NONREF/CHG PENALTY APPLY" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <common_v50_0:Endorsement Value="NONEND/NONREF VLD SA ONLY" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <common_v50_0:Endorsement Value="NONEND-/REF" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <air:FareRuleKey FareInfoRef="sQTWMC3R2BKA5svFCAAAAA==" ProviderCode="1G">6UUVoSldxwgoBDod9lw1CsbKj3F8T9EyxsqPcXxP0TLGyo9xfE/RMsuWFfXVd1OAly5qxZ3qLwOXLmrFneovA5cuasWd6i8Dly5qxZ3qLwOXLmrFneovA0prhS7A5XirjynaV73G5Ybzd/VTAJtvZZOe0KNo8lAk+ZcYfnlwjGgoQAOB3NUwHgOyWVEtUxxB7lC94aKWBT/MN4B6NiLACBll6FxyIC6cYuAWfcH2w92IEQfz1U0L7yHjHE8eyooBjnqTLWH39jvqkp0FEw0raOCbZ1nsUQQBXFYZySjRTG1jQfRfdF5snouFsAExMoVlv4Xvb2u1Qx+/he9va7VDH7+F729rtUMfv4Xvb2u1Qx+/he9va7VDHzyxauAs+veBE308BFXsd7QPNqcmmS6r7B2WN4EjYakqaX94QGLUjiICtVjYv91BNPvQb2zWrtbY5GwF8kqQiiA=</air:FareRuleKey>
                  <air:Brand Key="sQTWMC3R2BKA5svFCAAAAA==" BrandID="245008" UpSellBrandID="245011" Name="Saver" Carrier="SA" BrandTier="0001">
                     <air:Title Type="External" LanguageCode="EN">Saver</air:Title>
                     <air:Title Type="Short" LanguageCode="EN">Saver</air:Title>
                     <air:Text Type="MarketingConsumer" LanguageCode="EN">� Combinable with any other fare class.

� Ticket payment period: as per fare rule.

� Flight changes allowed at no charge subject to the applicable booking class being available, If the applicable booking class is not available. 

� Upgrade permitted to the higher applicable fare.

� No name changes allowed after ticketing.

� Select seat at check-in only or purchase on flysaa.com.

� 1 Voyager Mile for every R1.60 spent.

� Re-routing permitted.

� Standby not permitted.

� Complimentary onboard meals or snacks.

� Refunds - partially/non-refundable within terms and conditions.

� No show fee will apply.

� Checked-in baggage allowance from 1 piece up to 23kg (depending on destination - refer to flysaa.com for full details).

� One piece of cabin baggage, each not exceeding 8kg in weight.

� Please note that if the flight is operated by another airline then the onboard product or service maybe different to that described above.</air:Text>
                     <air:Text Type="MarketingAgent" LanguageCode="EN">� Combinable with any other fare class.

� Ticket payment period: as per fare rule.

� Flight changes allowed at no charge subject to the applicable booking class being available, If the applicable booking class is not available. 

� Upgrade permitted to the higher applicable fare.

� No name changes allowed after ticketing.

� Select seat at check-in only or purchase on flysaa.com.

� 1 Voyager Mile for every R1.60 spent.

� Re-routing permitted.

� Standby not permitted.

� Complimentary onboard meals or snacks.

� Refunds - partially/non-refundable within terms and conditions.

� No show fee will apply.

� Checked-in baggage allowance from 1 piece up to 23kg (depending on destination - refer to flysaa.com for full details).

� One piece of cabin baggage, each not exceeding 8kg in weight.

� Please note that if the flight is operated by another airline then the onboard product or service maybe different to that described above.</air:Text>
                     <air:Text Type="Strapline" LanguageCode="EN">Our best available fare</air:Text>
                     <air:ImageLocation Type="Consumer" ImageWidth="1400" ImageHeight="800">https://cdn.travelport.com/southafrican/SA_general_large_45797.jpg</air:ImageLocation>
                     <air:ImageLocation Type="Agent" ImageWidth="150" ImageHeight="150">https://cdn.travelport.com/southafrican/SA_general_medium_484.jpg</air:ImageLocation>
                     <air:OptionalServices>
                        <air:OptionalService Type="Baggage" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKA+svFCAAAAA==" Chargeable="Included in the brand" OptionalServicesRuleRef="sQTWMC3R2BKA/svFCAAAAA==" Tag="Checked Baggage" DisplayOrder="2">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKARsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Checked baggage</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105382.jpg"/>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105382.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Check in your bags for extra convenience</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">� Saver passengers can check in 1 piece of baggage up to 23kg.

� Plus passengers can check in 1 piece of baggage up to 23kg.

� Select passengers can check in 1 piece of baggage up to 23kg.

� Priority passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.

� Premium passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">� Saver passengers can check in 1 piece of baggage up to 23kg.

� Plus passengers can check in 1 piece of baggage up to 23kg.

� Select passengers can check in 1 piece of baggage up to 23kg.

� Priority passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.

� Premium passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Checked baggage</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Y,1,23,Bag</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Baggage" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAAtvFCAAAAA==" SecondaryType="CY" Chargeable="Included in the brand" OptionalServicesRuleRef="sQTWMC3R2BKABtvFCAAAAA==" Tag="Other" DisplayOrder="999">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKARsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Hand baggage</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105388.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105388.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Taking bags on board</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">1x8kg (max 56 x 36 x 23cm).</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">1x8kg (max 56 x 36 x 23cm).</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Hand baggage</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Y,1,8,CY</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Branded Fares" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKACtvFCAAAAA==" SecondaryType="VC" Chargeable="Available for a charge" Tag="Rebooking" DisplayOrder="3">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKARsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Changes</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55886.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55886.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:Text Type="Strapline" LanguageCode="EN">Making changes to your reservation</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Changes</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Changes</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Branded Fares" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKADtvFCAAAAA==" SecondaryType="RF" Chargeable="Not offered" Tag="REFUNDABLE TICKET" DisplayOrder="22">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKARsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Refunds</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55887.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55887.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Cancelling your reservation</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Refunds</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Refunds</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="PreReservedSeatAssignment" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAEtvFCAAAAA==" Chargeable="Available for a charge" Tag="Seat Assignment" DisplayOrder="5">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKARsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Seat Selection</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105390.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105390.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Pre book your preferred seat in advance</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">Saver fares can select advanced seat reservation available on flysaa.com at a small fee

Plus fares (domestic) can select seat at check-in free of charge. Advanced seat reservation available on flysaa.com at a small fee. 
Plus fares (international) seating available at time of booking.

Select fares seating available at time of booking.

Emergency Exit seats available at a fee for Saver, Plus and Select fares.

Priority and Premium fares seating available at time of booking.

Please note that if the flight is operated by another airline then the options to pre assign seats might be different.</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">Saver fares can select advanced seat reservation available on flysaa.com at a small fee

Plus fares (domestic) can select seat at check-in free of charge. Advanced seat reservation available on flysaa.com at a small fee. 
Plus fares (international) seating available at time of booking.

Select fares seating available at time of booking.

Emergency Exit seats available at a fee for Saver, Plus and Select fares.

Priority and Premium fares seating available at time of booking.

Please note that if the flight is operated by another airline then the options to pre assign seats might be different.</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Seat Selection</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Seating</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="MealOrBeverage" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAFtvFCAAAAA==" Chargeable="Included in the brand" Tag="Other" DisplayOrder="999">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKARsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Meals</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105386.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105386.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">On board catering</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">� Saver, Plus and Select passengers can enjoy a complementary meal and a variety of beverages.

� Priority and Premium passengers can enjoy award-winning cuisine prepared by world-renowned chefs</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">� Saver, Plus and Select passengers can enjoy a complementary meal and a variety of beverages.

� Priority and Premium passengers can enjoy award-winning cuisine prepared by world-renowned chefs</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Meals</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Meals</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="InFlightEntertainment" CreateDate="2020-03-03T00:30:10.338+00:00" ServiceSubCode="" Key="sQTWMC3R2BKAGtvFCAAAAA==" SecondaryType="IT" Chargeable="Not offered" Tag="WiFi" DisplayOrder="7">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKARsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>WiFi</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105389.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105389.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Stay connected whilst in the air</air:Text>
                           <air:Title Type="External" LanguageCode="EN">WiFi</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">WiFi</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Lounge" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAHtvFCAAAAA==" Chargeable="Not offered" OptionalServicesRuleRef="sQTWMC3R2BKAItvFCAAAAA==" Tag="Lounge Access" DisplayOrder="8">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKARsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Lounge Access</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105387.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105387.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">The destination between destinations</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">Beautifully designed facilities, with elegant finishes, spacious interiors, a smoker�s lounge and bar to make you feel right at home without the queues or the fuss.</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">Beautifully designed facilities, with elegant finishes, spacious interiors, a smoker�s lounge and bar to make you feel right at home without the queues or the fuss.</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Lounge Access</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Lounge Acc</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="TravelServices" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAJtvFCAAAAA==" Chargeable="Not offered" OptionalServicesRuleRef="sQTWMC3R2BKAKtvFCAAAAA==" Tag="Other" DisplayOrder="999">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKARsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Priority</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105391.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105391.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Beat the queues at the airport</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">Business Class passengers can enjoy the benefits of priority check in with its own entrance and priority boarding to skip the queues</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">Business Class passengers can enjoy the benefits of priority check in with its own entrance and priority boarding to skip the queues</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Priority</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Priority</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Upgrades" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKALtvFCAAAAA==" SecondaryType="ME" Chargeable="Not offered" Tag="Upgrades" DisplayOrder="11">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKARsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Upgradeable fare</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105392.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105392.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Use your miles to upgrade</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Upgradeable fare</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Upgrades</air:Title>
                        </air:OptionalService>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKA/svFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">Y,1,KG,23,BAG</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKABtvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">Y,1,KG,8,CY - W23,H36,L56,CM</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKAItvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">We have lounges in 5 of South Africa�s major Domestic cities with presence in Harare, Lagos and Lusaka. You are legible to use the lounges when travelling on SAA or a Star Alliance partner airline, (this applies to your guests as well) on the same day of travel.
This is applicable to:
SAA Voyager Lifetime Platinum or Platinum Card holder, entitled to two guests;
SAA Voyager Gold member, entitled to one guest;
SAA Voyager Silver members, no guest is allowed;
SAA Business Class passenger, no guest is allowed;
Star Gold member, entitled to one guest;
SAA NEDBANK Platinum Credit Card membership does not include guest invitations. This card may be used when travelling on a SAA flight number, and is only valid in local lounges (South Africa).

Within the SAA Baobab lounges at ORTIA (both domestic &amp;amp; international sides), we have exclusive lounge areas for Lifetime Platinum and Platinum members.</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKAKtvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">*Only available for Business Class passengers</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                     </air:OptionalServices>
                     <air:Rules>
                        <air:RulesText>*For detailed fare conditions please refer to fare notes as per the fare display</air:RulesText>
                     </air:Rules>
                  </air:Brand>
               </air:FareInfo>
               <air:FareInfo Key="sQTWMC3R2BKAMtvFCAAAAA==" FareBasis="GSAX" PassengerTypeCode="ADT" Origin="BFN" Destination="CPT" EffectiveDate="2020-03-03T02:30:00.000+02:00" DepartureDate="2020-04-21" Amount="ZAR500.00" NotValidAfter="2020-10-21" TaxAmount="ZAR884.61">
                  <common_v50_0:Endorsement Value="NONEND" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <common_v50_0:Endorsement Value="NONREF/CHG PENALTY APPLY" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <common_v50_0:Endorsement Value="NONEND/NONREF VLD SA ONLY" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <common_v50_0:Endorsement Value="NONEND-/REF" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <air:FareRuleKey FareInfoRef="sQTWMC3R2BKAMtvFCAAAAA==" ProviderCode="1G">6UUVoSldxwgoBDod9lw1CsbKj3F8T9EyxsqPcXxP0TLGyo9xfE/RMsuWFfXVd1OAly5qxZ3qLwOXLmrFneovA5cuasWd6i8Dly5qxZ3qLwOXLmrFneovA0prhS7A5XirjynaV73G5Ybzd/VTAJtvZWr4gOR/0C8BcmGjLq1kfNQoQAOB3NUwHq+T5W9I5ORh2kpAc6+TYjWWWdwS4Dg2ycsiOHFaFMf8hf6E18cRejGVqfCTByZWB/usF7CDIol16Os0CRl9F5OzwqagSNw6Eo0sKBvhNXxa5ZnwpvTiu4JK5x9yOUd+rUACA4xcw3/+ly5qxZ3qLwOXLmrFneovA5cuasWd6i8Dly5qxZ3qLwOXLmrFneovA4q+cJFUBzriwNmwgE7MqQt7PHybnt8kEFNFX/4N2RTgw6DTb7hnOe2UyQ+S+OdckvvQb2zWrtbY5GwF8kqQiiA=</air:FareRuleKey>
                  <air:Brand Key="sQTWMC3R2BKAMtvFCAAAAA==" BrandID="245008" UpSellBrandID="245011" Name="Saver" Carrier="SA" BrandTier="0001">
                     <air:Title Type="External" LanguageCode="EN">Saver</air:Title>
                     <air:Title Type="Short" LanguageCode="EN">Saver</air:Title>
                     <air:Text Type="MarketingConsumer" LanguageCode="EN">� Combinable with any other fare class.

� Ticket payment period: as per fare rule.

� Flight changes allowed at no charge subject to the applicable booking class being available, If the applicable booking class is not available. 

� Upgrade permitted to the higher applicable fare.

� No name changes allowed after ticketing.

� Select seat at check-in only or purchase on flysaa.com.

� 1 Voyager Mile for every R1.60 spent.

� Re-routing permitted.

� Standby not permitted.

� Complimentary onboard meals or snacks.

� Refunds - partially/non-refundable within terms and conditions.

� No show fee will apply.

� Checked-in baggage allowance from 1 piece up to 23kg (depending on destination - refer to flysaa.com for full details).

� One piece of cabin baggage, each not exceeding 8kg in weight.

� Please note that if the flight is operated by another airline then the onboard product or service maybe different to that described above.</air:Text>
                     <air:Text Type="MarketingAgent" LanguageCode="EN">� Combinable with any other fare class.

� Ticket payment period: as per fare rule.

� Flight changes allowed at no charge subject to the applicable booking class being available, If the applicable booking class is not available. 

� Upgrade permitted to the higher applicable fare.

� No name changes allowed after ticketing.

� Select seat at check-in only or purchase on flysaa.com.

� 1 Voyager Mile for every R1.60 spent.

� Re-routing permitted.

� Standby not permitted.

� Complimentary onboard meals or snacks.

� Refunds - partially/non-refundable within terms and conditions.

� No show fee will apply.

� Checked-in baggage allowance from 1 piece up to 23kg (depending on destination - refer to flysaa.com for full details).

� One piece of cabin baggage, each not exceeding 8kg in weight.

� Please note that if the flight is operated by another airline then the onboard product or service maybe different to that described above.</air:Text>
                     <air:Text Type="Strapline" LanguageCode="EN">Our best available fare</air:Text>
                     <air:ImageLocation Type="Consumer" ImageWidth="1400" ImageHeight="800">https://cdn.travelport.com/southafrican/SA_general_large_45797.jpg</air:ImageLocation>
                     <air:ImageLocation Type="Agent" ImageWidth="150" ImageHeight="150">https://cdn.travelport.com/southafrican/SA_general_medium_484.jpg</air:ImageLocation>
                     <air:OptionalServices>
                        <air:OptionalService Type="Baggage" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKARtvFCAAAAA==" Chargeable="Included in the brand" OptionalServicesRuleRef="sQTWMC3R2BKAStvFCAAAAA==" Tag="Checked Baggage" DisplayOrder="2">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKATsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Checked baggage</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105382.jpg"/>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105382.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Check in your bags for extra convenience</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">� Saver passengers can check in 1 piece of baggage up to 23kg.

� Plus passengers can check in 1 piece of baggage up to 23kg.

� Select passengers can check in 1 piece of baggage up to 23kg.

� Priority passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.

� Premium passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">� Saver passengers can check in 1 piece of baggage up to 23kg.

� Plus passengers can check in 1 piece of baggage up to 23kg.

� Select passengers can check in 1 piece of baggage up to 23kg.

� Priority passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.

� Premium passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Checked baggage</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Y,1,23,Bag</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Baggage" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKATtvFCAAAAA==" SecondaryType="CY" Chargeable="Included in the brand" OptionalServicesRuleRef="sQTWMC3R2BKAUtvFCAAAAA==" Tag="Other" DisplayOrder="999">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKATsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Hand baggage</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105388.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105388.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Taking bags on board</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">1x8kg (max 56 x 36 x 23cm).</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">1x8kg (max 56 x 36 x 23cm).</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Hand baggage</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Y,1,8,CY</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Branded Fares" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAVtvFCAAAAA==" SecondaryType="VC" Chargeable="Available for a charge" Tag="Rebooking" DisplayOrder="3">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKATsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Changes</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55886.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55886.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:Text Type="Strapline" LanguageCode="EN">Making changes to your reservation</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Changes</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Changes</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Branded Fares" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAWtvFCAAAAA==" SecondaryType="RF" Chargeable="Not offered" Tag="REFUNDABLE TICKET" DisplayOrder="22">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKATsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Refunds</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55887.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55887.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Cancelling your reservation</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Refunds</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Refunds</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="PreReservedSeatAssignment" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAXtvFCAAAAA==" Chargeable="Available for a charge" Tag="Seat Assignment" DisplayOrder="5">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKATsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Seat Selection</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105390.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105390.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Pre book your preferred seat in advance</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">Saver fares can select advanced seat reservation available on flysaa.com at a small fee

Plus fares (domestic) can select seat at check-in free of charge. Advanced seat reservation available on flysaa.com at a small fee. 
Plus fares (international) seating available at time of booking.

Select fares seating available at time of booking.

Emergency Exit seats available at a fee for Saver, Plus and Select fares.

Priority and Premium fares seating available at time of booking.

Please note that if the flight is operated by another airline then the options to pre assign seats might be different.</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">Saver fares can select advanced seat reservation available on flysaa.com at a small fee

Plus fares (domestic) can select seat at check-in free of charge. Advanced seat reservation available on flysaa.com at a small fee. 
Plus fares (international) seating available at time of booking.

Select fares seating available at time of booking.

Emergency Exit seats available at a fee for Saver, Plus and Select fares.

Priority and Premium fares seating available at time of booking.

Please note that if the flight is operated by another airline then the options to pre assign seats might be different.</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Seat Selection</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Seating</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="MealOrBeverage" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAYtvFCAAAAA==" Chargeable="Included in the brand" Tag="Other" DisplayOrder="999">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKATsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Meals</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105386.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105386.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">On board catering</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">� Saver, Plus and Select passengers can enjoy a complementary meal and a variety of beverages.

� Priority and Premium passengers can enjoy award-winning cuisine prepared by world-renowned chefs</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">� Saver, Plus and Select passengers can enjoy a complementary meal and a variety of beverages.

� Priority and Premium passengers can enjoy award-winning cuisine prepared by world-renowned chefs</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Meals</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Meals</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="InFlightEntertainment" CreateDate="2020-03-03T00:30:10.338+00:00" ServiceSubCode="" Key="sQTWMC3R2BKAZtvFCAAAAA==" SecondaryType="IT" Chargeable="Not offered" Tag="WiFi" DisplayOrder="7">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKATsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>WiFi</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105389.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105389.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Stay connected whilst in the air</air:Text>
                           <air:Title Type="External" LanguageCode="EN">WiFi</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">WiFi</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Lounge" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAatvFCAAAAA==" Chargeable="Not offered" OptionalServicesRuleRef="sQTWMC3R2BKAbtvFCAAAAA==" Tag="Lounge Access" DisplayOrder="8">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKATsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Lounge Access</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105387.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105387.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">The destination between destinations</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">Beautifully designed facilities, with elegant finishes, spacious interiors, a smoker�s lounge and bar to make you feel right at home without the queues or the fuss.</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">Beautifully designed facilities, with elegant finishes, spacious interiors, a smoker�s lounge and bar to make you feel right at home without the queues or the fuss.</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Lounge Access</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Lounge Acc</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="TravelServices" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKActvFCAAAAA==" Chargeable="Not offered" OptionalServicesRuleRef="sQTWMC3R2BKAdtvFCAAAAA==" Tag="Other" DisplayOrder="999">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKATsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Priority</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105391.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105391.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Beat the queues at the airport</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">Business Class passengers can enjoy the benefits of priority check in with its own entrance and priority boarding to skip the queues</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">Business Class passengers can enjoy the benefits of priority check in with its own entrance and priority boarding to skip the queues</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Priority</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Priority</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Upgrades" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAetvFCAAAAA==" SecondaryType="ME" Chargeable="Not offered" Tag="Upgrades" DisplayOrder="11">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKATsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Upgradeable fare</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105392.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105392.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Use your miles to upgrade</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Upgradeable fare</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Upgrades</air:Title>
                        </air:OptionalService>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKAStvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">Y,1,KG,23,BAG</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKAUtvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">Y,1,KG,8,CY - W23,H36,L56,CM</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKAbtvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">We have lounges in 5 of South Africa�s major Domestic cities with presence in Harare, Lagos and Lusaka. You are legible to use the lounges when travelling on SAA or a Star Alliance partner airline, (this applies to your guests as well) on the same day of travel.
This is applicable to:
SAA Voyager Lifetime Platinum or Platinum Card holder, entitled to two guests;
SAA Voyager Gold member, entitled to one guest;
SAA Voyager Silver members, no guest is allowed;
SAA Business Class passenger, no guest is allowed;
Star Gold member, entitled to one guest;
SAA NEDBANK Platinum Credit Card membership does not include guest invitations. This card may be used when travelling on a SAA flight number, and is only valid in local lounges (South Africa).

Within the SAA Baobab lounges at ORTIA (both domestic &amp;amp; international sides), we have exclusive lounge areas for Lifetime Platinum and Platinum members.</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKAdtvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">*Only available for Business Class passengers</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                     </air:OptionalServices>
                     <air:Rules>
                        <air:RulesText>*For detailed fare conditions please refer to fare notes as per the fare display</air:RulesText>
                     </air:Rules>
                  </air:Brand>
               </air:FareInfo>
               <air:FareInfo Key="sQTWMC3R2BKAftvFCAAAAA==" FareBasis="GSAOW" PassengerTypeCode="ADT" Origin="CPT" Destination="JNB" EffectiveDate="2020-03-03T02:30:00.000+02:00" DepartureDate="2020-04-26" Amount="ZAR630.00" NotValidBefore="2020-04-26" NotValidAfter="2020-04-26" TaxAmount="ZAR1162.61">
                  <common_v50_0:Endorsement Value="NONEND" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <common_v50_0:Endorsement Value="NONREF/CHG PENALTY APPLY" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <common_v50_0:Endorsement Value="NONEND/NONREF VLD SA ONLY" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <common_v50_0:Endorsement Value="NONEND-/REF" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <air:FareRuleKey FareInfoRef="sQTWMC3R2BKAftvFCAAAAA==" ProviderCode="1G">6UUVoSldxwgoBDod9lw1CsbKj3F8T9EyxsqPcXxP0TLGyo9xfE/RMsuWFfXVd1OAly5qxZ3qLwOXLmrFneovA5cuasWd6i8Dly5qxZ3qLwOXLmrFneovA0prhS7A5XirjynaV73G5Ybzd/VTAJtvZe+lroixsZVgV9eCJ22Y584oQAOB3NUwHobvxXAzIWIA7lC94aKWBT+y5E4hL44Clxll6FxyIC6cYuAWfcH2w92IEQfz1U0L79YLUsX5J2eOE7TpXoMoA1rqkp0FEw0raOCbZ1nsUQQBy8kQxHrr33IKwnGlEIOjy4uFsAExMoVlv4Xvb2u1Qx+/he9va7VDH7+F729rtUMfv4Xvb2u1Qx+/he9va7VDHzyxauAs+veBE308BFXsd7QPNqcmmS6r7B2WN4EjYakqlejJhenmsgUCtVjYv91BNPvQb2zWrtbY5GwF8kqQiiA=</air:FareRuleKey>
                  <air:Brand Key="sQTWMC3R2BKAftvFCAAAAA==" BrandID="245008" UpSellBrandID="245011" Name="Saver" Carrier="SA" BrandTier="0001">
                     <air:Title Type="External" LanguageCode="EN">Saver</air:Title>
                     <air:Title Type="Short" LanguageCode="EN">Saver</air:Title>
                     <air:Text Type="MarketingConsumer" LanguageCode="EN">� Combinable with any other fare class.

� Ticket payment period: as per fare rule.

� Flight changes allowed at no charge subject to the applicable booking class being available, If the applicable booking class is not available. 

� Upgrade permitted to the higher applicable fare.

� No name changes allowed after ticketing.

� Select seat at check-in only or purchase on flysaa.com.

� 1 Voyager Mile for every R1.60 spent.

� Re-routing permitted.

� Standby not permitted.

� Complimentary onboard meals or snacks.

� Refunds - partially/non-refundable within terms and conditions.

� No show fee will apply.

� Checked-in baggage allowance from 1 piece up to 23kg (depending on destination - refer to flysaa.com for full details).

� One piece of cabin baggage, each not exceeding 8kg in weight.

� Please note that if the flight is operated by another airline then the onboard product or service maybe different to that described above.</air:Text>
                     <air:Text Type="MarketingAgent" LanguageCode="EN">� Combinable with any other fare class.

� Ticket payment period: as per fare rule.

� Flight changes allowed at no charge subject to the applicable booking class being available, If the applicable booking class is not available. 

� Upgrade permitted to the higher applicable fare.

� No name changes allowed after ticketing.

� Select seat at check-in only or purchase on flysaa.com.

� 1 Voyager Mile for every R1.60 spent.

� Re-routing permitted.

� Standby not permitted.

� Complimentary onboard meals or snacks.

� Refunds - partially/non-refundable within terms and conditions.

� No show fee will apply.

� Checked-in baggage allowance from 1 piece up to 23kg (depending on destination - refer to flysaa.com for full details).

� One piece of cabin baggage, each not exceeding 8kg in weight.

� Please note that if the flight is operated by another airline then the onboard product or service maybe different to that described above.</air:Text>
                     <air:Text Type="Strapline" LanguageCode="EN">Our best available fare</air:Text>
                     <air:ImageLocation Type="Consumer" ImageWidth="1400" ImageHeight="800">https://cdn.travelport.com/southafrican/SA_general_large_45797.jpg</air:ImageLocation>
                     <air:ImageLocation Type="Agent" ImageWidth="150" ImageHeight="150">https://cdn.travelport.com/southafrican/SA_general_medium_484.jpg</air:ImageLocation>
                     <air:OptionalServices>
                        <air:OptionalService Type="Baggage" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAktvFCAAAAA==" Chargeable="Included in the brand" OptionalServicesRuleRef="sQTWMC3R2BKAltvFCAAAAA==" Tag="Checked Baggage" DisplayOrder="2">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAVsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Checked baggage</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105382.jpg"/>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105382.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Check in your bags for extra convenience</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">� Saver passengers can check in 1 piece of baggage up to 23kg.

� Plus passengers can check in 1 piece of baggage up to 23kg.

� Select passengers can check in 1 piece of baggage up to 23kg.

� Priority passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.

� Premium passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">� Saver passengers can check in 1 piece of baggage up to 23kg.

� Plus passengers can check in 1 piece of baggage up to 23kg.

� Select passengers can check in 1 piece of baggage up to 23kg.

� Priority passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.

� Premium passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Checked baggage</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Y,1,23,Bag</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Baggage" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAmtvFCAAAAA==" SecondaryType="CY" Chargeable="Included in the brand" OptionalServicesRuleRef="sQTWMC3R2BKAntvFCAAAAA==" Tag="Other" DisplayOrder="999">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAVsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Hand baggage</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105388.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105388.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Taking bags on board</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">1x8kg (max 56 x 36 x 23cm).</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">1x8kg (max 56 x 36 x 23cm).</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Hand baggage</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Y,1,8,CY</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Branded Fares" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAotvFCAAAAA==" SecondaryType="VC" Chargeable="Available for a charge" Tag="Rebooking" DisplayOrder="3">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAVsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Changes</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55886.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55886.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:Text Type="Strapline" LanguageCode="EN">Making changes to your reservation</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Changes</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Changes</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Branded Fares" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAptvFCAAAAA==" SecondaryType="RF" Chargeable="Not offered" Tag="REFUNDABLE TICKET" DisplayOrder="22">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAVsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Refunds</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55887.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55887.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Cancelling your reservation</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Refunds</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Refunds</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="PreReservedSeatAssignment" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAqtvFCAAAAA==" Chargeable="Available for a charge" Tag="Seat Assignment" DisplayOrder="5">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAVsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Seat Selection</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105390.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105390.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Pre book your preferred seat in advance</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">Saver fares can select advanced seat reservation available on flysaa.com at a small fee

Plus fares (domestic) can select seat at check-in free of charge. Advanced seat reservation available on flysaa.com at a small fee. 
Plus fares (international) seating available at time of booking.

Select fares seating available at time of booking.

Emergency Exit seats available at a fee for Saver, Plus and Select fares.

Priority and Premium fares seating available at time of booking.

Please note that if the flight is operated by another airline then the options to pre assign seats might be different.</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">Saver fares can select advanced seat reservation available on flysaa.com at a small fee

Plus fares (domestic) can select seat at check-in free of charge. Advanced seat reservation available on flysaa.com at a small fee. 
Plus fares (international) seating available at time of booking.

Select fares seating available at time of booking.

Emergency Exit seats available at a fee for Saver, Plus and Select fares.

Priority and Premium fares seating available at time of booking.

Please note that if the flight is operated by another airline then the options to pre assign seats might be different.</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Seat Selection</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Seating</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="MealOrBeverage" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKArtvFCAAAAA==" Chargeable="Included in the brand" Tag="Other" DisplayOrder="999">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAVsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Meals</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105386.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105386.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">On board catering</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">� Saver, Plus and Select passengers can enjoy a complementary meal and a variety of beverages.

� Priority and Premium passengers can enjoy award-winning cuisine prepared by world-renowned chefs</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">� Saver, Plus and Select passengers can enjoy a complementary meal and a variety of beverages.

� Priority and Premium passengers can enjoy award-winning cuisine prepared by world-renowned chefs</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Meals</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Meals</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="InFlightEntertainment" CreateDate="2020-03-03T00:30:10.338+00:00" ServiceSubCode="" Key="sQTWMC3R2BKAstvFCAAAAA==" SecondaryType="IT" Chargeable="Not offered" Tag="WiFi" DisplayOrder="7">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAVsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>WiFi</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105389.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105389.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Stay connected whilst in the air</air:Text>
                           <air:Title Type="External" LanguageCode="EN">WiFi</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">WiFi</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Lounge" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAttvFCAAAAA==" Chargeable="Not offered" OptionalServicesRuleRef="sQTWMC3R2BKAutvFCAAAAA==" Tag="Lounge Access" DisplayOrder="8">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAVsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Lounge Access</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105387.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105387.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">The destination between destinations</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">Beautifully designed facilities, with elegant finishes, spacious interiors, a smoker�s lounge and bar to make you feel right at home without the queues or the fuss.</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">Beautifully designed facilities, with elegant finishes, spacious interiors, a smoker�s lounge and bar to make you feel right at home without the queues or the fuss.</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Lounge Access</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Lounge Acc</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="TravelServices" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAvtvFCAAAAA==" Chargeable="Not offered" OptionalServicesRuleRef="sQTWMC3R2BKAwtvFCAAAAA==" Tag="Other" DisplayOrder="999">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAVsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Priority</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105391.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105391.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Beat the queues at the airport</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">Business Class passengers can enjoy the benefits of priority check in with its own entrance and priority boarding to skip the queues</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">Business Class passengers can enjoy the benefits of priority check in with its own entrance and priority boarding to skip the queues</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Priority</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Priority</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Upgrades" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAxtvFCAAAAA==" SecondaryType="ME" Chargeable="Not offered" Tag="Upgrades" DisplayOrder="11">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAVsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Upgradeable fare</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105392.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105392.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Use your miles to upgrade</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Upgradeable fare</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Upgrades</air:Title>
                        </air:OptionalService>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKAltvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">Y,1,KG,23,BAG</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKAntvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">Y,1,KG,8,CY - W23,H36,L56,CM</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKAutvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">We have lounges in 5 of South Africa�s major Domestic cities with presence in Harare, Lagos and Lusaka. You are legible to use the lounges when travelling on SAA or a Star Alliance partner airline, (this applies to your guests as well) on the same day of travel.
This is applicable to:
SAA Voyager Lifetime Platinum or Platinum Card holder, entitled to two guests;
SAA Voyager Gold member, entitled to one guest;
SAA Voyager Silver members, no guest is allowed;
SAA Business Class passenger, no guest is allowed;
Star Gold member, entitled to one guest;
SAA NEDBANK Platinum Credit Card membership does not include guest invitations. This card may be used when travelling on a SAA flight number, and is only valid in local lounges (South Africa).

Within the SAA Baobab lounges at ORTIA (both domestic &amp;amp; international sides), we have exclusive lounge areas for Lifetime Platinum and Platinum members.</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKAwtvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">*Only available for Business Class passengers</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                     </air:OptionalServices>
                     <air:Rules>
                        <air:RulesText>*For detailed fare conditions please refer to fare notes as per the fare display</air:RulesText>
                     </air:Rules>
                  </air:Brand>
               </air:FareInfo>
               <air:FareInfo Key="sQTWMC3R2BKAytvFCAAAAA==" FareBasis="WOW4Z" PassengerTypeCode="ADT" Origin="JNB" Destination="PHW" EffectiveDate="2020-03-03T02:30:00.000+02:00" DepartureDate="2020-04-27" Amount="ZAR390.00" NotValidBefore="2020-04-27" NotValidAfter="2020-04-27" TaxAmount="ZAR1428.61">
                  <common_v50_0:Endorsement Value="NONEND" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <common_v50_0:Endorsement Value="NONREF/CHG PENALTY APPLY" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <common_v50_0:Endorsement Value="NONEND/NONREF VLD SA ONLY" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <common_v50_0:Endorsement Value="NONEND-/REF" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                  <air:FareRuleKey FareInfoRef="sQTWMC3R2BKAytvFCAAAAA==" ProviderCode="1G">6UUVoSldxwgoBDod9lw1CsbKj3F8T9EyxsqPcXxP0TLGyo9xfE/RMsuWFfXVd1OAly5qxZ3qLwOXLmrFneovA5cuasWd6i8Dly5qxZ3qLwOXLmrFneovA0prhS7A5XirjynaV73G5Ybzd/VTAJtvZYoJhN1GvPefS2ZD2iMgTwYoQAOB3NUwHgOyWVEtUxxB7lC94aKWBT//1OIuuAqi3xll6FxyIC6cYuAWfcH2w92IEQfz1U0L7yHjHE8eyooBjnqTLWH39jvvWpSmZkrE0eCbZ1nsUQQBXFYZySjRTG3U2+I59dhHLYuFsAExMoVlv4Xvb2u1Qx+/he9va7VDH7+F729rtUMfv4Xvb2u1Qx+/he9va7VDHzyxauAs+veBE308BFXsd7QPNqcmmS6r7B2WN4EjYakqaX94QGLUjiICtVjYv91BNPvQb2zWrtbY5GwF8kqQiiA=</air:FareRuleKey>
                  <air:Brand Key="sQTWMC3R2BKAytvFCAAAAA==" BrandID="245008" UpSellBrandID="245011" Name="Saver" Carrier="SA" BrandTier="0001">
                     <air:Title Type="External" LanguageCode="EN">Saver</air:Title>
                     <air:Title Type="Short" LanguageCode="EN">Saver</air:Title>
                     <air:Text Type="MarketingConsumer" LanguageCode="EN">� Combinable with any other fare class.

� Ticket payment period: as per fare rule.

� Flight changes allowed at no charge subject to the applicable booking class being available, If the applicable booking class is not available. 

� Upgrade permitted to the higher applicable fare.

� No name changes allowed after ticketing.

� Select seat at check-in only or purchase on flysaa.com.

� 1 Voyager Mile for every R1.60 spent.

� Re-routing permitted.

� Standby not permitted.

� Complimentary onboard meals or snacks.

� Refunds - partially/non-refundable within terms and conditions.

� No show fee will apply.

� Checked-in baggage allowance from 1 piece up to 23kg (depending on destination - refer to flysaa.com for full details).

� One piece of cabin baggage, each not exceeding 8kg in weight.

� Please note that if the flight is operated by another airline then the onboard product or service maybe different to that described above.</air:Text>
                     <air:Text Type="MarketingAgent" LanguageCode="EN">� Combinable with any other fare class.

� Ticket payment period: as per fare rule.

� Flight changes allowed at no charge subject to the applicable booking class being available, If the applicable booking class is not available. 

� Upgrade permitted to the higher applicable fare.

� No name changes allowed after ticketing.

� Select seat at check-in only or purchase on flysaa.com.

� 1 Voyager Mile for every R1.60 spent.

� Re-routing permitted.

� Standby not permitted.

� Complimentary onboard meals or snacks.

� Refunds - partially/non-refundable within terms and conditions.

� No show fee will apply.

� Checked-in baggage allowance from 1 piece up to 23kg (depending on destination - refer to flysaa.com for full details).

� One piece of cabin baggage, each not exceeding 8kg in weight.

� Please note that if the flight is operated by another airline then the onboard product or service maybe different to that described above.</air:Text>
                     <air:Text Type="Strapline" LanguageCode="EN">Our best available fare</air:Text>
                     <air:ImageLocation Type="Consumer" ImageWidth="1400" ImageHeight="800">https://cdn.travelport.com/southafrican/SA_general_large_45797.jpg</air:ImageLocation>
                     <air:ImageLocation Type="Agent" ImageWidth="150" ImageHeight="150">https://cdn.travelport.com/southafrican/SA_general_medium_484.jpg</air:ImageLocation>
                     <air:OptionalServices>
                        <air:OptionalService Type="Baggage" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKA3tvFCAAAAA==" Chargeable="Included in the brand" OptionalServicesRuleRef="sQTWMC3R2BKA4tvFCAAAAA==" Tag="Checked Baggage" DisplayOrder="2">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAXsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Checked baggage</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105382.jpg"/>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105382.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Check in your bags for extra convenience</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">� Saver passengers can check in 1 piece of baggage up to 23kg.

� Plus passengers can check in 1 piece of baggage up to 23kg.

� Select passengers can check in 1 piece of baggage up to 23kg.

� Priority passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.

� Premium passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">� Saver passengers can check in 1 piece of baggage up to 23kg.

� Plus passengers can check in 1 piece of baggage up to 23kg.

� Select passengers can check in 1 piece of baggage up to 23kg.

� Priority passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.

� Premium passengers can check in 1 piece of baggage up to 32kg for domestic routes and 2 pieces of baggage up to 32kg each for international routes.</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Checked baggage</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Y,1,23,Bag</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Baggage" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKA5tvFCAAAAA==" SecondaryType="CY" Chargeable="Included in the brand" OptionalServicesRuleRef="sQTWMC3R2BKA6tvFCAAAAA==" Tag="Other" DisplayOrder="999">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAXsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Hand baggage</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105388.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105388.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Taking bags on board</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">1x8kg (max 56 x 36 x 23cm).</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">1x8kg (max 56 x 36 x 23cm).</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Hand baggage</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Y,1,8,CY</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Branded Fares" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKA7tvFCAAAAA==" SecondaryType="VC" Chargeable="Available for a charge" Tag="Rebooking" DisplayOrder="3">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAXsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Changes</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55886.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55886.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:Text Type="Strapline" LanguageCode="EN">Making changes to your reservation</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Changes</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Changes</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Branded Fares" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKA8tvFCAAAAA==" SecondaryType="RF" Chargeable="Not offered" Tag="REFUNDABLE TICKET" DisplayOrder="22">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAXsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Refunds</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55887.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafrican/SA_general_medium_55887.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Cancelling your reservation</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Refunds</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Refunds</air:Title>
                        </air:OptionalService>
                        
                        
                        <air:OptionalService Type="InFlightEntertainment" CreateDate="2020-03-03T00:30:10.338+00:00" ServiceSubCode="" Key="sQTWMC3R2BKA/tvFCAAAAA==" SecondaryType="IT" Chargeable="Not offered" Tag="WiFi" DisplayOrder="7">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAXsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>WiFi</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105389.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105389.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Stay connected whilst in the air</air:Text>
                           <air:Title Type="External" LanguageCode="EN">WiFi</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">WiFi</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Lounge" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAAuvFCAAAAA==" Chargeable="Not offered" OptionalServicesRuleRef="sQTWMC3R2BKABuvFCAAAAA==" Tag="Lounge Access" DisplayOrder="8">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAXsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Lounge Access</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105387.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105387.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">The destination between destinations</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">Beautifully designed facilities, with elegant finishes, spacious interiors, a smoker�s lounge and bar to make you feel right at home without the queues or the fuss.</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">Beautifully designed facilities, with elegant finishes, spacious interiors, a smoker�s lounge and bar to make you feel right at home without the queues or the fuss.</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Lounge Access</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Lounge Acc</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="TravelServices" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKACuvFCAAAAA==" Chargeable="Not offered" OptionalServicesRuleRef="sQTWMC3R2BKADuvFCAAAAA==" Tag="Other" DisplayOrder="999">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAXsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Priority</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105391.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105391.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Beat the queues at the airport</air:Text>
                           <air:Text Type="MarketingAgent" LanguageCode="EN">Business Class passengers can enjoy the benefits of priority check in with its own entrance and priority boarding to skip the queues</air:Text>
                           <air:Text Type="MarketingConsumer" LanguageCode="EN">Business Class passengers can enjoy the benefits of priority check in with its own entrance and priority boarding to skip the queues</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Priority</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Priority</air:Title>
                        </air:OptionalService>
                        <air:OptionalService Type="Upgrades" CreateDate="2020-03-03T00:30:10.338+00:00" Key="sQTWMC3R2BKAEuvFCAAAAA==" SecondaryType="ME" Chargeable="Not offered" Tag="Upgrades" DisplayOrder="11">
                           <common_v50_0:ServiceData AirSegmentRef="sQTWMC3R2BKAXsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0"/>
                           <common_v50_0:ServiceInfo xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">
                              <common_v50_0:Description>Upgradeable fare</common_v50_0:Description>
                              <common_v50_0:MediaItem caption="Agent" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105392.jpg"/>
                              <common_v50_0:MediaItem caption="Consumer" height="60" width="60" url="https://cdn.travelport.com/southafricanairways/SA_general_medium_105392.jpg"/>
                           </common_v50_0:ServiceInfo>
                           <air:EMD AssociatedItem="Flight"/>
                           <air:Text Type="Strapline" LanguageCode="EN">Use your miles to upgrade</air:Text>
                           <air:Title Type="External" LanguageCode="EN">Upgradeable fare</air:Title>
                           <air:Title Type="Short" LanguageCode="EN">Upgrades</air:Title>
                        </air:OptionalService>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKA4tvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">Y,1,KG,23,BAG</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                        <air:OptionalServiceRules Key="sQTWMC3R2BKA6tvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">Y,1,KG,8,CY - W23,H36,L56,CM</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                       
                        <air:OptionalServiceRules Key="sQTWMC3R2BKADuvFCAAAAA==">
                           <common_v50_0:Remarks xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">*Only available for Business Class passengers</common_v50_0:Remarks>
                        </air:OptionalServiceRules>
                     </air:OptionalServices>
                     <air:Rules>
                        <air:RulesText>*For detailed fare conditions please refer to fare notes as per the fare display</air:RulesText>
                     </air:Rules>
                  </air:Brand>
               </air:FareInfo>
               <air:BookingInfo BookingCode="W" CabinClass="Economy" FareInfoRef="sQTWMC3R2BKAmsvFCAAAAA==" SegmentRef="sQTWMC3R2BKAPsvFCAAAAA==" HostTokenRef="sQTWMC3R2BKAasvFCAAAAA=="/>
               <air:BookingInfo BookingCode="W" CabinClass="Economy" FareInfoRef="sQTWMC3R2BKA5svFCAAAAA==" SegmentRef="sQTWMC3R2BKARsvFCAAAAA==" HostTokenRef="sQTWMC3R2BKAbsvFCAAAAA=="/>
               <air:BookingInfo BookingCode="G" CabinClass="Economy" FareInfoRef="sQTWMC3R2BKAMtvFCAAAAA==" SegmentRef="sQTWMC3R2BKATsvFCAAAAA==" HostTokenRef="sQTWMC3R2BKAcsvFCAAAAA=="/>
               <air:BookingInfo BookingCode="G" CabinClass="Economy" FareInfoRef="sQTWMC3R2BKAftvFCAAAAA==" SegmentRef="sQTWMC3R2BKAVsvFCAAAAA==" HostTokenRef="sQTWMC3R2BKAdsvFCAAAAA=="/>
               <air:BookingInfo BookingCode="W" CabinClass="Economy" FareInfoRef="sQTWMC3R2BKAytvFCAAAAA==" SegmentRef="sQTWMC3R2BKAXsvFCAAAAA==" HostTokenRef="sQTWMC3R2BKAesvFCAAAAA=="/>
               <air:TaxInfo Category="EV" Amount="ZAR124.30" Key="sQTWMC3R2BKAgsvFCAAAAA=="/>
               <air:TaxInfo Category="UM" Amount="ZAR100.00" Key="sQTWMC3R2BKAhsvFCAAAAA=="/>
               <air:TaxInfo Category="ZA" Amount="ZAR497.00" Key="sQTWMC3R2BKAisvFCAAAAA=="/>
               <air:TaxInfo Category="ZV" Amount="ZAR309.00" Key="sQTWMC3R2BKAjsvFCAAAAA=="/>
               <air:TaxInfo Category="YQ" Amount="ZAR3838.00" Key="sQTWMC3R2BKAksvFCAAAAA=="/>
               <air:TaxInfo Category="YR" Amount="ZAR934.00" Key="sQTWMC3R2BKAlsvFCAAAAA=="/>
               <air:FareCalc>PHW SA JNB 390.00WOW4Z SA BFN 150.00WOW4Z SA CPT 500.00GSAX SA JNB 630.00GSAOW SA PHW 390.00WOW4Z ZAR2060.00END</air:FareCalc>
               <air:PassengerType Code="ADT" BookingTravelerRef="Qm9va2luZ1RyYXZlbGVyMQ=="/>
               <air:PassengerType Code="ADT" BookingTravelerRef="Qm9va2luZ1RyYXZlbGVyMg=="/>
            </air:AirPricingInfo>
            <air:FareNote Key="sQTWMC3R2BKAKuvFCAAAAA==">LAST DATE TO PURCHASE TICKET: 04MAR20 JNB</air:FareNote>
            <air:FareNote Key="sQTWMC3R2BKALuvFCAAAAA==">TICKETING AGENCY 80EZ</air:FareNote>
            <air:FareNote Key="sQTWMC3R2BKAMuvFCAAAAA==">DEFAULT PLATING CARRIER SA</air:FareNote>
            <air:FareNote Key="sQTWMC3R2BKANuvFCAAAAA==">FARE HAS A PLATING CARRIER RESTRICTION</air:FareNote>
            <air:FareNote Key="sQTWMC3R2BKAOuvFCAAAAA==">E-TKT REQUIRED</air:FareNote>
            <air:FareNote Key="sQTWMC3R2BKAPuvFCAAAAA==">TICKETING FEES MAY APPLY</air:FareNote>
            <common_v50_0:HostToken Key="sQTWMC3R2BKAasvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">GFB10101ADT00  01WOW4Z                                 010001#GFB200010101NADTV3306CHD10020000399#GFMCSIP306NCHD1 SA ADTWOW4Z</common_v50_0:HostToken>
            <common_v50_0:HostToken Key="sQTWMC3R2BKAbsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">GFB10101ADT00  02WOW4Z                                 010002#GFB200010102NADTV3306CHD10020000599#GFMCSIP306NCHD1 SA ADTWOW4Z</common_v50_0:HostToken>
            <common_v50_0:HostToken Key="sQTWMC3R2BKAcsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">GFB10101ADT00  03GSAX                                  010003#GFB200010103NADTV3306SAVX0080000199U#GFMCSIP306NSAVX SA ADTGSAX</common_v50_0:HostToken>
            <common_v50_0:HostToken Key="sQTWMC3R2BKAdsvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">GFB10101ADT00  04GSAOW                                 010004#GFB200010104NADTV3306SAVD0010000199#GFMCSIP306NSAVD SA ADTGSAOW</common_v50_0:HostToken>
            <common_v50_0:HostToken Key="sQTWMC3R2BKAesvFCAAAAA==" xmlns:common_v50_0="http://www.travelport.com/schema/common_v50_0">GFB10101ADT00  05WOW4Z                                 010005#GFB200010105NADTV3306CHD10020000399#GFMCSIP306NCHD1 SA ADTWOW4Z</common_v50_0:HostToken>
         </air:AirPricingSolution>
         <com:ActionStatus TicketDate="2020-03-07" Type="TAU" ProviderCode="1G" xmlns:com="http://www.travelport.com/schema/common_v50_0"/>
      </univ:AirCreateReservationReq>
   </soap:Body>
</soap:Envelope>