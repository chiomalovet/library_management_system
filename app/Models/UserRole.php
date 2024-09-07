<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

    public function user()
    {
        return $this->belongsToManyo(User::class);
    }
}
