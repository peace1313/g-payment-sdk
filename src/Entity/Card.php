<?php

namespace Peace1313\GPaymentSdk\Entity;

class Card
{
    private string $holderName;
    private string $token;

    public function __construct(string $holderName, string $token)
    {
        $this->holderName = $holderName;
        $this->token = $token;
    }

    public function toArray(): array
    {
        return [
            "holderName" => $this->holderName,
            "token" => $this->token
        ];
    }
}