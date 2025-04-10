<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use Inertia\Inertia;
use Illuminate\Routing\Controller;


class NotificationController extends Controller
{
    public function index()
    {
    // Order notifications by 'created_at' in descending order
    $notifications = Notification::orderBy('created_at', 'desc')->get();

    return Inertia::render('Frontend/Notification/Index', [
        'notifications' => $notifications,
        'message' => session('message'),
        'message_type' => session('message_type'),
    ]);
    }


    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = true;
        $notification->save();

        return redirect()->route('notifications.index')
        ->with('message', 'Notification marked as read.')
        ->with('message_type', 'success');
    }

    public function delete($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('notifications.index')
        ->with('message', 'Notification deleted.')
        ->with('message_type', 'success');
    }

    public function markAllAsRead()
{
    Notification::where('is_read', false)->update(['is_read' => true]);

    return redirect()->route('notifications.index')
        ->with('message', 'All notifications marked as read.')
        ->with('message_type', 'success');
}

}
