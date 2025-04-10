<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'gender',
        'email',
        'phone',
        'date_of_birth',
        'address',
        'occupation',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Automatically assign roles based on email
    protected static function booted()
    {
        static::creating(function ($user) {
            // If the user is created by a logged-in admin (context passed from controller)
            if (auth()->check() && auth()->user()->role_id === 2) { // Assuming role_id 1 is for admin
                // Assign role_id for 'clerk'
                $clerkRole = Role::firstOrCreate(['name' => 'clerk']);
                $user->role_id = $clerkRole->id;
                $user->assignRole('clerk');
            } else {
                // Assign roles based on email if no admin is creating the user
                if ($user->email === 'admin@gmail.com') {
                    // Assign role_id for 'admin'
                    $adminRole = Role::firstOrCreate(['name' => 'admin']);
                    $user->role_id = $adminRole->id;
                    $user->assignRole('admin');
                } elseif ($user->email === 'clerk@gmail.com') {
                    // Assign role_id for 'clerk'
                    $clerkRole = Role::firstOrCreate(['name' => 'clerk']);
                    $user->role_id = $clerkRole->id;
                    $user->assignRole('clerk');
                } else {
                    // Assign role_id for 'patient'
                    $patientRole = Role::firstOrCreate(['name' => 'patient']);
                    $user->role_id = $patientRole->id;
                    $user->assignRole('patient');
                }
            }
        });
    }
}
