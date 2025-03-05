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

    public function getInstallmentOptions(  array $cardBin)
    {
        return $this->processor->makeRequest( '/api/inquiry/installment',
            [
            "acquirer" => ['bankId'=>$cardBin['bankId']],
            "firmSwtId" => Config::SWT_ID,
            "cardBin" => $cardBin['cardBin'],
        ]  );
    }
}