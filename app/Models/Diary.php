<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'pet_id',
        'pet_age',
        'action_id',
        'action_score',
        'event_id',
    ];
    public function pet(){
        return $this->belongsTo(Pet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function action()
    {
        return $this->belongsTo(Action::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
