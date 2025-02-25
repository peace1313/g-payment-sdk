<?php

namespace Peace1313\GPaymentSdk\Entity;

class PaymentRequest
{
    public string $userId;
    public string $amount;
    public array $card;
    public array $cardHolder;
    public array $billingAddress;
    public array $shippingAddress;
    public string $currencyNumber;
    public string $installmentCount;
    public string $orderId;

    public function __construct(array $data)
    {
        $this->userId = $data['userId'] ?? throw new \InvalidArgumentException("Kullanıcı ID zorunludur.");
        $this->amount = $data['amount'] ?? throw new \InvalidArgumentException("Ödeme tutarı zorunludur.");
        $this->currencyNumber = $data['currencyNumber'] ?? "949"; // Varsayılan: TRY (Türk Lirası)
        $this->installmentCount = $data['installmentCount'] ?? "";
        $this->orderId = $data['orderId'] ?? throw new \InvalidArgumentException("Sipariş ID zorunludur.");

        $this->card = $data['card'] ?? throw new \InvalidArgumentException("Kart bilgileri eksik.");
        $this->cardHolder = $data['cardHolder'] ?? throw new \InvalidArgumentException("Kart sahibinin bilgileri eksik.");
        $this->billingAddress = $data['billingAddress'] ?? throw new \InvalidArgumentException("Fatura adresi eksik.");
        $this->shippingAddress = $data['shippingAddress'] ?? throw new \InvalidArgumentException("Teslimat adresi eksik.");
    }

    public function toArray(): array
    {
        return [
            "txnAmount" => $this->amount,
            "generateOrderId" => "Y",
            "currencyNumber" => $this->currencyNumber,
            "installmentCount" => $this->installmentCount,
            "orderId" => $this->orderId,
            "acquirer" => ["bankId" => "62"],

            "card" => $this->card,
            "cardHolder" => $this->cardHolder,
            "billingAddress" => $this->billingAddress,
            "shippingAddress" => $this->shippingAddress,
        ];
    }
}
