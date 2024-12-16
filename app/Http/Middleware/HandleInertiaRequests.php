<?php

namespace App\Http\Middleware;
use App\Models\Notification;


use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? $request->user()->load('roles') : null, // Load user roles
            ],
            'flash' => [
            'message' => fn () => $request->session()->get('message'),
            'message_type' => fn () => $request->session()->get('message_type'),
            'notifications' => Notification::latest()->take(3)->get(),
        ],
        ];
        
    }
}
