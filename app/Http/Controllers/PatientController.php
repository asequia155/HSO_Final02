<?php

namespace App\Http\Controllers;

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
    $patients = Patient::all();

    return Inertia::render('Frontend/Patient/Index', [
        'patients' => $patients,
        'message' => session('message'),
        'message_type' => session('message_type'),
    ]);
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
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'gender' => 'required|string',
                'email' => 'required|email|unique:patients,email',
                'phone' => 'required|string|max:15',
                'occupation' => 'nullable|string|max:255',
                'date_of_birth' => 'required|date',
                'address' => 'nullable|string|max:255',
                'rx' => 'nullable|string|max:255',
                'od' => 'nullable|string|max:255',
                'os' => 'nullable|string|max:255',
                'add' => 'nullable|string|max:255',
                'pd' => 'nullable|string|max:255',
            ]);
        
            // Create a patient with all fields, including prescription details
            Patient::create($validated);
            
            return redirect()->route('patients')
            ->with('message', 'Patient added successfully.')
            ->with('message_type', 'success');
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
            'rx' => 'nullable|string|max:255',
            'od' => 'nullable|string|max:255',
            'os' => 'nullable|string|max:255',
            'add' => 'nullable|string|max:255',
            'pd' => 'nullable|string|max:255',
        ]);
        
        // Find and update the patient
        $patient = Patient::findOrFail($id);
        $patient->update($validatedData);

        return redirect()->route('patients')
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
}
