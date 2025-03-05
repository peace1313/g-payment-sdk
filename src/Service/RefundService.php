<?php

namespace Peace1313\GPaymentSdk\Service;

use Peace1313\GPaymentSdk\PaymentProcessor;
use Peace1313\GPaymentSdk\Validator\PaymentValidator;
use Peace1313\GPaymentSdk\Exception\PaymentException;

class refundService
{
    private $processor;

    public function __construct(PaymentProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function registerCard( $cardDetails)

    {
         
        PaymentValidator::validateCardDetails($cardDetails['card']);
        $params['registrationType']='F';
        $response = $this->processor->makeRequest('/api/token/generate', $cardDetails,$params );
        if (isset($response['error'])) {
            throw PaymentException::apiError($response['error']);
        }
        return $response;
    }

 

    public function validateCard($token){
        PaymentValidator::validateRequestId($token['card']['originalRequestId']);

        $response = $this->processor->makeRequest('/api/token/inquiry', [], $token['card']);
        if (isset($response['error'])) {
            throw PaymentException::apiError($response['error']);
        }
        return $response;

    }
    public function updateCardExpire(  $token){

        PaymentValidator::validateToken($token['card']['token']);

        $response = $this->processor->makeRequest('/api/token/updatecardexpire', $token );
        if (isset($response['error'])) {
            throw PaymentException::apiError($response['error']);
        }
        return $response;
        
    }
    public function removeCard( $token){

        PaymentValidator::validateToken($token['card']['token']);

        $response = $this->processor->makeRequest('/api/token/removetoken', $token );
        if (isset($response['error'])) {
            throw PaymentException::apiError($response['error']);
        }
        return $response;
    }
}
