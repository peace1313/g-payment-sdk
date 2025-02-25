<?php

namespace Peace1313\GPaymentSdk\Service;

use Peace1313\GPaymentSdk\PaymentProcessor;
use Peace1313\GPaymentSdk\Config\Config;

class InstallmentService
{
    private $processor;

    public function __construct(PaymentProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function getInstallmentOptions(string $userId, string $cardBin)
    {
        return $this->processor->makeRequest('/api/inquiry/installment', [
            "acquirer" => ["bankId" => Config::BANK_ID],
            "firmSwtId" => Config::SWT_ID,
            "cardBin" => $cardBin
        ], $userId);
    }
}