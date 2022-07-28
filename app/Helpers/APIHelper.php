<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;



class APIHelper
{

    public static function makeAPIResponse($status = true, $message = "Done", $data = null, $status_code = 200)
    {
        $response = [
            "success" => $status,
            "message" => $message,
            "data" => $data,

        ];
        if ($data != null || is_array($data)) {
            $response["data"] = $data;
        }
        return response()->json($response, $status_code);
    }


    public static function errorsResponse($errors)
    {
        $error_data = [];
        foreach ($errors as $x => $x_value) {
            $data['source'] = $x;
            foreach ($x_value as $value) {
                if (is_array($value)) {
                    $data['detail'] = $value[1];
                } else {
                    $data['detail'] = $value;
                }
            }
            $error_data[] = $data;
        }
        $response = [
            "success" => false,
            "message" => "Validation Errors",
            "errors" => $error_data
        ];
        return $response;
    }

    /**
     * Core function for call all services.
     *
     * @param  string $method
     * @param  string $url
     * @param  array $body
     * @param  array $headers
     * @param  string $guzzle_body_type
     * @return array | null $response_body
     * @throws object errors
     */
    public static function sendAPICall($method = "GET", $url = "", $body = null, $headers = ['Content-Type' => 'application/json', 'Accept' => 'application/json; charset=utf-8'], $guzzle_body_type = 'json')
    {
        $curl_exception = false;
        $client = new Client(['http_errors' => false, 'verify' => false]);

        $request_body = [
            'headers' => $headers,
            $guzzle_body_type => $body,
            'timeout' => 30,
        ];


        try {
            $response = $client->request($method, $url, $request_body);



        } catch (\Exception $e) {

            Log::critical($e);
            $curl_exception = true;
        }

        if (!$curl_exception && $response->getBody()) {

            //for payment api
            if ($headers["Content-Type"] == "application/x-www-form-urlencoded"){
                $response_body["body"] = (string)$response->getBody();
                $status_code = $response->getStatusCode();
                $response_body["status_code"] = $status_code;
                $response_body["headers"] = $response->getHeaders();
                return $response_body;
            }

            $response_body["body"] = json_decode((string)$response->getBody(), true);
            $status_code = $response->getStatusCode();
            $response_body["status_code"] = $status_code;
            $response_body["headers"] = $response->getHeaders();
            return $response_body;
        } else {
            $log_data = ["ACTION" => "API ERROR", "URL" => $url, "BODY" => $body, "HEADERS" => $headers, "GUZZLE_BODY_TYPE" => $guzzle_body_type];
            Log::critical(json_encode($log_data));
            return null;
        }
    }






}
