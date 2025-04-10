<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([

            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'nullable|string',
            'occupation' => 'nullable|string',
            'phone' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
'name' => "{$request->first_name} {$request->last_name}", // Use string interpolation            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,

            'gender' => $request->gender,
            'occupation' => $request->occupation,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);


        event(new Registered($user));

        Auth::login($user);

        return redirect(route(name: 'dashboard', absolute: false));

    }
    public function store1(Request $request): RedirectResponse
    {
        // Ensure the logged-in user is an admin
        if (auth()->user()->role_id !== 2) { // Assuming role_id 1 is for admin
            abort(403, 'Unauthorized action.');
        }

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Create the new clerk user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 1, // Assign the clerk role (role_id 1 for clerk)
        ]);

        // Optionally, assign a role using Spatie if roles are implemented
        $user->assignRole('clerk'); // Example usage of the $user variable

        // Redirect back with success message
        return redirect(route(name: 'accounts.index', absolute: false))->with(key: 'success', value: 'Clerk created successfully.');

    }

}
