<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerRegistration extends Model
{
    use HasFactory;

    // Specify table name if it's different from the default (e.g., 'player_registrations')
    // protected $table = 'player_registrations';

    // Add 'fide_id' to the fillable array
    protected $fillable = [
        'fide_id',
        'aicf_id',
        'fide_rating',
        'state_membership_id',
        'player_name',
        'residential_address',
        'gender',
        'father_name',
        'state',
        'dob',
        'district',
        'mobile_1',
        'taluk',
        'mobile_2',
        'pin_code',
        'email',
        'school_college_name',
        'online_chess_id',
        'user_id',
        'status',
        'payment_status',
        'mother_name',
    ];

    // If you're using timestamps, you don't need to define this unless it's false
    public $timestamps = true;

    // Cast attributes to specific types (e.g., 'dob' as date)
    protected $casts = [
        'dob' => 'date',
        'fide_rating' => 'integer',
    ];

    // Define relationships with other models (example: PlayerRegistration belongs to User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Example for adding relationships to other models (if applicable)
    public function tournamentRegistrations()
    {
        return $this->hasMany(TournamentRegistration::class);
    }
}
