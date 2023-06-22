<?php

namespace App\Helpers;

class CurrencyFormatHelper
{
    public static function format($amount)
    {
        return 'R$ ' . number_format($amount, 2, ',', '.');

    }
    
}