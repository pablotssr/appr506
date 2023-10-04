<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function randomColor(){
        $color = sprintf('#%06X',mt_rand(0, 0xFFFFFF));
        return $color;
    }

    public function randomStats(){
        return [
            'health' => rand(75,100),
            'mental' => rand(50,100),
            'iq' => rand(20,150),
            'clean' => rand(75,100)
        ];
    }

    protected static function boot(){
        parent::boot();
        static::creating(function($pet){
            $pet->color = $pet->randomColor();
            $pet->age = 1;
            $pet->birth = now();
            $stats = $pet->randomStats();

            foreach ($stats as $key => $value){
                $pet->$key = $value;
            }
        });
    }
}
