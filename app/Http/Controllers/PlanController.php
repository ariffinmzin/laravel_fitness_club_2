<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $plans = Plan::all();
        return view('plan.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $active_options = Plan::ACTIVE_OPTIONS;

        $duration_options = ["" => "Sila Pilih Pelan"] + Plan::DURATION_OPTIONS;

        return view('plan.create', compact('active_options', 'duration_options'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $duration_validation = implode(",", array_keys(Plan::DURATION_OPTIONS));
        $active_validation = implode(",", array_keys(Plan::ACTIVE_OPTIONS));
        $validated_data = $request->validate([
            'name' => 'required|string|unique:plans,name|min:4|max:20',
            'code' => 'required|string|unique:plans,code|min:4|max:20',
            'duration' => 'required|in:' . $duration_validation,
            'price' => 'required|numeric',
            'active' => 'required|in:' . $active_validation,
        ]);

        $plan = Plan::create($validated_data);

        return redirect()->route('plan.index')->with('success', 'Plan created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
