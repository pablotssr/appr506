<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    use HasFactory;

    protected $fillable = [
        'action1',
        'action2',
        'score',
        'event_id',
        'diary_id',
    ];
    public function action1()
    {
        return $this->belongsTo(Action::class, 'action1');
    }

    public function action2()
    {
        return $this->belongsTo(Action::class, 'action2');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function diary()
    {
        return $this->belongsTo(Diary::class);
    }
}