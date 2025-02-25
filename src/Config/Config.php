<?php

namespace Peace1313\GPaymentSdk\Config;

class Config
{
    public static function getEnv($key, $default = null)
    {
        return getenv($key) ?: $default;
    }

    const API_URL = self::getEnv('API_URL', 'https://api.example.com');
    const SWT_ID = self::getEnv('SWT_ID', 'CC82C381E078482AB328943FCCB7100C');
    const SWT_PASSWORD = self::getEnv('SWT_PASSWORD', '123asdASD@');
    const BANK_ID = self::getEnv('BANK_ID', '62');
}