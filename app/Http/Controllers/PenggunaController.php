<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        return view('pengguna.edit', compact('user'));
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
            'role' => 'required|in:admin,member'
        ];

        if ($request->filled('password')) {  // Use 'filled' to check if the password is not empty
            $validation_rules['password'] = [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'
            ];
        }

        $validated_data = $request->validate($validation_rules);

        $user->name = $validated_data['name'];
        $user->email = $validated_data['email'];
        $user->role = $validated_data['role'];
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
}
