<?php

namespace Peace1313\GPaymentSdk\Validator;

use Peace1313\GPaymentSdk\Exception\PaymentException;

class PaymentValidator
{
    public static function validateCardDetails(array $cardDetails)
    {
        if (!isset($cardDetails['cardNumber']) || !preg_match('/^\d{16}$/', $cardDetails['cardNumber'])) {
            throw PaymentException::invalidCardNumber();
        }
    }

    public static function validateAmount($amount)
    {
        if ($amount <= 0) {
            throw PaymentException::invalidAmount();
        }
    }

    public static function validateUserId($userId)
    {
        if (empty($userId) || !is_string($userId)) {
            throw new PaymentException("Kullanıcı ID geçersiz.");
        }
    }
}