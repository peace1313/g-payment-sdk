<?php

namespace Peace1313\GPaymentSdk\Entity;

class CardHolder
{
    private string $email;
    private string $gsm;
    private string $ip;
    private string $name;
    private string $lastName;

    public function __construct(string $email, string $gsm, string $ip, string $name, string $lastName)
    {
        $this->email = $email;
        $this->gsm = $gsm;
        $this->ip = $ip;
        $this->name = $name;
        $this->lastName = $lastName;
    }

    public function toArray(): array
    {
        return [
            "email" => $this->email,
            "gsm" => $this->gsm,
            "ip" => $this->ip,
            "name" => $this->name,
            "lastName" => $this->lastName
        ];
    }
}