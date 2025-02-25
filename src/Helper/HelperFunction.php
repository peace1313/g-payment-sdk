<?php

namespace Peace1313\GPaymentSdk\Helper;

if (!function_exists('getGUID')) {
    function getGUID()
    {
        return bin2hex(random_bytes(16));
    }
}