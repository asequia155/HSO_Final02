<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Http\Controllers\ReservationController;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;

use Inertia\Inertia;

class PatientDashboardController extends Controller
{
    /**
     * Display the patient's dashboard.
     *
     * @param Request $request
     * @return \Inertia\Response
     */

    public function index(Request $request)
    {
        $user = $request->user(); // Get the authenticated user

        // Fetch reservations for the authenticated user
        $reservations = Reservation::where('user_id', $user->id)
            ->orderBy('appointment_date', 'desc') // Sort by appointment date
            ->paginate(10); // Paginate results

        return Inertia::render('Frontend/User/PatientReservationIndex', [
            'reservations' => $reservations, // Pass reservations to the frontend
            'user' => $user, // Pass user information to the frontend
        ]);
    }
    public function purchase(Request $request)
{
    $user = auth()->user(); // Get the currently logged-in user

    // Fetch the patient with the same email as the logged-in user and their transactions
    $patient = Patient::with([
        'prescriptions' => function ($query) {
            $query->orderBy('created_at', 'desc');
        },
        'transactions.items.product' => function ($query) {
            $query->orderBy('created_at', 'desc'); // Order the transactions by creation date
        }
    ])->where('email', $user->email)->first();

    // Check if a patient was found
    if (!$patient) {
        try {
            $patient = Patient::where('email', $user->email)->firstOrFail();
        } catch (\Exception $e) {
            \Log::error('Error fetching patient: ' . $e->getMessage());
            return redirect()->route('patient.dashboard')->withErrors([
                'error' => 'Unable to fetch data. Wait for confirmation.',
            ]);
        }

    }
    else{
        // Get the transactions for the patient
    $transactions = $patient->transactions;

    // Pass the patient and their transactions to the Inertia view
    return Inertia::render('Frontend/User/Purchase', [
        'patient' => $patient,
        'transactions' => $transactions,
    ]);
    }

}




    /**
     * Show the details of a specific reservation.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showReservation($id, Request $request)
    {
        $user = $request->user();

        // Fetch reservations with their histories for the authenticated user
    $reservations = Reservation::with(['reservationHistories' => function ($query) {
        $query->orderBy('created_at', 'desc'); // Optional: Order histories by date
    }])
        ->where('user_id', $user->id)
        ->paginate(10);

        return view('user.reservation.index', [
            'reservation' => $reservations,
        ]);
    }

    /**
     * Update patient profile information.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('patient.dashboard')->with('success', 'Profile updated successfully.');
    }

    public function applyReservation()
    {
        return Inertia::render('Frontend/User/ApplyAppointment');

    }

    public function store(Request $request)
    {
        $user = auth()->user(); // Get the currently logged-in user

        $validated = $request->validate([
            'remarks' => 'nullable|string',
            'occupation' => 'nullable|string',
            'appointmentDate' => 'required|date',
            'appointmentTime' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    $maxSlots = 2;
                    $existingCount = Reservation::where('appointment_time', $value)
                        ->where('appointment_date', $request->appointmentDate)
                        ->count();

                    if ($existingCount >= $maxSlots) {
                        $fail("The {$attribute} has reached the maximum number of bookings for this date.");
                    }
                },
            ],
        ]);

        // Create the reservation
        $reservation = Reservation::create([
            'user_id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'email' => $user->email,
            'gender' => $user->gender,
            'remarks' => $validated['remarks'] ?? null,
            'date_of_birth' => $user->date_of_birth,
            'address' => $user->address,
            'occupation' => $validated['occupation'] ?? $user->occupation,
            'appointment_date' => $validated['appointmentDate'],
            'appointment_time' => $validated['appointmentTime'],
        ]);

        // Create a reservation history record
        ReservationHistory::create([
            'reservation_id' => $reservation->id,
            'first_name' => $reservation->first_name,
            'last_name' => $reservation->last_name,
            'phone' => $reservation->phone,
            'email' => $reservation->email,
            'gender' => $reservation->gender,
            'remarks' => $reservation->remarks,
            'date_of_birth' => $reservation->date_of_birth,
            'address' => $reservation->address,
            'occupation' => $reservation->occupation,
            'appointment_date' => $reservation->appointment_date,
            'appointment_time' => $reservation->appointment_time,
            'status' => 'Pending',
        ]);

        // Set success messages and redirect
        session()->flash('message', 'Reservation submitted successfully.');
        session()->flash('message_type', 'success');

        // Redirect back to `/`
        return Inertia::render('Frontend/User/ApplyAppointment');
    }


public function history(Request $request)
{

        $user = $request->user(); // Get the authenticated user

        // Initialize the query for ReservationHistory
        $query = ReservationHistory::query();

        // Apply filtering to fetch histories connected to reservations belonging to the current user
        $query->whereHas('reservation', function ($reservationQuery) use ($user) {
            $reservationQuery->where('user_id', $user->id);
        });

        // Extract start and end dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Apply date range filter if provided
        if ($startDate && $endDate) {
            $query->whereBetween('appontment_date', [$startDate, $endDate]);
        }

        // Fetch the reservation histories with filters applied
        $histories = $query->orderBy('appointment_date', 'desc')->get();

        // Return data using Inertia
        return Inertia::render('Frontend/User/PatientReservationHistory', [
            'histories' => $histories,
        ]);
    }

}

