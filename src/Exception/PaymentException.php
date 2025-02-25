<?php

namespace Peace1313\GPaymentSdk\Exception;

use Exception;

class PaymentException extends Exception
{
    public static function invalidData($message)
    {
        return new self("Geçersiz veri: " . $message);
    }

    public static function apiError($message)
    {
        return new self("API Hatası: " . $message);
    }
}