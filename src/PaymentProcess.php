<?php

namespace Peace1313\GPaymentSdk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Peace1313\GPaymentSdk\Config\Config;
use Peace1313\GPaymentSdk\Exception\PaymentException;

class PaymentProcessor
{
    private Client $client;
    private string $apiUrl;
    private string $swtId;
    private string $swtPassword;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => Config::API_URL,
            'timeout'  => 10.0,
            'verify'   => false
        ]);

        $this->apiUrl = Config::API_URL;
        $this->swtId = Config::SWT_ID;
        $this->swtPassword = Config::SWT_PASSWORD;
    }

    public function makeRequest(string $endpoint, array $body, string $userId)
    {
        $requestId = bin2hex(random_bytes(16));
        $timestamp = time();
        $hashedData = strtoupper(hash('sha256', $requestId . $this->swtId . $userId . $timestamp . $this->swtPassword));

        $body['header'] = [
            'requestId' => $requestId,
            'swtId' => $this->swtId,
            'userId' => $userId,
            'hashedData' => $hashedData,
            'timestamp' => $timestamp
        ];

        try {
            $response = $this->client->post($endpoint, [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => $body
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['errorCode'])) {
                throw PaymentException::apiError($data['errorMessage']);
            }

            return $data;
        } catch (RequestException $e) {
            throw PaymentException::apiError($e->getMessage());
        }
    }
}