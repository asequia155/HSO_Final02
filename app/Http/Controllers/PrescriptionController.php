<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Patient;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function store(Request $request, $patientId)
    {
        $validatedData = $request->validate([
            'rx' => 'nullable|string|max:255',
            'od' => 'nullable|numeric',
            'os' => 'nullable|numeric',
            'add' => 'nullable|numeric',
            'pd' => 'nullable|numeric',
        ]);

        // Find the patient to associate the prescription with
        $patient = Patient::findOrFail($patientId);

        // Create a prescription record for the patient
        $patient->prescriptions()->create($validatedData);

        return response()->json(['message' => 'Prescription added successfully'], 201);
    }
}
