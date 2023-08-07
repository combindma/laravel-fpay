<?php

namespace Combindma\Fpay\Traits;

use Combindma\Fpay\Fpay;
use Illuminate\Support\Facades\Log;

trait FpayGateway
{
    public function requestPayment(Fpay $fpay, array $customData = null)
    {
        //Send Data to Fpay Server
        $fpay->guardAgainstInvalidRequest();
        $request = $fpay->prepareRequest($customData);
        $content = json_encode($request);
        $curl = curl_init($fpay->getBaseUri());
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            ['Content-type: application/json']
        );
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        // For Production Server
        //curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);

        // For Test Server
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSLVERSION, 1);

        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($status !== 201 && $status !== 200) {
            Log::error('Error: call to URL '.$fpay->getBaseUri().'failed with status '.$status.', response '.$json_response.', curl_error '.curl_error($curl).', curl_errno '.curl_errno($curl));

            return redirect($fpay->getShopUrl())->withErrors(['payment' => __('Une erreur est survenue au niveau de la requête, veuillez réessayer ultérieurement.')]);
        }
        curl_close($curl);

        //Response in JSON Format
        $response = json_decode($json_response, true);
        $RESPONSE_CODE = $response['RESPONSE_CODE'];
        $REASON_CODE = $response['REASON_CODE'];
        $REP = (int) $RESPONSE_CODE;

        // If Errors
        if ($REP !== 0) {
            // Errors .
            Log::error('Error returned from Fpay (RESPONSE_CODE : '.$RESPONSE_CODE.') | (REASON_CODE : '.$REASON_CODE.')');

            return redirect($fpay->getShopUrl())->withErrors(['payment' => __('Une erreur est survenue au niveau de la requête, veuillez réessayer ultérieurement.')]);
        }

        //Forward data to view
        $orderID = $response['ORDER_ID'];
        $referenceID = $response['REFERENCE_ID'];
        $trackID = $response['TRACK_ID'];
        $fpayUrl = $response['FPAY_URL'];

        return view('fpay::request-payment', compact('fpay', 'orderID', 'referenceID', 'trackID', 'fpayUrl'));
    }

    public function callback()
    {
        $response = 'No Data POST';

        return view('fpay::callback', compact('response'));
    }
}
