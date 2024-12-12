<?php

namespace App\Http\Controllers;


use App\Models\PatientPrescription;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Routing\Controller;

class PrescriptionController extends Controller
{
    
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'rx' => 'required|string|max:255',
            'od' => 'nullable|string|max:255',
            'os' => 'nullable|string|max:255',
            'add' => 'nullable|string|max:255',
            'pd' => 'nullable|string|max:255',
        ]);
    
        $validated['patient_id'] = $id;
    
        PatientPrescription::create($validated);
    
        // Redirect to the patient's detail page with success message
      
        return redirect()
    ->route('patients.show', ['id' => $id])
    ->with('message', 'Prescription added successfully.')
    ->with('message_type', 'success');

    }

    public function destroy($patientId, $prescriptionId)
    {
        $prescription = PatientPrescription::where('patient_id', $patientId)
            ->where('id', $prescriptionId)
            ->firstOrFail();
    
        $prescription->delete();
    
        return redirect()
            ->route('patients.show', $patientId)
            ->with('message', 'Prescription deleted successfully.')
            ->with('message_type', 'success');
    }
    

public function update(Request $request, $patientId, $prescriptionId)
{
    $prescription = PatientPrescription::where('patient_id', $patientId)
        ->where('id', $prescriptionId)
        ->firstOrFail();

    $validated = $request->validate([
        'rx' => 'required|string|max:255',
        'od' => 'nullable|string|max:255',
        'os' => 'nullable|string|max:255',
        'add' => 'nullable|string|max:255',
        'pd' => 'nullable|string|max:255',
    ]);

    $prescription->update($validated);

    return redirect()
        ->route('patients.show', $patientId)
        ->with('message', 'Prescription updated successfully.')
        ->with('message_type', 'success');
}


}
