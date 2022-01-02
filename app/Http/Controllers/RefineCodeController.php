<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RefineCodeController extends Controller
{
    public function Test(Type $var = null)
    {
        //        dd($request->all());
        $dt = Carbon::now();
        $date_today = $dt->timezone('Europe/London');
        $date = $date_today->toDateString();
        $invoice = new invoice;
        $client = client::find($request->receiver_name);
        $invoice->client_id = $client->id;
        if($request->diff_receiver_name){
            $invoice->receiver_name = $request->diff_receiver_name;
        } else {
            $invoice->receiver_name = strtoupper($client->first_name . ' ' . $client->last_name);
        }
        $invoice->billing_address = strtoupper($request->billing_address);
        $invoice->invoice_date = $request->invoice_date;
        $invoice->invoice_no = $invoice_no;
        if (!empty($request->discount)) {
            $invoice->discount = str_replace(',', '', $request->discount);
        } else {
            $request->discount = 0.0;
        }
        $invoice->currency = $request->currency;
        $invoice->total = str_replace(',', '', $request->total);
        $invoice->discounted_total = str_replace(',', '', $request->total) - str_replace(',', '', $request->discount);
        $invoice->mail_sent = $date;
        $invoice->remarks = $request->remarks;
        $invoice->save();
        $tax = settings::all();
        if ($tax[0]->enable == 'yes') {
            $invoice->VAT_percentage = $tax[0]->tax;
            $invoice->VAT_amount = ($tax[0]->tax) / 100 * (str_replace(',', '', $invoice->discounted_total));
        }

        $invoice->paid = 0;
        if ($request->credit_amount != null) {
            $invoice->credit = 1;
            $invoice->credit_amount = $invoice->credit_amount + str_replace(',', '', $request->credit_amount);
            $invoice->paid = $invoice->paid + str_replace(',', '', $request->credit_amount);
        }
        if ($request->debit_amount != null) {
            $invoice->debit = 1;
            $invoice->debit_amount = $invoice->debit_amount + str_replace(',', '', $request->debit_amount);
            $invoice->paid = $invoice->paid + str_replace(',', '', $request->debit_amount);
        }
        if ($request->cash_amount != null) {
            $invoice->cash = 1;
            $invoice->cash_amount = $invoice->cash_amount + str_replace(',', '', $request->cash_amount);
            $invoice->paid = $invoice->paid + str_replace(',', '', $request->cash_amount);
        }
        if ($request->bank_amount != null) {
            $invoice->bank = 1;
            $invoice->bank_amount = $invoice->bank_amount + str_replace(',', '', $request->bank_amount);
            $invoice->paid = $invoice->paid + str_replace(',', '', $request->bank_amount);
        }
        //$invoice->save();
        $invoice->pending_amount = $invoice->discounted_total + $invoice->VAT_amount - $invoice->paid;
        $invoice->save();
        $flight_counter = 0;
        $visa_counter = 0;
        $insurance_counter = 0;
        $hotel_counter = 0;
        $local_sight_sceen_counter = 0;
        $local_transport_counter = 0;
        $car_rental_counter = 0;
        $other_facilities_counter = 0;


        if (!empty($request->flight)) {
            foreach ($request->flight as $key => $value) {
                $jsonData = json_encode($value);
                //dd($jsonData);
                //   echo "<script>alert('$jsonData');</script>";
                $flight = new Flight;
                $flight->invoice_id = $invoice->id;
                $flight->universal_pnr = strtoupper($value['universal_pnr'][0]);
                $flight->booking_date = strtoupper($value['booking_date'][0]);
                $flight->pnr = strtoupper($value['pnr'][0]);
                $flight->agency_pcc = strtoupper($value['agency_pcc'][0]);
                $flight->airline_ref = strtoupper($value['airline_ref'][0]);
                $flight->total_amount = str_replace(',', '', $request->flight_amount[$key]);
                $flight->segment_one_from = strtoupper($value['segment_one_from'][0]);
                $flight->segment_two_from = isset($value['segment_two_from']) ? strtoupper($value['segment_two_from'][0]) : '';
                $flight->segment_one_to = strtoupper($value['segment_one_to'][0]);
                $flight->segment_two_to = isset($value['segment_two_to']) ? strtoupper($value['segment_two_to'][0]) : '';
                $flight->segment_one_carrier = isset($value['segment_one_carrier']) ? strtoupper($value['segment_one_carrier'][0]) : '';
                $flight->segment_two_carrier = isset($value['segment_two_carrier']) ? strtoupper($value['segment_two_carrier'][0]) : '';
                $flight->segment_one_flight = strtoupper($value['segment_one_flight'][0]);
                $flight->segment_two_flight = isset($value['segment_two_flight']) ? strtoupper($value['segment_two_flight'][0]) : '';
                $flight->segment_one_class = strtoupper($value['segment_one_class'][0]);
                $flight->segment_two_class = isset($value['segment_two_class']) ? strtoupper($value['segment_two_class'][0]) : '';
                $flight->segment_one_departure = strtoupper($value['segment_one_departure'][0]);
                $flight->segment_two_departure = isset($value['segment_two_departure']) ? strtoupper($value['segment_two_departure'][0]) : '';
                $flight->segment_one_arrival = strtoupper($value['segment_one_arrival'][0]);
                $flight->segment_two_arrival = isset($value['segment_two_arrival']) ? strtoupper($value['segment_two_arrival'][0]) : '';
                $flight->json_data = $jsonData;
                $flight->journey_type = strtoupper($value['journey_type'][0]);
                $flight->journey_stop = isset($value['journey_stop']) ? strtoupper($value['journey_stop'][0]) : 0;
                //$flight->flight_remarks = strtoupper($request->flight_remarks[$flight_counter]);
                $flight->save();


                foreach ($value['pax_type'] as $index => $pax_type) {
                    //if($request->verify[$index] == $flight->pnr ){
                    $passenger = new Passenger;
                    $passenger->flight_id = $flight->id;
                    $passenger->pax_type = isset($value['pax_type'][$index]) ? strtoupper($value['pax_type'][$index]) : '';
                    $passenger->first_name = isset($value['first_name'][$index]) ? strtoupper($value['first_name'][$index]) : '';
                    $passenger->last_name = isset($value['last_name'][$index]) ? strtoupper($value['last_name'][$index]) : '';
                    $passenger->DOB = isset($value['DOB'][$index]) ? $value['DOB'][$index] : '';
                    $passenger->segment_one_fare_cost = isset($value['segment_one_fare_cost'][$index]) ? str_replace(',', '', $value['segment_one_fare_cost'][$index]) : '0.00';
                    $passenger->segment_two_fare_cost = isset($value['segment_two_fare_cost'][$index]) ? str_replace(',', '', $value['segment_two_fare_cost'][$index]) : '0.00';
                    $passenger->segment_one_fare_sell = isset($value['segment_one_fare_sell'][$index]) ? str_replace(',', '', $value['segment_one_fare_sell'][$index]) : '0.00';
                    $passenger->segment_two_fare_sell = isset($value['segment_two_fare_sell'][$index]) ? str_replace(',', '', $value['segment_two_fare_sell'][$index]) : '0.00';
                    $passenger->save();
                    //}
                }

            }
        }


        
        foreach (invoice::all() as $inv) {
            if ($inv->pending_amount < 0) {
                $inv->advance = 0 - $inv->pending_amount;
                $inv->pending_amount = 0;
                $inv->save();
            }
            if ($inv->pending_amount == 0) {
                $inv->status = 1;
                $inv->save();
            }
            if ($inv->pending_amount > 0) {
                $inv->status = 0;
                $inv->save();
            }
        }

        if ($request->confirmation_via == 'email') {
            $visa = invoice::find($invoice->id)->invoiceInfo->where('service_name', 'Visa Services');
            $hotel = invoice::find($invoice->id)->invoiceInfo->where('service_name', 'Hotel');
            $insurance = invoice::find($invoice->id)->invoiceInfo->where('service_name', 'Insurance');
            $local_sight_sceen = invoice::find($invoice->id)->invoiceInfo->where('service_name', 'Local Sight Sceen');
            $local_transport = invoice::find($invoice->id)->invoiceInfo->where('service_name', 'Local Transport');
            $car_rental = invoice::find($invoice->id)->invoiceInfo->where('service_name', 'Car Rental');
            $other_facilities = invoice::find($invoice->id)->invoiceInfo->where('service_name', 'Other Facilities');
            do {
                $token = str_random();
            } while (invoice::where('token', $token)->first());
            $invoice->token = $token;
            $invoice->save();
            $data = [
                'tax' => settings::all(),
                'invoice' => invoice::find($invoice->id),
                'products' => products::all(),
                'airlines' => airlines::all(),
                'visa' => $visa,
                'hotel' => $hotel,
                'insurance' => $insurance,
                'local_sight_sceen' => $local_sight_sceen,
                'local_transport' => $local_transport,
                'car_rental' => $car_rental,
                'other_facilities' => $other_facilities,
                'token' => $token,
            ];
            $contactEmail = $invoice->client->email;
            Mail::send('emails.invoice', $data, function ($message) use ($contactEmail) {
                $message->to($contactEmail)->subject('Invoice!!');
            });
        }
        if ($request->activeConditions) {
            foreach ($request->activeConditions as $condition) {
                $invoice->conditions()->create([
                    'type' => 'default',
                    'conditions' => TermsAndConditions::find($condition)->conditions
                ]);
            }
        }
        if ($request->activeRemark) {
            $data = '';
            foreach ($request->activeRemark as $remark) {
                $data .= ' | '.$remark;
            }
            $invoice->remarks .= ' | '. $data;
            $invoice->save();
        }

        $invoice->atolProtectionRemarks = $request->atolProtectionRemarks;
        $invoice->save();
    }
}
