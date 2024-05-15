<?php

namespace App\Libraries\PaymentGateway;

use App\Models\Plan;
use App\Models\Payment;
use Illuminate\Http\Request;

class Stripe
{
    protected $stripe_client = null;

    function __construct()
    {
        $this->stripe_client = new \Stripe\StripeClient(env('STRIPE_SECRET'));

    }

    function go(Plan $plan, Payment $payment)
    {
        $verify_url = route('checkout.verify', [
            'payment' => $payment->payment_code,
            'payment_method' => 'stripe',

        ]) . '?session_id={CHECKOUT_SESSION_ID}';

        $response = $this->stripe_client->checkout->sessions->create([
            'success_url' => $verify_url,
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'product_data' => [
                            'name' => $plan->name
                        ],
                        'unit_amount' => $payment->getRawOriginal('amount'),
                        'currency' => 'MYR'
                    ],
                    'quantity' => 1

                ]
            ],
            'mode' => 'payment',
            'allow_promotion_codes' => false,
            'metadata' => [
                'plan' => $plan->code,
                'payment_code' => $payment->payment_code,
            ]

        ]);

        // dd($response);

        return $response['url'];

    }

    function verify(Request $request, Payment $payment)
    {

        $session = $this->stripe_client->checkout->sessions->retrieve($request->session_id);

        if ($session->amount_total == $payment->getRawOriginal('amount') && ($session->currency == 'myr') && ($session->payment_status == 'paid') && ($session->status == 'complete')) {

            return [
                'success' => true,
                'payment_code' => $session->metadata->payment_code,
                'plan' => $session->metadata->plan
            ];

        }

        $errors = [];

        if ($session->amount_total != $payment->getRawOriginal('amount')) {

            $errors[] = 'Amount paid does not match';

        }

        if ($session->currency != 'myr') {
            $errors[] = 'Currency does not match';
        }

        if ($session->payment_status != 'paid') {
            $errors[] = 'Payment status is not paid';
        }

        if ($session->status != 'complete') {
            $errors[] = 'Status is not completed';
        }

        return [
            'success' => false,
            'errors' => $errors,
            'payment_code' => $session->metadata->payment_code,
            'plan' => $session->metadata->plan
        ];


    }
}