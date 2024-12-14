<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['tournament_id', 'order_id', 'amount', 'payment_status','provider_reference_id','checksum', 'user_id','payment_mode'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }
    public function tournamentRegistration()
    {
        return $this->hasOne(TournamentRegistration::class, 'order_id');
    }
}
