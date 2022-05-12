<?php

namespace App\Service;

class test
{

    /*
     * $data au format JSON !!
     */
    public static function callAPI($method, $url, $data){
        $dolibarrToken = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA44gDy39/Y9vlgHRu7Z2/8irrv3G7gIPoZ3vysSli1oO0XCmBGCJeJx1ZaO8si6gVmvfa5o9JPXrbbFABUTzo9NfrSAr0c2rspz64OzuZKvHRhn1SaqlKDQpOWH6V/r6yET2cIkEUty4Ha3+RzjE//3mWFfCZAV5sUn2PYMJ6pAokLdQusNGwq81cKEyI8FgfDTC8m3CYs1sdfmVSb+rOWS/BlwVYq71Dx9NghrsuqCFcztCBbnrmqwpxVRFCwCxQZZA1E3+HadGADor5efLlG0zdPiwhH0ivNxmyXz/E14zloYEZoCbpnh/48htcXLEskXsjjospTKlHS/ZhPzCUPwIDAQAB';

        $curl = curl_init();
        if ($method === 'POST'){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }else if ($method === 'PUT'){
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }else if($method === 'DELETE') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        }else{
            if ($data){
                $url = sprintf("%s?%s", $url, http_build_query($data));
            }
        }

        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'accept: application/json',
            'Authorization: Basic ' . $dolibarrToken
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        // EXECUTE:
        $result = curl_exec($curl);
        if(curl_error($curl) && $method != 'DELETE'){
            dump(curl_error($curl));
//            dol_syslog('WEBHOOK: ' . $action . ' / error: ' . curl_error($curl));
        }
        curl_close($curl);
        return $result;
    }
}
