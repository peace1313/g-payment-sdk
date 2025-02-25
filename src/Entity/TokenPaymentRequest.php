<?php

namespace Peace1313\GPaymentSdk\Entity;

class TokenPaymentRequest
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
    public string $orderGroupId;

    public function __construct(array $data)
    {
        $this->userId = $data['userId'] ?? throw new \InvalidArgumentException("Kullanıcı ID zorunludur.");
        $this->amount = $data['amount'] ?? throw new \InvalidArgumentException("Ödeme tutarı zorunludur.");
        $this->currencyNumber = $data['currencyNumber'] ?? "949"; // Varsayılan: TRY
        $this->installmentCount = $data['installmentCount'] ?? "0"; // Varsayılan: Peşin Ödeme
        $this->orderId = $data['orderId'] ?? throw new \InvalidArgumentException("Sipariş ID zorunludur.");
        $this->orderGroupId = $data['orderGroupId'] ?? "";

        $this->card = $data['card'] ?? throw new \InvalidArgumentException("Kart token bilgisi eksik.");
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
            "orderGroupId" => $this->orderGroupId,
            "acquirer" => [],

            "card" => $this->card,
            "cardHolder" => $this->cardHolder,
            "billingAddress" => $this->billingAddress,
            "shippingAddress" => $this->shippingAddress,
        ];
    }
}
