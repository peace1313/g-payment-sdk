<?php

namespace Peace1313\GPaymentSdk\Validator;

use Peace1313\GPaymentSdk\Exception\PaymentException;

class PaymentValidator
{
    /**
     * Kart bilgilerini doğrular.
     */
    public static function validateCardDetails(array $cardDetails)
    {
        // Dizi boş mu?
        if (empty($cardDetails)) {
            throw new PaymentException("Kart bilgileri eksik.");
        }

        // Kart numarası 16 haneli mi?
      //  if (!isset($cardDetails['number']) || !preg_match('/^\d{16}$/', $cardDetails['number'])) {
     //       throw PaymentException::invalidCardNumber();
      //  }
        if (!isset($cardDetails['expireMonth']) || !preg_match('/^(0[1-9]|1[0-2])$/', $cardDetails['expireMonth'])) {
            throw new PaymentException("Geçersiz son kullanma ayı. 01 ile 12 arasında olmalıdır.");
        }

        if (!isset($cardDetails['expireYear']) || !preg_match('/^\d{2}$/', $cardDetails['expireYear'])) {
            throw new PaymentException("Geçersiz son kullanma yılı. 2 haneli olmalıdır.");
        }


        $currentYear = (int) date('y'); // Yılın son iki hanesini al (2024 → 24)
        $expireYear = (int) $cardDetails['expireYear'];

        if ($expireYear < $currentYear) {
            throw new PaymentException("Son kullanma yılı geçmiş olamaz.");
        }
    }


    public static function validateAmount($amount)
    {
        if (!is_numeric($amount) || $amount <= 0) {
            throw PaymentException::invalidAmount();
        }
    }


    public static function validateRequestId($token)
    {

        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $token)) {
            throw new PaymentException("token yanlış");
        }
    }

    public static function validateToken($token)
    {
        if (!preg_match('/^[a-zA-Z0-9]+$/', $token)) {
            throw new PaymentException("token yanlış");
        }
    }


    public static function validateString(  $value)
    {


        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $value)) {
            throw new PaymentException("$key sadece harf, rakam ve boşluk içerebilir.");
        }
    }

    /**
     * API'ye gönderilecek tüm verileri doğrular.
     */
    public static function validatePaymentData(array $data)
    {
        if (empty($data)) {
            throw new PaymentException("Ödeme verileri eksik.");
        }

        self::validateUserId($data['userId'] ?? null);
        self::validateAmount($data['amount'] ?? null);
        self::validateCardDetails($data['card'] ?? []);
        self::validateString("orderId", $data['orderId'] ?? null);
    }
}
