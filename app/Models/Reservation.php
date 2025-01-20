<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable=[
        'event_id',
        'ticket_amount'
    ];

    public function event(){
        return $this->belongsTo(Event::class);
    }
}
