<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Membership;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // echo "<h1>Senarai Pengguna</h1>";
        $users = User::all();
        return view('pengguna.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // echo "<h1>Borang Pengguna Baru</h1>";
        return view('pengguna.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validation_rules = [
            'name' => 'required|string|min:5|max:255',
            'email' => 'required|email|max:255|unique:users',
            'role' => 'required|in:admin,member',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'
            ],
        ];

        $validated_data = $request->validate($validation_rules);

        // User::create([
        //     'name' => $request->input('name'),
        //     'email' => $request->input('email'),
        //     'password' => Hash::make($request->input('password')),
        // ]);

        User::create($validated_data);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berjaya didaftarkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        echo "<h1>Maklumat Pengguna</h1>";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = User::findOrFail($id);
        $role_options = User::USER_ROLES;
        $plan_options = ['' => 'Sila Pilih Pelan'] + Plan::getFormattedPlans();
        $membership_options = Membership::MEMBERSHIP_STATUS;

        $countries = ['' => 'Sila Pilih Negara'] + Country::pluck('name', 'id')->toArray();

        $membership_is_empty = $user->memberships->isEmpty();

        $payment_methods = ['' => 'Pilih Kaedah Bayaran'] + Payment::PAYMENT_METHODS;

        $js_plans = Plan::getIdPriceJSON();

        // $membership_is_empty = $user->memberships->isEmpty() ? null : $user->memberships->first();



        return view('pengguna.edit', compact('user', 'role_options', 'plan_options', 'membership_options', 'countries', 'membership_is_empty', 'payment_methods', 'js_plans'));
        ;
        // echo "<h1>Borang Kemaskini Pengguna</h1>";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::findOrFail($id);
        $validation_rules = [
            'name' => 'required|string|min:5|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,member',
            'address_1' => 'required|string|min:5|max:255',
            'address_2' => 'nullable|string|min:5|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'country_id' => 'required|integer|exists:countries,id'

        ];

        if ($request->filled('password')) {  // Use 'filled' to check if the password is not empty
            $validation_rules['password'] = [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'
            ];
        }

        $validated_data = $request->validate($validation_rules);

        $user->fill($validated_data);

        // $user->name = $validated_data['name'];
        // $user->email = $validated_data['email'];
        // $user->role = $validated_data['role'];
        if (!empty($validated_data['password'])) {
            $user->password = bcrypt($validated_data['password']);
        }
        $user->save();

        return redirect()->route('pengguna.edit', $user->id)->with('success', 'Pengguna berjaya dikemaskini.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function update_keahlian(Request $request, User $user)
    {

        $validated_data = $request->validate([
            'plan_id' => 'required',
            'expire_on' => 'required|date',
            'status' => 'required|string'
        ]);

        $membership = $user->memberships()->first();

        if (!$membership) {
            $membership = new Membership();
            $membership->user_id = $user->id;
        }

        // $membership->plan_id = $validated_data['plan_id'];
        // $membership->expire_on = Carbon::parse($validated_data['expire_on']);
        // $membership->status = $validated_data['status'];

        $membership->plan_id = $request->input('plan_id');
        $membership->expire_on = Carbon::parse($request->input('expire_on'));
        $membership->status = $request->input('status');


        $membership->save();
        return redirect()->back()->with('success', 'Membership details has been updated');


    }

    public function tambah_bayaran(Request $request, User $user)
    {
        $validated_data = $request->validate([
            'plan_id' => 'required',
            'payment_method' => 'required|string',
            'amount' => 'nullable|numeric',
            'new_expiry' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        $update_plan_id = 0;
        if (is_numeric($validated_data['plan_id'])) {
            $plan = Plan::findOrFail($validated_data['plan_id']);
            $update_plan_id = $plan->id;
        }

        $membership = $user->memberships()->first();

        if (!$membership) {
            $membership = new Membership;
            $membership->user_id = $user->id;
            $membership->status = 'active';
        }

        $membership->plan_id = $update_plan_id;

        if ($membership->plan_id === 0) {
            $membership->expire_on = Carbon::parse($validated_data['new_expiry']);
        } else {
            if (Carbon::parse($membership->expire_on)->isFuture()) {
                $membership->expire_on = Carbon::parse($membership->expire_on)->add($plan->duration);

            } else {
                $membership->expire_on = Carbon::today()->add($plan->duration);
            }
        }

        $membership->save();

        $payment = new Payment();
        $payment->membership_id = $membership->id;
        $payment->amount = ($update_plan_id === 0) ? $validated_data['amount'] : $plan->price;
        $payment->payment_method = $validated_data['payment_method'];
        $payment->remarks = $validated_data['remarks'];
        $payment->payment_status = 'completed';
        $payment->payment_code = Str::random(20);
        $payment->save();

        return redirect()->back()->with('success', 'New payment has been recorded');


    }
}

