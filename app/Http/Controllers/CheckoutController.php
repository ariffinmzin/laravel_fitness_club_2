<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Payment;
use App\Models\Membership;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    //

    // /checkout/{plan}/{payment_gateway}

    // /verify/{payment}/{payment_gateway}
    public function index(Request $request, Plan $plan, $payment_method)
    {
        // dd($plan, $payment_method);
        if (!in_array($payment_method, Payment::SUPPORTED_PAYMENTS)) {
            abort(405, "Unknown payment method");
        }
        $payment = $this->record_payment($plan, $payment_method);

        return $this->{$payment_method . '_go'}($plan, $payment);

    }

    protected function stripe_go(Plan $plan, Payment $payment)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $verify_url = route('checkout.verify', [
            'payment' => $payment->payment_code,
            'payment_method' => 'stripe',

        ]) . '?session_id={CHECKOUT_SESSION_ID}';

        $response = $stripe->checkout->sessions->create([
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

        return redirect($response['url']);

    }

    protected function securepay_go()
    {

    }

    protected function record_payment(Plan $plan, $payment_method)
    {
        $user = Auth::user();
        $membership = $user->memberships()->first();
        if (!$membership) {
            $membership = new Membership();
            $membership->user_id = $user->id;
            $membership->plan_id = $plan->id;
            $membership->status = 'inactive';
            $membership->expire_on = \Carbon\Carbon::today();
            $membership->save();
        }

        return Payment::create([
            'membership_id' => $membership->id,
            'amount' => $plan->price,
            'payment_method' => $payment_method,
            'payment_status' => 'pending',
            'payment_code' => Str::random(20),
            'remarks' => 'Stripe payment for ' . $plan->code
        ]);
    }

    public function verify()
    {

        echo "<h1>Payment received</h1>";

    }
}
