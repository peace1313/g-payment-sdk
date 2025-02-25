<?php

namespace Peace1313\GPaymentSdk\Service;

use Peace1313\GPaymentSdk\PaymentProcessor;
use Peace1313\GPaymentSdk\Validator\PaymentValidator;
use Peace1313\GPaymentSdk\Exception\PaymentException;

class CardService
{
    private $processor;

    public function __construct(PaymentProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function registerCard($userId, $cardDetails)
    {
        
        PaymentValidator::validateUserId($userId);
        PaymentValidator::validateCardDetails($cardDetails);

      
        $response = $this->processor->makeRequest('/api/card/register', [
            "cardDetails" => $cardDetails
        ], $userId);

        if (isset($response['error'])) {
            throw PaymentException::apiError($response['error']);
        }

        return $response;
    }

    public function listCards($userId)
    {
  
        PaymentValidator::validateUserId($userId);

        return $this->processor->makeRequest('/api/card/list', [], $userId);
    }
}
