<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
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

    /**
     * public function index() -- used in routing 
     * -- to redirect to payment gateway
     * 
     * public function verify() -- used in routing
     * -- returning from payment gateway 
     * 
     * protected function record_payment() 
     * -- to create a payment record before going to payment gateway 
     * 
     * protected function process_payment() 
     * -- to process payment & membership after returning from payment gateway
     * 
     * protected function {payment-gateway}_go() 
     * -- called by index() based on selected payment gateway
     * 
     * protected function {payment-gateway}_verify() 
     * -- called by verified based on selected payment gateway 
     */



    /**
     * 
     * /checkout/{plan}/{payment_gateway}
     */


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
            $membership->expire_on = Carbon::today();
            $membership->save();
        }

        return Payment::create([
            'membership_id' => $membership->id,
            'plan_id' => $plan->id,
            'user_id' => $user->id,
            'amount' => $plan->price,
            'payment_method' => $payment_method,
            'payment_status' => 'pending',
            'payment_code' => Str::random(20),
            'remarks' => 'Stripe payment for ' . $plan->code
        ]);
    }

    public function verify(Request $request, Payment $payment, $payment_method)
    {

        // echo "<h1>Payment received</h1>";

        if (!in_array($payment_method, Payment::SUPPORTED_PAYMENTS)) {
            abort(405, "Unknown payment method");
        }

        $result = $this->{$payment_method . '_verify'}($request, $payment);

        if ($result['success']) {

            $this->process_payment($payment);

        }

        return view('checkout.thankyou');

    }

    protected function process_payment(Payment $payment)
    {

        $user = User::find($payment->user_id);
        $plan = Plan::find($payment->user_id);
        $membership = $user->memberships()->first();
        $membership->plan_id = $plan->id;

        if (Carbon::parse($membership->expire_on)->isFuture()) {

            $membership->expire_on = Carbon::parse($membership->expire_on)->add($plan->duration);

        } else {

            $membership->expire_on = Carbon::today()->add($plan->duration);

        }

        $membership->status = 'active';
        $membership->save();

        $payment->payment_status = 'completed';
        $payment->save();

        return true;

    }

    protected function stripe_verify(Request $request, Payment $payment)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id);

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
