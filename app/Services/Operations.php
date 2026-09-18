<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;

class Operations
{
    //
    public static function decryptId($value)
    {
        try {
            $value = decrypt($value);
        } catch (DecryptException $e) {
            return null;
            // return redirect()->route('home');
        }

        return $value;
    }
}