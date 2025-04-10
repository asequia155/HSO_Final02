<?php

namespace App\Http\Controllers;
use inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class AccountController extends Controller
{
    /**
     * Display a list of all accounts with roles.
     *
     * @return \Inertia\Response
     */
    public function index()
{
    // Get the authenticated user

    $accounts = User::with('roles') // Eager load roles
    ->whereHas('roles', function ($query) {
        $query->whereIn('id', [1]); // Filter users with role IDs 1 and 2
    })
    ->get();

return Inertia::render('Frontend/Accounts/AccountManagement', [
    'users' => $accounts, // Pass the filtered accounts as 'users'
]);
}
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $id,
    ]);

    $user = User::findOrFail($id);
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    return back()->with('success', 'Account updated successfully!');
}




    /**
     * Toggle the active status of an account.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */


    /**
     * Delete an account.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $account = User::findOrFail($id);
        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }


}
