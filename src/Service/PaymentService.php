<?php

namespace Peace1313\GPaymentSdk\Service;

use Peace1313\GPaymentSdk\PaymentProcessor;
use Peace1313\GPaymentSdk\Entity\TokenPaymentRequest;
use Peace1313\GPaymentSdk\Exception\PaymentException;

class PaymentService
{
    private $processor;

    public function __construct(PaymentProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function processTokenPayment(TokenPaymentRequest $paymentRequest)
    {
        $response = $this->processor->makeRequest('/api/payment/token/preauth', $paymentRequest->toArray(), $paymentRequest->userId);

        if (isset($response['error'])) {
            throw PaymentException::apiError($response['error']);
        }

        return $response;
    }
}