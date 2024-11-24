<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// UPDATE USER INFO
// php artisan tinker
// $user = App\Models\User::where('username', 'examplename')->first();
// $user->password = Hash::make('newpassword123');
// $user->save();

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function username()
    {
        return 'username';
    }
}