<?php

namespace Peace1313\GPaymentSdk\Helper;
use CodeIgniter\Encryption\Encryption;
class HelperFunction 
{
    public  function getGUID()
    {
        return bin2hex(random_bytes(16));
    }
    public function generateBasicAuthHeader($username, $password) {
        $credentials = base64_encode($username . ':' . $password);
        return 'Basic ' . $credentials;
    }

    public function calculateSHA256($data) {
        $hash = hash("sha256", $data, true);
        $result = "";
        foreach (str_split($hash) as $byte) {
            $result .= sprintf("%02x", ord($byte));
        }
        return strtoupper($result);
    }
    public function generateUUIDv4() {
        $data = function_exists('random_bytes') ? random_bytes(16) : openssl_random_pseudo_bytes(16);

        // UUID v4 için belirli bitleri ayarla
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40); // Versiyon 4
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80); // Varyant 1

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function __construct()
    {
        $this->encryption = \Config\Services::encrypter();
    }

    public function encryptID($userID)
    {
        return bin2hex($this->encryption->encrypt($userID));
    }

    public function decryptID($encryptedID)
    {
        return $this->encryption->decrypt(hex2bin($encryptedID));
    }
}
