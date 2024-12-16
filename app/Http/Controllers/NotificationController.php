<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Inertia\Inertia;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display the latest notifications.
     */
    public function index()
    {
        // Fetch the latest 3 notifications
        $notifications = Notification::latest()->take(3)->get();

        // Return the notifications as a response (or pass to Inertia)
        return Inertia::render('Frontend/Notification/Index', [         
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);

        return response()->json(['message' => 'Notification marked as read']);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);

        return response()->json(['message' => 'All notifications marked as read']);
    }

    /**
     * Delete a notification.
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return response()->json(['message' => 'Notification deleted']);
    }
}
