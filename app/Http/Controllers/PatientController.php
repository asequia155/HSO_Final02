<?php

namespace App\Http\Controllers;
use App\Models\Notification;

use App\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::orderBy('id', 'desc')->get();

        return Inertia::render('Frontend/Patient/Index', [
            'patients' => $patients,
            'message' => session('message'),
            'message_type' => session('message_type'),
            'notifications' => Notification::where('is_read', operator: false)->latest()->take(3)->get(),
        ]);
    }
    public function checkPatient(Request $request)
{
    $request->validate([
        'first_name' => 'required|string',
        'last_name' => 'required|string',
    ]);

    $exists = Patient::where('first_name', $request->first_name)
                     ->where('last_name', $request->last_name)
                     ->exists();

    return response()->json(['exists' => $exists]);
}

    public function create()
    {
        return Inertia::render('Frontend/Patient/AddPatient');
    }

    /**
     * Store a newly created resource in storage.
        */
        public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'gender' => 'required|string',
        'email' => 'required|email|unique:patients,email',
        'occupation' => 'nullable|string',
        'phone' => 'required|string',
        'date_of_birth' => 'required|date',
        'address' => 'required|string',
    ]);

    // Create the patient
    $patient = Patient::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'gender' => $request->gender,
        'email' => $request->email,
        'occupation' => $request->occupation,
        'phone' => $request->phone,
        'date_of_birth' => $request->date_of_birth,
        'address' => $request->address,
    ]);

    // Redirect to the show route for the created patient
    return redirect()->route('patients.show', $patient->id)
        ->with('message', 'Patient added successfully.')
        ->with('message_type', 'success');
}




public function show($id)
{
    $patient = Patient::with([
        'prescriptions' => function ($query) {
            $query->orderBy('created_at', 'desc');
        },
        'transactions.items.product' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }
    ])->findOrFail($id);

    return Inertia::render('Frontend/Patient/PatientDetails', [
        'patient' => $patient,
        'notifications' => Notification::where('is_read', false)->latest()->take(3)->get(),
    ]);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $patients = Patient::all();

    return Inertia::render('Frontend/Patient/Index', [
        'patients' => $patients,
    ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        Log::info('Update method reached');

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'occupation' => 'nullable|string',
        ]);

        // Find and update the patient
        $patient = Patient::findOrFail($id);
        $patient->update($validatedData);

        // Prepare updated data to send to the frontend
        $updatedPatient = Patient::find($id);

        // Re-render the page with the updated patient data and flash message
        return redirect()->route('patients.show', ['id' => $id])
        ->with('message', 'Patient updated successfully.')
        ->with('message_type', 'success');
    }


    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients')
        ->with('message', 'Patient deleted successfully.')
        ->with('message_type', 'success');
    }

    public function search(Request $request)
{
    $search = $request->input('name');
    $patients = Patient::where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->get(['id', 'first_name', 'last_name']);

    // Combine first and last names into a single field
    $patients->transform(function ($patient) {
        $patient->name = $patient->first_name . ' ' . $patient->last_name;
        return $patient;
    });

    return response()->json($patients);
}


}
