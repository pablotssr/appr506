<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Diary;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'age',
        'birth',
        'health',
        'mental',
        'iq',
        'clean',
        'alive'=> 'boolean',
    ];

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function diary()
    {
        return $this->hasMany(Diary::class);
    }
    public function randomColor()
    {
        return mt_rand(1, 10);
    }

    public function randomStats()
    {
        return [
            'health' => rand(75, 100),
            'mental' => rand(50, 100),
            'iq' => rand(20, 150),
            'clean' => rand(75, 100),
            'alive' => true
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($pet) {
            $pet->color = $pet->randomColor();
            $pet->age = 1;
            $pet->birth = now();
            $stats = $pet->randomStats();

            foreach ($stats as $key => $value) {
                $pet->$key = $value;
            }
        });

        static::updating(function ($pet) {
            $pet->health = min($pet->health, 100);
            $pet->mental = min($pet->mental, 100);
            $pet->iq = min($pet->iq, 150);
            $pet->clean = min($pet->clean, 100);

            if ($pet->health == 0 || $pet->mental == 0) {
                $pet->alive = false;
            } else {
                $pet->health = max($pet->health, 0);
                $pet->mental = max($pet->mental, 0);
                $pet->iq = max($pet->iq, 0);
                $pet->clean = max($pet->clean, 0);
            }
        });
    }
}