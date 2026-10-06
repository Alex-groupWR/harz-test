<?php
namespace Dadata;

class RestCurl
{
    private static $key = "eedce56e41d6ae55da52e4459ac1dd15b0bb63eb"; 

    public static function exec($method, $url, $obj = array())
    {
        $curl = curl_init();

        switch ($method) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($obj));
                break;
            default:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($obj));
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Token ' . self::$key
        ]);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);

        $header = trim(substr($response, 0, $info['header_size']));
        $body = substr($response, $info['header_size']);

        return [
            'status' => $info['http_code'],
            'header' => $header,
            'data' => json_decode($body),
        ];
    }

    public static function post($url, $obj = [])
    {
        return self::exec("POST", $url, $obj);
    }
}

class CompanySuggestions
{
    public function getCompanyByINN($inn)
    {
        $url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party";
        $data = ["query" => $inn];
        return RestCurl::post($url, $data);
    }
}