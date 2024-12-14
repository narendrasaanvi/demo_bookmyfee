<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function tournamenttype()
    {
        return $this->belongsTo(TournamentType::class, 'tournament_type_id', 'id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
    public function prize()
    {
        return $this->belongsTo(Prize::class);
    }
    public function playerRegistrations()
    {
        return $this->hasMany(PlayerRegistration::class);
    }
}
