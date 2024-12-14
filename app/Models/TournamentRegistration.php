<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentRegistration extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default (e.g., 'tournament_registrations')
    // protected $table = 'tournament_registrations';

    // Define which attributes are mass assignable
    protected $fillable = [
        'tournament_id',
        'player_id',
        'amount',
        'order_id',
        'category'
    ];

    // Use timestamps for created_at and updated_at columns (if required)
    public $timestamps = true;

    // Optional: If you want to cast certain attributes
    // For example, if 'amount' is stored as a string and needs to be treated as a float
    protected $casts = [
        'amount' => 'float',
    ];

    // Relationship with Tournament model
    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }

    // Relationship with PlayerRegistration model
    public function player()
    {
        return $this->belongsTo(PlayerRegistration::class, 'player_id');
    }
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'order_id');  // assuming 'order_id' links the two tables
    }
}
