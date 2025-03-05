<?php

namespace Peace1313\GPaymentSdk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Peace1313\GPaymentSdk\Config\Config;
use Peace1313\GPaymentSdk\Exception\PaymentException;
use Peace1313\GPaymentSdk\Helper\HelperFunction;
class PaymentProcessor
{
    private Client $client;
    private string $apiUrl;
    private string $swtId;
    private string $swtPassword;
    private string $serviceUser;
    private string $servicePass;

    public function __construct()
    {
        $this->helper=new HelperFunction();

        $this->client = new Client([
            'base_uri' => Config::API_URL,
            'timeout'  => 10.0,
            'verify'   => false
        ]);

        $this->apiUrl = Config::API_URL;
        $this->swtId = Config::SWT_ID;
        $this->swtPassword = Config::SWT_PASSWORD;
        $this->serviceUser  =Config::SERVICE_USER;
        $this->servicePass  =Config::SERVICE_PASS;
        $this->userId  =Config::USER_ID;
    }

    public function makeRequest(string $endpoint, array $body ,array $params=array() )
    {
        $requestId = $this->helper->generateUUIDv4();
        $timestamp = time();
        $hashedData = strtoupper(hash('sha256', $requestId . $this->swtId . $this->userId . $timestamp . $this->swtPassword));
        $body['header'] = [
            'requestId' => $requestId,
            'swtId' => $this->swtId,
            'userId' => $this->userId,
            'hashedData' => $hashedData,
            'timestamp' => $timestamp,

        ];
        $body['additionalData'] = $this->helper->generateUUIDv4();
        if(!empty($params)){
            $body = array_merge($body, $params);
        }
        
        try {
            $response = $this->client->post($endpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $this->helper->generateBasicAuthHeader($this->serviceUser, $this->servicePass)
                ],
                'json' => $body
            ]);

            $data = json_decode($response->getBody(), true);
            $data['payResult']['requestId'] =  $requestId;
            $data['payResult']['returnCode']  =$data['header']['returnCode'] ;
            $data['payResult']['reasonCode'] = $data['header']['reasonCode'] ;
            $data['payResult']['message'] = $data['header']['message'] ;
            $data['payResult']['additionalData']=$body['additionalData'] ;
            unset($data['header']);
            if (isset($data['errorMap']) && is_array($data['errorMap'])) {
                throw PaymentException::fromErrorMap($data['errorMap']);
            }


            return $data;
        } catch (RequestException $e) {
            throw PaymentException::apiError($e->getMessage());
        }
    }
}
