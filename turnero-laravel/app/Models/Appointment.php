<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['fecha', 'hora', 'estado', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
