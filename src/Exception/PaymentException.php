<?php

namespace Peace1313\GPaymentSdk\Exception;

use Exception;

class PaymentException extends Exception
{
    private array $errorData;

    public function __construct(string $message, int $code = 400)
    {
        parent::__construct($message, $code);
        $this->errorData = [
            "success" => false,
            "message" => $message
        ];
    }

    public function getErrorData(): array
    {
        return $this->errorData;
    }

    public static function invalidData($message)
    {
        return new self("Geçersiz veri: " . $message);
    }

    public static function apiError($message)
    {
        return new self("API Hatası: " . $message);
    }

    public static function invalidCardNumber()
    {
        return new self("Geçersiz kart numarası!!", 400);
    }

    public static function fromErrorMap(array $errorMap)
    {
        $errorMessages = [];
        foreach ($errorMap as $field => $message) {
            $errorMessages[] = "$field: $message";
        }

        return new self("API Hatası: " . implode(", ", $errorMessages), 400);
    }
}
