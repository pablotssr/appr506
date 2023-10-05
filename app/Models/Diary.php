<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    use HasFactory;
    protected $fillable = [
        'pet_id',
    ];
    public function pet(){
        return $this->belongsTo(Pet::class);
    }
}
