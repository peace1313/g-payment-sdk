<?php

namespace Peace1313\GPaymentSdk\Entity;

class Address
{
    private string $name;
    private string $lastName;
    private string $city;
    private string $country;
    private string $zipCode;
    private string $email;

    public function __construct(string $name, string $lastName, string $city, string $country, string $zipCode, string $email)
    {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->city = $city;
        $this->country = $country;
        $this->zipCode = $zipCode;
        $this->email = $email;
    }

    public function toArray(): array
    {
        return [
            "name" => $this->name,
            "lastName" => $this->lastName,
            "city" => $this->city,
            "country" => $this->country,
            "zipCode" => $this->zipCode,
            "email" => $this->email
        ];
    }
}