<?php

namespace App\Http\Controllers;
use App\Mail\ReservationNotification;
use App\Models\Patient;
use App\Models\Reservation;
use App\Models\Holiday;
use App\Models\Notification;
use App\Models\ReservationHistory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Mail\NotificationEmail;
use Illuminate\Support\Facades\Mail;


class ReservationController extends Controller
{
    /**
     * Display a listing of the reservations.
     */
    public function index(Request $request)
    {
        // Get query parameters for filtering
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $currentDate = now()->toDateString(); // Get the current date

        // Build the query with optional filters
        $query = Reservation::query()
            ->select([
                'id',
                'first_name',
                'last_name',
                'phone',
                'email',
                'gender',
                'remarks',
                'date_of_birth',
                'address',
                'occupation',
                'appointment_date',
                'appointment_time',
            ])
            ->where('appointment_date', '>=', $currentDate) // Exclude past dates
            ->orderBy('appointment_date', 'asc') // Sort by appointment_date ascending
            ->orderBy('appointment_time', 'asc'); // Sort by appointment_time ascending

        // Apply date filtering if both start_date and end_date are provided
        if ($startDate && $endDate) {
            $query->whereBetween('appointment_date', [$startDate, $endDate]);
        }

        // Get all reservations (filtered or unfiltered)
        $reservations = $query->get();

        // Add `patientExists` property to each reservation
        $reservations->each(function ($reservation) {
            $reservation->patientExists = Patient::where('email', $reservation->email)->exists();
        });

        // Get all patient emails (optional, remove if unused)
        $patients = Patient::select('email')->get();

        // Render the Inertia view with formatted reservation data
        return Inertia::render('Frontend/Reservation/Index', [
            'reservations' => $reservations,
            'patients' => $patients, // Optional, if used in frontend
            'filters' => [
                'startDate' => $startDate,
                'endDate' => $endDate,
            ],
            'notifications' => Notification::where('is_read', false)->latest()->take(3)->get(),
        ]);
    }
    public function show($email)
    {
        $exists = Patient::where('email', $email)->exists();

        return response()->json(['exists' => $exists]);
    }


    // Helper function to format phone numbers
    private function formatPhoneNumber($phoneNumber)
    {
        // Remove country code if it starts with +63
        if (strpos($phoneNumber, '+63') === 0) {
            $phoneNumber = '0' . substr($phoneNumber, 3);
        }

        // Add dashes in the proper positions
        return preg_replace('/(\d{4})(\d{3})(\d{4})/', '$1-$2-$3', $phoneNumber);
    }

    public function newCount(Request $request)
    {
        // Get the last viewed time from the session or default to the past
        $lastViewedTime = $request->session()->get('last_viewed_reservation_time', Carbon::now()->subYear());

        // Count reservations created after the last viewed time
        $newCount = Reservation::where('created_at', '>', $lastViewedTime)->count();

        return response()->json(['new_count' => $newCount]);
    }
    public function markViewed(Request $request)
    {
        // Store the current timestamp as the "last viewed time" in session
        $request->session()->put('last_viewed_reservation_time', Carbon::now());

        return response()->json(['status' => 'success']);
    }

    public function reservationCount(Request $request)
{
    // Get the last viewed time from the session or default to the start of today
    $lastViewedTime = $request->session()->get('last_viewed_reservation_time', now()->startOfDay());

    // Count new reservations since the last viewed time
    $newCount = Reservation::where('created_at', '>', $lastViewedTime)->count();

    // Optionally update the session when explicitly marked as viewed
    if ($request->has('markViewed')) {
        $request->session()->put('last_viewed_reservation_time', now());
    }

    return response()->json(['new_count' => $newCount]);
}

    public function resetNewCount(Request $request)
    {
        // Get the ID of the latest reservation
        $lastId = Reservation::latest('id')->first()->id ?? 0;

        // Update the session with the latest viewed reservation ID
        $request->session()->put('last_viewed_reservation_id', $lastId);

        return response()->json(['status' => 'reset']);
    }
    public function countNewReservations(Request $request)
    {
        $lastViewed = $request->input('last_viewed'); // Timestamp or ID

        // Get reservations added after the last viewed timestamp
        $newCount = Reservation::where('created_at', '>', $lastViewed)->count();

        return response()->json(['new_count' => $newCount]);
    }



    /**
     * Store a newly created reservation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email',
            'gender' => 'required|string',
            'remarks' => 'nullable|string',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
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

        $reservation = Reservation::create([
            'first_name' => $validated['firstName'],
            'last_name' => $validated['lastName'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'remarks' => $validated['remarks'] ?? null,
            'date_of_birth' => $validated['date_of_birth'],
            'address' => $validated['address'],
            'occupation' => $validated['occupation'] ?? null,
            'appointment_date' => $validated['appointmentDate'],
            'appointment_time' => $validated['appointmentTime'],
        ]);

        ReservationHistory::create([
            'reservation_id' => $reservation->id,
            'first_name' => $reservation->first_name,
            'last_name' => $reservation->last_name,
            'phone' => $reservation->phone,
            'email' => $reservation->email,
            'gender' => $reservation->gender,
            'remarks' => $reservation->remarks,
            'date_of_birth' => $validated['date_of_birth'],
            'address' => $validated['address'],
            'occupation' => $validated['occupation'] ?? null,
            'appointment_date' => $reservation->appointment_date,
            'appointment_time' => $reservation->appointment_time,
            'status' => 'Pending',
        ]);


        session()->flash('message', 'Reservation submitted successfully.');
        session()->flash('message_type', 'success');

    // Redirect back to `/`
    return Inertia::location('/');

    }
    public function confirm(Request $request, $id)
    {
        // Find the reservation by ID
        $reservation = Reservation::findOrFail($id);

        // Update the reservation status to "Confirmed"
        $reservation->update([
            'status' => 'Confirmed',

        ]);

        // Create a new history record with the "Confirmed" status
        ReservationHistory::create([
            'reservation_id' => $reservation->id,
            'first_name' => $reservation->first_name,
            'last_name' => $reservation->last_name,
            'phone' => $reservation->phone,
            'email' => $reservation->email,
            'gender' => $reservation->gender,
            'remarks' => $reservation->remarks,
            'appointment_date' => $reservation->appointment_date,
            'appointment_time' => $reservation->appointment_time,
            'status' => 'Confirmed',
        ]);

        // Send a notification email to the user
        Mail::to($reservation->email)->send(mailable: new ReservationNotification($reservation, type: 'confirm'));



    }
    public function delete(Request $request, $id)
{
    // Find the reservation by ID
    $reservation = Reservation::findOrFail($id);

    // Update the reservation status to "Rejected"
    $reservation->update([
        'status' => 'Rejected',
    ]);

    // Create a history record with the "Rejected" status
    ReservationHistory::create([
        'reservation_id' => $reservation->id,
        'first_name' => $reservation->first_name,
        'last_name' => $reservation->last_name,
        'phone' => $reservation->phone,
        'email' => $reservation->email,
        'gender' => $reservation->gender,
        'remarks' => $reservation->remarks,
        'appointment_date' => $reservation->appointment_date,
        'appointment_time' => $reservation->appointment_time,
        'status' => 'Rejected',
    ]);

    // Send a rejection email to the user
    Mail::to($reservation->email)->send(new ReservationNotification($reservation, 'reject'));

    // Return a response to the frontend
    $reservation->delete();

}





    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        // Fetch all bookings for the selected date
        $bookedSlots = Reservation::where('appointment_date', $request->query('date'))
            ->select('appointment_time', \DB::raw('COUNT(*) as count'))
            ->groupBy('appointment_time')
            ->get();

        return response()->json($bookedSlots);
    }

    /**
     * Display a list of all holidays.
     */
    public function holidayIndex()
    {
        $holidays = Holiday::select('id', 'name', 'date')->orderBy('date', 'asc')->get();

        return Inertia::render('Reservations/HolidayIndex', [
            'holidays' => $holidays,
        ]);
    }

    /**
     * Fetch all holidays (API endpoint).
     */
    public function fetchHolidays()
    {
        $holidays = Holiday::select('id', 'name', 'date')->orderBy('date', 'asc')->get();

        return response()->json($holidays);
    }

    /**
     * Store a new holiday.
     */
    public function storeHoliday(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|unique:holidays,date',
        ]);

        $startYear = now()->year; // Current year
        $endYear = $startYear + 5; // Add holidays up to 5 years in advance (customizable)

        $holidays = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $holidayDate = Carbon::parse($validated['date'])->setYear($year)->toDateString();

            // Avoid duplicate holidays for the same date
            if (!Holiday::where('date', $holidayDate)->exists()) {
                $holidays[] = [
                    'name' => $validated['name'],
                    'date' => $holidayDate,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert holidays in bulk
        Holiday::insert($holidays);

        return back()->with([
            'message' => 'Holiday added successfully for the next 5 years!',
        ]);
    }

    /**
     * Delete a specific holiday.
     */
    public function destroyHoliday(Holiday $holiday)
    {
        $holiday->delete();

        return back()->with([
            'message' => 'Holiday deleted successfully!'
        ]);
    }
    /**
     * Remove the specified reservation from storage.
     */
    /**
     * Display the reservation history with optional date range filtering or today's reservations.
     */
    /**
     * Display the reservation history for today or based on optional date range.
     */
    public function history(Request $request)
{
    // Initialize the query
    $query = ReservationHistory::query();

    // Extract start and end dates from the request
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Apply date range filter if provided
    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // Fetch all reservation histories if no date range is specified
    $histories = $query->orderBy('created_at', 'desc')->get();

    // Return data using Inertia
    return Inertia::render('Frontend/Reservation/ReservationHistory', [
        'histories' => $histories,
        'notifications' => Notification::where('is_read', false)->latest()->take(3)->get(),
    ]);
}

    public function destroy(Reservation $reservation)
    {
        // Create a "deleted" history record
        ReservationHistory::create([
            'reservation_id' => $reservation->id,
            'first_name' => $reservation->first_name,
            'last_name' => $reservation->last_name,
            'phone' => $reservation->phone,
            'email' => $reservation->email,
            'gender' => $reservation->gender,
            'remarks' => $reservation->remarks,
            'appointment_date' => $reservation->appointment_date,
            'appointment_time' => $reservation->appointment_time,
            'status' => 'Rejected',
        ]);

        // Delete only the reservation
        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('message', 'Reservation deleted successfully.')
            ->with('message_type', 'success');
    }


}
