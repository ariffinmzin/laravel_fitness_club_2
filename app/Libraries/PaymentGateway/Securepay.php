<?php

namespace App\Libraries\PaymentGateway;

use App\Models\Plan;
use App\Models\Payment;
use Illuminate\Http\Request;

class Securepay
{
    function go(Plan $plan, Payment $payment)
    {
        return 'https://securepay.my';

    }

    function verify(Request $request, Payment $payment)
    {
        return [
            'success' => false,
            'errors' => []
        ];

    }





}